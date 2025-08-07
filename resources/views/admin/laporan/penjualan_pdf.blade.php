<!DOCTYPE html>
<html>

<head>
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 14px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        h3 {
            margin-bottom: 5px;
        }

        .tanggal-header {
            margin-top: 20px;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h3>Laporan Penjualan ({{ $from }} s/d {{ $to }})</h3>

    @php $grandTotal = 0; @endphp

    @foreach ($data as $tanggal => $items)
        <p class="tanggal-header">Tanggal: {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}</p>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jam</th>
                    <th>Total Bayar</th>
                </tr>
            </thead>
            <tbody>
                @php $subTotal = 0; @endphp
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->created_at->format('H:i') }}</td>
                        <td>Rp {{ number_format($item->total_bayar, 0, ',', '.') }}</td>
                    </tr>
                    @php $subTotal += $item->total_bayar; @endphp
                @endforeach
                <tr>
                    <td colspan="2"><strong>Sub Total</strong></td>
                    <td><strong>Rp {{ number_format($subTotal, 0, ',', '.') }}</strong></td>
                </tr>
                @php $grandTotal += $subTotal; @endphp
            </tbody>
        </table>
    @endforeach

    <h4>Total Keseluruhan: Rp {{ number_format($grandTotal, 0, ',', '.') }}</h4>
</body>

</html>
