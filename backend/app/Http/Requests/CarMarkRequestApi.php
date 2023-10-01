<?php
declare(strict_types=1);
namespace App\Http\Requests;

use App\Domain\Interfaces\RequestApiInterface;

class CarMarkRequestApi extends AbstractRequestApi implements RequestApiInterface
{
    /**
     * @return bool
     */
     public function authorize(): bool
     {
         return true;
     }
}
