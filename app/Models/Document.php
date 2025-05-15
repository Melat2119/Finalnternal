<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'title',
        'department',
        'type',
        'file_path',
        'uploaded_by',
        'status',
        'approved_by',
        'approval_comment',
        'uidesigner_id',
    ];

    public function developers()
    {
        return $this->belongsToMany(Developer::class, 'developer_document');
    }

    public function socialmediamanagers()
    {
        return $this->belongsToMany(\App\Models\Socialmediamanager::class, 'document_socialmediamanager', 'document_id', 'socialmediamanager_id');
    }

    public function receptions()
    {
        return $this->belongsToMany(\App\Models\Reception::class, 'document_reception', 'document_id', 'reception_id');
    }
}

