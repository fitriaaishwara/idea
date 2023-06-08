<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonitoringProject extends Model
{
    use HasFactory, Uuid, SoftDeletes;
    protected $table = 'monitoring_projects';
    protected $primaryKey = 'id';
    protected $fillable = [
        'monitoring_client_id', 'name', 'description', 'start_date', 'end_date', 'note', 'project_status', 'status', 'created_by', 'updated_by'
    ];

    public function monitoring_client()
    {
        return $this->belongsTo('App\Models\Client', 'monitoring_client_id', 'id');
    }
    public function monitoring_project_details()
    {
        return $this->hasMany('App\Models\MonitoringProjectDetail', 'monitoring_project_id', 'id')->oldest('created_at');
    }
    public function monitoring_project_meetings()
    {
        return $this->hasMany('App\Models\MonitoringProjectMeeting', 'monitoring_project_id', 'id');
    }
    public function next_monitoring_project_detail()
    {
        return $this->hasOne('App\Models\MonitoringProjectDetail', 'monitoring_project_id', 'id')->where('is_done', false)->oldest('order');
    }
    public function prev_monitoring_project_detail()
    {
        return $this->hasOne('App\Models\MonitoringProjectDetail', 'monitoring_project_id', 'id')->where('is_done', true)->latest('order');
    }

}
