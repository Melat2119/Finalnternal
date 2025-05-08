<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class FAQ extends Model
{
    //
    use HasFactory;
    protected $fillable =[
        'question',
        'answer',
        'product_id',
        'service_id',
    ];
    public function product(){
        return $this->belongsTo(Products::class);
    }
    public function service(){
        return $this->belongsTo(Service::class);
    }
}
