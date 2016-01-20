<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
		echo $this->cart->totalItems();		
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
			'sku' => '123456',
			'description' => 'PlayStation 4',
			'price' => 300,
			'quantity' => 1
		];
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

	public function discard()
	{

	}
}
