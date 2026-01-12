<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $transaction->invoice_code }}</title>
    <style>
        /* CSS untuk simulasi kertas thermal */
        body {
            font-family: 'Courier New', Courier, monospace; /* Font ala mesin kasir */
            font-size: 12px;
            color: #000;
            margin: 0;
            padding: 10px;
            width: 58mm; /* Lebar kertas thermal standar 58mm */
        }
        
        .container {
            width: 100%;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }

        .header h1 {
            font-size: 16px;
            margin: 0;
            text-transform: uppercase;
        }

        .header p {
            margin: 2px 0;
            font-size: 10px;
        }

        .info {
            margin-bottom: 10px;
            border-bottom: 1px dashed #000;
            padding-bottom: 10px;
        }

        .info p {
            margin: 2px 0;
            display: flex;
            justify-content: space-between;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        th {
            text-align: left;
            border-bottom: 1px dashed #000;
            padding: 5px 0;
        }

        td {
            padding: 5px 0;
            vertical-align: top;
        }

        .qty {
            width: 15%;
            text-align: center;
        }

        .price {
            width: 25%;
            text-align: right;
        }

        .total-section {
            border-top: 1px dashed #000;
            padding-top: 10px;
            margin-bottom: 20px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-weight: bold;
            font-size: 14px;
            margin-top: 5px;
        }

        .footer {
            text-align: center;
            font-size: 10px;
            margin-top: 20px;
            border-top: 1px dashed #000;
            padding-top: 10px;
        }

        /* Hilangkan elemen browser saat diprint */
        @media print {
            @page {
                margin: 0;
                size: auto;
            }
            body {
                padding: 10px; /* Padding minimal saat print */
            }
        }
    </style>
</head>
<body onload="window.print()"> {{-- Otomatis print saat halaman dibuka --}}

    <div class="container">
        
        {{-- HEADER TOKO --}}
        <div class="header">
            <h1>DIMSUM ENAK</h1>
            <p>Jl. Mastrip No. 123, Jember</p>
            <p>Telp: 0812-3456-7890</p>
        </div>

        {{-- INFO TRANSAKSI --}}
        <div class="info">
            <p>
                <span>No: {{ $transaction->invoice_code }}</span>
            </p>
            <p>
                <span>Tgl: {{ $transaction->created_at->format('d/m/Y H:i') }}</span>
            </p>
            <p>
                <span>Kasir: {{ $transaction->user->name ?? 'Admin' }}</span>
            </p>
        </div>

        {{-- LIST ITEM --}}
        <table>
            <thead>
                <tr>
                    <th style="width: 50%">Item</th>
                    <th class="qty">Qty</th>
                    <th class="price">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transaction->details as $detail)
                <tr>
                    <td>{{ $detail->product->name }}</td>
                    <td class="qty">{{ $detail->quantity }}</td>
                    <td class="price">{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- TOTAL --}}
        <div class="total-section">
            <div class="total-row">
                <span>TOTAL</span>
                <span>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
            </div>
            <div class="total-row" style="font-weight: normal; font-size: 12px; margin-top: 5px;">
                <span>Bayar</span>
                <span>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span> {{-- Asumsi uang pas dulu --}}
            </div>
            <div class="total-row" style="font-weight: normal; font-size: 12px;">
                <span>Kembali</span>
                <span>Rp 0</span>
            </div>
        </div>

        {{-- FOOTER --}}
        <div class="footer">
            <p>Terima Kasih atas Kunjungan Anda</p>
            <p>Barang yang sudah dibeli tidak dapat ditukar/dikembalikan</p>
            <br>
            <p>-- Layanan Konsumen --</p>
            <p>IG: @dimsum.enak.jember</p>
        </div>

    </div>

</body>
</html>