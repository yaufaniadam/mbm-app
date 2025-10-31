<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $table = 'sekolah';

    protected $fillable = [
        'sppg_id',
        'nama_sekolah',
        'alamat',
        'province_code',
        'city_code',
        'district_code',
        'village_code',
    ];

    public function sppg()
    {
        return $this->belongsTo(Sppg::class);
    }
}
