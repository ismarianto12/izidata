<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class galery extends Model
{
    public $table = 'galery';
    public $timestamps = false;
    public $guarded = [];
    use HasFactory;
}
