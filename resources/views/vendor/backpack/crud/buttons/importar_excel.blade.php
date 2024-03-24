@if($crud->hasAccess('importarexcel'))
    <a href="{{ url($crud->route.'/importar-excel') }}" class="btn btn-primary" data-style="zoom-in">
        <span class="ladda-label">
            <i class="la la-magic"></i>
            Importar Excel
        </span>
    </a>
@endif
