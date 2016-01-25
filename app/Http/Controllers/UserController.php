<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\GiftCard;

class UserController extends Controller
{
	private $user; 

	public function __construct()
	{
		$this->user = Auth::user();	
	}

	public function getMyCards()
	{
		$cards = GiftCard::where('user_id', $this->user->id)->get();
		
		return view('user.cards')
			->with(compact('cards'));
	}

}
