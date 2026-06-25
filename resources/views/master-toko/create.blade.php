{{-- resources/views/master-toko/create.blade.php --}}
@extends('layouts.app')

@section('title', 'Tambah Toko')

@section('content')

    <div class="max-w-lg mx-auto">
        <div class="mb-5">
            <h1 class="text-xl font-semibold text-gray-800">Tambah Toko Baru</h1>
            <p class="text-sm text-gray-400 mt-1">Isi form di bawah untuk menambahkan toko.</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form action="{{ route('master-toko.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Kode Toko Baru <span class="text-red-500">*</span>
                    </label>
                    <input type="number" name="kode_toko_baru" value="{{ old('kode_toko_baru') }}"
                        class="w-full rounded-lg border @error('kode_toko_baru') border-red-400 @else border-gray-300 @enderror px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                        required>
                    @error('kode_toko_baru')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Toko Lama</label>
                    <input type="number" name="kode_toko_lama" value="{{ old('kode_toko_lama') }}"
                        class="w-full rounded-lg border @error('kode_toko_lama') border-red-400 @else border-gray-300 @enderror px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <p class="mt-1 text-xs text-gray-400">Kosongkan jika tidak ada kode lama.</p>
                    @error('kode_toko_lama')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Sales Area <span class="text-red-500">*</span>
                    </label>
                    <select name="area_sales"
                        class="w-full rounded-lg border @error('area_sales') border-red-400 @else border-gray-300 @enderror px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                        required>
                        <option value="">-- Pilih Area --</option>
                        @foreach ($areas as $area)
                            <option value="{{ $area }}" {{ old('area_sales') == $area ? 'selected' : '' }}>
                                Area {{ $area }}
                            </option>
                        @endforeach
                    </select>
                    @error('area_sales')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="px-5 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition">
                        Simpan
                    </button>
                    <a href="{{ route('master-toko.index') }}"
                        class="px-5 py-2 rounded-lg border border-gray-300 text-gray-600 text-sm hover:bg-gray-50 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection
