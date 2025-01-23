<!DOCTYPE html>
<html>

<head>
    <title>Factura</title>
    <style>
        .factura-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .logo {
            width: 80px;
            height: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: center;
        }

        .evidencia-img {
            width: 100px;
            height: auto;
        }
    </style>
</head>

<body>
    <div class="factura-container">
        <div class="factura-header">
            <img src="{{ $factura->logo_empresa }}" alt="Logo Empresa" class="logo" />
            <div>
                <p>{{ $factura->direccion_empresa }}</p>
                <p>{{ $factura->telefono_empresa }}</p>
            </div>
        </div>

        <h2>Factura</h2>

        <div class="cliente-info">
            <p><strong>Cliente:</strong> {{ $cliente->nombre }}</p>
            <p><strong>NIT:</strong> {{ $cliente->nit }}</p>
            <p><strong>Contacto:</strong> {{ $cliente->contacto }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Material</th>
                    <th>Cantidad</th>
                    <th>Valor Unitario</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($venta_materiales as $item)
                    <tr>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->cantidad }}</td>
                        <td>${{ $item->valor_unitario }}</td>
                        <td>${{ $item->cantidad * $item->valor_unitario }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Total: ${{ $factura->total }}</h3>
        <p><strong>Fecha de Venta:</strong> {{ $factura->fecha_venta }}</p>
        <p><strong>Estado:</strong> {{ $factura->fecha_pago ? 'Pagada' : 'Pendiente' }}</p>

        @if (count($evidencia) > 0)
            <h3>Evidencia</h3>
            <div class="evidencias">
                @foreach ($evidencia as $img)
                    <img src="{{ $img }}" alt="Evidencia" class="evidencia-img" />
                @endforeach
            </div>
        @endif
    </div>
</body>

</html>
