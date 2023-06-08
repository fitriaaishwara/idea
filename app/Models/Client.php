<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, Uuid, SoftDeletes;
    protected $table = 'clients';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id', 'regency_id', 'type', 'name', 'address', 'scope_1', 'scope_2', 'scope_3', 'service', 'standard', 'pic', 'pic_position', 'mobile_phone', 'email', 'is_win', 'status', 'last_followup_at', 'created_by', 'updated_by'
    ];

    public function regency()
    {
        return $this->belongsTo('App\Models\Regency', 'regency_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
    public function scope_1()
    {
        return $this->belongsTo('App\Models\Scope', 'scope_1', 'id');
    }
    public function scope_2()
    {
        return $this->belongsTo('App\Models\Scope', 'scope_2', 'id');
    }
    public function scope_3()
    {
        return $this->belongsTo('App\Models\Scope', 'scope_3', 'id');
    }
    public function follow_up_clients()
    {
        return $this->hasMany('App\Models\FollowUp', 'client_id', 'id');
    }
    public function last_follow_up_client()
    {
        return $this->hasOne('App\Models\FollowUp', 'client_id', 'id')->latest();
    }
    public function client_win()
    {
        return $this->hasOne('App\Models\ClientWin', 'client_id', 'id')->latest();
    }
    public function scope1()
    {
        return $this->belongsTo('App\Models\Scope', 'scope_1', 'id');
    }
    public function scope2()
    {
        return $this->belongsTo('App\Models\Scope', 'scope_2', 'id');
    }
    public function scope3()
    {
        return $this->belongsTo('App\Models\Scope', 'scope_3', 'id');
    }

}
