<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;
    protected $table = 'folders';
    protected $primaryKey = 'id';
    protected $fillable = [
        'parent_id', 'name', 'description', 'status', 'created_by', 'updated_by', 'deleted_by', 'deleted_at'
    ];

    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }
    public function deletedBy()
    {
        return $this->belongsTo('App\Models\User', 'deleted_by', 'id');
    }
    public function documents()
    {
        return $this->hasMany('App\Models\Document', 'folder_id', 'id');
    }
    public function child()
    {
        return $this->hasMany('App\Models\Folder', 'parent_id', 'id');
    }
}
