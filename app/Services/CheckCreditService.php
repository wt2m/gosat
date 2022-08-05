<?php

namespace App\Services;

use App\Requests\GosatHandler;
use App\Models\GosatRequest\OfferSimulation;
use App\Models\ConsultaCredito;
use Illuminate\Http\Request;

use App\Utils\CalculateFees;

class CheckCreditService {

    public static function consultarCredito($cpf, $parcela, $valor): array  
    {

        $financialInstitutions = GosatHandler::getInstitutionByCPF($cpf);
        $dadosDasOfertasCredito = self::getOffers($financialInstitutions);
        $filteredFinancialInstitutions = self::filter($dadosDasOfertasCredito, $parcela, $valor);
        $creditOffers = self::calculateCreditOffer($filteredFinancialInstitutions, $parcela, $valor);
        $ordered = self::orderData($creditOffers);
        

        return $ordered;
    }

   

    private static function getOffers(array $data): array
    {
        $offers = [];
        foreach($data['institutions'] as $index => $institution){
            foreach ($institution->modalities as $modality){
                array_push($offers, [
                    'instituicaoFinanceira' => $institution->name,
                    'modalidadeCredito' => $modality->name,
                    'ofertaDeCredito' => GosatHandler::getOfferSimulation(new OfferSimulation($data['cpf'], $institution->id, $modality->code))
                ]); 
            }
        }

        return $offers;
    }

    private static function filter(array $dadosDasOfertasCredito, $parcela, $valor): array{
        if(isset($parcela)){
            $dadosDasOfertasCredito = array_filter($dadosDasOfertasCredito, function($v) use ($parcela) {
                return $parcela <= $v['ofertaDeCredito']->QntParcelaMax && $parcela >= $v['ofertaDeCredito']->QntParcelaMin;
            });
        }
        
        if(isset($valor)){
            $dadosDasOfertasCredito = array_filter($dadosDasOfertasCredito, function($v) use ($valor) {
                return $valor <= $v['ofertaDeCredito']->valorMax && $valor >= $v['ofertaDeCredito']->valorMin;
            });
        }

        return $dadosDasOfertasCredito;
    }

    private static function calculateCreditOffer(array $array, $parcela, $valor): array
    {
        $ofertasCreditoPessoal = [];

        foreach($array as $dadosDoCredito){

            $valorMax = !isset($valor) ? $dadosDoCredito['ofertaDeCredito']->valorMax : $valor;
            $parcelasMax = !isset($parcela) ? $dadosDoCredito['ofertaDeCredito']->QntParcelaMax : $parcela; 
            $jurosMes = $dadosDoCredito['ofertaDeCredito']->jurosMes;

            $taxaJuros = CalculateFees::calculateFees(
                $valorMax,
                $jurosMes,
                $parcelasMax
            );

            $valorAPagar = CalculateFees::calculateTotalFees($valorMax,$taxaJuros);
            $ofertasCreditoPessoal[] = [
                'instituicaoFinanceira' => $dadosDoCredito['instituicaoFinanceira'],
                'modalidadeCredito' => $dadosDoCredito['modalidadeCredito'],
                'valorAPagar' => $valorAPagar,
                'valorSolicitado' => $valorMax,
                'qntParcelas' => $parcelasMax,
                'taxaJuros' => $taxaJuros,
            ];
        }

        return $ofertasCreditoPessoal;
    }

    private static function orderData(array $array): array
    {
        $marks = array();
        foreach ($array as $key => $row)
        {
            $marks[$key] = $row['taxaJuros'];
        }
        array_multisort($marks, SORT_ASC, $array);

       return $array;
    }

    
}