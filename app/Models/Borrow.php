<?php

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model 
{
    use HasFactory;

    /* The attributes that are mass assignable */
    protected $fileable = [
        'book_id',
        'borrower_id',
        'borrowed_at',
        'returned_at',
    ];

    /* Define the relationship with the Book model */
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    /* Define the relationship with the user model */
    public function borrower()
    {
        return $this->belongsTo(user::class);
    }
}