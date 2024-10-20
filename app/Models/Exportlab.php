<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exportlab extends Model
{
    use HasFactory;

    protected $table = 'exportlab';
    protected $fillable = [
        'name',
        'department',
        'date',
        'analysis',
    ];
}
