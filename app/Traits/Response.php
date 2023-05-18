<?php

namespace App\Traits;

trait Response {

    function sendResponse($result = null,$message = " " , $code = 200)
    {

        $response = [
            'data' => $result,
            'message' => $message,
            'code' => $code,
        ];
        return response()->json($response, $code);
    }

    public function sendMessage($message = " ",$code = 200)
    {
        $response = [
            'data' => null,
            'message' => $message,
            'code' => $code,
        ];
        return response()->json($response, $code);
    }
}
