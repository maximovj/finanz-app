<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\InformeFinanciero;

class MuestreoController extends Controller
{
    public function getMuestreoDatos(){
        $resultados = InformeFinanciero::selectRaw('MONTH(fecha) as mes, SUM(monto_final) as saldo_total')
                ->groupBy('mes')
                ->get();

        $meses = $resultados->reduce(function ($carry, $item) {
            $carry[] = $this->getNombreDelMes($item->mes);
            return $carry;
        }, []);

        $saldos = $resultados->reduce(function ($carry, $item) {
            $carry[] = floatval($item->saldo_total);
            return $carry;
        }, []);


        return ['meses' => $meses, 'saldos' => $saldos];
    }

    protected function getNombreDelMes(int $mes){
        $mes_nombre = "";
        switch($mes){
            case 1: $mes_nombre = "Enero"; break;
            case 2: $mes_nombre = "Febrero"; break;
            case 3: $mes_nombre = "Marzo"; break;
            case 4: $mes_nombre = "Abril"; break;
            case 5: $mes_nombre = "Mayo"; break;
            case 6: $mes_nombre = "Junio"; break;
            case 7: $mes_nombre = "Julio"; break;
            case 8: $mes_nombre = "Agosto"; break;
            case 9: $mes_nombre = "Septiembre"; break;
            case 10: $mes_nombre = "Octubre"; break;
            case 11: $mes_nombre = "Noviembre"; break;
            case 12: $mes_nombre = "Diciembre"; break;
        }

        return $mes_nombre;
    }
}
