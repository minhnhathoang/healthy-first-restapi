<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'date_of_receiving',
        'test_results'
    ];

    public function establishment()
    {
        return $this->belongsTo(Establishment::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }
}
