{{-- resources/views/master-toko/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Toko')

@section('content')

    <div class="max-w-lg mx-auto">
        <div class="mb-5">
            <h1 class="text-xl font-semibold text-gray-800">Edit Toko</h1>
            <p class="text-sm text-gray-400 mt-1">Kode toko baru tidak dapat diubah.</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form action="{{ route('master-toko.update', $toko->kode_toko_baru) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Toko Baru</label>
                    <input type="number" value="{{ $toko->kode_toko_baru }}"
                        class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-400 cursor-not-allowed"
                        disabled>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Toko Lama</label>
                    <input type="number" name="kode_toko_lama" value="{{ old('kode_toko_lama', $toko->kode_toko_lama) }}"
                        class="w-full rounded-lg border @error('kode_toko_lama') border-red-400 @else border-gray-300 @enderror px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
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
                            <option value="{{ $area }}"
                                {{ old('area_sales', $toko->area_sales) == $area ? 'selected' : '' }}>
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
                        class="px-5 py-2 rounded-lg bg-yellow-500 text-white text-sm font-medium hover:bg-yellow-600 transition">
                        Perbarui
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
