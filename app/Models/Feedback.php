<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    //
    use HasFactory;
    protected $fillable=[
        'document_id',
        'message',
        'product_id',
        'service_id',
    ];
    //many to one ( feedback to  documents)
    public function document()
    {
        return $this->belongsTo(Document::class);
    }
    public function product(){
        return $this->belongsTo(Products::class);
    }
    public function service(){
        return $this->belongsTo(Service::class);
    }
}
