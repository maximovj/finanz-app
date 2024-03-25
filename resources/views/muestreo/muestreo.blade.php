@extends(backpack_view('blank'))
<script>
    //var chart_js = @json($chart_monto['montos_iniciales']);
    //console.log(chart_js);
</script>
@php
    //dd($chart_monto['montos_iniciales']);
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
                    <div class="row center-items mb-4">
                        <div class="col-sm-12 col-md-11">
                            <div class="finanz-chart-box">
                                <canvas id="myChart-4" class="finanz-chart-render"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="row center-items mb-4">
                        <div class="col-sm-12 col-md-6">
                            <div class="finanz-chart-box wp-80">
                                <canvas id="myChart-2" class="finanz-chart-render"></canvas>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="finanz-chart-box wp-80">
                                <canvas id="myChart-3" class="finanz-chart-render"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="row center-items mb-4">
                        <div class="col-sm-12 col-md-11">
                            <div class="finanz-chart-box wp-100">
                                <canvas id="myChart" class="finanz-chart-render"></canvas>
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

@endsection

@section('after_scripts')
<script src="../../js/custom/chart-mes.js"></script>
<script src="../../js/custom/chart-etiqueta.js"></script>
<script src="../../js/custom/chart-categoria.js"></script>
<script src="../../js/custom/chart-monto.js"></script>
<script>
    const Utils = ChartUtils.init();
    var chart_mes_meses = @json($chart_mes['meses']);
    var chart_mes_saldos_inicial = @json($chart_mes['saldos_inicial']);
    var chart_mes_saldos_final = @json($chart_mes['saldos_final']);

    var chart_categoria_categorias = @json($chart_categoria['categorias']);
    var chart_categoria_saldos = @json($chart_categoria['saldos']);

    var chart_etiqueta_etiquetas = @json($chart_etiqueta['etiquetas']);
    var chart_etiqueta_saldos_inicial = @json($chart_etiqueta['saldos_inicial']);
    var chart_etiqueta_saldos_final = @json($chart_etiqueta['saldos_final']);

    var chart_monto_descripciones = @json($chart_monto['descripciones']);
    var chart_monto_montos_iniciales = @json($chart_monto['montos_iniciales']);
    var chart_monto_montos_finales = @json($chart_monto['montos_finales']);

    $(document).ready(function(){
        const ctx = document.getElementById('myChart');
        initChartMes(ctx, chart_mes_meses, chart_mes_saldos_inicial, chart_mes_saldos_final);

        const ctx2 = document.getElementById('myChart-2');
        initChartCategoria(ctx2, chart_categoria_categorias, chart_categoria_saldos);

        const ctx3 = document.getElementById('myChart-3');
        initChartEtiqueta(ctx3, chart_etiqueta_etiquetas, chart_etiqueta_saldos_final);

        const ctx4 = document.getElementById('myChart-4');
        initChartMonto(ctx4, chart_monto_descripciones, chart_monto_montos_iniciales, chart_monto_montos_finales);
    });
</script>
@endsection
