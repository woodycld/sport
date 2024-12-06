<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserParametersTable extends Migration
{
    public function up()
    {
        Schema::create('user_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('gender', ['male', 'female']);
            $table->integer('height'); // Рост
            $table->float('current_weight'); // Текущий вес
            $table->float('desired_weight'); // Желаемый вес
            $table->integer('age'); // Возраст
            $table->enum('goal', ['lose_fat', 'maintain', 'gain_muscle']); // Цель
            $table->tinyInteger('weekly_trainings'); // Число тренировок в неделю
            $table->enum('fitness_level', ['beginner', 'trained', 'amateur', 'athlete']); // Уровень физподготовки
            $table->enum('activity_level', [
                'sedentary_low',
                'sedentary_medium',
                'physically_active'
            ]); // Уровень активности
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_parameters');
    }
}
