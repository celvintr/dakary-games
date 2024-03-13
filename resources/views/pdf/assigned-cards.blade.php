<html>
<head>
    <style>
        main {
            margin: 45px 0;
        }

        table {
            width: 100%;
        }

        table.info {
            margin: 0 0 30px;
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

        table.cards {
            margin: 0 0 30px;
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
        <h3>CONTRATO {{ $data['assigned_card']['code'] }}</h3>

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

        <table class="cards">
            @foreach ($data['items'] as $key => $item)
                @if ($key % 3 == 0)
                    @if ($key > 0) </tr> @endif
                    <tr>
                @endif
                <td>
                    <table class="cards-item">
                        <tr>
                            <td style="width: 85%;">
                                <b>{{ $item['name'] }}</b> <br>
                                {{ $item['min'] }} al {{ $item['max'] }}
                            </td>
                            <th style="width: 15%;">{{ $item['qty'] }}</th>
                        </tr>
                    </table>
                </td>
                @if (count($data['items']) == ($key + 1))
                    </tr>
                @endif
            @endforeach
        </table>
        
        @if (count($data['items_pending'])) 
            <h5 style="margin: 0;">Reasignadas</h5>
            <table class="cards">
                @foreach ($data['items_pending'] as $key => $item)
                    @if ($key % 3 == 0)
                        @if ($key > 0) </tr> @endif
                        <tr>
                    @endif
                    <td>
                        <table class="cards-item">
                            <tr>
                                <td style="width: 85%;">
                                    <b>{{ $item['name'] }}</b> <br>
                                    {{ implode(', ', $item['cards']) }}
                                </td>
                                <th style="width: 15%;">{{ count($item['cards']) }}</th>
                            </tr>
                        </table>
                    </td>
                    @if (count($data['items']) == ($key + 1))
                        </tr>
                    @endif
                @endforeach
            </table>
        @endif

        <p>
            Por medio de la presente conformo que he recibido por parte de Dakary Games S A de CV
            la cantidad de <b><u>&nbsp;&nbsp;{{ $data['assigned_card']->details->count() }}&nbsp;&nbsp;</u></b> Tarjetas que me comprometo a distribuirlas conforme las
            indicaciones y precios establecidos en este documento, entregando el dinero obtenido por
            estas ventas a los representantes de Dakary Games S A de CV semanalmente o conforme
            la venta amerite, siendo responsables de las mismas por pérdidas y/o reclamos de
            diamantes usando estas tarjetas que me han asignado.
        </p>
        <p>
            Dakary Games S A de CV se compromete a realizar los cambios de tarjetas y sustitución
            cuando se requiera por parte del cliente, siendo estos cambios de forma inmediata.
        </p>
        <p>
            El abandono o cancelación de este contrato se puede realizar en cualquier momento
            siempre y cuando ambas partes sean informadas devolviendo todas las tarjetas y el efectivo
            si se ha realizado alguna venta.
        </p>
        <p>
            De forma libre y voluntaria acepto todos y cada uno de los términos que contienen la
            presente acta y se ratifican los mismos.
        </p>

    </main>

    <footer>
        <table>
            <tr>
                <td style="width:50%; text-align:center;">
                    __________________________________ <br>
                    Lugar y Fecha
                </td>
                <td style="width:50%; text-align:center;">
                    __________________________________ <br>
                    Identidad y Nombre
                </td>
            </tr>
        </table>
    </footer>
</body>
</html>
