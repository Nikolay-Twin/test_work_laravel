<?php
declare(strict_types=1);
namespace App\Http\Api;

use App\Http\Requests\CarRequestApi;
use App\Domain\Services\CarApiCrud;
use Illuminate\Http\JsonResponse;

final class CarController
{
    public function __construct(
        private readonly CarApiCrud $service
    ){}

    /**
     * @param CarRequestApi $request
     * @return JsonResponse
     */
    public function __invoke(CarRequestApi $request): JsonResponse
    {
        return $this->service->read($request);
    }

    /**
     * @param CarRequestApi $request
     * @return JsonResponse
     */
    public function create(CarRequestApi $request): JsonResponse
    {
        return $this->service->create($request);
    }

    /**
     * @param CarRequestApi $request
     * @return JsonResponse
     */
    public function update(CarRequestApi $request): JsonResponse
    {
        return $this->service->update($request);
    }

    /**
     * @param CarRequestApi $request
     * @return JsonResponse
     */
    public function delete(CarRequestApi $request): JsonResponse
    {
        return $this->service->delete($request);
    }
}
