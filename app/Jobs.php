<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jobs extends Model
{
	protected $appends = ['created_tz','job_type_lable'];
	
    public function getJobTypeLableAttribute()
    {
        return str_replace("-"," ",ucfirst($this->job_type));
    }
	public function getCreatedTzAttribute()
    {
        if($this->created_at != ""){
            return \Carbon\Carbon::parse($this->created_at)->diffForHumans();
        }
		return $this->created_at;
    }
}
