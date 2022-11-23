<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class finiquito extends Model
{
    use HasFactory;

    protected $fillable = [
        'empleado_id',
        'monto',
        'fecha_finiquito',
        'pagado'
    ];
}
