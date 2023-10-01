<?php
declare(strict_types=1);
namespace App\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Validator;

final class Car extends Model
{
    protected $fillable = [
        'model_id',
        'user_id',
        'name',
        'year',
        'mileage',
        'color',
    ];

    public const MESSAGES = [
        'car_id.required'   => 'Не передан ID автомобиля',
        'car_id.uuid'       => 'ID автомобиля должен быть валидным UUID',
        'car_id.exists'     => 'Автомобиль не найден',
        'model_id.required' => 'Не передан ID модели',
        'model_id.uuid'     => 'ID модели должен быть валидным UUID',
        'model_id.exists'   => 'Такой модели нет в списке',
        'name.required'     => 'Не передано название автомобиля',
        'user_id.uuid'      => 'ID пользователя должен быть валидным UUID',
        'year.date_format'  => 'Год выпуска должен быть в формате YYYY',
        'mileage.integer'   => 'Пробег должен быть числом',
        'color.string'      => 'Цвет должен быть строкой',
        'delete.required'   => 'Не переданы идентификаторы автомобилей для удаления',
    ];

    /**
     * @return string[]
     */
    public static function rulesCreate(): array
    {
        return  [
            'model_id' => 'required|uuid|exists:car_models',
            'name'     => 'required',
            'user_id'  => 'nullable|uuid',
            'year'     => 'nullable|date_format:Y',
            'mileage'  => 'nullable|int',
            'color'    => 'nullable|string',
        ];
    }

    /**
     * @return string[]
     */
    public static function rulesUpdate(): array
    {
        return  array_merge(self::rulesCreate(), [
            'car_id'   => 'required|uuid|exists:cars',
            'model_id' => 'nullable|uuid|exists:car_models',
            'name'     => 'nullable',
        ]);
    }

    /**
     * @return string[]
     */
    public static function rulesDelete(): array
    {
        return ['delete' => 'required'];
    }

    /**
     * @param array|string $delete
     * @return array
     */
    public static function batchDelete(array|string $delete): array
    {
        $delete = is_array($delete) ? $delete : [$delete];

        $deleted = $errors = [];
        foreach ($delete as $car_id) {
            $validation = Validator::make(['car_id' => $car_id], [
                'car_id' => 'required|uuid|exists:cars'
            ], self::MESSAGES);

            if ($validation->fails()) {
                $message = $validation->errors()->getMessages()['car_id'];
                $errors[] = ['id' => $car_id, 'error' => array_shift($message)];
                continue;
            }

            if (static::where('car_id', $car_id)->delete()) {
                $deleted[] = $car_id;
            } else {
                $errors[] = ['id' => $car_id, 'error' => 'Сбой системы'];
            }
        }

        return ['deleted' => $deleted, 'errors' => $errors];
    }

    /**
     * @return BelongsTo
     */
    public function model(): BelongsTo
    {
        return $this->belongsTo(CarModel::class, 'model_id', 'model_id');
    }
}
