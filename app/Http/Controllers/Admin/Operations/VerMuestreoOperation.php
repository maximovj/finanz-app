<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Http\Controllers\System\MuestreoController;
use Illuminate\Support\Facades\Route;

trait VerMuestreoOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupVerMuestreoRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/ver-muestreo', [
            'as'        => $routeName.'.vermuestreo',
            'uses'      => $controller.'@ver_muestreo',
            'operation' => 'vermuestreo',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupVerMuestreoDefaults()
    {
        $this->crud->allowAccess('vermuestreo');

        $this->crud->operation('vermuestreo', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
        });

        $this->crud->operation('list', function () {
            $this->crud->addButton('top', 'vermuestreo', 'view', 'crud::buttons.ver_muestreo');
            // $this->crud->addButton('line', 'vermuestreo', 'view', 'crud::buttons.vermuestreo');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function ver_muestreo()
    {
        $this->crud->hasAccessOrFail('vermuestreo');
        $muestreo_controller = new MuestreoController();

        // Set data for view BackPack
        $balanza = session('balanza_current');
        $this->data['balanza'] = $balanza;
        $this->data['chart_mes'] = $muestreo_controller->getMuestreoDatos();
        $this->data['chart_categoria'] = $muestreo_controller->getMuestreoCategoria();
        $this->data['chart_etiqueta'] = $muestreo_controller->getMuestreoEtiqueta();
        $this->data['chart_monto'] = $muestreo_controller->getMuestreoMonto();

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = 'Muestreo';
        $this->data['subtitle'] = 'Ver detalles';

        // load the view
        return view("muestreo.muestreo", $this->data);
    }
}
