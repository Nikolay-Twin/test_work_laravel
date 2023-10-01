<?php
declare(strict_types=1);
namespace App\Domain\Interfaces;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface ResourceApiInterface
{
    public function getCollection(): AnonymousResourceCollection;
}
