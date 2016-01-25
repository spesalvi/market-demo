<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GiftCard extends Model
{

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function brand()
	{
		return $this->belongsTo('App\Brands');
	}
    //
}
