<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MonitoringProjectDetailDate extends Model
{
    use HasFactory, Uuid, SoftDeletes;
    protected $table = 'monitoring_project_detail_dates';
    protected $primaryKey = 'id';
    protected $fillable = [
        'monitoring_project_detail_id', 'user_id', 'revise_date', 'revise_comment'
    ];

    public function monitoring_project_detail()
    {
        return $this->belongsTo('App\Models\MonitoringProjectDetail', 'monitoring_project_detail_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
