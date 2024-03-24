@extends(backpack_view('blank'))

@php
    //dd($muestreo);
@endphp

@php
  $defaultBreadcrumbs = [
    trans('backpack::crud.admin') => url(config('backpack.base.route_prefix'), 'dashboard'),
    $crud->entity_name_plural => url($crud->route),
    'Muestreo' => true,
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
	<div class="col-md-12">
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
                    <div>
                        <canvas id="myChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
	</div>
</div>
@endsection

@section('before_scritps')

@endsection

@section('after_scripts')
<!-- <script src="../../js/examples/stacked-bar-line.js"></script> -->
<script src="../../js/custom/chart-muestreo.js"></script>
<script>
    const Utils = ChartUtils.init();
    var meses = @json($muestreo['meses']);
    var saldos_totales = @json($muestreo['saldos']);

    $(document).ready(function(){
        const ctx = document.getElementById('myChart');
        chartMuestreo(ctx, meses, saldos_totales, saldos_totales);
    });
</script>
@endsection
