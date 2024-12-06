@extends('dashboard')

@section('dashboard-content')
    <h2 class="mb-4">Параметры пользователя</h2>

    <!-- Уведомления -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Отображение текущих параметров -->
    <h4 class="mb-3">Текущие параметры:</h4>
    <ul class="list-group mb-4">
        <li class="list-group-item">1. Пол:
            @if ($parameters && $parameters->gender)
                {{ $parameters->gender == 'male' ? 'Мужчина' : 'Женщина' }}
            @else
                Не указано
            @endif
        </li>
        <li class="list-group-item">2. Рост: {{ $parameters->height ?? 'Не указано' }} см</li>
        <li class="list-group-item">3. Текущий вес: {{ $parameters->current_weight ?? 'Не указано' }} кг</li>
        <li class="list-group-item">4. Желаемый вес: {{ $parameters->desired_weight ?? 'Не указано' }} кг</li>
        <li class="list-group-item">5. Возраст: {{ $parameters->age ?? 'Не указано' }} лет</li>
        <li class="list-group-item">6. Цель:
            @if ($parameters && $parameters->goal)
                @if ($parameters->goal == 'lose_fat')
                    Похудеть (убрать жир)
                @elseif ($parameters->goal == 'maintain')
                    Поддерживать форму
                @elseif ($parameters->goal == 'gain_muscle')
                    Набрать мышечную массу
                @else
                    Не указано
                @endif
            @else
                Не указано
            @endif
        </li>
        <li class="list-group-item">7. Планируемое число тренировок: {{ $parameters->weekly_trainings ?? 'Не указано' }}</li>
        <li class="list-group-item">8. Уровень физической подготовки:
            @if ($parameters && $parameters->fitness_level)
                @if ($parameters->fitness_level == 'beginner')
                    Новичок
                @elseif ($parameters->fitness_level == 'trained')
                    Тренированный
                @elseif ($parameters->fitness_level == 'amateur')
                    Спортсмен-любитель
                @elseif ($parameters->fitness_level == 'athlete')
                    Спортсмен
                @else
                    Не указано
                @endif
            @else
                Не указано
            @endif
        </li>
        <li class="list-group-item">9. Уровень активности:
            @if ($parameters && $parameters->activity_level)
                @if ($parameters->activity_level == 'sedentary_low')
                    Сидячая работа (малоподвижный образ жизни)
                @elseif ($parameters->activity_level == 'sedentary_medium')
                    Сидячая работа (среднеактивный образ жизни)
                @elseif ($parameters->activity_level == 'physically_active')
                    Работа с физической нагрузкой
                @else
                    Не указано
                @endif
            @else
                Не указано
            @endif
        </li>
    </ul>

    <!-- Форма обновления параметров -->
    <form action="{{ route('dashboard.parameters.store') }}" method="POST">
        @csrf

        <!-- Пол -->
        <div class="mb-3">
            <label for="gender" class="form-label">Пол:</label>
            <select name="gender" id="gender" class="form-control">
                <option value="male" {{ old('gender', $parameters->gender ?? '') == 'male' ? 'selected' : '' }}>Мужчина</option>
                <option value="female" {{ old('gender', $parameters->gender ?? '') == 'female' ? 'selected' : '' }}>Женщина</option>
            </select>
        </div>

        <!-- Рост -->
        <div class="mb-3">
            <label for="height" class="form-label">Рост (см):</label>
            <input type="number" name="height" id="height" class="form-control" value="{{ old('height', $parameters->height ?? '') }}">
        </div>

        <!-- Текущий вес -->
        <div class="mb-3">
            <label for="current_weight" class="form-label">Текущий вес (кг):</label>
            <input type="number" step="0.1" name="current_weight" id="current_weight" class="form-control" value="{{ old('current_weight', $parameters->current_weight ?? '') }}">
        </div>

        <!-- Желаемый вес -->
        <div class="mb-3">
            <label for="desired_weight" class="form-label">Желаемый вес (кг):</label>
            <input type="number" step="0.1" name="desired_weight" id="desired_weight" class="form-control" value="{{ old('desired_weight', $parameters->desired_weight ?? '') }}">
        </div>

        <!-- Возраст -->
        <div class="mb-3">
            <label for="age" class="form-label">Возраст:</label>
            <input type="number" name="age" id="age" class="form-control" value="{{ old('age', $parameters->age ?? '') }}">
        </div>

        <!-- Цель -->
        <div class="mb-3">
            <label for="goal" class="form-label">Цель:</label>
            <select name="goal" id="goal" class="form-control">
                <option value="lose_fat" {{ old('goal', $parameters->goal ?? '') == 'lose_fat' ? 'selected' : '' }}>Похудеть (убрать жир)</option>
                <option value="maintain" {{ old('goal', $parameters->goal ?? '') == 'maintain' ? 'selected' : '' }}>Поддерживать форму</option>
                <option value="gain_muscle" {{ old('goal', $parameters->goal ?? '') == 'gain_muscle' ? 'selected' : '' }}>Набрать мышечную массу</option>
            </select>
        </div>

        <!-- Число тренировок -->
        <div class="mb-3">
            <label for="weekly_trainings" class="form-label">Планируемое число тренировок в неделю:</label>
            <select name="weekly_trainings" id="weekly_trainings" class="form-control">
                @for($i = 0; $i <= 7; $i++)
                    <option value="{{ $i }}" {{ old('weekly_trainings', $parameters->weekly_trainings ?? '') == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>

        <!-- Уровень физической подготовки -->
        <div class="mb-3">
            <label for="fitness_level" class="form-label">Уровень физической подготовки:</label>
            <select name="fitness_level" id="fitness_level" class="form-control">
                <option value="beginner" {{ old('fitness_level', $parameters->fitness_level ?? '') == 'beginner' ? 'selected' : '' }}>Новичок</option>
                <option value="trained" {{ old('fitness_level', $parameters->fitness_level ?? '') == 'trained' ? 'selected' : '' }}>Тренированный</option>
                <option value="amateur" {{ old('fitness_level', $parameters->fitness_level ?? '') == 'amateur' ? 'selected' : '' }}>Спортсмен-любитель</option>
                <option value="athlete" {{ old('fitness_level', $parameters->fitness_level ?? '') == 'athlete' ? 'selected' : '' }}>Спортсмен</option>
            </select>
        </div>

        <!-- Уровень активности -->
        <div class="mb-3">
            <label for="activity_level" class="form-label">Уровень активности:</label>
            <select name="activity_level" id="activity_level" class="form-control">
                <option value="sedentary_low" {{ old('activity_level', $parameters->activity_level ?? '') == 'sedentary_low' ? 'selected' : '' }}>Сидячая работа (малоподвижный образ жизни)</option>
                <option value="sedentary_medium" {{ old('activity_level', $parameters->activity_level ?? '') == 'sedentary_medium' ? 'selected' : '' }}>Сидячая работа (среднеактивный образ жизни)</option>
                <option value="physically_active" {{ old('activity_level', $parameters->activity_level ?? '') == 'physically_active' ? 'selected' : '' }}>Работа с физической нагрузкой</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Сохранить параметры</button>
    </form>
@endsection
