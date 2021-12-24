<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detail extends Model
{
    protected $fillable = [
        'client_id','luckydraw_id','kista_id','agent_id','lottery_status','amount','created_by','updated_by','is_active','date_np','date','time','remaining','is_remained','rpaid_date','rpaid_date_np','lottery_prize'
    ];

    public  function getClientInfo(){
        return $this->belongsTo(Client::class,'client_id')->select('id','name','address','phone','serial_no');
    }

    public  function getClient(){
        return $this->belongsTo(Client::class,'client_id')->select('id','name','address','phone')->groupBy('client_id');
    }

    public function getKistaInfo(){
        return $this->belongsTo(Kista::class,'kista_id')->select('id','name');
    }
    public function getAgentInfo(){
        return $this->belongsTo(Agent::class,'agent_id')->select('id','name');
    }

}
