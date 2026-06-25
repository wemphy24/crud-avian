@extends('layouts.app')

@section('title', 'Edit Transaksi')

@section('content')

    <div class="max-w-lg mx-auto">
        <div class="mb-5">
            <h1 class="text-xl font-semibold text-gray-800">Edit Transaksi</h1>
            <p class="text-sm text-gray-400 mt-1">Hanya nominal transaksi yang dapat diubah.</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form action="{{ route('transaksi.update', $transaksi->kode_toko) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Toko</label>
                    <input type="text" value="{{ $transaksi->kode_toko }}"
                        class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-400 cursor-not-allowed"
                        disabled>
                    <p class="mt-1 text-xs text-gray-400">
                        Kode toko tidak dapat diubah.
                    </p>
                </div>

                @php $toko = $transaksi->toko(); @endphp
                @if ($toko)
                    <div class="rounded-lg bg-gray-50 border border-gray-200 px-4 py-3 text-sm">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Info Toko</p>
                        <div class="flex items-center justify-between">
                            <div class="space-y-1">
                                <p class="text-gray-700">
                                    Kode Baru:
                                    <span class="font-medium">{{ $toko->kode_toko_baru }}</span>
                                </p>
                                @if ($toko->kode_toko_lama)
                                    <p class="text-gray-500 text-xs">
                                        Kode Lama: {{ $toko->kode_toko_lama }}
                                    </p>
                                @endif
                            </div>
                            <span class="bg-blue-100 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-full">
                                Area {{ $toko->area_sales }}
                            </span>
                        </div>
                    </div>
                @endif

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nominal Transaksi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-sm text-gray-400">
                            Rp
                        </span>
                        <input type="number" name="nominal_transaksi"
                            value="{{ old('nominal_transaksi', $transaksi->nominal_transaksi) }}" step="0.01"
                            min="0" max="999999.99"
                            class="w-full rounded-lg border @error('nominal_transaksi') border-red-400 @else border-gray-300 @enderror pl-9 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                            required>
                    </div>
                    <p class="mt-1 text-xs text-gray-400">
                        Nominal sebelumnya:
                        <span class="text-green-600 font-medium">
                            Rp {{ number_format($transaksi->nominal_transaksi, 0, ',', '.') }}
                        </span>
                    </p>
                    @error('nominal_transaksi')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="px-5 py-2 rounded-lg bg-yellow-500 text-white text-sm font-medium hover:bg-yellow-600 transition">
                        Perbarui
                    </button>
                    <a href="{{ route('transaksi.index') }}"
                        class="px-5 py-2 rounded-lg border border-gray-300 text-gray-600 text-sm hover:bg-gray-50 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection
