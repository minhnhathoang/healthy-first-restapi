<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory;

    protected $fillable = [
        'province_id',
        'district_id',
        'code',
        'name',
        'level'
    ];

    public $timestamps = false;
}
