<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\InformeFinancieroRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Support\Facades\DB;

/**
 * Class InformeFinancieroCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class InformeFinancieroCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\InformeFinanciero::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/informe-financiero');
        CRUD::setEntityNameStrings('informe financiero', 'informe financieros');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->addColumns();

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Show operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);
        $this->addColumns();

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    public function addColumns(){

        // Create new column
        $this->crud->addColumn([
            'name' => 'no_cuenta',
            'type' => 'text',
            'label' => 'No. Cuenta',
        ]);

        // Create new column
        $this->crud->addColumn([
            'name' => 'fecha',
            'type' => 'text',
            'label' => 'Fecha',
        ]);

        // Create new column
        $this->crud->addColumn([
            'name' => 'descripcion',
            'type' => 'text',
            'label' => 'Descripción',
        ]);

        // Create new column
        $this->crud->addColumn([
            'name' => 'categoria',
            'type' => 'text',
            'label' => 'Categoría',
        ]);

        // Create new column
        $this->crud->addColumn([
            'name' => 'monto_inicial',
            'type' => 'number',
            'label' => 'Monto inicial',
            'prefix'        => '$',
            //'suffix'        => ' MXN',
            'decimals'      => 2,
            'dec_point'     => '.',
            'thousands_sep' => ',',
        ]);

        // Create new column
        $this->crud->addColumn([
            'name' => 'monto_final',
            'type' => 'number',
            'label' => 'Monto final',
            'prefix'        => '$',
            //'suffix'        => ' MXN',
            'decimals'      => 2,
            'dec_point'     => '.',
            'thousands_sep' => ',',
        ]);

        // Create new column
        $this->crud->addColumn([
            'name' => 'etiqueta',
            'type' => 'text',
            'label' => 'Etiqueta',
        ]);

    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(InformeFinancieroRequest::class);
        $this->addFields();

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function addFields(){

        // Create new field
        $this->crud->addField([
            'name' => 'finanz_form-alert',
            'type' => 'finanz_form-alert',
        ]);

        // Create new field
        $this->crud->addField([  // Select2
        'label'     => "Seleccione una balanza",
        'type'      => 'select2',
        'name'      => 'balanza_id', // the db column for the foreign key
        'entity'    => 'balanza', // the method that defines the relationship in your Model
        'attribute' => 'custom_title', // foreign key attribute that is shown to user
        'options'   => (function ($query) {
                return $query->orderBy('titulo', 'ASC')->get(['id', DB::raw("CONCAT(id,' - ',titulo) as custom_title")]);
            }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
        ]);

        // Create new field
        $this->crud->addField([
            'name' => 'no_cuenta',
            'type' => 'text',
            'label' => 'No. de cuenta',
            'attributes' => [
                'required' => 'true',
            ]
        ]);

        // Create new field
        $this->crud->addField([
            'name' => 'descripcion',
            'type' => 'text',
            'label' => 'Descripción',
            'attributes' => [
                'required' => 'true',
            ]
        ]);

        // Create new field
        $this->crud->addField([
            'name' => 'categoria',
            'type' => 'select_from_array',
            'label' => 'Categoría',
            'allows_null' => false,
            'default' => 'na',
            'options' => $this->getCategorias(),
        ]);

        // Create new field
        $this->crud->addField([
            'name' => 'etiqueta',
            'type' => 'select_from_array',
            'label' => 'Etiqueta',
            'allows_null' => false,
            'default' => 'na',
            'options' => $this->getEtiquetas(),
        ]);

        // Create new field
        $this->crud->addField([
            'name' => 'monto_inicial',
            'type' => 'number',
            'label' => 'Monto inicial',
            'value' => 0,
            'attributes' => ["step" => "any"], // allow decimals
            'prefix'     => "$",
            'suffix'     => ".00",
        ]);

        // Create new field
        $this->crud->addField([
            'name' => 'monto_final',
            'type' => 'number',
            'label' => 'Monto final',
            'value' => 0,
            'attributes' => ["step" => "any"], // allow decimals
            'prefix'     => "$",
            'suffix'     => ".00",
        ]);
    }

    protected function getCategorias(){
        return [
            'na' => 'Ninguno',
            'gasto' => 'Gasto',
            'ingreso' => 'Ingreso',
            'ahorro' => 'Ahorro',
            'prestamo' => 'Prestamo',
        ];
    }

    protected function getEtiquetas(){
        return [
            'na' => 'Ninguno',
            'credito' => 'Tarjeta de credito',
            'debito' => 'Tarjeta de debito',
            'patrimonio' => 'Patrimonio',
            'capital' => 'Capital'
        ];
    }

}
