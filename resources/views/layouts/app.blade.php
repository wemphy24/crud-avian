<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CRUD Avian')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen">
    <div class="max-w-screen-2xl mx-auto">
        <div class="grid grid-cols-6">
            {{-- Sidebar (Desktop) --}}
            <div class="hidden xl:flex flex-col gap-4 p-6 h-screen overflow-y-auto border-r border-gray-100">
                <h1 class="text-2xl font-semibold">CRUD Avian</h1>
                <div class="flex flex-col">
                    <a href="{{ route('master-toko.index') }}"
                        class="flex items-center gap-2 rounded-xl p-2 hover:bg-gray-100 {{ request()->routeIs('master-toko.*') ? 'text-blue-400 font-medium' : '' }}">
                        <x-heroicon-o-building-storefront class="w-5 h-5" />
                        <p>Master Toko</p>
                    </a>
                    <a href="{{ route('master-sales.index') }}"
                        class="flex items-center gap-2 rounded-xl p-2 hover:bg-gray-100 {{ request()->routeIs('master-sales.*') ? 'text-blue-400 font-medium' : '' }}">
                        <x-heroicon-o-user-group class="w-5 h-5" />
                        <p>Master Sales</p>
                    </a>
                    <a href="{{ route('transaksi.index') }}"
                        class="flex items-center gap-2 rounded-xl p-2 hover:bg-gray-100 {{ request()->routeIs('transaksi.*') ? 'text-blue-400 font-medium' : '' }}">
                        <x-heroicon-o-banknotes class="w-5 h-5" />
                        <p>Transaksi</p>
                    </a>
                    <a href="{{ route('laporan.index') }}"
                        class="flex items-center gap-2 rounded-xl p-2 hover:bg-gray-100 {{ request()->routeIs('laporan.*') ? 'text-blue-400 font-medium' : '' }}">
                        <x-heroicon-o-document-chart-bar class="w-5 h-5" />
                        <p>Laporan</p>
                    </a>
                </div>
            </div>

            {{-- Main Content --}}
            <div class="col-span-6 xl:col-span-5 p-6 bg-gray-50">
                <div class="max-w-7xl mx-auto py-6">

                    {{-- Kalau sukses --}}
                    @if (session('success'))
                        <div
                            class="mb-4 flex items-center justify-between bg-green-50 border border-green-200 text-green-800 text-sm rounded-lg px-4 py-3">
                            <span>{{ session('success') }}</span>
                            <button onclick="this.parentElement.remove()"
                                class="text-green-500 hover:text-green-700 ml-4">&times;</button>
                        </div>
                    @endif

                    {{-- Kalau error --}}
                    @if (session('error'))
                        <div
                            class="mb-4 flex items-center justify-between bg-red-50 border border-red-200 text-red-800 text-sm rounded-lg px-4 py-3">
                            <span>{{ session('error') }}</span>
                            <button onclick="this.parentElement.remove()"
                                class="text-red-500 hover:text-red-700 ml-4">&times;</button>
                        </div>
                    @endif


                </div>
                @yield('content')
            </div>
        </div>
    </div>

    {{-- Floating Button --}}
    <button onclick="document.getElementById('mobileMenuModal').classList.remove('hidden')"
        class="xl:hidden fixed bottom-6 right-6 z-40 flex items-center justify-center w-14 h-14 bg-blue-600 text-white rounded-full shadow-lg hover:bg-blue-700 transition">
        <x-heroicon-o-bars-3 class="w-6 h-6" />
    </button>

    {{-- Mobile Menu Modal --}}
    <div id="mobileMenuModal" class="xl:hidden hidden fixed inset-0 z-50">

        <div class="absolute inset-0 bg-black/50"
            onclick="document.getElementById('mobileMenuModal').classList.add('hidden')"></div>

        <div class="absolute right-0 top-0 h-full w-full max-w-xs bg-white shadow-xl overflow-y-auto">
            <div class="flex flex-col gap-4 p-6 h-screen">
                <h1 class="text-2xl font-semibold">CRUD Avian</h1>
                <div class="flex flex-col">
                    <a href="{{ route('master-toko.index') }}"
                        onclick="document.getElementById('mobileMenuModal').classList.add('hidden')"
                        class="flex items-center gap-2 rounded-xl p-2 hover:bg-gray-100 {{ request()->routeIs('master-toko.*') ? 'text-blue-400 font-medium' : '' }}">
                        <x-heroicon-o-building-storefront class="w-5 h-5" />
                        <p>Master Toko</p>
                    </a>
                    <a href="{{ route('master-sales.index') }}"
                        onclick="document.getElementById('mobileMenuModal').classList.add('hidden')"
                        class="flex items-center gap-2 rounded-xl p-2 hover:bg-gray-100 {{ request()->routeIs('master-sales.*') ? 'text-blue-400 font-medium' : '' }}">
                        <x-heroicon-o-user-group class="w-5 h-5" />
                        <p>Master Sales</p>
                    </a>
                    <a href="{{ route('transaksi.index') }}"
                        onclick="document.getElementById('mobileMenuModal').classList.add('hidden')"
                        class="flex items-center gap-2 rounded-xl p-2 hover:bg-gray-100 {{ request()->routeIs('transaksi.*') ? 'text-blue-400 font-medium' : '' }}">
                        <x-heroicon-o-banknotes class="w-5 h-5" />
                        <p>Transaksi</p>
                    </a>
                    <a href="{{ route('laporan.index') }}"
                        onclick="document.getElementById('mobileMenuModal').classList.add('hidden')"
                        class="flex items-center gap-2 rounded-xl p-2 hover:bg-gray-100 {{ request()->routeIs('laporan.*') ? 'text-blue-400 font-medium' : '' }}">
                        <x-heroicon-o-document-chart-bar class="w-5 h-5" />
                        <p>Laporan</p>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>

</html>
