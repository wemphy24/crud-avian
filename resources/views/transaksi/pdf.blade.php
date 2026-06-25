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

        .filter-info {
            background-color: #EFF6FF;
            border-left: 4px solid #2563EB;
            padding: 8px 12px;
            margin-bottom: 16px;
            font-size: 11px;
            color: #1E40AF;
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
        <h1>Data Transaksi</h1>
        <p>Aplikasi Manajemen Toko &amp; Transaksi</p>
    </div>

    <div class="meta-info">
        <div class="meta-left">
            Tanggal Cetak: {{ now()->format('d F Y, H:i') }} WIB
        </div>
        <div class="meta-right">
            Total Data: <strong>{{ $data->count() }} transaksi</strong>
        </div>
    </div>

    {{-- Info filter area jika ada --}}
    @if ($area)
        <div class="filter-info">
            Filter Area: <strong>Area {{ $area }}</strong>
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width: 20%;">Kode Toko</th>
                <th style="width: 30%;">Nominal Transaksi</th>
                <th style="width: 20%;">Area</th>
                <th style="width: 30%;">Sales</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $row)
                <tr>
                    <td>{{ $row['kode_toko'] }}</td>
                    <td class="nominal">
                        Rp {{ number_format($row['nominal_transaksi'], 0, ',', '.') }}
                    </td>
                    <td>
                        @if ($row['area_sales'])
                            <span class="badge-area">{{ $row['area_sales'] }}</span>
                        @else
                            <span style="color: #9CA3AF;">-</span>
                        @endif
                    </td>
                    <td>{{ $row['sales']->implode(', ') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #9CA3AF; padding: 20px;">
                        Belum ada data transaksi.
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if ($data->isNotEmpty())
            <tfoot>
                <tr>
                    <td colspan="1" style="text-align: right;">Total</td>
                    <td class="nominal">
                        Rp {{ number_format($data->sum('nominal_transaksi'), 0, ',', '.') }}
                    </td>
                    <td colspan="2"></td>
                </tr>
            </tfoot>
        @endif
    </table>

    <div class="footer">
        Dokumen ini digenerate otomatis oleh sistem pada {{ now()->format('d F Y H:i:s') }} WIB
    </div>

</body>

</html>
