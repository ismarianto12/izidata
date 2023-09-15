<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class video extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $datetime = false;
    public $incrementing = false;
    protected $table = 'video';
    public $guarded = [];
}
