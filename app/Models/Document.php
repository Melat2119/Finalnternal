<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Document extends Model
{
    use HasFactory;
    protected $fillable=['title','content','category_id','filePath'];
    //document belonging to a category
    public function category(){
        return $this->belongsTo(Category::class);
    }
    //document having many versions
    public function versions(){
        return $this->belongsToMany(Version::class,'document_versions');
    }
    //document has many feedback
    public function feedback(){
        return $this ->hasMany((Feedback::class));
    }
    //document belongs to different products(many to many)
    public function products()
    {
        return $this->belongsToMany(Products::class,'product_documents');
    }
    //document belongs to many services
    public function services(){
        return $this->belongsToMany(Service::class,'document_services');
    }


    
}

