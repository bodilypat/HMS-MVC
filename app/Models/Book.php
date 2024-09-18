<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Book extends Model
{
    use HasFactory;

    protected $fileable = [
        'title',
        'auther_id',
        'category_id',
        'published_at',
    ];

    /* relationship model */
    public function auther():BelongsTo
    {
        return $this->belongsTo(Author::class,'auther_id','id');
    }

    public function category():BelongsTo
    {
        return $this->BelongsTo('Category::Class');
    }

    public function publisher():BelongsTo
    {
        return $this->BelongsTo('Borrow::Class')
    }

}