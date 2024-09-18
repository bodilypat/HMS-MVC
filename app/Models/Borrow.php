<?php

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model 
{
    use HasFactory;

    /* The attributes the are mass assignable */
    protected $fileable = [
        'book-id',
        'borrowed_id',
        'borrowed_at',
        'returned_at',
    ];

    /* Define the relationship with the Book model */
    public function books()
    {
        return $this->belongsTo(Book::class);
    }

    /* Define the relationshio with the Borrower model */
    public function borrower()
    {
        $return $this->belongsTo(Borrower::class);
    }
}