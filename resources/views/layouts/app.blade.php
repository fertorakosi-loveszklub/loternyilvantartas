<!doctype html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fertőrákosi Lövészklub</title>
    <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
    <link rel="shortcut icon" href="{{ asset('icon.png') }}" type="image/png">
</head>
<body>
<header class="mb-5">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary text-white">
        <div class="container">
            <a class="navbar-brand" href="/">Fertőrákosi Lövészklub</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item @if($menu == 'home') active @endif">
                        <a class="nav-link" href="/">Főoldal</a>
                    </li>
                    <li class="nav-item @if($menu == 'ammo') active @endif">
                        <a class="nav-link" href="/ammo">Lőszernyilvántartás</a>
                    </li>
                    <li class="nav-item @if($menu == 'calibers') active @endif">
                        <a class="nav-link" href="{{ route('calibers.index') }}">Kaliberek</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<main>
    <div class="container">

        @if ($errors->isNotEmpty())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </div>
</main>
<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
