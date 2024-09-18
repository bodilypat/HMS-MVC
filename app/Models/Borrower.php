<?php

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    use HasFactory;

    protected $fileable = [
        'name',
        'email',
    ];

    /* Define the relationship with the Borrow model */
    public function borrows()
    {
        $this->hasMany(Book::Class);
    }
}



