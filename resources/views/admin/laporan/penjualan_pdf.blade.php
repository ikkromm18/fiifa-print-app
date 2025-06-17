<!DOCTYPE html>
<html>

<head>
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: sans-serif;
        }
    </style>
</head>

<body>
    <h3>Laporan Penjualan ({{ $from }} s/d {{ $to }})</h3>
    <table border="1" cellspacing="0" cellpadding="6" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                    <td>Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
