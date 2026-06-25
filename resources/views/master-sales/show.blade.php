@extends('layouts.app')

@section('title', 'Detail Sales')

@section('content')

    <div class="mb-5 flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-800">Detail Sales</h1>
        <a href="{{ route('master-sales.index') }}"
            class="bg-white text-blue-400 text-sm px-4 py-2 rounded-lg border border-blue-100 hover:bg-blue-100 transition">
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl p-5 flex flex-col gap-4 border-2 border-dashed border-yellow-100">
            <h2 class="text-xs font-semibold uppercase tracking-wide">Info Sales</h2>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500">Kode Sales</dt>
                    <dd>
                        <span class="bg-orange-100 text-gray-700 text-xs font-medium px-3 py-1 rounded-md">
                            {{ $sales->kode_sales }}
                        </span>
                    </dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Nama Sales</dt>
                    <dd class="font-medium text-gray-800">{{ $sales->nama_sales }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Area</dt>
                    <dd>
                        <span class="bg-blue-100 text-xs font-medium px-3 py-1 rounded-md">
                            Area {{ $sales->prefix_area }}
                        </span>
                    </dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Jumlah Toko</dt>
                    <dd class="font-medium text-gray-800">{{ $toko->count() }} toko</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Total Transaksi</dt>
                    <dd class="font-semibold text-green-600">
                        Rp {{ number_format($sales->total_transaksi, 0, ',', '.') }}
                    </dd>
                </div>
            </dl>

            <div class="mt-5 pt-4 border-t border-gray-100">
                <a href="{{ route('master-sales.edit', $sales->kode_sales) }}"
                    class="block w-full text-center text-sm px-4 py-2 rounded-lg border border-yellow-300 text-yellow-600 hover:bg-yellow-50 transition">
                    Edit Sales Ini
                </a>
            </div>
        </div>

        <div class="bg-white rounded-xl p-5 flex flex-col gap-4 border-2 border-dashed border-green-100">
            <h2 class="text-xs font-semibold uppercase tracking-wide">
                Toko di Area {{ $sales->prefix_area }}
            </h2>

            @if ($toko->isEmpty())
                <p class="text-sm text-gray-400">Tidak ada toko di area ini.</p>
            @else
                <ul class="space-y-2">
                    @foreach ($toko as $t)
                        <li class="flex items-center justify-between text-sm py-1.5 border-b border-gray-50 last:border-0">
                            <div>
                                <span class="font-medium text-gray-800">Toko {{ $t->kode_toko_baru }}</span>
                                @if ($t->kode_toko_lama)
                                    <span class="text-xs text-gray-400 ml-1">(lama: {{ $t->kode_toko_lama }})</span>
                                @endif
                            </div>
                            <a href="{{ route('master-toko.show', $t->kode_toko_baru) }}"
                                class="text-xs text-sky-500 hover:text-sky-700 transition">
                                Lihat
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="bg-white rounded-xl p-5 flex flex-col gap-4 border-2 border-dashed border-blue-100">
            <h2 class="text-xs font-semibold uppercase tracking-wide">
                Area yang Ditangani
            </h2>

            @if ($area->isEmpty())
                <p class="text-sm text-gray-400">Tidak ada area terdaftar.</p>
            @else
                <ul class="space-y-2">
                    @foreach ($area as $a)
                        <li class="flex items-center justify-between text-sm py-1.5 border-b border-gray-50 last:border-0">
                            <div class="flex items-center gap-2">
                                <span class="bg-blue-100 text-xs font-medium px-3 py-1 rounded-md">
                                    Area {{ $a->area_sales }}
                                </span>
                            </div>
                            <span class="text-xs text-gray-400">
                                Toko {{ $a->kode_toko }}
                            </span>
                        </li>
                    @endforeach
                </ul>
            @endif

            <div class="mt-5 pt-4 border-t border-gray-100">
                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-3">
                    Rekan Sales Area {{ $sales->prefix_area }}
                </p>
                @php
                    $rekanSales = \App\Models\TableD::byArea($sales->prefix_area)
                        ->where('kode_sales', '!=', $sales->kode_sales)
                        ->get();
                @endphp

                @if ($rekanSales->isEmpty())
                    <p class="text-sm text-gray-400">Tidak ada rekan sales.</p>
                @else
                    <ul class="space-y-1.5">
                        @foreach ($rekanSales as $rekan)
                            <li class="flex items-center justify-between text-sm">
                                <span class="text-gray-700">{{ $rekan->nama_sales }}</span>
                                <span class="bg-orange-100 text-gray-700 text-xs font-medium px-3 py-1 rounded-md">
                                    {{ $rekan->kode_sales }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>

    </div>

@endsection
