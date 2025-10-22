<?php


namespace App\Helpers;
class ApiResponse{
    

    static function sendResponse($code = 200, $msg = null, $data = [] , $meta = []){
        $response = [
            'status' => $code,
            'message' => $msg,
            'data' => $data
        ];
        if($meta){
            $response['meta'] = $meta;
        }
        return response()->json($response, $code);
    }
}