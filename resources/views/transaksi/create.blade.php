@extends('layouts.app')

@section('title', 'Tambah Transaksi')

@section('content')

    <div class="max-w-lg mx-auto">
        <div class="mb-5">
            <h1 class="text-xl font-semibold text-gray-800">Tambah Transaksi</h1>
            <p class="text-sm text-gray-400 mt-1">Pilih toko dan masukkan nominal transaksi.</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form action="{{ route('transaksi.store') }}" method="POST" class="space-y-5">
                @csrf


                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Kode Toko <span class="text-red-500">*</span>
                    </label>
                    <select name="kode_toko"
                        class="w-full rounded-lg border @error('kode_toko') border-red-400 @else border-gray-300 @enderror px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                        required>
                        <option value="">-- Pilih Toko --</option>
                        @foreach ($tokoList as $toko)
                            <option value="{{ $toko['kode'] }}" {{ old('kode_toko') == $toko['kode'] ? 'selected' : '' }}>
                                {{ $toko['label'] }}
                            </option>
                        @endforeach
                    </select>
                    <p class="mt-1 text-xs text-gray-400">
                        Format: Kode Toko — Sales Area
                    </p>
                    @error('kode_toko')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>


                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nominal Transaksi <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-sm text-gray-400">
                            Rp
                        </span>
                        <input type="number" name="nominal_transaksi" value="{{ old('nominal_transaksi') }}" step="0.01"
                            min="0" max="999999.99" placeholder="0.00"
                            class="w-full rounded-lg border @error('nominal_transaksi') border-red-400 @else border-gray-300 @enderror pl-9 pr-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                            required>
                    </div>
                    <p class="mt-1 text-xs text-gray-400">
                        Maksimal Rp 999.999,99
                    </p>
                    @error('nominal_transaksi')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>


                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="px-5 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition">
                        Simpan
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
