<?php

namespace App\Http\Controllers\System;

use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class AyudaImportarExcelCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class AyudaController extends CrudController
{

    public function setup()
    {
        CRUD::setEntityNameStrings('Ayuda', 'Ayuda');
    }

    public function ayuda_importar_excel(){

        // Set data enviroment for view BackPack
        $this->data['crud'] = $this->crud;
        $this->data['title'] = 'Importar Excel';
        $this->data['subtitle'] = 'Ayuda';
        $this->data['section'] = 'Importar Excel';

        // Get view
        return view("ayuda.importar-excel", $this->data);
    }

}
