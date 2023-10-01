<?php
declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Api\CarController;

Route::group([
    'prefix' => 'api',
    'namespace' => 'App\Http\Api',
    ],
    static function () {
        Route::group(['prefix' => 'v1'], static function () {

            Route::get('/mark',   CarMarkController::class);
            Route::get('/model/{markId?}', CarModelController::class);
            Route::get('/car/{carId?}',    CarController::class);
            Route::post('/car',   [CarController::class, 'create']);
            Route::put('/car',    [CarController::class, 'update']);
            Route::delete('/car', [CarController::class, 'delete']);

    });
});
