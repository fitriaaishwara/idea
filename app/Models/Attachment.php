<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attachment extends Model
{
    use HasFactory, Uuid;
    protected $table = 'attachments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'path', 'name', 'extension'
    ];

    public function document()
    {
        return $this->hasOne('App\Models\Document', 'attachment_id', 'id');
    }
}
