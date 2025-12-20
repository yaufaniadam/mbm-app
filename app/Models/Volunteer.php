<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    protected $table = 'relawan';


    protected $fillable = [
        'sppg_id',
        'nama_relawan',
        'gender',
        'posisi',
        'kontak',
        'address',
    ];

    public function sppg()
    {
        return $this->belongsTo(Sppg::class);
    }
}
