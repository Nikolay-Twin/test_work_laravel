<?php
declare(strict_types=1);
namespace App\Http\Resources;

use App\Domain\Interfaces\ResourceApiInterface;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\JsonSerializable;

class CarModelResource extends JsonResource implements ResourceApiInterface
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
            'model_id' => $this->model_id,
            'mark_id'  => $this->mark_id,
            'name'     => $this->name,
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
