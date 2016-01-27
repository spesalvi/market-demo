<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\GiftCard;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use JulioBitencourt\Cart\Cart;

class CartController extends Controller
{
	protected $cart;
	
	public function __construct(Cart $cart)
	{
		$this->cart = $cart;
	}

	public function index()
	{
		if($this->cart->isEmpty())
		{
			return redirect()->action('ListingController@getAllListings');
		}
		$items = $this->cart->all();
		foreach($items as &$item)
		{
			$item['card'] = GiftCard::where([
				['id', $item['sku']]
			])->get()->first();	
		}
		return view('cart.details',[
			'total' => $this->cart->totalItems(),
			'cart_items' => $this->cart->totalItems(),
			'cart' => $this->cart,
			'items' => $items
		]);
	}

	public function add(Request $request)
	{
	 	if(!$request->ajax())
		{
			$status_code = 401;
			$content = 'Not allowed';
			return new Response($content, $status_code);
		}	
		$sku = $request->input('sku');

		$card = GiftCard::where([
			['id', $sku],
			['status' , 'available']
		])->get()
		   ->first();

		$item = [
			'sku' => $request->input('sku'),
			'description' => $request->input('description'),
			'price' => $card->offer_price,
			'quantity' => 1,
			'options' => $card->brand->img_large
		];

		$card->status = 'incart';
		$card->save();

		$result = $this->cart->insert($item);
		$response = array(
			'status' => 'success',
			'cart_size' => $this->cart->totalItems()
		);
		return new Response(
			json_encode($response),
			200
		);
		
	}

	public function delete(Request $request)
	{
		$sku = $request->input('sku');

		$card = GiftCard::where([
			['id', $sku],
			['status', 'incart']
		])->get()->first();

		$this->cart->delete($sku);

		$card->status = 'available';
		$card->save();

		return response()->json([
			'status' => 'success',
			'cart_size' => $this->cart->totalItems()
		]);
	}

	public function discard(Request $request)
	{
	 	if(!$request->ajax())
		{
			$status_code = 401;
			$content = 'Not allowed';
			return new Response($content, $status_code);
		}	
		$this->cart->destroy();
		$response = array(
			'status' => 'success',
			'cart_size' => $this->cart->totalItems()
		);
		return new Response(
			json_encode($response),
			200
		);
	}
}
