<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExtendController extends Controller
{
    /**
     * @param array $errors
     * @param string $message
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendValidationError($errors = [], $message = "The given data was invalid.", $code = 404)
    {
        $response = [
            'status' => false,
            'message' => $message,
            'errors' => $errors,
        ];

        return response()->json($response, $code);
    }

    /**
     * @param string $message
     * @param array $errors
     * @param int $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendError($message = '', $errors = [], $code = 404)
    {
        $response = [
            'status' => false,
            'message' => $message,
        ];

        if (!empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $code);
    }

    /**
     * @param string $message
     * @param array $result
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse($message = '', $result = [])
    {
        $response = [
            'status' => true,
            'message' => $message
        ];

        if (!empty($result)) {
            $response['data'] = $result;
        }

        return response()->json($response, 200);
    }
}
