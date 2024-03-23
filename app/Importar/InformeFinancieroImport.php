<?php

namespace App\Importar;

use Exception;
use Carbon\Carbon;
use App\Models\Balanza;
use App\Models\InformeFinanciero;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;

class InformeFinancieroImport implements ToCollection
{

    public static $batchSize = 1000;
    public static $contador = 0;
    public static $infoBalanza = [];
    protected $mensaje;

    public function __construct($balanza)
    {
        // get `Balanza` information
        self::$infoBalanza = [
            'balanza_id' => $balanza->id,
        ];
    }

    /**
     * @author Victor J. <github.com:maximovj>
     * @date 21/03/2024
     * @desc This PHP function processes a collection of rows in batches and generates a message indicating
     * the number of records inserted.
     * @param Collection rows The `collection` function you provided seems to be processing a
     * collection of rows in batches. It splits the rows into batches of a certain size
     * (`self::`) and then processes each batch using the `processBatch` method.
     * @return void
     */
    public function collection(Collection $rows)
    {
        $filaTotal = $rows->count();

        // Run Process batch
        for($i = 0; $i < $filaTotal; $i += self::$batchSize)
        {
            $this->processBatch($rows->splice($i, self::$batchSize));
        }

        // Check out count record inserted
        if(self::$contador === 0)
        {
            throw new Exception('vacio', 1);
        }

        // Generate a message to success
        $this->mensaje = "Se insertaron " . self::$contador . " registros";
    }

    /**
     * @author Victor J. <github.com:maximovj>
     * @date 21/03/2024
     * @desc The function processes a batch of rows by reading each row from an Excel file, performing some
     * operations, and then inserting the processed data into a database.
     * @param Collection $rows
     * @param Collection rows The `processBatch` function you provided seems to iterate over a
     * collection of rows, but it currently has a `var_dump` statement followed by a `sleep(1)` and
     * `continue` which will prevent the rest of the code from executing.
     */
    public function processBatch(Collection $rows){
        $insertarRegistros = [];
        // Read row and cell from `Excel` file
        foreach ($rows as $row)
        {
            //var_dump($row);
            //sleep(1);
            //continue;

            $validator = $this->validator($row);
            $array_data  = $validator['array_data'];

            if(!$validator['passes']){
                continue;
            }

            //var_dump($array_data);
            //sleep(1);

            $registro = [
                'no_cuenta' => strval($array_data[0]),
                'fecha' => Carbon::createFromFormat('d.m.Y', strval($array_data[1]))->format('Y-m-d'),
                'descripcion' => strval($array_data[2]),
                'categoria' => strval($array_data[3]),
                'monto_inicial' => floatval($array_data[4]),
                'monto_final' => floatval($array_data[5]),
                'etiqueta' => strval($array_data[6]),
            ];

            $insertarRegistros[] = array_merge(self::$infoBalanza, $registro);
            self::$contador++;
        }
        $this->insertarRegistro($insertarRegistros);
    }

    /**
     * @author Victor J. <github.com:maximovj>
     * @date 21/03/2024
     * @desc The function `insertarRegistro` inserts or updates records in a database table using unique
     * columns specified in an array.
     * @param insertarRegistros The parameter `` appears to be an array containing
     * data to be inserted or updated in a database table. In this case, it seems to be related to
     * financial reports based on the column names provided in the `` array.
     * @return void
     */
    public function insertarRegistro($insertarRegistros)
    {
        $columnasUnicas = [
            'balanza_id',
            'no_cuenta',
            'fecha',
            'descripcion',
            'categoria',
            'monto_inicial',
            'monto_final',
            'etiqueta',
        ];

        InformeFinanciero::upsert($insertarRegistros, $columnasUnicas, $columnasUnicas);
    }

    /**
    * @author Victor J. <github.com:maximovj>
    * @date 21/03/2024
    * @desc This PHP function named getMensaje() returns the value of the property .
    * @return The `mensaje` property is being returned by the `getMensaje` method.
    */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    public function validator(Collection $row){
        $registro = array_slice($row->toArray(),0, 7);
        //var_dump($registro);

        $validator = Validator::make($registro,
        [
            '0' => 'required',
            '1' => 'required|date_format:d.m.Y',
            '2' => 'required|string|min:3',
            '3' => 'required|string|min:3',
            '4' => 'sometimes|numeric|nullable',
            '5' => 'sometimes|numeric|nullable',
            '6' => 'required|string|min:3|nullable',
        ]);

        if($validator->fails()){
            //var_dump($validator->errors()->all());
            return [
                'passes' => false,
                'array_data' => [],
            ];
        }

        return [
            'passes' => true,
            'array_data' => $validator->validate(),
        ];
    }

}
