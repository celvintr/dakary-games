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

        table.info th,
        table.info td {
            text-align: left;
            border: 1px solid #ffffff;
            padding: 6px 4px;
        }
        table.info th {
            background-color: #f6f6f6;
        }

        table.details th,
        table.details td {
            border: 1px solid #ffffff;
            padding: 6px 4px;
        }
        table.details th {
            background-color: #f6f6f6;
        }

        table.cards {
            margin: 30px 0;
        }
        table.cards th,
        table.cards td {
            width: 33.3%;
        }
        table.cards-item {
            border-collapse: collapse;
        }
        table.cards-item th,
        table.cards-item td {
            border: 1px solid #454545;
            padding: 6px 4px;
            font-size: 13px;
        }
        table.cards-item th {
            background-color: #d0d0d0;
        }
    </style>
</head>
<body>
    <header style="text-align: center;">
        <img src="{{ public_path('img/banner-dakary-games.png') }}" style="width: 360px; height: auto;" width="360px">
    </header>

    <main>
        <h3>CIERRE DE CONTRATO {{ $data['assigned_card']['code'] }}</h3>

        <p>
            <b>Fecha de Cierre: </b> {{ $data['assigned_card']->updated_at->format('d/m/Y h:ia') }}
        </p>

        <table class="info">
            <tr>
                <th style="width: 70%;">Nombre Completo</th>
                <th style="width: 30%;">Código Asignado</th>
            </tr>
            <tr>
                <td>{{ $data['assigned_card']->dealer->name }}</td>
                <td>{{ $data['assigned_card']->dealer->code }}</td>
            </tr>
            <tr>
                <th>Número de ID</th>
                <th>Número de Celular</th>
            </tr>
            <tr>
                <td>{{ $data['assigned_card']->dealer->document }}</td>
                <td>{{ $data['assigned_card']->dealer->phone }}</td>
            </tr>
            <tr>
                <th>Nombre del Negocio</th>
                <th>Fecha de Asignación</th>
            </tr>
            <tr>
                <td>{{ $data['assigned_card']->dealer->company }}</td>
                <td>{{ $data['assigned_card']->created_at->format('d/m/Y h:ia') }}</td>
            </tr>
        </table>

        <h4>RESUMEN DE PRODUCTOS</h4>
        <table class="details">
            <thead>
                <tr>
                    <th style="width: 10%;">Código</th>
                    <th style="width: 35%; text-align: left;">Producto</th>
                    <th style="width: 25%; text-align: left;">Fecha y Hora</th>
                    <th style="width: 15%; text-align: right;">Precio</th>
                    <th style="width: 15%; text-align: right;">Comisión</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data['assigned_card']->details_changed as $detail)
                    <tr>
                        <td style="text-align: center;">{{ $detail->code }}</td>
                        <td>{{ $detail->card->name }}</td>
                        <td>{{ $detail->updated_at->format('d/m/Y h:ia') }}</td>
                        <td style="text-align: right;">{{ $detail->price_formatted }}</td>
                        <td style="text-align: right;">{{ $detail->comission_formatted }}</td>
                    </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="5"><hr /></td>
                </tr>
                <tr>
                    <th colspan="3" style="text-align: right;">Totales: </th>
                    <th style="text-align: right;">{{ $data['assigned_card']->details_summary['amount_changed_formatted'] }}</th>
                    <th style="text-align: right;">{{ $data['assigned_card']->details_summary['comission_changed_formatted'] }}</th>
                </tr>
            </tfoot>
        </table>

        <table class="cards">
            <tr>
                <td style="width: 50%;">
                    <table class="cards-item">
                        <tr>
                            <th style="width: 100%;">
                                <b>TOTAL A PAGAR</b> <br>
                                <h1 style="margin: 0;">{{ $data['assigned_card']->details_summary['amount_total_formatted'] }}</h1>
                            </th>
                        </tr>
                    </table>
                </td>
                <td style="width: 50%;">
                    <table class="cards-item">
                        <tr>
                            <th style="width: 100%;">
                                <b>COMISIÓN</b> <br>
                                <h1 style="margin: 0;">{{ $data['assigned_card']->details_summary['comission_changed_formatted'] }}</h1>
                            </th>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="page-break"></div>

        <h4>PRODUCTOS PENDIENTES</h4>
        <table class="details">
            <thead>
                <tr>
                    <th style="width: 10%;">Código</th>
                    <th style="width: 35%; text-align: left;">Producto</th>
                    <th style="width: 25%; text-align: left;">Fecha y Hora</th>
                    <th style="width: 15%; text-align: right;">Precio</th>
                    <th style="width: 15%; text-align: right;">Comisión</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data['assigned_card']->details_pending as $detail)
                    <tr>
                        <td style="text-align: center;">{{ $detail->code }}</td>
                        <td>{{ $detail->card->name }}</td>
                        <td>-</td>
                        <td style="text-align: right;">{{ $detail->price_formatted }}</td>
                        <td style="text-align: right;">{{ $detail->comission_formatted }}</td>
                    </tr>
                @endforeach
            </tbody>

            <tfoot>
                <tr>
                    <td colspan="5"><hr /></td>
                </tr>
                <tr>
                    <th colspan="3" style="text-align: right;">Totales: </th>
                    <th style="text-align: right;">{{ $data['assigned_card']->details_summary['amount_pending_formatted'] }}</th>
                    <th style="text-align: right;">{{ $data['assigned_card']->details_summary['comission_pending_formatted'] }}</th>
                </tr>
            </tfoot>
        </table>
    </main>
</body>
</html>
