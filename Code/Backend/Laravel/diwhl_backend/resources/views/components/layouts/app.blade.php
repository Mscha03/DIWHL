<!doctype html>
<html lang="en" xmlns:livewire="http://www.w3.org/1999/html">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    @vite('resources/css/app.css', 'resources/js/app.js')
    <livewire:styles/>
</head>
<body class="min-h-screen flex flex-col">
        <x-header />
            {{ $slot }}
        <x-footer />
    <livewire:scripts/>
</body>
</html>
