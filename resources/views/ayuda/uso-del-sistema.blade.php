@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => route('finanz.ayuda.importar-excel'),
    $section ?? 'Section' => route('finanz.ayuda.importar-excel'),
  ];

  // if breadcrumbs aren't defined in the CrudController, use the default breadcrumbs
  $breadcrumbs = $breadcrumbs ?? $defaultBreadcrumbs;
@endphp

@section('header')
	<section class="container-fluid">
	  <h2>
        <span class="text-capitalize">{!! $title ?? 'Title' !!}</span>
        <small>{!! $subtitle ?? 'Subtitle' !!}.</small>

        @if ($crud->hasAccess('list'))
          <small><a href="{{ url($crud->route) }}" class="d-print-none font-sm"><i class="la la-angle-double-{{ config('backpack.base.html_direction') == 'rtl' ? 'right' : 'left' }}"></i> {{ trans('backpack::crud.back_to_all') }} <span>{{ $crud->entity_name_plural }}</span></a></small>
        @endif
	  </h2>
	</section>
@endsection

@section('content')

<div class="row">
	<div class="col-md-8">
        <!-- Default header -->
        <div class="row mb-0">
            <div class="col-sm-6">
                <div class="d-print-none with-border">
                    <!-- Add buttons using element a -->
                    <!-- <a href="#" role="button" class="btn btn-success"></a> -->
                </div>
            </div>
        </div>
        <!-- Default body -->
        <div class="mx-0 my-2">
            <div class="card">
                <div class="card-body">
                    <!-- Alerta de instrucciones -->
                    <div class="form-group col-sm-12" style="margin-bottom: 0;" element="div">
                        <div class="alert alert-light alert-dismissible fade show" style="font-size: 12px;" role="alert">
                            <span style="color: red;">NOTA:</span>
                            <span style="color: red;">Haz click sobre el título de cada tema para ver la información</span>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true" style="color: black;">&times;</span>
                            </button>
                        </div>
                    </div>
                    <div id="accordion">
                        <div class="card">
                            <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Balanzas
                                </button>
                            </h5>
                            </div>

                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <p>
                                    Una balanza es un contender de estado flujo de efectivo / informe financiero, es requerido para que el sistema, puedo ordenar las cuentas / los datos por balanza. <br/>
                                    Los datos requeridos son: titulo, descripción y periodo.
                                </p>
                                <span class="text-muted fs-10 p-clear">Puedes crear una balanza <a href="{{ route('balanza.create') }}" target="_blank">(Aquí)</a></span>
                            </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Estado flujo de efectivo / Informe Financieros
                                </button>
                            </h5>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="card-body">
                                <p>
                                    Cada balanza tiene su propio estado flujo de efectivo / Informe financieros, esta página muestra todos los registros o datos de una balanza. Los registros o datos, son información de cada cuenta o movimiento de efectivo, muestra información como: No. cuenta, Fecha, Descripción, Categoría, Monto inicial, Monto final, Etiqueta y Acciones.
                                </p>
                                <span class="text-muted fs-10 p-clear">Nota: Consulte Ayuda > Importar Excel > Columnas e información requeridas.</span>
                            </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Muestreo
                                </button>
                            </h5>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="card-body">
                                <p>
                                    En la página de "Muestreo", muestra todos los registros o datos de una balanza agrupados por meses, categorías, etiquetas y montos. Para la visualización se utilizan varios tipos de gráficas.
                                </p>
                                <img src="{{ asset('finanz/chart-montos.webp') }}" alt="gráfica de montos" class="w-100" loading="lazy"/>
                                <img src="{{ asset('finanz/chart-etiquetas.webp') }}" alt="gráfica de montos" class="wp-50" loading="lazy"/>
                                <img src="{{ asset('finanz/chart-categorias.webp') }}" alt="gráfica de montos" class="wp-50" loading="lazy"/>
                                <img src="{{ asset('finanz/chart-meses.webp') }}" alt="gráfica de montos" class="w-100" loading="lazy"/>
                                <span class="text-muted fs-10 p-clear">Nota: Se utilizan montos inicial y monto final para generar los datos de las gráficas.</span><br/>
                            </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingThree">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                Importar Excel
                                </button>
                            </h5>
                            </div>
                            <div id="collapseFive" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                            <div class="card-body">
                                <p>
                                    En la página de "Importar Excel", sirve para importar datos desde una archivo Excel. <br/>
                                    El sistema requiere de 5 columnas en tu archivo Excel, para importar datos en el sistema, es necesario colocar los datos en el columna B1-B5, en las primeras 5 filas de tu archivo Excel. <br/>
                                    El sistema requiere de 7 columnas en tu archivo Excel, para importar datos en el sistema.
                                </p>
                                <span class="text-muted fs-10 p-clear">Nota: El sistema genera un token para importar datos desde una archivo Excel.</span><br/>
                                <span class="text-muted fs-10 p-clear">Nota: Consulte Ayuda > Importar Excel</span>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
@endsection

@section('before_scritps')

@section('after_scripts')



