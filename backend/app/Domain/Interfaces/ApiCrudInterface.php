<?php
declare(strict_types=1);
namespace App\Domain\Interfaces;

use Illuminate\Http\JsonResponse;

interface ApiCrudInterface extends ApiReadInterface
{
    public function create(RequestApiInterface $request): JsonResponse;
    public function update(RequestApiInterface $request): JsonResponse;
    public function delete(RequestApiInterface $request): JsonResponse;
}
