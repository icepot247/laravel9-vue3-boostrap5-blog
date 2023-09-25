<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;


class BaseController extends Controller
{
    public function sendSuccess( $msg, $data=[])
    {
        $response = [
            'status' => true,
            'code' => 1,
            'message' => $msg,
        ];
        if(!empty($data)){
            $response['data'] = $data;
        }
        return response()->json($response, 200);
    }

    public function sendError( $errCode = 99, $msg='', $data = [], $resCode=401  )
    {
        $response = [
            'status' => false,
            'code' => $errCode,
            'message' => $msg,
        ];
        if(!empty($data)){
            $response['data'] = $data;
        }
        return response()->json($response, $resCode);
    }
}
