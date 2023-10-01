<?php
declare(strict_types=1);
namespace App\Domain\Services;

use App\Domain\Interfaces\ApiReadInterface;
use App\Domain\Interfaces\RequestApiInterface;
use App\Domain\Models\CarModel;
use App\Http\Requests\CarModelRequestApi;
use App\Http\Resources\CarModelResource;
use Illuminate\Http\JsonResponse;

class CarModelApiReader extends AbstractApiService implements ApiReadInterface
{
    /**
     * @param CarModelRequestApi $request
     * @return JsonResponse
     */
    public function read(RequestApiInterface $request): JsonResponse
    {
        $markId = $request->route('markId', 'all');

        if ('all' === $markId) {
            $data = CarModel::with('mark')->get();
        } else {
            $data = CarModel::where('mark_id', $markId)->get();
        }

        if ($data->isEmpty()) {
            return $this->error('Моделей авто не найдено');
        }

        return $this->success(new CarModelResource($data));
    }
}
