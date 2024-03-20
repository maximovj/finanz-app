@extends(backpack_view('blank'))

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    $section ?? 'Section' => true,
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
                    <p class="form-text text-muted">
                        Debe colocar los siguientes datos, que se muestra en la tabla de a continuación, en su archivo excel para validar el documento.
                        Asegúrese de incluir todas las columnas requeridas (B1-B5) para la importación, para seguir con la importación, puede usar el siguiente guía <a href="#" target="_blank" rel="noopener noreferrer">click aquí</a>
                    </p>
                    <table class="table table-bordered" style="font-size: 12px;">
                        <thead>
                            <tr>
                                <th scope="col">A</th>
                                <th scope="col">B</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="finanz-bold">Software</td>
                                    <td>FinanzApp</td>
                                </tr>
                                <tr>
                                    <td class="finanz-bold">Periodo</td>
                                    <td>{{ $balanza->periodo }}</td>
                                </tr>
                                <tr>
                                    <td class="finanz-bold">Rango</td>
                                    <td>{{ $balanza->append_rango }}</td>
                                </tr>
                                <tr>
                                    <td class="finanz-bold">No. Balanza</td>
                                    <td>{{ $balanza->id }}</td>
                                </tr>
                                <tr>
                                    <td class="finanz-bold">Token</td>
                                    <td>{{ $balanza->token }}</td>
                                </tr>
                            </tbody>
                    </table>
                    <form action="">
                        <div class="form-group">
                          <label for="archivo-excel">Seleccionar archivo excel</label>
                          <input type="file" name="archivo-excel" id="archivo-excel" class="form-control" placeholder="archivo-excel" aria-describedby="helpArchivoExcel">
                          <small id="helpArchivoExcel" class="text-muted">Asegúrese de incluir todas las columnas requeridas.</small>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="checkbox" class="form-check-input" name="validar-columnas" id="validar-columnas">
                            Mi archivo incluye las columnas requeridas.
                          </label>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div>
            <button class="btn btn-success">Importar</button>
        </div>
	</div>
</div>
@endsection

@section('before_scritps')

@endsection

@section('after_scripts')

@endsection


