<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Products extends Model
{
    //
    use HasFactory;
    protected $fillable =[
        'name',
        'description',
    ];
    //many to many(product has many documents)
    public function documents(){
        return $this->belongsToMany(Document::class,'product_documents');
    }
    public function FAQ(){
        return $this->hasMany(Faq::class);
    }
    public function Feedback(){
        return $this->hasMany(Feedback::class);
    }
}
