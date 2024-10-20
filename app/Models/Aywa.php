<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aywa extends Model
{
    use HasFactory;
    protected $table = 'aywa';
    protected $fillable = [
        'name',
        'department',
        'date',
        'phone',
    ];
}
