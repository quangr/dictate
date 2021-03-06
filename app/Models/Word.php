<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Word extends EloquentModel
{
	protected $guarded = [];
public function word($userid){
		return $this->select(DB::raw('date,count(*) as count'))->where('userid','=',$userid)->groupBy('date')->get();
	}

public function datalist($date,$userid){
		return $this->select('id','word')->where('date','=',$date)->where('userid','=',$userid)->get();
	}
public function checkdelete($userid,$id)
{
	return $this->select('userid')->where('id','=',$id)->get()->first()->userid==$userid;
}
public function deleteword($id)
{
	return $this->where('id', '=', $id)->delete();
}
}
