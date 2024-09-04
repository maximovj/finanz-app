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
                    <div id="accordion">
                    <div class="card">
                            <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseZero" aria-expanded="true" aria-controls="collapseZero">
                                Pasos para importación Excel
                                </button>
                            </h5>
                            </div>

                            <div id="collapseZero" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <p>
                                    El sistema requiere de crear una balanza antes de importar datos desde un archivo Excel, es requerido para que el sistema, puedo ordenar las cuentas / los datos por balanza.
                                </p>
                                <p>Los pasos para la importación de datos desde un archivo Excel:</p>
                                <p>
                                    <span class="badge badge-primary">Paso 1</span><br/>
                                    <span class="text-muted fs-12 p-clear">Crear una balanza en el sistema, desde la página de "Balanzas".</span><br/>
                                    <span class="text-muted fs-10 p-clear">Puedes crear una balanza <a href="{{ route('balanza.create') }}" target="_blank">(Aquí)</a></span>
                                </p>
                                <p>
                                    <span class="badge badge-primary">Paso 2</span><br/>
                                    <span class="text-muted fs-12 p-clear">Dar clic en acciones y seleccionar la opción "Estado flujo de efectivo".</span><br/>
                                    <span class="text-muted fs-10 p-clear">Nota: El sistema genera un token para importar datos desde una archivo Excel.</span>
                                </p>
                                <p>
                                    <span class="badge badge-primary">Paso 3</span><br/>
                                    <span class="text-muted fs-12 p-clear">Dar clic en "Importar Excel", desde la página de "Informe Financieros".</span><br/>
                                    <span class="text-muted fs-10 p-clear">Nota: El sistema genera una tabla con todos los datos de validación para tu archivo Excel.</span>
                                </p>
                                <p>
                                    <span class="badge badge-primary">Paso 4</span><br/>
                                    <span class="text-muted fs-12 p-clear">Agregar los datos de validación en tu archivo Excel, en la columna B1-B5.</span><br/>
                                    <span class="text-muted fs-10 p-clear">Nota: Puedes descargar una plantilla de Excel <a href="{{ asset('storage/finanz/EF-Plain.xlsx') }}" download>(Aquí)</a>.</span>
                                </p>
                                <p>
                                    <span class="badge badge-primary">Paso 5</span><br/>
                                    <span class="text-muted fs-12 p-clear">Agregar datos en las 7 columnas e información requeridas para el sistema.</span><br/>
                                    <span class="text-muted fs-10 p-clear">Nota: Consulte Ayuda > Importar Excel > Columnas e información requeridas.</span>
                                </p>
                                <p>
                                    <span class="badge badge-primary">Paso 6</span><br/>
                                    <span class="text-muted fs-12 p-clear">Seleccionar tu archivo Excel, desde el formulario "Importar Excel".</span><br/>
                                </p>
                                <p>
                                    <span class="badge badge-primary">Paso 7</span><br/>
                                    <span class="text-muted fs-12 p-clear">Marcar checkbox de "Mi archivo incluye todas las columnas requeridas", desde el formulario "Importar Excel".</span><br/>
                                </p>
                                <p>
                                    <span class="badge badge-primary">Paso 8</span><br/>
                                    <span class="text-muted fs-12 p-clear">Dar clic en el botón de "Importar", desde el formulario "Importar Excel".</span><br/>
                                    <span class="text-muted fs-10 p-clear">Nota: El sistema primero leerá los datos de validación, posterior importará los datos del archivo Excel. El sistema no guarda el documento Excel, en el servidor.</span>
                                </p>
                            </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingOne">
                            <h5 class="mb-0">
                                <button class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Datos de validación
                                </button>
                            </h5>
                            </div>

                            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                            <div class="card-body">
                                <p>
                                    El sistema requiere de 5 columnas en tu archivo Excel, para importar datos en el sistema, es necesario colocar los datos en el columna B1-B5, en las primeras 5 filas de tu archivo Excel.
                                </p>
                                <p>Los columnas de validación requeridas para el archivo Excel son:</p>
                                <p>
                                    <span class="badge badge-primary">Software</span><br/>
                                    <span class="text-muted fs-12 p-clear">Esta columna es exclusividad para el sistema, el valor siempre debe ser FinanzApp.</span>
                                </p>
                                <p>
                                    <span class="badge badge-primary">Periodo</span><br/>
                                    <span class="text-muted fs-12 p-clear">Esta columna es el periodo de la balanza actual (Esto es generado por el sistema).</span>
                                </p>
                                <p>
                                    <span class="badge badge-primary">Rango</span><br/>
                                    <span class="text-muted fs-12 p-clear">Esta columna es el rango de la balanza actual (Esto es generado por el sistema).</span>
                                </p>
                                <p>
                                    <span class="badge badge-primary">No. Balanza</span><br/>
                                    <span class="text-muted fs-12 p-clear">Esta columna es el número / id de balanza actual (Esto es generado por el sistema).</span>
                                </p>
                                <p>
                                    <span class="badge badge-primary">Token</span><br/>
                                    <span class="text-muted fs-12 p-clear">Esta columna es el token / clave secreta para balanza actual (Esto es generado por el sistema).</span>
                                </p>
                                <figure>
                                    <img class="w-100" src="{{ asset('storage/finanz/datos-de-validacion.webp') }}" alt="datos-de-verifacion.jpg" loading="lazy">
                                    <figcaption class="text-muted">Fig.1 - Datos de validación</figcaption>
                                </figure>
                            </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" id="headingTwo">
                            <h5 class="mb-0">
                                <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Columnas e información requeridas
                                </button>
                            </h5>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                            <div class="card-body">
                                <p>
                                    El sistema requiere de 7 columnas en tu archivo Excel, para importar datos en el sistema. Puede descargar una plantilla <a href="{{ asset('storage/finanz/EF-Plain.xlsx') }}" download>(Aquí)</a>.
                                </p>
                                <p>Los columnas requeridas para el archivo Excel son:</p>
                                <p>
                                    <span class="badge badge-primary">id/no_cuenta</span><br/>
                                    <span class="text-muted fs-12 p-clear">Esta columna es personalizable, puede ingresar un número de referencia, número de cuenta, etc.</span>
                                </p>
                                <p>
                                    <span class="badge badge-primary">fecha</span><br/>
                                    <span class="text-muted fs-12 p-clear">Esta columna es para agregar fecha, el formato requerido para el sistema es: dd.mm.YY</span>
                                </p>
                                <p>
                                    <span class="badge badge-primary">descripción</span><br/>
                                    <span class="text-muted fs-12 p-clear">Esta columna es personalizable, puede ingresar el concepto o descripción para el registro / cuenta.</span>
                                </p>
                                <p>
                                    <span class="badge badge-primary">categoría</span><br/>
                                    <span class="text-muted fs-12 p-clear">Esta columna es para clasificar la cuenta, la información requerida es: ninguno, gasto, ingreso, prestamo, ahorro (sin tildes).</span>
                                </p>
                                <p>
                                    <span class="badge badge-primary">monto inicial</span><br/>
                                    <span class="text-muted fs-12 p-clear">Esta columna es personalizable, puede ingresar el monto inicial / monto antes del gasto.</span>
                                </p>
                                <p>
                                    <span class="badge badge-primary">monto final</span><br/>
                                    <span class="text-muted fs-12 p-clear">Esta columna es personalizable, puede ingresar el monto final / gasto.</span>
                                </p>
                                <p>
                                    <span class="badge badge-primary">etiqueta</span><br/>
                                    <span class="text-muted fs-12 p-clear">Esta columna es para clasificar la cuenta, la información requerida es: ninguno, credito, debito, patrimonio, capital (sin tildes).</span>
                                </p>
                                <figure>
                                    <img class="w-100" src="{{ asset('storage/finanz/columnas-requeridas.webp') }}" alt="Columnas requeridas" loading="lazy">
                                    <figcaption class="text-muted">Fig.2 - Columnas requerida en archivo excel.</figcaption>
                                </figure>
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



