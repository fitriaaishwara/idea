<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileExtension extends Model
{
    use HasFactory, Uuid;
    protected $table = 'file_extensions';
    protected $primaryKey = 'id';
    protected $fillable = [
        'extension', 'description'
    ];
    public function documentType()
    {
        return $this->hasOne('App\Models\DocumentType', 'file_extension_id', 'id');
    }
}
