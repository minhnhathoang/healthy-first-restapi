<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Establishment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'owner',
        'address',
        'telephone',
        'description',
        'kind_of_business'
    ];

    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }

    public function samples()
    {
        return $this->hasMany(Sample::class);
    }
}
