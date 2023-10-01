<?php
declare(strict_types=1);
namespace App\Http\Requests;

use App\Domain\Interfaces\RequestApiInterface;

class CarModelRequestApi extends AbstractRequestApi implements RequestApiInterface
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
            'markId' => 'nullable|uuid'
        ];
    }

    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'markId.uuid' => 'markId должен быть валидным UUID',
        ];
    }
}
