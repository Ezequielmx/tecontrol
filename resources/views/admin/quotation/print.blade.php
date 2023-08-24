<!DOCTYPE html>
<html>
@php
setlocale(LC_TIME, "spanish");
@endphp

<head>
    <title>Cotización {{ $quotation->nro }}</title>
    <style>
        body {
            font-family: Calibri, sans-serif;
            font-size: 13px;
            font-weight: 400;
        }

        .container {
            width: 700px;
            margin: auto;
            /*border: 1px solid gray;*/
        }

        .logo-cell {
            width: 300px;
        }

        .logo {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .header-text {
            width: 30%;
            text-align: right;
        }

        .header-text p {
            font-size: 12px;
            margin: 3px;
            text-align: left;
        }

        table {
            border-spacing: 0px;
        }

        h3,
        h2,
        h1 {
            font-weight: 400;
        }

        h3 {
            font-size: 14px;
            margin: 0;
        }

        h2 {
            font-size: 16px;
        }

        td {
            padding: 2px;
        }


        .table-striped {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1rem;
        }

        .ths,
        .tds {
            padding: 0.4rem;
            text-align: left;
            vertical-align: top;
            border-top: 1px solid #dee2e6;
            font-size: 12px;
            vertical-align: middle;
        }

        .ths {
            background-color: #f8f9fa;
        }

        .table-striped tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body>
    <div class="container">
        <table style="width: 100%;">
            <tr>
                <td class="logo-cell" style="width: 50%">
                    <img src="{{ asset('img/logo2.png') }}" alt="Logo" class="logo">
                </td>
                <td style="width: 20%"></td>
                <td class="header-text" style="width: 30%">
                    <p><b>TECONTROL S.R.L.</b></p>
                    <p>Navarro 822 - 1722 - Merlo</p>
                    <p>Buenos Aires - Argentina</p>
                    <p>E-mail: martin@tecontrol.com.ar</p>
                    <p>ventas@tec-control.com.ar</p>
                    <p>C.U.I.T.: 30-71167661-5</p>
                </td>
            </tr>
        </table>
        <hr>
        <table style="width: 100%;">
            <tr>
                <td style="width:30%">
                    <h2>Presupuesto Nro: <b>{{ $quotation->nro}}</b></h2>
                </td>
                <td style="width:70%; text-align:right;">
                    <h3>Fecha: <b>{{ utf8_encode(strftime("%d/%m/%Y", strtotime($quotation->fecha)))}}</b></h3>
                </td>
            </tr>
        </table>
        <table style="width: 100%;">
            <tr>
                <td style="width:15%">
                    <h3>Sres: </h3>
                </td>
                <td style="width:80%">
                    <h3><b>{{ $quotation->client->razon_social}}</b></h3>
                </td>
            </tr>
            <tr>
                <td style="width:15%">
                    <h3>Dirección: </h3>
                </td>
                <td style="width:80%">
                    <h3>{{ $quotation->client->direccion}}</h3>
                </td>
                <td>
            </tr>
            <tr>
                <td style="width:15%">
                    <h3>At.: </h3>
                </td>
                <td style="width:80%">
                    <h3>{{ $quotation->contact()->first()->apellido_nombre}}</h3>
                </td>
                <td>
            </tr>
            <tr>
                <td style="width:15%">
                    <h3>Telefono: </h3>
                </td>
                <td style="width:80%">
                    <h3>{{ $quotation->contact()->first()->telefono}}</h3>
                </td>
                <td>
            </tr>
            <tr>
                <td style="width:15%">
                    <h3>Email: </h3>
                </td>
                <td style="width:80%">
                    <h3>{{ $quotation->contact()->first()->mail}}</h3>
                </td>
                <td>
            </tr>
            <tr>
                <td style="width:15%">
                    <h3>Ref.: </h3>
                </td>
                <td style="width:80%">
                    <h3>{{ $quotation->ref}}</h3>
                </td>
                <td>
            </tr>
        </table>
        <p>
            Por medio de la presente, tenemos el agrado de dirigirnos a ustedes a los efectos de poner a su
            consideración, la cotización de los componentes que detallamos a continuación:
        </p>

        <table class="table-striped">
            <thead>
                <th class="ths">Item</th>
                <th class="ths">Cant</th>
                <th class="ths">Descripción</th>
                <th class="ths" style="text-align:center">Moneda</th>
                <th class="ths" style="text-align:right">Precio Unitario</th>
                <th class="ths" style="text-align:right">Subtotal</th>
            </thead>
            <tbody>
                @php
                $num=1;
                $total=0;
                $simb = '$';
                switch ($quotation->quotationDetails->first()->currency_id) {
                case 1:
                $simb = 'USD';
                break;
                case 2:
                $simb = '€';
                break;
                default:
                $simb = '$';
                break;
                }
                @endphp
                @foreach ($quotation->quotationDetails as $detalle)
                <tr>
                    <td class="tds" style="width: 5%; text-align:center;">{{ $num++ }}</td>
                    <td class="tds" style="width: 5%; text-align:center;">{{ $detalle->cantidad }}</td>
                    <td class="tds" style="width: 46%">{{ $detalle->product->descripcion_cotizacion }}</td>
                    <td class="tds" style="width: 12%; text-align:center">{{ $detalle->currency->moneda}}</td>
                    <td class="tds" style="width: 16%; text-align:right">{{$simb . ' ' .
                        number_format($detalle->precio,2,",",".") }}</td>
                    <td class="tds" style="width: 16%; text-align:right">{{$simb . ' ' . number_format($detalle->precio
                        * $detalle->cantidad,2,",",".") }}</td>
                </tr>
                @php
                $total += $detalle->precio * $detalle->cantidad;
                @endphp
                @endforeach
                <tr>
                    <td class="tds" style="background-color: white;"></td>
                    <td class="tds" style="background-color: white;"></td>
                    <td class="tds" style="background-color: white;"></td>
                    <td class="tds"
                        style="background-color: gray; font-weight: bold; color: white; font-size: 13px; border: 1px solid gray">
                        Total</td>
                    <td class="tds"
                        style="text-align:center; font-weight: bold; font-size: 13px; border: 1px solid gray">{{
                        $quotation->quotationDetails->first()->currency->moneda}}</td>
                    <td class="tds"
                        style="text-align:right; text-align:right; font-weight: bold; font-size: 13px; border: 1px solid gray">
                        {{$simb . ' ' .  number_format($total,2,",",".") }}</td>
                </tr>
            </tbody>
        </table>
        @if ($quotation->nota)
        <h3 style="text-decoration: underline;"><b>NOTA:</b></h3>
        <p>
            {{ $quotation->nota }}
        </p>
        @endif

        <h3 style="text-decoration: underline;"><b>CONDICIONES COMERCIALES:</b></h3>
        <ul>
            <li> {{ $quotation->quotationDetails->first()->currency->textoNota }}</li>
            <li> POR LA EVENTUAL DIFERENCIA DE CAMBIO EN +/- 5% A LA FECHA DE EFECTIVO EL PAGO, SE EMITIRA NOTA DE
                DEBITO O NOTA DE CREDITO SEGÚN CORRESPONDA.</li>
        </ul>

        <table>
            <tr>
                <td style="color:gray">· VALIDEZ DE LA OFERTA:</td>
                <td>{{ $quotation->validezOferta }}</td>
            </tr>
            <tr>
                <td style="color:gray">· CONDICIONES DE PAGO:</td>
                <td>{{ $quotation->condicion }}</td>
            </tr>
            <tr>
                <td style="color:gray">· PLAZO DE ENTREGA:</td>
                <td>{{ $quotation->plazoEntrega }}</td>
            </tr>
            <tr>
                <td style="color:gray">· LUGAR DE ENTERGA:</td>
                <td>{{ $quotation->lugarEntrega }}</td>
            </tr>
        </table>

        <p><b>Sin otro particular, aprovechamos la ocasión para saludarlo muy atentamente y quedamos a su
                disposición ante eventuales consultas.</b></p>

        <span>Martín Yakisich</span><br>
        <span>DPTO. TECNICO</span><br>
        <span>RPG4b Rv. 01</span>

    </div>
</body>

</html>