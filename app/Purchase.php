<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'supplier_name','item_name','amount','created_by','updated_by','is_active','date_np','date','time','quantity','rate','description',
    ];
}
