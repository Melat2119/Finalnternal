<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    //
    public function documents()
    {
        return $this->belongsToMany(Document::class,'document_services');
    }
    public function Faq(){
        return $this->hasMany(Faq::class);
    }
    public function Feedback(){
        return $this->hasMany(Feedback::class);
    }
}
