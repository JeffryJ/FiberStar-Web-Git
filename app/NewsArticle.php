<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsArticle extends Model
{
    protected $fillable = [
        'news_title','article','image_link'
    ];

    protected $dates =[
        'created_at','updated_at'
    ];

    public function scopeEssentials($query){
        $extra = ['id','news_title AS title','image_link AS image','article AS newsdesc'];
//        return $query->select(array_merge($extra,$this->getFillable()));
        return $query->select($extra);
    }

    public function scopeLandingpage($query){
        $extra = ['id','image_link AS image','created_at AS date','news_title AS title','article AS newsdesc'];
//        return $query->select(array_merge($extra,$this->getFillable()));
        return $query->select($extra);
    }
}
