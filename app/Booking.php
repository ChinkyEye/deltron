<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
     protected $fillable = [
        'agent_id','booked_serialno','created_by','updated_by','is_active','date_np','date','time','slug'
    ];

    protected $casts = [
        'booked_serialno' => 'array',
    ];

    public  function getAgent(){
        return $this->belongsTo(Agent::class,'agent_id')->select('id','name');
    }
}
