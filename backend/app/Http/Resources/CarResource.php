<?php
declare(strict_types=1);
namespace App\Http\Resources;

use App\Domain\Interfaces\ResourceApiInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\JsonSerializable;

class CarResource extends JsonResource implements ResourceApiInterface
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request): array|Arrayable|JsonSerializable
    {
        return [
                'car_id'     => $this->car_id,
                'markName'   => $this->model->mark->name,
                'model_id'   => $this->model_id,
                'modelName'  => $this->model->name,
                'name'       => $this->name,
                'year'       => $this->year,
                'mileage'    => $this->mileage,
                'color'      => $this->color,
        ];
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function getCollection(): AnonymousResourceCollection
    {
        return static::collection($this->resource);
    }
}
