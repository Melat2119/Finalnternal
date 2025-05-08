<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocumentsVersion extends Model
{
    //
    use HasFactory;
    protected $fillable = [
        'version_number',
        'changes',
    ];


}
