<?php

class CalculoJuros {
    
    static function valorParcelaJurosSimples($valor, $taxa, $parcelas, $parcelasSemJuros = 0) {
        if ($parcelas <= $parcelasSemJuros) {
            return $valor / $parcelas;
        }
        
        $taxa = $taxa / 100;
        $m = $valor * (1 + $taxa * $parcelas);
        
        return $m / $parcelas;
    }

    static function valorParcelaJurosComposto($valor, $taxa, $parcelas, $parcelasSemJuros = 0) {
        if ($parcelas <= $parcelasSemJuros) {
            return $valor / $parcelas;
        }
        
        $taxa = $taxa / 100;
        $valParcela = $valor * pow((1 + $taxa), $parcelas);
        
        return $valParcela / $parcelas;
    }

}
