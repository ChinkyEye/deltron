<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = [
        'luckydraw_id','kista_id','name','address','phone','commission','created_by','updated_by','is_active','date_np','date','time','is_head'
    ];

    public  function getKista(){
        return $this->belongsTo(Kista::class,'kista_id')->select('id','name');
    }

    public  function getBooking(){
        return $this->hasMany(Booking::class,'agent_id')->select('id','agent_id','booked_serialno','is_active','date_np')->where('is_active','1');
    }
    public  function getBookingLatest(){
        return $this->hasOne(Booking::class,'agent_id')->select('id','agent_id','booked_serialno','is_active','date_np')->where('is_active','1');
    }

    public function countMember()
    {
        return $this->belongsTo(Client::class,'id','agent_id')->where('is_active','1')->groupBy('agent_id')->selectRaw('agent_id,Count(agent_id) as total');
    }
}
