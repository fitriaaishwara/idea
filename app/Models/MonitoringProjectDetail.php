<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonitoringProjectDetail extends Model
{
    use HasFactory, Uuid, SoftDeletes;
    protected $table = 'monitoring_projects_details';
    protected $primaryKey = 'id';
    protected $fillable = [
        'monitoring_project_id', 'attachment_id', 'temporary_id', 'order', 'activity', 'description', 'percentage', 'plan_date', 'revise_date', 'revise_comment', 'actual_date', 'comment', 'is_done', 'created_by', 'updated_by'
    ];

    public function monitoring_project()
    {
        return $this->belongsTo('App\Models\MonitoringProject', 'monitoring_project_id', 'id');
    }
    public function attachment()
    {
        return $this->belongsTo('App\Models\Attachment', 'attachment_id', 'id');
    }
    public function monitoring_project_detail_pic()
    {
        return $this->hasMany('App\Models\MonitoringProjectDetailPIC', 'monitoring_projects_detail_id', 'id');
    }
    public function monitoring_project_detail_dates()
    {
        return $this->hasMany('App\Models\MonitoringProjectDetailDate', 'monitoring_projects_detail_id', 'id');
    }

}
