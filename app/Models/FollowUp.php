<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FollowUp extends Model
{
    use HasFactory, SoftDeletes, Uuid;
    protected $table = 'follow_ups';
    protected $primaryKey = 'id';
    protected $fillable = [
        'client_id', 'attachment_id', 'date', 'type', 'amount', 'note', 'status', 'created_by', 'updated_by'
    ];

    public function client()
    {
        return $this->belongsTo('App\Models\Client', 'client_id', 'id');
    }
    public function attachment()
    {
        return $this->belongsTo('App\Models\Attachment', 'attachment_id', 'id');
    }
    public function createdBy()
    {
        return $this->belongsTo('App\Models\User', 'created_by', 'id');
    }
}
