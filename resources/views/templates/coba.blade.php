<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — Agung</title>

    {{-- Tailwind via CDN (cukup untuk dev) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    {{-- Font (opsional) --}}
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', system-ui, -apple-system, Segoe UI, Roboto, 'Helvetica Neue', Arial, 'Noto Sans', 'Apple Color Emoji', 'Segoe UI Emoji';
        }
    </style>
</head>
<body class="bg-cream min-h-dvh flex items-center">
<div class="container mx-auto px-4 md:px-8 lg:px-12">
    @yield('content')
</div>
</body>
</html>
