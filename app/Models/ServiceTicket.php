<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceTicket extends Model
{
    protected $fillable = [
        'date_wo',
        'branch',
        'no_wo_client',
        'type_wo',
        'client',
        'is_active',
        'teknisi'
    ];
}
