<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Word extends EloquentModel
{
public function word(){
		return $this->select(DB::raw('date,count(*) as count'))->groupBy('date')->get();
	}
}
