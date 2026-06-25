@extends('layouts.app')

@section('title', 'Tambah Sales')

@section('content')

    <div class="max-w-lg mx-auto">
        <div class="mb-5">
            <h1 class="text-xl font-semibold text-gray-800">Tambah Sales Baru</h1>
            <p class="text-sm text-gray-400 mt-1">Kode sales harus diawali huruf area yang valid.</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form action="{{ route('master-sales.store') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Kode Sales <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="kode_sales" value="{{ old('kode_sales') }}" placeholder="Contoh: A3, B3"
                        class="w-full rounded-lg border @error('kode_sales') border-red-400 @else border-gray-300 @enderror px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                        required>
                    <p class="mt-1 text-xs text-gray-400">
                        Diawali huruf area (A/B) diikuti angka urut.
                    </p>
                    @error('kode_sales')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Sales <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_sales" value="{{ old('nama_sales') }}" maxlength="20"
                        class="w-full rounded-lg border @error('nama_sales') border-red-400 @else border-gray-300 @enderror px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                        required>
                    @error('nama_sales')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="px-5 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700 transition">
                        Simpan
                    </button>
                    <a href="{{ route('master-sales.index') }}"
                        class="px-5 py-2 rounded-lg border border-gray-300 text-gray-600 text-sm hover:bg-gray-50 transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

@endsection
