<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kista extends Model
{
    protected $fillable = [
        'luckydraw_id','name','amount','created_by','updated_by','is_active','date_np','date','time'
    ];

    public  function getLuckyDraw(){
        return $this->belongsTo(LuckyDraw::class,'luckydraw_id');
    }
    public  function getCommision(){
        return $this->hasMany(AgentHasCommision::class,'kista_id','id');
    }
    public function getExpense(){
        return $this->belongsTo(Expense::class,'id','kista_id')->groupBy('kista_id')->selectRaw('kista_id,SUM(amount) as total');;
    }
    public  function getAmount(){
        return $this->belongsTo(Detail::class,'id','kista_id')->groupBy('kista_id')->selectRaw('kista_id,SUM(amount) as totals');
    }
    public function getKistaName()
    {
        return $this->hasOne(Kista::class,'id','id');
    }
    public  function getUserName(){
        return $this->belongsTo(User::class,'created_by');
    }
}
