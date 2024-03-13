<html>
<head>
    <style>
        .page-break { page-break-before: always; }

        main {
            margin: 45px 0;
        }

        table {
            width: 100%;
        }

        table.details th,
        table.details td {
            border: 1px solid #ffffff;
            font-size: 12px;
        }
        table.details th {
            background-color: #f6f6f6;
            padding: 8px 4px;
        }
        table.details td {
            padding: 4px 4px;
        }
    </style>
</head>
<body>
    <header style="text-align: center;">
        <img src="{{ public_path('img/banner-dakary-games.png') }}" style="width: 360px; height: auto;" width="360px">
    </header>

    <main>
        <h3>REPORTE DE VENTAS POR FECHA</h3>

        <p>
            <b>Desde: </b> {{ $data['params']['date_from'] }} <br>
            <b>Hasta: </b> {{ $data['params']['date_to'] }}
            @if ($data['params']['status_detail'])
                <br><b>Estatus Productos: </b> {{ config('cons.status-assigned-detail.' . $data['params']['status_detail']) }}
            @endif
            @if ($data['params']['status_parent'])
                <br><b>Estatus Contratos: </b> {{ config('cons.status-assigned.' . $data['params']['status_parent']) }}
            @endif
        </p>

        <table class="details">
            <thead>
                <tr>
                    <th style="width: 7%;">Fecha</th>
                    <th style="width: 5%;">Hora</th>
                    <th style="width: 8%;">Producto</th>
                    <th style="width: 20%; text-align: left;">Nombre</th>
                    <th style="width: 25%; text-align: left;">Cliente</th>
                    <th style="width: 25%; text-align: left;">Negocio</th>
                    <th style="width: 10%; text-align: right;">Precio</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $total = 0;
                @endphp
                @foreach ($data['details'] as $detail)
                    <tr>
                        <td style="text-align: center;">{{ $detail->updated_at->format('d/m/Y') }}</td>
                        <td style="text-align: center;">{{ $detail->updated_at->format('h:ia') }}</td>
                        <td style="text-align: center;">{{ $detail->code }}</td>
                        <td>{{ $detail->card->name }}</td>
                        <td>{{ $detail->assigned->dealer->name }}</td>
                        <td>{{ $detail->assigned->dealer->company }}</td>
                        <td style="text-align: right;">{{ $detail->price_formatted }}</td>
                    </tr>

                    @php
                        $total += $detail->price;
                    @endphp
                @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="7"><hr /></td>
                </tr>
                <tr>
                    <th colspan="6" style="text-align: right;">Venta Total: </th>
                    <th style="text-align: right;">{{ HP::formatFormDecimal($total) }}</th>
                </tr>
            </tfoot>
        </table>
    </main>
</body>
</html>
