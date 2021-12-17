<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentHasPaid extends Model
{
     protected $fillable = [
        'luckydraw_id','kista_id','agent_id','amount','description','created_by','updated_by','is_active','date_np','date','time'
      ];
}
