<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans; font-size: 12px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #343a40; color: white; padding: 8px; border: 1px solid #000; }
        td { padding: 6px; border: 1px solid #ccc; }
    </style>
</head>
<body>
<h2>Reporte de Productos</h2>

<table>
    <thead>
    <tr>
        <th>Código</th>
        <th>Nombre</th>
        <th>Marca</th>
        <th>Precio</th>
        <th>Fecha creación</th>
    </tr>
    </thead>
    <tbody>
    @foreach($products as $product)
        <tr>
            <td>{{ $product->code }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->brand }}</td>
            <td>${{ number_format($product->price, 2) }}</td>
            <td>{{ optional($product->created_at)->format('d/m/Y H:i') }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
