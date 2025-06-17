<!DOCTYPE html>
<html>

<head>
    <title>Laporan Stok Barang</title>
    <style>
        body {
            font-family: sans-serif;
        }
    </style>
</head>

<body>
    <h3>Laporan Stok Barang</h3>
    <table border="1" cellspacing="0" cellpadding="6" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_produk }}</td>
                    <td>{{ $item->stok }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
