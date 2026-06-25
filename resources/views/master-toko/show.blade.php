{{-- resources/views/master-toko/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Toko')

@section('content')


    <div class="mb-5 flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-800">Detail Toko</h1>
        <a href="{{ route('master-toko.index') }}"
            class="bg-white text-blue-400 text-sm px-4 py-2 rounded-lg border border-blue-100 hover:bg-blue-100 transition">
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl p-5 flex flex-col gap-4 border-2 border-dashed border-blue-100">
            <h2 class="text-xs font-semibold uppercase tracking-wide">Info Toko</h2>
            <dl class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500">Kode Baru</dt>
                    <dd class="font-medium text-gray-800">{{ $toko->kode_toko_baru }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Kode Lama</dt>
                    <dd class="font-medium text-gray-800">{{ $toko->kode_toko_lama ?? '-' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Area Sales</dt>
                    <dd>
                        <span class="bg-blue-100 px-3 py-1 rounded-md">
                            Area {{ $toko->area_sales ?? '-' }}
                        </span>
                    </dd>
                </div>
            </dl>
        </div>


        <div class="bg-white rounded-xl p-5 flex flex-col gap-4 border-2 border-dashed border-orange-100">
            <h2 class="text-xs font-semibold uppercase tracking-wide">Sales di Area Ini</h2>
            <ul class="space-y-2">
                @forelse($sales as $s)
                    <li class="flex items-center justify-between text-sm">
                        <span class="text-gray-800">{{ $s->nama_sales }}</span>
                        <span class="bg-orange-100 text-xs px-3 py-1 rounded-sm">
                            {{ $s->kode_sales }}
                        </span>
                    </li>
                @empty
                    <li class="text-sm text-gray-400">Tidak ada sales.</li>
                @endforelse
            </ul>
        </div>

        <div class="bg-white rounded-xl p-5 flex flex-col gap-4 border-2 border-dashed border-green-100">
            <h2 class="text-xs font-semibold uppercase tracking-wide">Riwayat Transaksi</h2>
            <ul class="space-y-2">
                @forelse($transaksi as $t)
                    <li class="flex items-center justify-between text-sm">
                        <span class="text-gray-500">Kode: {{ $t->kode_toko }}</span>
                        <span class="text-green-500 font-semibold">
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
