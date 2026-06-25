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

        /* ── Header ── */
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 16px;
            border-bottom: 2px solid #2563EB;
        }

        .header h1 {
            font-size: 20px;
            font-weight: bold;
            color: #2563EB;
            margin-bottom: 4px;
        }

        .header p {
            font-size: 11px;
            color: #6B7280;
        }

        /* ── Section Title ── */
        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #1E40AF;
            background-color: #DBEAFE;
            padding: 6px 12px;
            margin-bottom: 8px;
            margin-top: 24px;
            border-left: 4px solid #2563EB;
        }

        /* ── Table ── */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }

        thead tr {
            background-color: #2563EB;
            color: #ffffff;
        }

        thead th {
            padding: 8px 10px;
            font-size: 11px;
            font-weight: bold;
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

        /* ── Total Row ── */
        .total-row td {
            background-color: #EFF6FF;
            font-weight: bold;
            color: #1E40AF;
            border-top: 2px solid #BFDBFE;
            padding: 8px 10px;
        }

        /* ── Badge ── */
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

        /* ── Nominal ── */
        .nominal {
            color: #166534;
            font-weight: bold;
        }

        /* ── Grand Total Box ── */
        .grand-total {
            margin-top: 24px;
            padding: 12px 16px;
            background-color: #EFF6FF;
            border: 1px solid #BFDBFE;
            border-radius: 6px;
            text-align: right;
        }

        .grand-total span {
            font-size: 13px;
            font-weight: bold;
            color: #1E40AF;
        }

        .grand-total .label {
            color: #6B7280;
            font-size: 11px;
            margin-right: 12px;
        }

        /* ── Footer ── */
        .footer {
            margin-top: 40px;
            padding-top: 12px;
            border-top: 1px solid #E5E7EB;
            text-align: center;
            font-size: 10px;
            color: #9CA3AF;
        }

        /* ── Meta info ── */
        .meta-info {
            display: table;
            width: 100%;
            margin-bottom: 20px;
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
    </style>
</head>

<body>

    {{-- Header --}}
    <div class="header">
        <h1>Laporan Transaksi</h1>
        <p>Aplikasi Manajemen Toko &amp; Transaksi</p>
    </div>

    {{-- Meta info --}}
    <div class="meta-info">
        <div class="meta-left">
            Tanggal Cetak: {{ now()->format('d F Y, H:i') }} WIB
        </div>
        <div class="meta-right">
            Total Keseluruhan:
            <strong style="color: #166534;">
                Rp {{ number_format($perArea->sum('total'), 0, ',', '.') }}
            </strong>
        </div>
    </div>

    {{-- ── Tabel Per Area ── --}}
    <div class="section-title">Rekapitulasi per Area</div>

    <table>
        <thead>
            <tr>
                <th style="width: 15%;">Area</th>
                <th style="width: 20%;">Jumlah Toko</th>
                <th style="width: 35%;">Sales</th>
                <th style="width: 30%;">Total Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perArea as $row)
                <tr>
                    <td>
                        <span class="badge-area">Area {{ $row['area'] }}</span>
                    </td>
                    <td>{{ $row['jumlahToko'] }} toko</td>
                    <td>{{ $row['sales']->implode(', ') }}</td>
                    <td class="nominal">
                        Rp {{ number_format($row['total'], 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; color: #9CA3AF; padding: 16px;">
                        Belum ada data.
                    </td>
                </tr>
            @endforelse

            {{-- Total row --}}
            @if ($perArea->isNotEmpty())
                <tr class="total-row">
                    <td colspan="3" style="text-align: right;">Grand Total</td>
                    <td>Rp {{ number_format($perArea->sum('total'), 0, ',', '.') }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    {{-- ── Tabel Per Sales ── --}}
    <div class="section-title">Rekapitulasi per Sales</div>

    <table>
        <thead>
            <tr>
                <th style="width: 15%;">Kode</th>
                <th style="width: 25%;">Nama Sales</th>
                <th style="width: 15%;">Area</th>
                <th style="width: 15%;">Jumlah Toko</th>
                <th style="width: 30%;">Total Transaksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($perSales as $row)
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
                    <td colspan="5" style="text-align: center; color: #9CA3AF; padding: 16px;">
                        Belum ada data.
                    </td>
                </tr>
            @endforelse

            {{-- Total row --}}
            @if ($perSales->isNotEmpty())
                <tr class="total-row">
                    <td colspan="4" style="text-align: right;">Grand Total</td>
                    <td>Rp {{ number_format($perSales->sum('total_transaksi'), 0, ',', '.') }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    {{-- Footer --}}
    <div class="footer">
        Dokumen ini digenerate otomatis oleh sistem pada
        {{ now()->format('d F Y H:i:s') }} WIB
    </div>

</body>

</html>
