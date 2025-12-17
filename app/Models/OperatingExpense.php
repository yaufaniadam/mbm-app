<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperatingExpense extends Model
{
    protected $fillable = [
        'sppg_id',
        'name',
        'amount',
        'date',
        'category',
        'attachment',
    ];

    public function sppg()
    {
        return $this->belongsTo(Sppg::class);
    }
}
