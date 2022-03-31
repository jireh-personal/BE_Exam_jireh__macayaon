<?php

namespace App\Http\Traits;

trait TraitResponse{

    public function preparedResponseSuccess($data,$msg)
    {
        return [
            'result'  => $data,
            'message' => $msg,
            'status'  => 'success'
        ];
    }
    public function preparedResponseFail($data,$msg)
    {
        return [
            'result'  => $data,
            'message' => $msg,
            'status'  => 'fail'
        ];
    }
}
