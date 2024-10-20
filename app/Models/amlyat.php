<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class amlyat extends Model
{
    use HasFactory;
    protected $table = 'amlyat';
    protected $fillable = [
        'date',
        'count',

    ];
}
