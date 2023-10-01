<?php
declare(strict_types=1);
namespace App\Domain\Services;

use App\Domain\Interfaces\ApiReadInterface;
use App\Domain\Interfaces\RequestApiInterface;
use App\Domain\Models\CarMark;
use App\Http\Requests\CarMarkRequestApi;
use App\Http\Resources\CarMarkResource;
use Illuminate\Http\JsonResponse;

class CarMarkApiReader extends AbstractApiService implements ApiReadInterface
{

    /**
     * @param CarMarkRequestApi $request
     * @return JsonResponse
     */
    public function read(RequestApiInterface $request): JsonResponse
    {
        $data = CarMark::all();
        if ($data->isEmpty()) {
            return $this->error('Марок авто не найдено');
        }
        return $this->success(new CarMarkResource($data));
    }
}
