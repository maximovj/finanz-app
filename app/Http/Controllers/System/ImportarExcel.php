<?php

namespace App\Http\Controllers\System;

use Exception;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Importar\InformeFinancieroImport;

class ImportarExcel extends Controller
{

    static public function importar($file, $token)
    {
        $msg_err = null;
        try {

            // check if exists token is correct
            $balanza = session('balanza_current');
            if($balanza->token !== $token )
            {
                throw new Exception('err_token', 1);
            }

            // check if exists file
            if(!$file)
            {
                throw new Exception('err_file', 1);
            }

            $tipo = $file->getClientOriginalExtension();
            $importExcel = new InformeFinancieroImport($balanza);

            if($tipo === 'xlsx')
            {
                Excel::import($importExcel, $file, null, \Maatwebsite\Excel\Excel::XLSX);
            } else if($tipo === 'xls')
            {
                Excel::import($importExcel, $file, null, \Maatwebsite\Excel\Excel::XLS);
            } else {
                Excel::import($importExcel, $file);
            }

        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            $msg_err = "El archivo importado tiene problemas de lectura o incompatibilidad.";
        } catch (\Throwable $t) {
            $message = $t->getMessage();

            if($message == "vacio"){
                $msg_err = "No hay datos que registrar.";
            }else if($message == "err_token"){
                $msg_err = "Lo siento, el token proporcionado invalidado por el sistema";
            }else if($message == "err_file"){
                $msg_err = "Lo siento, el archivo no es compatible con el sistema de lectura.";
            }

        }

        return $msg_err;
    }

    static public function validarHojaDeCalculo($archivo){
        if($archivo){
            $permitidos = ['xls', 'xlsx'];
            $extensionValida = in_array(strtolower($archivo->getClientOriginalExtension()), $permitidos);
            if($extensionValida && $archivo->isReadable() && $archivo->isWritable() && $archivo->isFile()){
                return $archivo;
            }
        }
        return null;
    }

}
