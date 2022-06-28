<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commune extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'id',
        'district_id',
        'name',
        'level'
    ];
}
