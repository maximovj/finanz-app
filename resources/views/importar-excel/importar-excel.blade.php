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
                            <div class="form-group">
                                <label for="archivo-excel">Seleccionar archivo excel</label>
                                <input required type="file" name="archivo-excel" id="archivo-excel" class="form-control" placeholder="archivo-excel" aria-describedby="helpArchivoExcel">
                                <div class="invalid-feedback">El archivo debe ser un archivo de hojas de calculo con extensión .xlsx o .xls</div>
                                <small id="helpArchivoExcel" class="text-muted">Asegúrese de incluir todas las columnas requeridas.</small>
                            </div>
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input" id="validar-columnas" name="validar-columnas" required>
                                <label class="custom-control-label" for="validar-columnas">Mi archivo incluye todas las columnas requeridas.</label>
                                <div class="invalid-feedback">Este campo es obligatorio</div>
                            </div>
                    </div>
                </div>
            </div>
            <div>
                <button onclick="fngImportarExcel(this)" class="btn btn-success">Importar</button>
            </div>
	</div>
</div>
@endsection

@section('before_scritps')

@endsection

@section('after_scripts')
<script>

    function fnHandlerFormFields(){
        // get values for each input
        const archivoExcel = $('#archivo-excel')[0].files[0];
        const validarColumnas = $('#validar-columnas').prop('checked');

        // check validate values for `archivo-excel` input
        if(!archivoExcel)
        {
            $('#archivo-excel').addClass('is-invalid');
        } else {
            $('#archivo-excel').removeClass('is-invalid');
            $('#archivo-excel').addClass('is-valid');
        }

        // check validate values for `validar-columnas` input
        if(!validarColumnas)
        {
            $('#validar-columnas').addClass('is-invalid');
        } else {
            $('#validar-columnas').removeClass('is-invalid');
            $('#validar-columnas').addClass('is-valid');
        }

        if(!validarColumnas || !archivoExcel){
            return false;
        }

        if (!archivoExcel.type.toLowerCase().includes('sheet') ||
            !archivoExcel.name.toLowerCase().endsWith('.xlsx') &&
            !archivoExcel.name.toLowerCase().endsWith('.xls') )
        {
            $('#archivo-excel').removeClass('is-valid');
            $('#archivo-excel').addClass('is-invalid');
            return false;
        }

        return true;
    }

    async function fngImportarExcel(event) {

        if(!fnHandlerFormFields()){
            return;
        }

        // get values for each input
        const formData = new FormData();
        const archivoExcel = $('#archivo-excel')[0].files[0];
        const validarColumnas = $('#validar-columnas').prop('checked');

        formData.append('archivo-excel', archivoExcel);

        // Generate URL with a token
        let generarUrl = "{{ route('informe-financiero.importar_excel_balanza', ['token' => ':token']) }}";
        generarUrl = generarUrl.replace(':token', "{{ $balanza->token }}");

        await fetch(generarUrl, {
            method: 'POST',
            headers: {
                'x-csrf-token': '{{ csrf_token() }}'
            },
            body: formData,
        })
        .then(res => res.json())
        .then(res => {
            alert('Peticón exitosa.');
            console.log(res);
        })
        .catch(err => {
            alert('Error de petición');
        });

    }
</script>
@endsection


