<?php
declare(strict_types=1);
namespace App\Http\Api;

use App\Domain\Services\CarMarkApiReader;
use App\Http\Requests\CarMarkRequestApi;
use Illuminate\Http\JsonResponse;

final class CarMarkController
{
    public function __construct(
        private readonly CarMarkApiReader $service
    ){}

    /**
     * @param CarMarkRequestApi $request
     * @return JsonResponse
     */
    public function __invoke(CarMarkRequestApi $request): JsonResponse
    {
        return $this->service->read($request);
    }
}
