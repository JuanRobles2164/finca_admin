<!DOCTYPE html>
<html>

<head>
    <title>Factura</title>
    <style>
        /* Estilos base */
        body {
            background-color: #f3f4f6; /* bg-gray-100 */
            padding: 1.5rem; /* p-6 */
            font-family: sans-serif;
        }

        .container {
            max-width: 1024px; /* container */
            margin-left: auto;
            margin-right: auto;
            background-color: white; /* bg-white */
            padding: 2rem; /* p-8 */
            border-radius: 0.5rem; /* rounded-lg */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* shadow-md */
        }

        /* Encabezado de la factura */
        .factura-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid black; /* border-b-2 border-black */
            padding-bottom: 1rem; /* pb-4 */
            margin-bottom: 1.5rem; /* mb-6 */
        }

        .logo {
            width: 5rem; /* w-20 */
            height: auto;
        }

        .text-right {
            text-align: right;
        }

        .text-sm {
            font-size: 0.875rem; /* text-sm */
        }

        /* Título de la factura */
        .text-2xl {
            font-size: 1.5rem; /* text-2xl */
        }

        .font-bold {
            font-weight: 700; /* font-bold */
        }

        .text-center {
            text-align: center;
        }

        .mb-6 {
            margin-bottom: 1.5rem; /* mb-6 */
        }

        /* Información del cliente */
        .mb-6 p {
            margin-bottom: 0.5rem;
        }

        /* Tabla de materiales */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 1.5rem; /* mb-6 */
        }

        th,
        td {
            border: 1px solid #cbd5e0; /* border border-gray-400 */
            padding: 0.5rem; /* p-2 */
            text-align: center;
        }

        thead {
            background-color: #edf2f7; /* bg-gray-200 */
        }

        /* Total y detalles adicionales */
        .text-xl {
            font-size: 1.25rem; /* text-xl */
        }

        .mt-6 {
            margin-top: 1.5rem; /* mt-6 */
        }

        /* Evidencias */
        .grid {
            display: grid;
            gap: 1rem; /* gap-4 */
        }

        .grid-cols-1 {
            grid-template-columns: repeat(1, 1fr); /* grid-cols-1 */
        }

        .md-grid-cols-2 {
            grid-template-columns: repeat(2, 1fr); /* md:grid-cols-2 */
        }

        .card {
            background-color: white; /* bg-white */
            border-radius: 0.5rem; /* rounded-lg */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* shadow-md */
            padding: 1rem; /* p-4 */
        }

        .evidencia-img {
            width: 100%;
            height: auto;
            border-radius: 0.5rem; /* rounded-lg */
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Encabezado de la factura -->
        <div class="factura-header">
            <img src="{{ $factura->logo_empresa }}" alt="Logo Empresa" class="logo" />
            <div class="text-right">
                <p class="text-sm">{{ $factura->direccion_empresa }}</p>
                <p class="text-sm">{{ $factura->telefono_empresa }}</p>
            </div>
        </div>

        <!-- Título de la factura -->
        <h2 class="text-2xl font-bold text-center mb-6">Factura</h2>

        <!-- Información del cliente -->
        <div class="mb-6">
            <p><strong>Cliente:</strong> {{ $cliente->nombre }}</p>
            <p><strong>NIT:</strong> {{ $cliente->nit }}</p>
            <p><strong>Contacto:</strong> {{ $cliente->contacto }}</p>
        </div>

        <!-- Tabla de materiales -->
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

        <!-- Total y detalles adicionales -->
        <h3 class="text-xl font-bold mt-6">Total: ${{ $factura->total }}</h3>
        <p><strong>Fecha de Venta:</strong> {{ $factura->fecha_venta }}</p>
        <p><strong>Estado:</strong> {{ $factura->fecha_pago ? 'Pagada' : 'Pendiente' }}</p>

        <!-- Evidencias -->
        @if (count($evidencia) > 0)
            <div class="grid grid-cols-1 md-grid-cols-2">
                @foreach ($evidencia as $img)
                    <div class="card">
                        <img src="{{ './'.asset($img->url) }}" alt="Evidencia" class="evidencia-img" />
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>

</html>
