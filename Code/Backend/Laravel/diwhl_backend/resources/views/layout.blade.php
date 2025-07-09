<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('page-title')</title>
    @vite('resources/css/app.css', 'resources/js/app.js')
</head>

<body class="bg-gray-100">

@include('layouts.header')

@yield('content')

@include('layouts.footer')

</body>
</html>
