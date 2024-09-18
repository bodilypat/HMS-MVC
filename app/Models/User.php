<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticationable;
use Illuminate\Notifications\Notifiable;
use Laravel\Scanctum\HasApiTokens;

class User extends Authenticatable 
{
    use HasApiTokens, HasFactory, Notifiable;

    /* The attributes that are mass assignable. */
    protected $fillable = [
        'name',
        'password',
    ];

    /* The attributes that should be hidden for seralization */
    protected $hidden = [
        'password',
    ];
}