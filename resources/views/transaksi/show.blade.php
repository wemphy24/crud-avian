{{-- resources/views/transaksi/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')

    <div class="mb-5 flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-800">Detail Transaksi</h1>
        <div class="flex gap-2">
            <a href="{{ route('transaksi.edit', $transaksi->kode_toko) }}"
                class="text-sm px-4 py-2 rounded-lg border border-yellow-300 text-yellow-600 hover:bg-yellow-50 transition">
                Edit
            </a>
            <a href="{{ route('transaksi.index') }}"
                class="text-sm px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 transition">
                &larr; Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-4">
                Info Transaksi
            </h2>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500">Kode Toko</dt>
                    <dd class="font-medium text-gray-800">{{ $transaksi->kode_toko }}</dd>
                </div>
                <div class="flex justify-between items-center">
                    <dt class="text-gray-500">Nominal</dt>
                    <dd class="text-green-600 font-bold text-base">
                        Rp {{ number_format($transaksi->nominal_transaksi, 0, ',', '.') }}
                    </dd>
                </div>
                <div class="flex justify-between items-center">
                    <dt class="text-gray-500">Area</dt>
                    <dd>
                        @if ($transaksi->area_sales)
                            <span class="bg-blue-100 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-full">
                                Area {{ $transaksi->area_sales }}
                            </span>
                        @else
                            <span class="text-gray-400 text-xs">-</span>
                        @endif
                    </dd>
                </div>
            </dl>

            <div class="mt-5 pt-4 border-t border-gray-100">
                <form action="{{ route('transaksi.destroy', $transaksi->kode_toko) }}" method="POST"
                    onsubmit="return confirm('Yakin hapus transaksi ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="w-full text-center text-sm px-4 py-2 rounded-lg border border-red-300 text-red-600 hover:bg-red-50 transition">
                        Hapus Transaksi
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-4">
                Info Toko
            </h2>

            @if ($toko)
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Kode Baru</dt>
                        <dd class="font-medium text-gray-800">{{ $toko->kode_toko_baru }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-gray-500">Kode Lama</dt>
                        <dd class="text-gray-600">{{ $toko->kode_toko_lama ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between items-center">
                        <dt class="text-gray-500">Area</dt>
                        <dd>
                            <span class="bg-blue-100 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-full">
                                Area {{ $toko->area_sales }}
                            </span>
                        </dd>
                    </div>
                </dl>

                <div class="mt-5 pt-4 border-t border-gray-100">
                    <a href="{{ route('master-toko.show', $toko->kode_toko_baru) }}"
                        class="block w-full text-center text-sm px-4 py-2 rounded-lg border border-sky-300 text-sky-600 hover:bg-sky-50 transition">
                        Lihat Detail Toko &rarr;
                    </a>
                </div>
            @else
                <p class="text-sm text-gray-400">Data toko tidak ditemukan.</p>
            @endif
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h2 class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-4">
                Sales yang Menangani
            </h2>

            @if ($sales->isEmpty())
                <p class="text-sm text-gray-400">Tidak ada sales untuk transaksi ini.</p>
            @else
                <ul class="space-y-2">
                    @foreach ($sales as $s)
                        <li class="flex items-center justify-between text-sm py-1.5 border-b border-gray-50 last:border-0">
                            <span class="font-medium text-gray-800">{{ $s->nama_sales }}</span>
                            <div class="flex items-center gap-2">
                                <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">
                                    {{ $s->kode_sales }}
                                </span>
                                <a href="{{ route('master-sales.show', $s->kode_sales) }}"
                                    class="text-xs text-sky-500 hover:text-sky-700 transition">
                                    Lihat &rarr;
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-5 pt-4 border-t border-gray-100">
                    <p class="text-xs text-gray-400">
                        Total <span class="font-semibold text-gray-600">{{ $sales->count() }} sales</span>
                        menangani area ini.
                    </p>
                </div>
            @endif
        </div>

    </div>

@endsection
