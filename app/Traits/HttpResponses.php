<?php

namespace App\Traits;



trait HttpResponses{

    protected function succes ($data, $message=null, $code=200 ){

        return response()->json([
            'status'=> 'Request was succesful.',
            'message'=>$message,
            'data'=>$data
        ], $code);
    }

    protected function erroe ($data, $message=null, $code) {
        return response()->json([
            'status'=> 'Error has occured...',
            'message'=>$message,
            'data'=>$data
        ], $code);


    }

}