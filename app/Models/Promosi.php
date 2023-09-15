<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promosi extends Model
{

    public $timestamps = false;

    public $incrementing = false;
    protected $table        = 'promo';
    public $guarded  = [];
    public static $tahun;
    use HasFactory;

}
