<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class JobVacancy extends Model
{
    protected $fillable = [
        'job_title','start_date','end_date','location','renumeration','qualifications','responsibilities','image_link'
    ];

    protected $dates = [
        'start_date','end_date'
    ];

    public function scopeBrief($query){
        $extra = ['id','image_link AS image','job_title AS jobdesc'];
//        return $query->select(array_merge($extra,$this->getFillable()));
        return $query->select($extra);
    }

    public function scopeEssentials($query){
        $extra = ['image_link AS image','job_title AS position',DB::raw('concat(date_format(start_date,\'%D %M %Y\')," - ",date_format(end_date,\'%D %M %Y\')) AS period'),'location','renumeration','qualifications as qualification','responsibilities as responsibles'];
//        return $query->select(array_merge($extra,$this->getFillable()));
        return $query->select($extra);
    }
}
