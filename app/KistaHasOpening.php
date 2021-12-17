<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KistaHasOpening extends Model
{
    protected $fillable = [
        'luckydraw_id','kista_id','amount','created_by','updated_by','is_active','date_np','date','time'
    ];
}
