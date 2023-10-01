<?php
declare(strict_types=1);
namespace App\Domain\Interfaces;

interface RequestApiInterface
{
    public function authorize(): bool;
}
