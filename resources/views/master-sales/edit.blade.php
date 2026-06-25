@extends('layouts.app')

@section('title', 'Edit Sales')

@section('content')

    <div class="max-w-lg mx-auto">
        <div class="mb-5">
            <h1 class="text-xl font-semibold text-gray-800">Edit Sales</h1>
            <p class="text-sm text-gray-400 mt-1">Kode sales tidak dapat diubah karena menjadi acuan area.</p>
        </div>

        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <form action="{{ route('master-sales.update', $sales->kode_sales) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Sales</label>
                    <div class="flex items-center gap-2">
                        <input type="text" value="{{ $sales->kode_sales }}"
                            class="w-full rounded-lg border border-gray-200 bg-gray-50 px-3 py-2 text-sm text-gray-400 cursor-not-allowed"
                            disabled>
                        <span
                            class="bg-blue-100 text-blue-700 text-xs font-medium px-2.5 py-1.5 rounded-full whitespace-nowrap">
                            Area {{ $sales->prefix_area }}
                        </span>
                    </div>
                    <p class="mt-1 text-xs text-gray-400">
                        Kode sales menentukan area — tidak bisa diubah.
                    </p>
                </div>


                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nama Sales <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama_sales" value="{{ old('nama_sales', $sales->nama_sales) }}"
                        maxlength="20"
                        class="w-full rounded-lg border @error('nama_sales') border-red-400 @else border-gray-300 @enderror px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300"
                        required>
                    <p class="mt-1 text-xs text-gray-400">Maksimal 20 karakter.</p>
                    @error('nama_sales')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-3 pt-2">
                    <button type="submit"
                        class="px-5 py-2 rounded-lg bg-yellow-500 text-white text-sm font-medium hover:bg-yellow-600 transition">
                        Perbarui
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
