<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Amlyat extends Model
{
    use HasFactory;

    protected $table = 'amlyat';
    protected $fillable = [
        'amlya',
        'date',
    ];
}
