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
    ];

    public function certifications() {
        return $this->hasMany(Certification::class);
    }
}
