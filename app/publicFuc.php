<?php


    function successRetun($returnData){
        $data['status']=200;
        $data['data']=$returnData;
        return response()->json($data);
    }