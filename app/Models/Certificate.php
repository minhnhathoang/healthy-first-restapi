<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'establishment_id',
        'registration_number',
        'date_issued',
        'due_date',
        'is_revoked'
    ];

    public function establishment() {
        return $this->belongsTo(Establishment::class);
    }
}
