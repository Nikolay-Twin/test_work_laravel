<?php
declare(strict_types=1);
namespace App\Http\Requests;

use App\Domain\Interfaces\RequestApiInterface;
use Illuminate\Foundation\Http\FormRequest;
use HttpRuntimeException;

abstract class AbstractRequestApi extends FormRequest implements RequestApiInterface
{

    /**
     * @return array|null
     * @throws HttpRuntimeException
     */
    public function validationData(): ?array
    {
        if (!$this->ajax()) {
          //  throw new HttpRuntimeException('Is not ajax.');
        }

        return array_merge(
            $this->all(),
            $this->json()->all(),
            $this->route()->parameters()
        );
    }

}
