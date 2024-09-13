<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auther extends Model
{
    use HasFactory;

    protected $file = ['name'];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}