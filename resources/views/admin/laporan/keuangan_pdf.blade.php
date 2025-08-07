<!DOCTYPE html>
<html>

<head>
    <title>Laporan Keuangan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h3,
        h4 {
            margin: 0 0 10px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #444;
        }

        th,
        td {
            padding: 6px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h3>Laporan Keuangan ({{ $from }} s/d {{ $to }})</h3>

    @php $grandTotal = 0; @endphp

    @foreach ($data as $tanggal => $transaksis)
        <h4>{{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</h4>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Waktu</th>
                    <th>Total Bayar</th>
                </tr>
            </thead>
            <tbody>
                @php $subTotal = 0; @endphp
                @foreach ($transaksis as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->created_at->format('H:i') }}</td>
                        <td>Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                    </tr>
                    @php $subTotal += $item->total_bayar; @endphp
                @endforeach
                <tr>
                    <td colspan="2"><strong>Subtotal</strong></td>
                    <td><strong>Rp {{ number_format($subTotal, 0, ',', '.') }}</strong></td>
                </tr>
                @php $grandTotal += $subTotal; @endphp
            </tbody>
        </table>
    @endforeach

    <h4>Total Pemasukan Keseluruhan: Rp {{ number_format($grandTotal, 0, ',', '.') }}</h4>
</body>

</html>
