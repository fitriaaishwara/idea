<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory, Uuid;
    protected $table = 'document_types';
    protected $primaryKey = 'id';
    protected $fillable = [
        'file_extension_id', 'status'
    ];
    public function fileExtension()
    {
        return $this->belongsTo('App\Models\FileExtension', 'file_extension_id', 'id');
    }
}
