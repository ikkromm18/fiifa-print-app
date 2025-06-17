<!DOCTYPE html>
<html>

<head>
    <title>Laporan Keuangan</title>
    <style>
        body {
            font-family: sans-serif;
        }
    </style>
</head>

<body>
    <h3>Laporan Keuangan ({{ $from }} s/d {{ $to }})</h3>
    <table border="1" cellspacing="0" cellpadding="6" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @php $total = 0; @endphp
            @foreach ($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->created_at->format('Y-m-d H:i') }}</td>
                    <td>Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                </tr>
                @php $total += $item->total_bayar; @endphp
            @endforeach
            <tr>
                <td colspan="2"><strong>Total Pemasukan</strong></td>
                <td><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>

</html>
