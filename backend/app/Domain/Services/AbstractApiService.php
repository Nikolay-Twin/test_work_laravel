<?php
declare(strict_types=1);
namespace App\Domain\Services;

use App\Domain\Interfaces\ResourceApiInterface;
use Illuminate\Http\JsonResponse;
use function response;

abstract class AbstractApiService
{
    /**
     * @param ResourceApiInterface|array $data
     * @param array $message
     * @return JsonResponse
     */
    public function success(ResourceApiInterface|array $data = [], array $message = []): JsonResponse
    {
        $response = [
            'success' => true,
            'data' => is_array($data) ? $data : $data->getCollection(),
            'message' => $message
        ];

        return response()->json($response);
    }

    /**
     * @param array $error
     * @param array $message
     * @param int $code
     * @return JsonResponse
     */
    public function error(string $message, array $errors = [], int $code = 404): JsonResponse
    {
        $response = [
            'message' => $message,
            'errors' => $errors
        ];

        return response()->json($response, $code);
    }
}
