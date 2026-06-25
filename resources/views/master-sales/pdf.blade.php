<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #111827;
            padding: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 24px;
            padding-bottom: 14px;
            border-bottom: 2px solid #2563EB;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
            color: #2563EB;
            margin-bottom: 4px;
        }

        .header p {
            font-size: 11px;
            color: #6B7280;
        }

        .meta-info {
            display: table;
            width: 100%;
            margin-bottom: 16px;
        }

        .meta-left {
            display: table-cell;
            text-align: left;
            font-size: 11px;
            color: #6B7280;
        }

        .meta-right {
            display: table-cell;
            text-align: right;
            font-size: 11px;
            color: #6B7280;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            background-color: #2563EB;
        }

        thead th {
            padding: 8px 10px;
            font-size: 11px;
            font-weight: bold;
            color: #ffffff;
            text-align: left;
        }

        tbody tr:nth-child(even) {
            background-color: #F3F4F6;
        }

        tbody tr:nth-child(odd) {
            background-color: #ffffff;
        }

        tbody td {
            padding: 7px 10px;
            font-size: 11px;
            border-bottom: 1px solid #E5E7EB;
            color: #374151;
        }

        tfoot tr {
            background-color: #EFF6FF;
        }

        tfoot td {
            padding: 8px 10px;
            font-size: 11px;
            font-weight: bold;
            color: #1E40AF;
            border-top: 2px solid #BFDBFE;
        }

        .badge-area {
            background-color: #DBEAFE;
            color: #1E40AF;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 10px;
            font-weight: bold;
        }

        .badge-code {
            background-color: #F3F4F6;
            color: #374151;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 10px;
        }

        .nominal {
            color: #166534;
            font-weight: bold;
        }

        .footer {
            margin-top: 32px;
            padding-top: 10px;
            border-top: 1px solid #E5E7EB;
            text-align: center;
            font-size: 10px;
            color: #9CA3AF;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Data Master Sales</h1>
        <p>Aplikasi Manajemen Toko &amp; Transaksi</p>
    </div>

    <div class="meta-info">
        <div class="meta-left">
            Tanggal Cetak: {{ now()->format('d F Y, H:i') }} WIB
        </div>
        <div class="meta-right">
            Total Data: <strong>{{ $data->count() }} sales</strong>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 15%;">Kode Sales</th>
                <th style="width: 25%;">Nama Sales</th>
                <th style="width: 15%;">Area</th>
                <th style="width: 15%;">Jumlah Toko</th>
                <th style="width: 30%;">Total Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $row)
                <tr>
                    <td>
                        <span class="badge-code">{{ $row['kode_sales'] }}</span>
                    </td>
                    <td>{{ $row['nama_sales'] }}</td>
                    <td>
                        <span class="badge-area">Area {{ $row['area'] }}</span>
                    </td>
                    <td>{{ $row['jumlah_toko'] }} toko</td>
                    <td class="nominal">
                        Rp {{ number_format($row['total_transaksi'], 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #9CA3AF; padding: 20px;">
                        Belum ada data sales.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if ($data->isNotEmpty())
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right;">Grand Total</td>
                    <td class="nominal">
                        Rp {{ number_format($data->sum('total_transaksi'), 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        @endif
    </table>

    <div class="footer">
        Dokumen ini digenerate otomatis oleh sistem pada {{ now()->format('d F Y H:i:s') }} WIB
    </div>

</body>

</html>
