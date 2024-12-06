@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
    <div class="container my-5">
        <h1>Добро пожаловать, {{ auth()->user()->name }}!</h1>
        <p>Это ваш личный кабинет.</p>

        <!-- Структура для меню и контента -->
        <div class="row mt-4">
            <!-- Меню -->
            <div class="col-md-3 border-end">
                <ul class="list-group">
                    <a href="{{ route('dashboard.trainings') }}" class="list-group-item {{ request()->routeIs('dashboard.trainings') ? 'active' : '' }}">
                        Тренировки
                    </a>
                    <a href="{{ route('dashboard.nutrition') }}" class="list-group-item {{ request()->routeIs('dashboard.nutrition') ? 'active' : '' }}">
                        Питание
                    </a>
                    <a href="{{ route('dashboard.parameters') }}" class="list-group-item {{ request()->routeIs('dashboard.parameters') ? 'active' : '' }}">
                        Параметры
                    </a>
                    <a href="{{ route('dashboard.settings') }}" class="list-group-item {{ request()->routeIs('dashboard.settings') ? 'active' : '' }}">
                        Настройки
                    </a>
                </ul>
            </div>

            <!-- Область отображения контента -->
            <div class="col-md-9">
                @yield('dashboard-content')
            </div>
        </div>
    </div>
@endsection
