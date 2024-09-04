@if($crud->hasAccess('vermuestreo'))
    <a href="{{ url($crud->route.'/ver-muestreo') }}" class="btn btn-primary" data-style="zoom-in">
        <span class="ladda-label">
            <i class="la la-magic"></i>
            Ver muestreo
        </span>
    </a>
@endif
