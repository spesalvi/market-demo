<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Session\SessionServiceProvider;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\GiftCard;
use App\Order;
use JulioBitencourt\Cart\Cart;

class UserController extends Controller
{
	private $user; 
	protected $cart;

	public function __construct(Cart $cart)
	{
		$this->cart = $cart;
		$this->user = Auth::user();	
	}

	public function getMyCards()
	{
		$cards = GiftCard::where('user_id', $this->user->id)
			->orderBy('created_at', 'DESC')
			->get();
		
		$cart_items = $this->cart->totalItems();
		return view('user.cards')
			->with(compact('cards', 'cart_items'));
	}

	public function purchasedCards(Request $request)
	{
		$new_purchase = $request->session()->get('card_purchased', false);
		$cards = Order::where('user_id', $this->user->id)->get();

		$cart_items = $this->cart->totalItems();

		return view('user.purchased_cards')
			->with(compact('cards', 'cart_items', 'new_purchase'));
	}

}
