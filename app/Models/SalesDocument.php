<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'client_name',
        'salesperson',
        'type',
        'status',
        'validity_period',
    ];
}
