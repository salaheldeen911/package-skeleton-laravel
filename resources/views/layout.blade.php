<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel Custom Fields') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal text-gray-900">
    <nav class="bg-white shadow">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a class="text-xl font-bold text-blue-600" href="{{ route('custom-fields.index') }}">
                Custom Fields
            </a>
            <div>
                <!-- Add navigation items here if needed -->
            </div>
        </div>
    </nav>

    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    @stack('scripts')
</body>

</html>