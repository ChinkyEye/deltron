<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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

    public function getPayment()
    {
        return $this->hasMany('App\Detail','client_id')->select('id','client_id','kista_id');
    }

    public function getReferPerson()
    {
        return $this->hasOne('App\ClientHasRefer','client_id','id');
    }
    // public function getPayment()
    // {
    //     return $this->hasOne('App\Detail','client_id');
    // }

    // public function getPayments($kistaid)
    // {
    //     return $this->getPayment()->where('kista_id',$kistaid);
    // }
    // public function getPayment()
    // {
    //     return $this->belongsTo('App\Detail','id','client_id')->with('getKistaInfo');
    // }
 
  
}
