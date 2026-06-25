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

        .badge-null {
            color: #9CA3AF;
            font-style: italic;
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
        <h1>Data Master Toko</h1>
        <p>Aplikasi Manajemen Toko &amp; Transaksi</p>
    </div>

    <div class="meta-info">
        <div class="meta-left">
            Tanggal Cetak: {{ now()->format('d F Y, H:i') }} WIB
        </div>
        <div class="meta-right">
            Total Data: <strong>{{ $data->count() }} toko</strong>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 25%;">Kode Toko Baru</th>
                <th style="width: 25%;">Kode Toko Lama</th>
                <th style="width: 25%;">Sales Area</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $row)
                <tr>
                    <td>{{ $row['kode_toko_baru'] }}</td>
                    <td>
                        @if ($row['kode_toko_lama'])
                            {{ $row['kode_toko_lama'] }}
                        @else
                            <span class="badge-null">tidak ada</span>
                        @endif
                    </td>
                    <td>
                        @if ($row['area_sales'])
                            <span class="badge-area">Area {{ $row['area_sales'] }}</span>
                        @else
                            <span class="badge-null">-</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center; color: #9CA3AF; padding: 20px;">
                        Belum ada data toko.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if ($data->isNotEmpty())
            <tfoot>
                <tr>
                    <td colspan="2" style="text-align: right;">Total Toko</td>
                    <td>{{ $data->count() }} toko</td>
                </tr>
            </tfoot>
        @endif
    </table>

    <div class="footer">
        Dokumen ini digenerate otomatis oleh sistem pada {{ now()->format('d F Y H:i:s') }} WIB
    </div>

</body>

</html>
