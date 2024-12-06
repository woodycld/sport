<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Спортивный дневник')</title>
    <!-- Подключаем Bootstrap 5 из CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Подключаем свой стиль -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $errors->first() }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Закрыть"></button>
    </div>
@endif

<!-- Шапка сайта -->
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 150px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Главная</a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Личный кабинет</a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-link nav-link">Выход</button>
                            </form>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('auth') ? 'active' : '' }}" href="{{ route('auth') }}">Авторизация и регистрация</a>
                        </li>
                    @endauth
                </ul>

            </div>
        </div>
    </nav>
</header>

<!-- Основное содержание страницы -->
<div class="container mt-4">
    @yield('content')
</div>

<!-- Подвал сайта -->
<footer class="bg-light py-2 mt-2">
    <div class="container">
        <div class="row align-items-center">
            <!-- Логотип -->
            <div class="col-md-3 text-center text-md-start">
                <a href="{{ route('home') }}"><img src="{{ asset('images/logo.png') }}" alt="Logo" style="width: 150px;"></a>
            </div>

            <!-- Контактная информация и социальные сети -->
            <div class="col-md-5 text-center">
                <p>Контактная информация:</p>
                <p><a href="mailto:support@sports_diary.ru">support@sports_diary.ru</a></p>
                <div class="social-icons">
                    <a href="#"><img src="{{ asset('/images/vk.png') }}" alt="VK" style="height: 40px"></a>
                    <a href="#"><img src="{{ asset('/images/inst.png') }}" alt="Instagram" style="height: 40px"></a>
                    <a href="#"><img src="{{ asset('/images/whatsapp.png') }}" alt="Whatsapp" style="height: 40px"></a>
                </div>
            </div>

            <!-- Дублирующее горизонтальное меню -->
            <div class="col-md-4 text-center text-md-end">
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ route('home') }}" class="text-dark">Главная</a></li>
                    <li class="mb-2"><a href="{{ route('auth') }}" class="text-dark">Авторизация и регистрация</a></li>
                </ul>
            </div>
        </div>

        <!-- Подпись о правах -->
        <div class="row mt-4">
            <div class="col text-center">
                <p>&copy; 2024 Спортивный дневник. Все права защищены. Шубин Даня</p>
            </div>
        </div>
    </div>
</footer>


<!-- Подключаем JS для Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
