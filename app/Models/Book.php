<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factory\HasFactory;
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

    public function auther():Belongsto
    {
        return $this->belongsTo(Author::class,'auther_id','id');
    }

    public function category():BelongTo
    {
        return $this->belongsTo(Category::class);
    }
    
    public function publisher():BelongsTo
    {
        return $this->belongsTo(Borrow::class);
    }
}

