@extends('adminlte::page')
@section('title', 'Dashboard')

@section('content_header')
<h1>Tecontrol - Home</h1>
@stop

@section('content')
<div class="row">
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
            <div class="inner">
                <div class="row">
                    <div class="col">
                        <span>Dolar Compra: </span>
                        <h3>{{ number_format($cotizaciones->dolarCompra,2,",",".") }}</h3>

                        <span>Euro Compra: </span>
                        <h3>{{ number_format($cotizaciones->euroCompra,2,",",".") }}</h3>
                    </div>
                    <div class="col">
                        <span>Dolar Venta: </span>
                        <h3>{{ number_format($cotizaciones->dolarVenta,2,",",".") }}</h3>

                        <span>Euro Venta: </span>
                        <h3>{{ number_format($cotizaciones->euroVenta,2,",",".") }}</h3>
                    </div>
                </div>
            </div>
            <div class="icon">
                <i class="fas fa-fw fa-dollar-sign "></i>
            </div>
            <a href="https://www.bna.com.ar/Personas" target="_blank" class="small-box-footer">MONEDAS - Cotizacion BNA
                <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
            <div class="inner">
                <div class="row">
                    <div class="col">
                        <span style="font-size: smaller;">Dolar Divisa Compra: </span>
                        <h3>{{ number_format($cotizaciones->dolarDivisaCompra,2,",",".") }}</h3>

                        <span style="font-size: smaller;">Euro Divisa Compra: </span>
                        <h3>{{ number_format($cotizaciones->euroDivisaCompra,2,",",".") }}</h3>
                    </div>
                    <div class="col">
                        <span style="font-size: smaller;">Dolar Divisa Venta: </span>
                        <h3>{{ number_format($cotizaciones->dolarDivisaVenta,2,",",".") }}</h3>

                        <span style="font-size: smaller;">Euro DIvisa Venta: </span>
                        <h3>{{ number_format($cotizaciones->euroDivisaVenta,2,",",".") }}</h3>
                    </div>
                </div>
            </div>
            <div class="icon">
                <i class="fas fa-fw fa-dollar-sign "></i>
            </div>
            <a href="https://www.bna.com.ar/Personas#divisas" target="_blank" class="small-box-footer">DIVISAS -
                Cotizacion BNA <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        @livewire('admin.cotiz-graf')
    </div>
</div>

@stop

@section('css')
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Ionicons -->
<link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.css"
    integrity="sha512-C7hOmCgGzihKXzyPU/z4nv97W0d9bv4ALuuEbSf6hm93myico9qa0hv4dODThvCsqQUmKmLcJmlpRmCaApr83g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css"
    integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>

<script>
    setTimeout(function () {
        var estadosIni = @json($estadosIni);
        var totalesIni = @json($totalesIni);
        var coloresIni = @json($coloresIni);
        Livewire.emit('graph', estadosIni, totalesIni, coloresIni);

        var estadosPie = @json($estadosPie);
        var totalesPie = @json($cantPie);
        var coloresPie = @json($coloresPie);
        Livewire.emit('graph2', estadosPie, totalesPie, coloresPie);
    }, 100);
    
    Livewire.on('graph', function(estados, datTotales, colores){
        const totales = [];
        datTotales.forEach(myFunction);
        function myFunction(item) {
            totales.push(parseInt(item));
        }

        const coloresBarras = ['#c5e0b4', '#ff5050','#e6e396','#5b9bd5','#317775','#92d050', '#373837'];

        Highcharts.chart('container-graph', {
            chart: {
                type: 'bar'
            },
            
            title: {
                text: ''
            },
            xAxis: {
                categories: estados
            },
            yAxis: {
                title: {
                    text: ''
                }
            },
            plotOptions: {
                series: {
                    stacking: 'normal',
                    dataLabels: {
                    enabled: true,
                    }
                },
                
            },
            legend: {
                enabled: false
            },
            series: [{
                name: 'Totales',
                data: totales,
                colorByPoint: true,
                colors: colores
            }]
        });
    });

    Livewire.on('graph2', function(estadosPie, totalesPie, coloresPie){
        const totales = [];
        totalesPie.forEach(myFunction);
        function myFunction(item) {
            totales.push(parseInt(item));
        }

        Highcharts.chart('container-graph2', {
            chart: {
                type: 'pie'
            },
            
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '<b>{point.name}: {point.y} </b> '
            },
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}: {point.y}</b> <br>({point.percentage:.1f}%)'
                    }
                }
            },
            series: [{
        name: 'Porcentaje',
        colorByPoint: true,
        colors: coloresPie,
        data: estadosPie.map(function (estado, index) {
            return {
                name: estado,
                y: totales[index]
            };
        })
    }]
        });
    });

</script>

@stop