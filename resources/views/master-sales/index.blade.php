@extends('layouts.app')

@section('title', 'Master Sales')

@section('content')

    <div class="flex items-center justify-between mb-5 flex-wrap gap-4">
        <h1 class="text-xl font-semibold text-gray-800">Master Sales</h1>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
            <a href="{{ route('master-sales.template') }}"
                class="inline-flex items-center justify-center text-sm px-3 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50 transition">
                Template Excel
            </a>
            <button onclick="document.getElementById('modalImport').classList.remove('hidden')"
                class="inline-flex items-center justify-center text-sm px-3 py-2 rounded-lg border border-blue-300 text-blue-600 hover:bg-blue-50 transition">
                Import Excel
            </button>
            <a href="{{ route('master-sales.create') }}"
                class="inline-flex items-center justify-center text-sm px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                + Tambah Sales
            </a>
            <a href="{{ route('master-sales.export.pdf') }}"
                class="inline-flex items-center justify-center text-sm px-3 py-2 rounded-lg border border-red-300 text-red-600 hover:bg-red-50 transition">
                Export PDF
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 text-gray-500 uppercase text-xs tracking-wider">
                    <tr>
                        <th class="px-5 py-3">Kode Sales</th>
                        <th class="px-5 py-3">Nama Sales</th>
                        <th class="px-5 py-3">Area</th>
                        <th class="px-5 py-3">Jumlah Toko</th>
                        <th class="px-5 py-3">Total Transaksi</th>
                        <th class="px-5 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($data as $row)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-5 py-3">
                                <span class="bg-gray-100 text-gray-700 text-xs font-medium px-2.5 py-1 rounded-full">
                                    {{ $row['kode_sales'] }}
                                </span>
                            </td>
                            <td class="px-5 py-3 font-medium text-gray-800">{{ $row['nama_sales'] }}</td>
                            <td class="px-5 py-3">
                                <span class="bg-blue-100 text-blue-700 text-xs font-medium px-2.5 py-1 rounded-sm">
                                    Area {{ $row['area'] }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-gray-600">{{ $row['jumlah_toko'] }} toko</td>
                            <td class="px-5 py-3 text-green-600 font-semibold">
                                Rp {{ number_format($row['total_transaksi'], 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-3 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('master-sales.show', $row['kode_sales']) }}"
                                        class="text-xs px-2.5 py-1 rounded-md border border-sky-300 text-sky-600 hover:bg-sky-50 transition">
                                        Detail
                                    </a>
                                    <a href="{{ route('master-sales.edit', $row['kode_sales']) }}"
                                        class="text-xs px-2.5 py-1 rounded-md border border-yellow-300 text-yellow-600 hover:bg-yellow-50 transition">
                                        Edit
                                    </a>
                                    <form action="{{ route('master-sales.destroy', $row['kode_sales']) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus sales ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="text-xs px-2.5 py-1 rounded-md border border-red-300 text-red-600 hover:bg-red-50 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-gray-400">
                                Belum ada data sales.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal --}}
    <div id="modalImport" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md mx-4">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h2 class="text-base font-semibold text-gray-800">Import Excel — Master Sales</h2>
                <button onclick="document.getElementById('modalImport').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600 text-xl">&times;</button>
            </div>
            <form action="{{ route('master-sales.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="px-6 py-4">
                    <p class="text-xs text-gray-400 mb-3">
                        Kolom yang diperlukan:
                        <code class="bg-gray-100 px-1 rounded">kode_sales</code>,
                        <code class="bg-gray-100 px-1 rounded">nama_sales</code>
                    </p>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pilih File Excel</label>
                    <input type="file" name="file" accept=".xlsx,.xls" required
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>
                <div class="flex justify-end gap-2 px-6 py-4 border-t border-gray-100">
                    <button type="button" onclick="document.getElementById('modalImport').classList.add('hidden')"
                        class="text-sm px-4 py-2 rounded-lg border border-gray-300 text-gray-600 hover:bg-gray-50">
                        Batal
                    </button>
                    <button type="submit"
                        class="text-sm px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition">
                        Upload & Import
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
