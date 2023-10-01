<?php
declare(strict_types=1);
namespace App\Http\Api;

use App\Http\Requests\CarModelRequestApi;
use App\Domain\Services\CarModelApiReader;
use Illuminate\Http\JsonResponse;

final class CarModelController
{

    public function __construct(
        private readonly CarModelApiReader $service
    ){}

    /**
     * @param CarMarkRequestApi $request
     * @return JsonResponse
     */
    public function __invoke(CarModelRequestApi $request): JsonResponse
    {
        return $this->service->read($request);
    }
}
