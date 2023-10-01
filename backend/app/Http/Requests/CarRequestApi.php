<?php
declare(strict_types=1);
namespace App\Http\Requests;

use App\Domain\Interfaces\RequestApiInterface;

class CarRequestApi extends AbstractRequestApi implements RequestApiInterface
{
    /**
     * @return bool
     */
     public function authorize(): bool
     {
         return true;
     }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'carId' => 'nullable|uuid'
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'carId.uuid' => 'carId должен быть валидным UUID',
        ];
    }
}
