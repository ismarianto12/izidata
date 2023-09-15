<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Download extends Model
{

    use HasFactory;
    public $timestamps      = false;
    public $incrementing    = false;
    protected $table        = 'download';
    public $guarded         = [];
    public static $tahun;

}
