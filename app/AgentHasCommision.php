<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgentHasCommision extends Model
{
    protected $fillable = [
        'agent_id','kista_id','commission','created_by','updated_by','is_active','date_np','date','time','is_head','commission_type'
    ];
}
