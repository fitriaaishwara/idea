<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonitoringProjectDetailPIC extends Model
{
    use HasFactory, Uuid, SoftDeletes;
    protected $table = 'monitoring_project_detail_pic';
    protected $primaryKey = 'id';
    protected $fillable = [
        'monitoring_projects_detail_id', 'user_id'
    ];

    public function monitoring_project_detail()
    {
        return $this->belongsTo('App\Models\MonitoringProjectDetail', 'monitoring_projects_detail_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
