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
            'as'        => $routeName.'.importar_excel',
            'uses'      => $controller.'@importar_excel',
            'operation' => 'importarexcel',
        ]);

        Route::post($segment.'/importar-excel/{token}/balanza', [
            'as'        => $routeName.'.importar_excel_balanza',
            'uses'      => $controller.'@importar_excel_balanza',
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
     * @author Victor J. <github.com:maximovj>
     * @date 19/03/2024
     * @desc The function `importar_excel` checks for the existence of a current balanza, sets data for the
     * view, and loads the importar-excel view in a PHP application.
     * @return The `importar_excel` function is returning a view called "importar-excel.importar-excel"
     * along with the data stored in `->data`. The view is being passed the data array which
     * includes information such as the current balanza, the CRUD instance, title, subtitle, and
     * section for display purposes.
     */
    public function importar_excel()
    {
        $this->crud->hasAccessOrFail('importarexcel');

        // check if exists `balanza_current`
        $balanza = session('balanza_current');
        if(!$balanza){
            request()->session()->forget('balanza_current');
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

    public function importar_excel_balanza($token)
    {
        $this->crud->hasAccessOrFail('importarexcel');

        // check if exists `balanza_current`
        $balanza = session('balanza_current');
        if($balanza->token !== $token )
        {
            request()->session()->forget('balanza_current');
            return response()->json([
                'code' => 400,
                'success' => false,
                'msg_title' => 'Importación Excel',
                'msg_text' => 'Lo siento, el token proporcionado invalidado por el sistema.',
                'data' => [],
            ], 400);
        }

        $file = request()->file('archivo-excel');

        return response()->json([
            'code' => 200,
            'success' => true,
            'msg_title' => 'Importación Excel',
            'msg_text' => 'La exportación se ha realizado exitosamente.',
            'data' => [
                'file' => $file
            ],
        ],200);
    }


}
