<?php

namespace App\Http\Controllers\System;

use App\Http\Controllers\Controller;
use App\Models\InformeFinanciero;
use Illuminate\Support\Facades\DB;

class MuestreoController extends Controller
{
    public function getMuestreoDatos(){
        $balanza = session('balanza_current');

        $resultados = InformeFinanciero::query()
        ->where('balanza_id', $balanza->id)
        ->selectRaw('MONTH(fecha) as mes, SUM(monto_inicial) as saldo_inicial, SUM(monto_final) as saldo_final')
        ->groupBy('mes')
        ->get();

        $meses = $resultados->reduce(function ($carry, $item) {
            $carry[] = $this->getNombreDelMes($item->mes);
            return $carry;
        }, []);

        $saldos_inicial = $resultados->reduce(function ($carry, $item) {
            $carry[] = floatval($item->saldo_inicial);
            return $carry;
        }, []);

        $saldos_final = $resultados->reduce(function ($carry, $item) {
            $carry[] = floatval($item->saldo_final);
            return $carry;
        }, []);


        return ['meses' => $meses, 'saldos_inicial' => $saldos_inicial, 'saldos_final' => $saldos_final];
    }

    public function getMuestreoCategoria()
    {
        $balanza = session('balanza_current');

        $resultados = InformeFinanciero::query()
        ->where('balanza_id', $balanza->id)
        ->selectRaw('categoria, SUM(monto_inicial) as saldo_inicial, SUM(monto_final) as saldo_final')
        ->groupBy('categoria')
        ->get();

        $categorias = $resultados->reduce(function ($carry, $item) {
            $carry[] = strval($item->categoria).' / monto_inicial';
            $carry[] = strval($item->categoria).' / monto_final';
            return $carry;
        }, []);

        $saldos = $resultados->reduce(function ($carry, $item) {
            $carry[] = [floatval($item->saldo_inicial), floatval($item->saldo_final)];
            return $carry;
        }, []);

        return ['categorias' => $categorias, 'saldos' => $saldos];
    }

    public function getMuestreoEtiqueta(){
        $balanza = session('balanza_current');

        $resultados = InformeFinanciero::query()
        ->where('balanza_id', $balanza->id)
        ->select(DB::raw('etiqueta, SUM(monto_inicial) as saldo_inicial, SUM(monto_final) as saldo_final'))
        ->groupBy('etiqueta')
        ->get();

        $etiquetas = $resultados->reduce(function ($carry, $item) {
            $carry[] = strval($item->etiqueta);
            return $carry;
        }, []);

        $saldos_inicial = $resultados->reduce(function ($carry, $item) {
            $carry[] = floatval($item->saldo_inicial);
            return $carry;
        }, []);

        $saldos_final = $resultados->reduce(function ($carry, $item) {
            $carry[] = floatval($item->saldo_final);
            return $carry;
        }, []);

        return ['etiquetas' => $etiquetas, 'saldos_inicial' => $saldos_inicial, 'saldos_final' => $saldos_final];
    }

    public function getMuestreoMonto()
    {
        $balanza = session('balanza_current');

        $resultados = InformeFinanciero::query()
        ->where('balanza_id', $balanza->id)
        ->selectRaw('fecha, descripcion, monto_inicial, monto_final')
        ->get();

        $x = 0;
        $montos_iniciales = $resultados->reduce(function ($carry, $item) use(&$x) {
            $carry[] = ['x' => $x, 'y' => floatval($item->monto_inicial), 'label' => strval($item->descripcion), 'fecha' => strval($item->fecha)];
            $x++;
            return $carry;
        }, []);

        $x = 0;
        $montos_finales = $resultados->reduce(function ($carry, $item) use(&$x) {
            $carry[] = ['x' => $x, 'y' => floatval($item->monto_final), 'label' => strval($item->descripcion), 'fecha' => strval($item->fecha)];
            $x++;
            return $carry;
        }, []);

        $descripciones = $resultados->reduce(function ($carry, $item) {
            $carry[] = strval($item->descripcion);
            return $carry;
        }, []);

        return ['montos_iniciales' => $montos_iniciales, 'montos_finales' => $montos_finales, 'descripciones' => $descripciones];
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
