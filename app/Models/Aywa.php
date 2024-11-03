<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aywa extends Model
{
    protected $table = 'aywa';
    protected $fillable = ['name', 'department', 'date', 'phone'];
}
