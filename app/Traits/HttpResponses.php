<?php

namespace app\Traits;



trait HttpResponses{

    protected function succes ($data, $message=null, $code=200 ){

        return response()->json([
            'status'=> 'Request was succesful.',
            'message'=>$message,
            'data'=>$data
        ], $code);
    }

}