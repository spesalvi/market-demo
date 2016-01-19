<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
#use App\GiftCard;
use App\Http\Controllers\Controller;

class ListingController extends Controller
{

	public function getListing(Request $request)
	{
		$gift_cards = [
			[
				'expiry_date' => '2016-05-25',
				'balance' => '200',
				'offer_price' => '190',
			],
			[
				'expiry_date' => '2016-02-28',
				'balance' => '2000',
				'offer_price' => '1800'
			],
			[
				'expiry_date' => '2016-12-21',
				'balance' => '20000',
				'offer_price' => '18000'
			],
		];
		return view('listing.all', [
			'gift_cards' => $gift_cards
		]);
	}
    //
}
