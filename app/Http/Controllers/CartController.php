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
		return view('cart.details',[
			'total' => $this->cart->totalItems(),
			'cart' => $this->cart
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
		$item = [
			'sku' => $request->input('sku'),
			'description' => $request->input('description'),
			'price' => $request->input('price'),
			'quantity' => 1
		];

		GiftCard::where([
			['id', $request->input('sku')],
			['status' , 'available']
		])->update(['status' => 'incart']);


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

	public function delete()
	{
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
