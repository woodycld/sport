<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserParameter;
use App\Models\CalorieProduct;
use App\Models\Menu;

class NutritionController extends Controller
{
    public function generate(Request $request)
    {
        $parameters = auth()->user()->parameters;

        if (!$parameters) {
            return redirect()->route('dashboard.parameters')->with('error', 'Заполните параметры для составления меню.');
        }

        $calorieIntake = $this->calculateCalories($parameters);
        $menu = $this->createMenu($calorieIntake);

        Menu::updateOrCreate(
            ['user_id' => auth()->id()],
            ['data' => json_encode($menu)]
        );

        return redirect()->route('dashboard.nutrition')->with('success', 'Ваш план питания успешно создан.');
    }

    public function update(Request $request)
    {
        return $this->generate($request);
    }

    private function calculateCalories($parameters)
    {
        $baseCalories = 10 * $parameters->current_weight + 6.25 * $parameters->height - 5 * $parameters->age;
        $activityMultiplier = match ($parameters->activity_level) {
            'sedentary_low' => 1.2,
            'sedentary_medium' => 1.55,
            'physically_active' => 1.9,
        };

        return $baseCalories * $activityMultiplier + ($parameters->goal == 'gain_muscle' ? 500 : ($parameters->goal == 'lose_fat' ? -500 : 0));
    }

    private function createMenu($calorieIntake)
    {
        $products = CalorieProduct::all();
        $menu = [];
        $days = ['Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота', 'Воскресенье'];

        foreach ($days as $day) {
            $dailyCalories = $calorieIntake / 3; // Разделим на 3 приема пищи
            $menu[$day] = [
                'breakfast' => $this->getRandomProduct($products, $dailyCalories),
                'lunch' => $this->getRandomProduct($products, $dailyCalories),
                'dinner' => $this->getRandomProduct($products, $dailyCalories),
            ];
        }

        return $menu;
    }

    private function getRandomProduct($products, $calorieTarget)
    {
        $product = $products->random();
        $portion = $calorieTarget / $product->calories;

        return [
            'name' => $product->name,
            'portion' => round($portion, 2) . ' ' . $product->unit,
            'calories' => $calorieTarget,
        ];
    }
}
