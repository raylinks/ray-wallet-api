<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

trait HasApiResponses
{
    /**
     * Set the server error response
     *
     * @param $message
     * @param \Exception|null $exception
     * @return \Illuminate\Http\JsonResponse
     */
    public function serverErrorAlert($message, Exception $exception = null): JsonResponse
    {
        if ($exception !== null) {
            Log::error("{$exception->getMessage()} on line {$exception->getLine()} in {$exception->getFile()}");
        }

        $response = [
            'statusCode' => config('patricia.status_codes.server_error'),
            'message' => $message,
        ];

        return Response::json($response, config('patricia.status_codes.server_error'));
    }

    /**
     * Set the form validation error response
     *
     * @param $errors
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function formValidationErrorAlert($errors, array $data = []): JsonResponse
    {
        $response = [
            'statusCode' => config('patricia.status_codes.validation_failed'),
            'message' => 'Whoops. Validation failed.',
            'validationErrors' => $errors,
        ];

        if (! empty($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, config('patricia.status_codes.validation_failed'));
    }

    /**
     * Set bad request error response
     *
     * @param $message
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function badRequestAlert($message, array $data = []): JsonResponse
    {
        $response = [
            'statusCode' => config('patricia.status_codes.bad_request'),
            'message' => $message,
        ];

        if (! empty($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, config('patricia.status_codes.bad_request'));
    }

    /**
     * Set the success response alert
     *
     * @param $message
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function successResponse($message, array $data = []): JsonResponse
    {
        $response = [
            'statusCode' => config('patricia.status_codes.success'),
            'message' => $message,
        ];

        if (! empty($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, config('patricia.status_codes.success'));
    }

    /**
     * Set "not found" error response
     *
     * @param $message
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function notFoundAlert($message, array $data = []): JsonResponse
    {
        $response = [
            'statusCode' => config('patricia.status_codes.not_found'),
            'message' => $message,
        ];

        if (! empty($data)) {
            $response['data'] = $data;
        }

        return Response::json($response, config('patricia.status_codes.not_found'));
    }
}
