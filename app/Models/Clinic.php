<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    use HasFactory;
    protected $table = 'clinic';
    protected $fillable = [
        'name',
        'date',
        'department',
        'pleace' ,
        'phone',
    ];
}
