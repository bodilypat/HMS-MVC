<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class category extends Model
{
    use HasFactory;
    protected $fileable = [
        'name',
        'description',
    ];

    /* Define the relationship with the Book model */
    public function books()
    {
        return $this->hasMany(Boo::Class);
    }
}
