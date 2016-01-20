<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
#use App\GiftCard;
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
		$gift_cards = [
			[
				'sku' => '123',
				'expiry_date' => '2016-05-25',
				'balance' => '200',
				'offer_price' => '190',
			],
			[
				'sku' => '124',
				'expiry_date' => '2016-02-28',
				'balance' => '2000',
				'offer_price' => '1800'
			],
			[
				'sku' => '125',
				'expiry_date' => '2016-12-21',
				'balance' => '20000',
				'offer_price' => '18000'
			],
		];
		return view('listing.all', [
			'cart_items' => $this->cart->totalItems(),
			'gift_cards' => $gift_cards,
			'brand' => $brand
		]);
	}
    //
}
