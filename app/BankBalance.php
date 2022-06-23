<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankBalance extends Model
{
      protected $fillable = [
        'luckydraw_id','kista_id','bank_name','account_no','address','phone','description','amount','created_by','updated_by','is_active','date_np','date','time'
      ];

      public  function getLuckyDraw(){
         return $this->belongsTo(LuckyDraw::class,'luckydraw_id')->select('id','name');
      }
      public  function getKista(){
         return $this->belongsTo(Kista::class,'kista_id')->select('id','name');
      }
      public  function getUserName(){
         return $this->belongsTo(User::class,'created_by');
      }

}
