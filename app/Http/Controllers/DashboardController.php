<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\UserParameter;
use App\Models\Menu;
use App\Models\Exercise;
use App\Models\WorkoutPlan;

class DashboardController extends Controller
{
    public function trainings()
    {
        $parameters = auth()->user()->parameters; // Получаем параметры пользователя

        // Получаем план тренировок для текущего пользователя
        $workoutPlan = WorkoutPlan::where('user_id', auth()->id())->first(); // Загружаем план тренировок из базы данных

        return view('dashboard.trainings', compact('parameters', 'workoutPlan')); // Передаем данные в представление
    }

    public function generateWorkoutPlan()
    {
        $parameters = auth()->user()->parameters; // Получаем параметры пользователя

        if (!$parameters) {
            return redirect()->route('dashboard.trainings')->with('error', 'Вы не указали параметры. Перейдите в раздел "Параметры".');
        }

        $days = $parameters->weekly_trainings; // Количество тренировок в неделю
        $muscleGroups = ['Грудь', 'Ноги', 'Спина', 'Плечи', 'Руки', 'Икры'];
        $exercises = Exercise::all();
        $workoutPlan = [];

        for ($i = 0; $i < $days; $i++) {
            $dayMuscles = [$muscleGroups[$i % count($muscleGroups)]]; // Выбираем группу мышц циклично
            $dayPlan = [];

            // Добавляем разминку
            $dayPlan[] = [
                'name' => 'Разминка на кардио-тренажере',
                'sets' => 1,
                'reps' => 10, // Время: 10 минут
                'weight' => null,
                'time' => 10,
            ];

            // Подбор упражнений для группы мышц
            $selectedExercises = $exercises->whereIn('muscle_group', $dayMuscles)->shuffle()->take(3);

            $totalTime = 10; // Время разминки
            foreach ($selectedExercises as $exercise) {
                $exerciseTime = ($exercise->recommended_reps * 1.5 + $exercise->recommended_sets * 0.5) + 5; // Время на упражнение
                $totalTime += $exerciseTime;

                if ($totalTime > 120) break; // Останавливаем, если время тренировки превышает 2 часа

                $dayPlan[] = [
                    'name' => $exercise->name,
                    'sets' => $exercise->recommended_sets,
                    'reps' => $exercise->recommended_reps,
                    'weight' => $exercise->recommended_weight,
                    'time' => round($exerciseTime, 2),
                ];
            }

            // Добавляем кардио в конце (5 минут)
            $dayPlan[] = [
                'name' => 'Кардио на выбор',
                'sets' => 1,
                'reps' => 5, // Время: 5 минут
                'weight' => null,
                'time' => 5,
            ];

            $workoutPlan["День " . ($i + 1)] = $dayPlan;
        }

        // Сохраняем или обновляем план тренировок в базе данных
        WorkoutPlan::updateOrCreate(
            ['user_id' => auth()->id()],
            ['data' => json_encode($workoutPlan)] // Сохраняем данные в формате JSON
        );

        return redirect()->route('dashboard.trainings')->with('success', 'Ваш план тренировок успешно создан.');
    }



    public function nutrition()
    {
        $parameters = auth()->user()->parameters; // Получаем параметры пользователя
        $menu = Menu::where('user_id', auth()->id())->first(); // Проверяем, есть ли план питания у пользователя

        return view('dashboard.nutrition', compact('parameters', 'menu'));
    }

    public function parameters()
    {
        $parameters = UserParameter::where('user_id', auth()->id())->first();

        return view('dashboard.parameters', compact('parameters'));
    }

    public function storeParameters(Request $request)
    {
        $request->validate([
            'gender' => 'required|in:male,female',
            'height' => 'required|integer|min:100|max:250',
            'current_weight' => 'required|numeric|min:30|max:300',
            'desired_weight' => 'required|numeric|min:30|max:300',
            'age' => 'required|integer|min:10|max:100',
            'goal' => 'required|in:lose_fat,maintain,gain_muscle',
            'weekly_trainings' => 'required|integer|min:0|max:7',
            'fitness_level' => 'required|in:beginner,trained,amateur,athlete',
            'activity_level' => 'required|in:sedentary_low,sedentary_medium,physically_active',
        ]);

        $parameters = UserParameter::updateOrCreate(
            ['user_id' => auth()->id()],
            $request->all()
        );

        return back()->with('success', 'Ваши параметры успешно сохранены!');
    }

    public function settings()
    {
        return view('dashboard.settings');
    }

    public function updateName(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'current_password' => 'required',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Текущий пароль указан неверно.']);
        }

        $user->update(['name' => $request->name]);

        return back()->with('success', 'Ваше имя успешно обновлено!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Текущий пароль указан неверно.']);
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Ваш пароль успешно обновлен!');
    }
}
