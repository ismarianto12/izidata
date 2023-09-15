<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penghargaan extends Model
{
    use HasFactory;
    public $datetime = false;
    public $timestamps = false;
    public $incrementing = false;
    protected $table = 'penghargaan';
    public $guarded = [];
}
