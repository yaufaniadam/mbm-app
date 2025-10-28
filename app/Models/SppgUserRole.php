<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SppgUserRole extends Model
{
    protected $fillable = [
        'sppg_id',
        'user_id',
        'role_id',
    ];
}
