<?php

namespace App\Http\Controllers\Admin\Operations;

use Illuminate\Support\Facades\Route;

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
        Route::get($segment.'/balanzaacciones', [
            'as'        => $routeName.'.balanzaacciones',
            'uses'      => $controller.'@balanzaacciones',
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
     * @return Response
     */
    public function balanzaacciones()
    {
        $this->crud->hasAccessOrFail('balanzaacciones');

        // prepare the fields you need to show
        $this->data['crud'] = $this->crud;
        $this->data['title'] = $this->crud->getTitle() ?? 'balanzaacciones '.$this->crud->entity_name;

        // load the view
        return view("crud::operations.balanzaacciones", $this->data);
    }
}
