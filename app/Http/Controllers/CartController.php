<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

	public function add()
	{
		$item = [
			'sku' => '123456',
			'description' => 'PlayStation 4',
			'price' => 300,
			'quantity' => 1
		];
		$result = $this->cart->insert($item);
		echo $this->cart->totalItems();
		
	}

	public function delete()
	{
	}

	public function discard()
	{

	}
}
