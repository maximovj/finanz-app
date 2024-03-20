<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\BalanzaRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class BalanzaCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class BalanzaCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    //use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    use \App\Http\Controllers\Admin\Operations\BalanzaAccionesOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Balanza::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/balanza');
        CRUD::setEntityNameStrings('balanza', 'balanzas');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->orderButtons('line',['balanzaacciones', 'delete']);
        $this->crud->removeButtons(['update', 'delete', 'line']);
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
            'name' => 'titulo',
            'type' => 'text',
            'label' => 'Titulo',
        ]);

        // Create new column
        $this->crud->addColumn([
            'name' => 'descripcion',
            'type' => 'text',
            'label' => 'Descripción',
        ]);

        // Create new column
        $this->crud->addColumn([
            'name' => 'append_periodo',
            'type' => 'text',
            'label' => 'Periodo',
        ]);

        // Create new column
        $this->crud->addColumn([
            'name' => 'append_rango',
            'type' => 'text',
            'label' => 'Rango',
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
        CRUD::setValidation(BalanzaRequest::class);
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

    public function addFields(){

        // Create new field
        $this->crud->addField([
            'name' => 'custom_html-mensaje',
            'type' => 'custom_html',
            'value' => '<span>Observación:</span><br><span>Todos los campos que tienen (*) son requeridos.</span>',
            'wrapper' => [
                'style' => 'color:red;font-style:italic;',
            ]
        ]);

        // Create new field
        $this->crud->addField([
            'name' => 'titulo',
            'type' => 'text',
            'label' => 'Titulo',
            'attributes' => [
                'required' => 'true',
            ],
        ]);

        // Create new field
        $this->crud->addField([
            'name' => 'descripcion',
            'type' => 'textarea',
            'label' => 'Descripción',
            'attributes' => [
                'required' => 'true',
            ],
        ]);

        // Create new field
        $this->crud->addField([
            'name' => 'periodo',
            'type' => 'finanz_select-period',
            'label' => 'Seleccione un periodo',
            'allows_null' => false,
            'default' => 'na',
            'options' => [
                'na' => 'Ninguno',
                'anual' => 'Anual',
                'rango_especifico' => 'Rango especifico',
                'periodo_especifico' => 'Periodo especifico',
            ]
        ]);

        // Create new field
        $this->crud->addField([
            'name'        => 'anio_1era',
            'label'       => "Seleccione un año de inicio",
            'type'        => 'select_from_array',
            'options'     => $this->getAniosDesc(),
            'allows_null' => false,
            'default'     => 'one',
            'wrapper' => [
                'id' => 'balanza-anio_1era',
                'class' => 'col-md-6'
            ]
        ]);

        // Create new field
        $this->crud->addField([
            'name' => 'mes_1era',
            'type' => 'select2_from_array',
            'label' => 'Seleccione un mes de inicio',
            'allows_null' => false,
            'options' => $this->getMeses(),
            'wrapper' => [
                'id' => 'balanza-mes_1era',
                'class' => 'col-md-6'
            ]
        ]);

        // Create new field
        $this->crud->addField([
            'name'        => 'anio_2da',
            'label'       => "Seleccione un año de inicio",
            'type'        => 'select_from_array',
            'options'     => $this->getAniosDesc(),
            'allows_null' => false,
            'default'     => 'one',
            'wrapper' => [
                'id' => 'balanza-anio_2da',
                'class' => 'col-md-6'
            ]
        ]);

        // Create new field
        $this->crud->addField([
            'name' => 'mes_2da',
            'type' => 'select2_from_array',
            'label' => 'Seleccione un mes de inicio',
            'allows_null' => false,
            'options' => $this->getMeses(),
            'wrapper' => [
                'id' => 'balanza-mes_2da',
                'class' => 'col-md-6'
            ]
        ]);

    }

    private function getAniosDesc()
    {
        $options = [];
        for ($year = 2024; $year >= 1940; $year--) {
            $options[$year] = "$year";
        }
        return $options;
    }

    private function getMeses(){
        return [
            'Enero'     => 'Enero',
            'Febrero'   => 'Febrero',
            'Marzo'     => 'Marzo',
            'Abril'     => 'Abril',
            'Mayo'      => 'Mayo',
            'Junio'     => 'Junio',
            'Julio'     => 'Julio',
            'Agosto'    => 'Agosto',
            'Octubre'   => 'Octubre',
            'Noviembre' => 'Noviembre',
            'Septiembre'=> 'Septiembre',
            'Diciembre' => 'Diciembre',
        ];
    }

}
