<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'luckydraw_id','kista_id','agent_id','name','address','phone','created_by','updated_by','is_active','date_np','date','time','lottery_no','serial_no','slug'
    ];

    public  function getAgent(){
        return $this->belongsTo(Agent::class,'agent_id');
    }

    public function getClientDetail(){
        return $this->hasMany(Detail::class,'client_id');
    }

    public function getCount()
    {
        return $this->belongsTo('App\Detail','id','client_id')->where('lottery_status','1')->groupBy('client_id')->selectRaw('client_id,Count(lottery_status) as total');
    }
 
  
}
