<?php

namespace App\Http\Controllers\Admin\Operations;

use App\Models\Balanza;
use Illuminate\Support\Facades\Route;
use Prologue\Alerts\Facades\Alert;

trait BalanzaAccionesOperation
{
    /**
     * Define which routes are needed for this operation.
     *
     * @param string $segment    Name of the current entity (singular). Used as first URL segment.
     * @param string $routeName  Prefix of the route name.
     * @param string $controller Name of the current CrudController.
     */
    protected function setupBalanzaAccionesRoutes($segment, $routeName, $controller)
    {
        Route::get($segment.'/{id}/estado-flujo-de-efectivo', [
            'as'        => $routeName.'.estado_flujo_de_efectivo',
            'uses'      => $controller.'@estado_flujo_de_efectivo',
            'operation' => 'balanzaacciones',
        ]);
    }

    /**
     * Add the default settings, buttons, etc that this operation needs.
     */
    protected function setupBalanzaAccionesDefaults()
    {
        $this->crud->allowAccess('balanzaacciones');

        $this->crud->operation('balanzaacciones', function () {
            $this->crud->loadDefaultOperationSettingsFromConfig();
        });

        $this->crud->operation('list', function () {
            // $this->crud->addButton('top', 'balanzaacciones', 'view', 'crud::buttons.balanzaacciones');
            $this->crud->addButton('line', 'balanzaacciones', 'view', 'crud::buttons.balanza_acciones');
        });
    }

    /**
     * Show the view for performing the operation.
     *
     * @param int $id
     * @return Response
     */
    public function estado_flujo_de_efectivo(int $id)
    {
        $this->crud->hasAccessOrFail('balanzaacciones');

        // Check if exist `$id`
        $balanza = Balanza::find($id);
        request()->session()->forget('balanza_current');

        if(!$balanza){
            Alert::error('Balanza no encontrado en el sistema')->flash();
            return redirect()->back();
        }

        // create global session
        session(['balanza_current' => (object) $balanza->toArray()]);
        return redirect()->route('informe-financiero.index');
    }
}
