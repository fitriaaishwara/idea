<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonitoringProjectMeetingParticipant extends Model
{
    use HasFactory, Uuid, SoftDeletes;
    protected $table = 'monitoring_project_meeting_participants';
    protected $primaryKey = 'id';
    protected $fillable = [
        'monitoring_project_meeting_id', 'temporary_id', 'name', 'role', 'status', 'created_by', 'updated_by'
    ];

    public function monitoring_project_meeting()
    {
        return $this->belongsTo('App\Models\MonitoringProjectMeeting', 'monitoring_project_meeting_id', 'id');
    }
}
