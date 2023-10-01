<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->uuid('car_id')->default(DB::raw('(gen_random_uuid())'))->unique();
            $table->string('name')->comment('Наименование');
            $table->uuid('model_id')->comment('Модель');
            $table->uuid('user_id')->nullable()->comment('Владелец');
            $table->year('year')->nullable()->comment('Год выпуска');
            $table->integer('mileage')->nullable()->comment('Пробег');
            $table->string('color')->nullable()->comment('Цвет');
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('created_at')->useCurrent();
            $table->index('model_id');
            $table->index('user_id');
            $table->foreign('model_id')->references('model_id')->on('car_models')->cascadeOnDelete();
            $table->foreign('user_id')->references('user_id')->on('users')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
};
