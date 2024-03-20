<?php

namespace App\Http\Controllers\Admin\Operations;

use Illuminate\Support\Facades\Route;
use Prologue\Alerts\Facades\Alert;

trait ImportarExcelOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupImportarExcelRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/importar-excel', [
            'as'        => $routeName.'.import_excel',
            'uses'      => $controller.'@import_excel',
            'operation' => 'importarexcel',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupImportarExcelDefaults()
    {
        $this->crud->allowAccess('importarexcel');

        $this->crud->operation('importarexcel', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
        });

        $this->crud->operation('list', function () {
            $this->crud->addButton('top', 'importarexcel', 'view', 'crud::buttons.importar_excel');
            // $this->crud->addButton('line', 'importarexcel', 'view', 'crud::buttons.importarexcel');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @return Response
     */
    public function import_excel()
    {
        $this->crud->hasAccessOrFail('importarexcel');

        // check if exists `balanza_current`
        $balanza = session('balanza_current');
        if(!$balanza){
            Alert::error('Lo siento, balanza no encontrado en el sistema')->flash();
            return redirect()->back();
        }

        // Set data for view BackPack
        $this->data['balanza'] = $balanza;

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = 'Importar excel';
        $this->data['subtitle'] = '';
        $this->data['section'] = 'Importar Excel';

        // load the view
        return view("importar-excel.importar-excel", $this->data);
    }
}
