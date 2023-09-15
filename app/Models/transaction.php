<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transaction extends Model
{

    public $timestamps = false;

    public $incrementing = false;
    protected $table        = 'transaction';
    public $guarded  = [];
     use HasFactory;
}
