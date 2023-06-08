<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleEmail extends Model
{
    use HasFactory, Uuid;
    protected $table = 'schedule_emails';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'attachment_id', 'date', 'note', 'total_client', 'is_html', 'subject', 'body', 'schedule_status', 'status', 'created_by', 'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    public function attachment()
    {
        return $this->belongsTo('App\Models\Attachment', 'attachment_id', 'id');
    }
    public function schedule_email_scopes()
    {
        return $this->hasMany('App\Models\ScheduleEmailScope', 'schedule_email_id', 'id');
    }
}
