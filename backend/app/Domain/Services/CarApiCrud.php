<?php
declare(strict_types=1);
namespace App\Domain\Services;

use App\Domain\Interfaces\ApiCrudInterface;
use App\Domain\Interfaces\RequestApiInterface;
use App\Domain\Models\Car;
use App\Http\Requests\CarRequestApi;
use App\Http\Resources\CarResource;
use Illuminate\Http\JsonResponse;

class CarApiCrud extends AbstractApiService implements ApiCrudInterface
{
    /**
     * @param CarRequestApi $request
     * @return JsonResponse
     */
    public function read(RequestApiInterface $request): JsonResponse
    {
        $carId = $request->route('carId', 'all');

        if ('all' === $carId) {
            $data = Car::with('model')->get();
        } else {
            $data = Car::where('car_id', $carId)->get();
        }

        if ($data->isEmpty()) {
            return $this->error('Aвтомобилей не найдено');
        }

        return $this->success(new CarResource($data));
    }

    /**
     * @param CarRequestApi $request
     * @return JsonResponse
     */
    public function create(RequestApiInterface $request): JsonResponse
    {
        $request->validate(Car::rulesCreate(), Car::MESSAGES);
        $id = Car::create($request->json()->all())->id;
        $car = Car::where('id', $id)->get();
        if ($car->isEmpty()) {
            return $this->error('Упс... :(');
        }
        return $this->success(new CarResource($car));
    }

    /**
     * @param CarRequestApi $request
     * @return JsonResponse
     */
    public function update(RequestApiInterface $request): JsonResponse
    {
        $request->validate(Car::rulesUpdate(), Car::MESSAGES);
        $car = Car::where('car_id', $request->json('car_id'))->first();
        $car->fill($request->json()->all());
        $car->save();

        if (!empty($changes = $car->getChanges())) {
            $car = Car::where('id', $car->id)->get();
            unset($changes['updated_at']);
            return $this->success(new CarResource($car), ['changes' => $changes]);
        }

        return $this->error('Нет изменений');

    }

    /**
     * @param CarRequestApi $request
     * @return JsonResponse
     */
    public function delete(RequestApiInterface $request): JsonResponse
    {
        $request->validate(Car::rulesDelete(), Car::MESSAGES);
        $delete = $request->json('delete');
        $result = Car::batchDelete($delete);
        if (empty($result['deleted']))  {
            return $this->error('Ничего не удалилось.', $result['errors']);
        }
        return $this->success(
            ['deleted' => $result['deleted']],
            ['errors'  => $result['errors']]
        );
    }
}
