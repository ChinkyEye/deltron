<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
     protected $fillable = [
        'kista_id','luckydraw_id','title','amount','created_by','updated_by','is_active','date_np','date','time'
    ];
}
