<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'role',
        'email',
        'password',
        'first_name',
        'surname',
        'last_name',
        'address',
        'gender',
        'job',
        'birthday',
        'mobile',
        'full_name'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attribute) => $attribute['first_name'] . ' ' . $attribute['surname'] . ' ' . $attribute['last_name'],
        );
    }

    protected function gender(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attribute) => $attribute['gender'] === 1 ? 'Female' : 'Male'
        );
    }

    protected function avatarLink(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attribute) => $attribute['avatar'] ? env('app_url'). ":8000/storage/".$attribute['avatar'] : null
        );
    }
}
