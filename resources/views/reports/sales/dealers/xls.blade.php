<table>
    <tr>
        <th colspan="5">
            FECHA: {{ $data['params']['date_from'] }} - {{ $data['params']['date_to'] }}
        </th>
    </tr>
    <tr>
        <th colspan="5">
            CLIENTE: {{ $data['dealer']->code }} - {{ $data['dealer']->name }}
        </th>
    </tr>
    <tr>
        <th colspan="5">
            NEGOCIO: {{ $data['dealer']->company }}
        </th>
    </tr>
    @if ($data['params']['status_detail'])
        <tr>
            <th colspan="5">
                Estatus Productos: {{ config('cons.status-assigned-detail.' . $data['params']['status_detail']) }}
            </th>
        </tr>
    @endif
    @if ($data['params']['status_parent'])
        <tr>
            <th colspan="5">
                Estatus Contratos: {{ config('cons.status-assigned.' . $data['params']['status_parent']) }}
            </th>
        </tr>
    @endif
</table>

<table>
    <thead>
        <tr>
            <th style="background-color: #f6f6f6; border: 1px solid #cccccc; font-weight: bold; width: 75px;">Fecha</th>
            <th style="background-color: #f6f6f6; border: 1px solid #cccccc; font-weight: bold; width: 75px;">Hora</th>
            <th style="background-color: #f6f6f6; border: 1px solid #cccccc; font-weight: bold; width: 100px;">Producto</th>
            <th style="background-color: #f6f6f6; border: 1px solid #cccccc; font-weight: bold; width: 200px; text-align: left;">Nombre</th>
            <th style="background-color: #f6f6f6; border: 1px solid #cccccc; font-weight: bold; width: 100px; text-align: right;">Precio</th>
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
                <td style="text-align: right;">{{ $detail->price_formatted }}</td>
            </tr>

            @php
                $total += $detail->price;
            @endphp
        @endforeach
    </tbody>

    <tfoot>
        <tr>
            <th colspan="4" style="background-color: #f6f6f6; border: 1px solid #cccccc; font-weight: bold; text-align: right;">Venta Total: </th>
            <th style="background-color: #f6f6f6; border: 1px solid #cccccc; font-weight: bold; text-align: right;">{{ HP::formatFormDecimal($total) }}</th>
        </tr>
    </tfoot>
</table>
