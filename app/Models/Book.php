<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factory\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class book extends Model 
{
    use HasFactory;
    protected $quarded = [];

    public function auther():Belongsto
    {
        return $this->belongsTo(auther::class,'auther_id','id');
    }

    public function category():BelongTo
    {
        return $this->belongsTo(category::class);
    }
    
    public function publisher():BelongsTo
    {
        return $this->belongsTo(publisher::class);
    }
}

