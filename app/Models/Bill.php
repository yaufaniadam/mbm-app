<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'sppg_id',
        'type',
        'billed_to',
        'invoice_number',
        'period_start',
        'period_end',
        'amount',
        'status',
    ];
}
