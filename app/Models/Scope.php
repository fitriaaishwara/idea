<?php

namespace App\Models;

use App\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scope extends Model
{
    use HasFactory, Uuid, SoftDeletes;
    protected $table = 'scopes';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'description', 'status'
    ];
}
