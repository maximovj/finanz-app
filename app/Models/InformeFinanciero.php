<?php

namespace App\Models;

use App\Models\Balanza;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class InformeFinanciero extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'informes_financieros';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * @author Victor J. <github.com:maximovj>
     * @date 18/03/2024
     * @desc The `balanza` function defines a relationship where the current object belongs to a `Balanza`
     * object using the specified foreign key and local key.
     * @return The code snippet is defining a relationship method named `balanza` in a Laravel Eloquent
     * model. This method specifies that the current model belongs to a `Balanza` model using the
     * foreign key `balanza_id` on the current model and the primary key `id` on the `Balanza` model.
     * When this method is called, it will return the related `Balanza` model instance
     */
    public function balanza(){
        return $this->belongsTo(Balanza::class, 'balanza_id', 'id');
    }

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
