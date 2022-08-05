<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use App\Services\CheckCreditService;
use App\Models\ConsultaCredito;

class CheckCredit extends Controller
{
    public function getCreditOptions(Request $request): JsonResponse
    {
        $request->validate([
            'cpf' => 'required',
            'parcela'   => 'numeric',
            'valor' => 'numeric'
        ]);

        $response =  CheckCreditService::consultarCredito($request->cpf, $request->parcela, $request->valor);

        $toSave = self::convertToObject($response);
        foreach($toSave as $c){
            $c->cpf = $request->cpf;
            $c->save();
        }

        return response()->json($response);
    }

    public function list(): JsonResponse
    {
        return response()->json(ConsultaCredito::all());
    }

    private static function convertToObject(array $array): array{
        $converted = [];
        foreach($array as $item){
            $model = new ConsultaCredito();
            $model->instituicao = $item['instituicaoFinanceira'];
            $model->modalidade  = $item['modalidadeCredito'];
            $model->valorSolicitado = $item['valorSolicitado'];
            $model->valorAPagar = $item['valorAPagar'];
            $model->qntParcelas = $item['qntParcelas'];
            $model->taxaJuros   = $item['taxaJuros'];

            array_push($converted, $model);
        }

        return $converted;
    }
}
