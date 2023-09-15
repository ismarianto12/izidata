<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class balance extends Model
{

    public $timestamps = false;

    public $incrementing = false;
    protected $table = 'balance';
    public $guarded = [];
    use HasFactory;
}
