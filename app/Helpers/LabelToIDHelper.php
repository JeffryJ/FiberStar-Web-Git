<?php

    function IDofRole($string){
        $data = \App\UserRole::whereRaw('LOWER(`role_name`) LIKE \'%'.strtolower($string).'%\'')->first();
        if($data!=null) return $data->id;
        else return 0;
    }

    function IDofPassThroughType($string){
        $data = \App\CoveragePassThroughType::whereRaw('LOWER(`pass_through_type`) LIKE \'%'.strtolower($string).'%\'')->first();
        if($data!=null) return $data->id;
        else return 0;
    }