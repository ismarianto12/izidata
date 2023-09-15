<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{

    public    $incrementing = false;
    protected $table        = 'tag';
    public $guarded  = [];
    public static $tahun;

    use HasFactory;

}
