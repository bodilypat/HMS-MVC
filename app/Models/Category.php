<?php

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Elquent\Model;

class category extends Model
{

    use HasFactory;

    protected $fileable = [
        'name' ,
        'description',
    ];

    /* Define the relationship  with the Book model */
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}