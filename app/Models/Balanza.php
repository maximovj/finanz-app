<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Balanza extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'balanzas';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];
    protected $appends = ['append-rango', 'append-periodo'];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /**
     * @author Victor J. <github.com:maximovj>
     * @date 18/03/2024
     * @desc The function `getAppendRangoAttribute` returns a value based on the period type and specific
     * attributes in a PHP class.
     * @return The `getAppendRangoAttribute` function returns a value based on the `periodo` attribute
     * of the object.
     */
    public function getAppendRangoAttribute()
    {
        $value = 'N/A';
        switch($this->periodo){
            case 'anual': $value = $this->anio_1era; break;
            case 'rango_especifico': $value = $value = $this->mes_1era.' - '.$this->anio_1era; break;
            case 'periodo_especifico':
                $value = $this->mes_1era.' - '.$this->anio_1era . ' | ' .
                        $this->mes_2da.' - '.$this->anio_2da;
            break;
        }
        return $value;
    }

    public function getAppendPeriodoAttribute(){
        $value = 'N/A';
        switch($this->periodo){
            case 'anual': $value = 'Anual'; break;
            case 'rango_especifico': $value = 'Rango especifico'; break;
            case 'periodo_especifico': $value = 'Periodo especifico'; break;
        }
        return $value;
    }


    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
