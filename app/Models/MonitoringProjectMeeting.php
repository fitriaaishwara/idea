<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonitoringProjectMeeting extends Model
{
    use HasFactory, Uuid, SoftDeletes;
    protected $table = 'monitoring_project_meetings';
    protected $primaryKey = 'id';
    protected $fillable = [
        'monitoring_project_id', 'agenda', 'date', 'start_time', 'end_time', 'location', 'mom', 'note', 'status', 'created_by', 'updated_by'
    ];

    public function monitoring_project()
    {
        return $this->belongsTo('App\Models\MonitoringProject', 'monitoring_project_id', 'id');
    }

    public function monitoring_project_meeting_participants()
    {
        return $this->hasMany('App\Models\MonitoringProjectMeetingParticipant', 'monitoring_project_meeting_id', 'id');
    }
}
