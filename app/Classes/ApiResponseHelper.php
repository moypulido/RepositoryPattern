<?php

namespace App\Classes;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApiResponseHelper
{
    public static function rollBack(\Exception $e, $message = 'Failure in the process')
    {
        DB::rollBack();
        self::throw($e, $message);
    }


    public static function throw(\Exception $e, $message = 'Failure in the process')
    {
        Log::info($e);
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => $message,
            'error' => $e->getMessage(),
        ], 500));
    }


    public static function sendResponse($result, $message = '', $code = 200)
    {
        if ($code == 204) {
            return response()->noContent();
        }

        $response = [
            'success' => true,
            'data' => $result
        ];

        if (!empty($message)) {
            $response['message'] = $message;
        }

        return response()->json($response, $code);
    }
}
