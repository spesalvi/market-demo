<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\GiftCard;
use App\Http\Controllers\Controller;
use JulioBitencourt\Cart\Cart;

class ListingController extends Controller
{

	protected $cart;

	public function __construct(Cart $cart)
	{
		$this->cart = $cart;
	}

	public function getListing(Request $request, $brand)
	{
		$brand_cards = GiftCard::where('brand_id', 0)->get();
		
		$gift_cards = [];
		foreach($brand_cards as $card)
		{
			$gift_cards[] = [
				'sku' => $card->id,
				'expiry_date' => $card->expiry_date,
				'balance' => $card->balance,
				'offer_price' => $card->offer_price
			];
		}

		return view('listing.all', [
			'cart_items' => $this->cart->totalItems(),
			'gift_cards' => $gift_cards,
			'brand' => $brand
		]);
	}
    //
}
