<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Jadwal extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $table        = 'jadwal';
    public $guarded  = [];
    public static $tahun;
    use HasFactory;

}

