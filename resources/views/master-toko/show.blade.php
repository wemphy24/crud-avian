{{-- resources/views/master-toko/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Toko')

@section('content')

    <div class="mb-5 flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-800">Detail Toko</h1>
        <a href="{{ route('master-toko.index') }}"
            class="text-sm px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 transition">
            &larr; Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Info Toko</h2>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500">Kode Baru</dt>
                    <dd class="font-medium text-gray-800">{{ $toko->kode_toko_baru }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Kode Lama</dt>
                    <dd class="font-medium text-gray-800">{{ $toko->kode_toko_lama ?? '-' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Sales Area</dt>
                    <dd>
                        <span class="bg-blue-100 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-full">
                            Area {{ $toko->area_sales ?? '-' }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>


        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Sales di Area Ini</h2>
            <ul class="space-y-2">
                @forelse($sales as $s)
                    <li class="flex items-center justify-between text-sm">
                        <span class="text-gray-800">{{ $s->nama_sales }}</span>
                        <span class="bg-gray-100 text-gray-600 text-xs px-2 py-0.5 rounded-full">
                            {{ $s->kode_sales }}
                        </span>
                    </li>
                @empty
                    <li class="text-sm text-gray-400">Tidak ada sales.</li>
                @endforelse
            </ul>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-4">Riwayat Transaksi</h2>
            <ul class="space-y-2">
                @forelse($transaksi as $t)
                    <li class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Kode: {{ $t->kode_toko }}</span>
                        <span class="text-green-600 font-semibold">
                            Rp {{ number_format($t->nominal_transaksi, 0, ',', '.') }}
                        </span>
                    </li>
                @empty
                    <li class="text-sm text-gray-400">Belum ada transaksi.</li>
                @endforelse
            </ul>
        </div>

    </div>
@endsection
