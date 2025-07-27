<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Struk Transaksi</title>
    <style>
        body {
            font-family: monospace;
            width: 300px;
            margin: auto;
        }

        h2,
        p,
        table {
            text-align: center;
        }

        table {
            width: 100%;
            margin-top: 10px;
            border-collapse: collapse;
        }

        td,
        th {
            padding: 4px;
            font-size: 14px;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body onload="window.print()">

    <h2>STRUK PEMBAYARAN</h2>
    <p>Kode Transaksi: {{ $transaksi->kode_transaksi }}</p>
    <p>Tanggal: {{ $transaksi->created_at->format('d/m/Y H:i') }}</p>
    <p>Kasir: {{ $transaksi->karyawan->nama_karyawan }}</p>

    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Qty</th>
                <th>Harga</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi->items as $item)
                <tr>
                    <td>{{ $item->produk->nama_produk }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td>{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <hr>

    <table>
        <tr>
            <td>Total</td>
            <td colspan="3" class="total text-right">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Bayar</td>
            <td colspan="3" class="text-right">Rp {{ number_format($transaksi->jumlah_bayar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Kembali</td>
            <td colspan="3" class="text-right">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</td>
        </tr>
    </table>

    <p>Terima kasih telah berbelanja!</p>

    <h2 style="text-align: center">FiiFa Print</h2>
    <p>Jalan Raya Comal-Sragi, RT 02 RW 14 Beji Desa Purwosari, Kecamatan Comal, Kabupaten Pemalang</p>
</body>

</html>
