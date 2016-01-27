<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\GiftCard;
use App\Brands;
use App\Http\Controllers\Controller;
use JulioBitencourt\Cart\Cart;

class ListingController extends Controller
{

	protected $cart;

	public function __construct(Cart $cart)
	{
		$this->cart = $cart;
	}

	public function getAllListings(Request $request)
	{
		$brand_cards = GiftCard::where([
			['status', 'available']
		])->get();
		return $this->displayCards($brand_cards);
	}

	public function getListing(Request $request, $brand_slug)
	{
		$brand = $this->getBrand($brand_slug);
		$brand_cards = GiftCard::where([
				['brand_id', $brand->id],
				['status' , 'available'],
			])->get();

		return $this->displayCards($brand_cards, $brand);
	}

	private function displayCards($brand_cards, $brand = null)
	{
		$gift_cards = [];
		foreach($brand_cards as $card)
		{
			$gift_cards[] = [
				'sku' => $card->id,
				'expiry_date' => $card->expiry_date,
				'balance' => $card->balance,
				'offer_price' => $card->offer_price,
				'image' => $card->brand->img_large
			];
		}

		return view('listing.all', [
			'cart_items' => $this->cart->totalItems(),
			'gift_cards' => $gift_cards,
			'brand' => $brand ? $brand->brand : ''
		]);
		
	}

	private function getBrand($brand_slug)
	{
		return Brands::where('slug', $brand_slug)->get()->first();	
	}
    //
}
