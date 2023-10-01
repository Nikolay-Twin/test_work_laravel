<?php
declare(strict_types=1);
namespace App\Domain\Interfaces;

use Illuminate\Http\JsonResponse;

interface ApiReadInterface
{
    public function read(RequestApiInterface $request): JsonResponse;
}
