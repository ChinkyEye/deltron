<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LuckyDraw extends Model
{
    protected $fillable = [
        'name','created_by','updated_by','is_active','date_np','date','time',
    ];
}
