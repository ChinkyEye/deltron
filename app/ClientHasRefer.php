<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientHasRefer extends Model
{
    protected $fillable = [
        'client_id','referperson_name','created_by','updated_by','is_active','date_np','date','time'
    ];
}
