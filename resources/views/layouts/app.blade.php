<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title ?? 'Jessica Nails Studio' }}</title>
    <meta name="description" content="Uñas impecables en Lima — diseños personalizados y acabado profesional." />
    <link rel="stylesheet" href="{{ asset('css/site.css') }}" />
</head>
<body>
    <header class="site-header">
        <div class="container nav-wrap">
            <a class="brand" href="{{ route('home') }}">{{ site_setting('site_name', 'Jessica Nails Studio') }}</a>
            <nav class="nav-links">
                <a href="{{ route('home') }}">Inicio</a>
                <a href="{{ route('gallery') }}">Galeria</a>
                <a href="/admin">Admin</a>
            </nav>
        </div>
    </header>

    <main class="container">
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container">
            <p>{{ site_setting('site_name', 'Jessica Nails Studio') }} · {{ site_setting('address', 'Lima, Perú') }}</p>
        </div>
    </footer>
</body>
</html>
