<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Dictate extends EloquentModel
{
	protected $guarded = [];
public function wordlist($userid,$number){
	$date=date("Ymd");
		return $this->select('word')->where('userid','=',$userid)->orderbyraw('score+'.$date.'-last_dictate_date DESC')->limit($number)->get();
	}
public function deleteword($userid,$word)
{
	return $this->where('word', '=', $word)->where('userid','=',$userid)->delete();
}


}