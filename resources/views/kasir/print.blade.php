<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Pembayaran - {{ $transaction->invoice_code }}</title>
    <style>
        /* Desain Struk Thermal */
        body {
            font-family: 'Courier New', Courier, monospace; /* Font struk jadul */
            width: 300px; /* Lebar kertas struk (58mm/80mm simulation) */
            font-size: 12px;
            margin: 0 auto;
            padding: 10px;
            color: #000;
        }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 16px; font-weight: bold; }
        .header p { margin: 2px 0; font-size: 10px; }
        .divider { border-bottom: 1px dashed #000; margin: 10px 0; }
        .item { display: flex; justify-content: space-between; margin-bottom: 5px; }
        .total-section { font-weight: bold; margin-top: 10px; }
        .footer { text-align: center; margin-top: 20px; font-size: 10px; }
        
        /* Hilangkan elemen browser saat print */
        @media print {
            @page { margin: 0; size: auto; }
            body { margin: 10px; }
        }
    </style>
</head>
<body onload="window.print()"> {{-- Otomatis print saat dibuka --}}

    <div class="header">
        <h2>KEDAI DIMSUM ENAK</h2>
        <p>Jl. Kampus No. 123, Jember</p>
        <p>Telp: 0812-3456-7890</p>
    </div>

    <div class="divider"></div>

    <div>
        <p>No: {{ $transaction->invoice_code }}</p>
        <p>Tgl: {{ $transaction->transaction_date }}</p>
        <p>Kasir: {{ $transaction->user->name }}</p>
    </div>

    <div class="divider"></div>

    {{-- List Barang --}}
    @foreach($transaction->details as $detail)
    <div class="item">
        <span style="flex: 1;">{{ $detail->product->name }}</span>
        <span style="width: 30px; text-align: center;">x{{ $detail->quantity }}</span>
        <span style="text-align: right;">{{ number_format($detail->subtotal, 0, ',', '.') }}</span>
    </div>
    @endforeach

    <div class="divider"></div>

    <div class="item total-section">
        <span>TOTAL</span>
        <span>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
    </div>
    <div class="item">
        <span>TUNAI</span>
        <span>Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</span>
    </div>
    <div class="item">
        <span>KEMBALI</span>
        <span>Rp 0</span>
    </div>

    <div class="footer">
        <p>--- TERIMA KASIH ---</p>
        <p>Simpan struk ini sebagai bukti pembayaran yang sah.</p>
    </div>

    <script>
        // Opsional: Tutup tab otomatis setelah print (tapi kadang user ingin lihat dulu)
        // window.onafterprint = function() { window.close(); }
    </script>
</body>
</html>