<?php

namespace App\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\GosatRequest\OfferSimulation;
use App\Models\GosatRequest\FinancialInstitution;

class GosatHandler 
{
  private const BASE_GOSAT_URL = 'https://dev.gosat.org/api/v1';

  public static function getInstitutionByCPF(string $cpf): array
  {
    $response = json_decode(Http::post(self::BASE_GOSAT_URL . '/simulacao/credito',[
        'cpf' => $cpf,
    ]));

    $financialInstitutions = [
      'cpf'=> $cpf,
      'institutions' => []
    ];

    foreach($response->instituicoes as $institution){
      $aux = new FinancialInstitution($institution->id, $institution->nome, $institution->modalidades);
      array_push($financialInstitutions['institutions'], $aux);
    } 
   return $financialInstitutions;
  }

  public static function getOfferSimulation(OfferSimulation $offer): object
  {
    $response = Http::post(self::BASE_GOSAT_URL . '/simulacao/oferta',[
      'cpf' => $offer->cpf,
      'instituicao_id' => $offer->institution_id,
      'codModalidade' => $offer->cod_modality
    ]);

    return json_decode($response);
  }
}