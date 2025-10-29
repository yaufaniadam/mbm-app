<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionSchedule extends Model
{
    protected $table = 'jadwal_produksi';

    protected $fillable = [
        'sppg_id',
        'tanggal',
        'menu_hari_ini',
        'jumlah',
        'status'
    ];
}
