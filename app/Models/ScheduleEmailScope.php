<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleEmailScope extends Model
{
    use HasFactory, Uuid;
    protected $table = 'schedule_email_scopes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'schedule_email_id', 'scope_id'
    ];

    public function schedule_email()
    {
        return $this->belongsTo('App\Models\ScheduleEmail', 'schedule_email_id', 'id');
    }
    public function scope()
    {
        return $this->belongsTo('App\Models\Scope', 'scope_id', 'id');
    }
}
