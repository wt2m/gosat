<?php

namespace App\Utils;

class CalculateFees {
    public function calculateFees(int $valorTotal, float $porcetagemDeJuros, int $parcelas): float
    {
        $jurosMensalEmReais = self::calculateMensalFees($valorTotal,$porcetagemDeJuros);
        return self::calculateTotalFeesBRL($jurosMensalEmReais,$parcelas);
    }

    public function calculateTotalFees(int $valorTotal, float $juros): float
    {
        return $valorTotal + $juros;
    }

    public function calculateMensalFees(int $valorTotal, float $porcetagemDeJuros): float
    {
        return ($valorTotal / 100) * $porcetagemDeJuros;
    }

    public function calculateTotalFeesBRL(float $jurosMensais, int $parcelas): float
    {
        $totalDeJuros = $jurosMensais * $parcelas;
        
        return floatval(number_format($totalDeJuros, 2, '.', ''));
    }
}