<?php

namespace App\Utils;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Throwable;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiResponser
{
    /**
     * Generates a successful response.
     *
     * @param mixed $data
     * @param array $meta
     * @param int $status
     * @return JsonResponse
     */
    public static function success(mixed $data = null, array $meta = [], int $status = 200): JsonResponse
    {
        $defaultMeta = [
            'execution_time' => microtime(true) - LARAVEL_START,
            'timestamp'      => now()->toIso8601String(),
            'api_version'    => config('app.api_version', '1.0'),
        ];

        if ($data instanceof LengthAwarePaginator) {
            return response()->json([
                'status' => 'success',
                'data'   => $data->items(),
                'meta'   => array_merge([
                    'total'        => $data->total(),
                    'current_page' => $data->currentPage(),
                    'per_page'     => $data->perPage(),
                    'last_page'    => $data->lastPage(),
                    'has_more'     => $data->hasMorePages(),
                ], array_merge($defaultMeta, $meta)),
            ], $status);
        }

        return response()->json([
            'status' => 'success',
            'data'   => $data,
            'meta'   => array_merge($defaultMeta, $meta),
        ], $status);
    }

    /**
     * Generates an error response.
     *
     * @param string|Throwable $error
     * @param int $status
     * @param array $details
     * @return JsonResponse
     */
    public static function error(string|Throwable $error, int $status = 500, array $details = []): JsonResponse
    {
        $message = $error instanceof Throwable ? $error->getMessage() : $error;
        $trace = config('app.debug') && $error instanceof Throwable ? $error->getTraceAsString() : null;

        return response()->json([
            'status'  => 'error',
            'message' => $message,
            'details' => $details,
            'trace'   => $trace,
        ], $status);
    }

    /**
     * Generates an error validation response.
     *
     * @param ValidationException $exception
     * @return JsonResponse
     */
    public static function validationError(ValidationException $exception): JsonResponse
    {
        return response()->json([
            'status'  => 'error',
            'message' => 'Validation failed',
            'errors'  => $exception->errors(),
        ], 422);
    }

    /**
     * Generates a no content response.
     *
     * @return JsonResponse
     */
    public static function noContent(): JsonResponse
    {
        return response()->json(null, 204);
    }

    /**
     * Generates a full custom response.
     *
     * @param array $response
     * @param int $status
     * @return JsonResponse
     */
    public static function custom(array $response, int $status = 200): JsonResponse
    {
        return response()->json($response, $status);
    }
}
