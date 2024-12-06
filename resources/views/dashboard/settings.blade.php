@extends('dashboard')

@section('dashboard-content')
    <h2 class="mb-4">Настройки профиля</h2>

    <!-- Сообщения об успехе -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Сообщения об ошибке -->
    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <!-- Форма обновления имени -->
    <form action="{{ route('settings.update-name') }}" method="POST" class="mb-5">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Ваше новое имя:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label for="current_password" class="form-label">Текущий пароль:</label>
            <input type="password" name="current_password" id="current_password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Изменить имя</button>
    </form>

    <hr>

    <!-- Форма обновления пароля -->
    <form action="{{ route('settings.update-password') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="current_password" class="form-label">Текущий пароль:</label>
            <input type="password" name="current_password" id="current_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="new_password" class="form-label">Новый пароль:</label>
            <input type="password" name="new_password" id="new_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="new_password_confirmation" class="form-label">Подтверждение нового пароля:</label>
            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Изменить пароль</button>
    </form>
@endsection
