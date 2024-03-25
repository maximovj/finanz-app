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
                        <p class="form-text text-muted fs-10 p-clear">
                            Debe colocar los siguientes datos (B1-B5), que se muestra en la tabla de a continuación, en su archivo excel para validar el documento.
                        </p>
                        <p class="form-text text-muted fs-10 p-clear">
                            Asegúrese de incluir todas las columnas e información requeridas para la importación.
                            <span class="btn-link fs-10 pointer"
                            data-img="{{asset("storage/finanz/columnas-requeridas.webp")}}"
                            data-title="Columnas requeridas"
                            data-text="Asegúrese de incluir todas las columnas e información requeridas para la importación."
                            onclick="handlerVerEjemplo(this)">(Ver ejemplo)</span>
                            <a href="#" target="_blank" rel="noopener noreferrer">(Ver guía).</a>
                        </p>
                        <br/>
                        <label><b>Datos de validación</b> <span class="btn-link fs-10 pointer"
                        data-img="{{asset("storage/finanz/datos-de-validacion.webp")}}"
                        data-title="Datos de validación"
                        data-text="Debe colocar los siguientes datos (B1-B5), que se muestra en la tabla de a continuación, en su archivo excel para validar el documento."
                        onclick="handlerVerEjemplo(this)">(Ver ejemplo)</span></label>
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
                        <p class="form-text text-muted fs-10 p-clear">
                            Descargar una plantilla de hoja de cálculo <a href="{{ asset('storage/finanz/EF-Plain.xlsx') }}" download>(Click aquí).</a>
                        </p>
                        <br>
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
async function fngImportarExcel(event) {
    if(!fnHandlerFormFields()){
        Swal.fire({
            title: "Importar Excel",
            text: "Todos los campos son requeridos!",
            icon: "error",
            timer: 2700,
            allowOutsideClick: false,
            showConfirmButton: false,
            showCancelButton: false,
            showCloseButton: false,
            didOpen: ()=>{
                toastr.error('Todos los campos son requeridos!', 'Importar Excel',{timeOut: 2000});
            }
        });
        return;
    }

    Swal.fire({
            title: "Importar Excel",
            text: "Importando archivo excel, espere por favor...",
            icon: "success",
            allowOutsideClick: false,
            showConfirmButton: false,
            showCancelButton: false,
            showCloseButton: false,
            didOpen: () => {
                Swal.showLoading();
            },
            willClose: () => {

            }
    });



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
        //alert('Peticón exitosa.');
        if(res.success){
            Swal.close();
            Swal.fire({
                title: "Importar Excel",
                text: "La importación fue exitosa!",
                icon: "success",
                timer: 2700,
                timerProgressBar: true,
                allowOutsideClick: false,
                showConfirmButton: false,
                showCancelButton: false,
                showCloseButton: false,
                didOpen: () => {
                    toastr.success('La importación fue exitosa!', 'Importar Excel',
                    {
                        timeOut: 2500,
                        progressBar: true,
                        closeDuration: 100,
                        onHidden: function() {  }
                    });
                },
                willClose: ()=>{
                    window.location.href = res.url_success;

                }
            });
        } else {
            Swal.close();
            Swal.fire({
                title: "Importar Excel",
                text: res.msg_text,
                icon: "error",
                timer: 2700,
                allowOutsideClick: false,
                showConfirmButton: false,
                showCancelButton: false,
                showCloseButton: false,
                didOpen: ()=>{
                    toastr.error(res.msg_text, 'Importar Excel',{timeOut: 2000});
                }
            });
        }
    })
    .catch(err => {
        Swal.close();
        toastr.error('Lo siento, hubo un error en el servidor', 'Importar Excel',{timeOut: 2000});
    });

    }
</script>
@endsection


