<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CRUD Avian</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="max-w-screen-2xl mx-auto">
        <div class="grid grid-cols-6">
            <div class="flex flex-col gap-4 p-6 h-screen overflow-y-auto border-r border-gray-100">
                <h1 class="text-2xl font-bold">CRUD Avian</h1>
                <div class="flex flex-col">
                    <a href="/" class="flex items-center gap-2 rounded-xl p-2 hover:bg-gray-100">
                        <x-heroicon-o-circle-stack class="w-5 h-5" />
                        <p>Master Data</p>
                    </a>
                </div>
            </div>
            <div class="col-span-5 p-6">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>
