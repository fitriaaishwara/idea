<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentArchive extends Model
{
    use HasFactory;
    protected $table = 'document_archives';
    protected $primaryKey = 'id';
    protected $fillable = [
        'folder_id', 'attachment_id', 'name', 'no_document', 'date', 'revisi', 'description', 'extension', 'size', 'download', 'status', 'created_by', 'updated_by', 'deleted_by', 'deleted_at'
    ];

    public function folder()
    {
        return $this->belongsTo('App\Models\Folder', 'folder_id', 'id');
    }
    public function attachment()
    {
        return $this->belongsTo('App\Models\Attachment', 'attachment_id', 'id');
    }
}
