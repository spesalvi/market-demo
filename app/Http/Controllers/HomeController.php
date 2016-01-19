<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use JulioBitencourt\Cart\Cart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
	
    protected $cart;

    public function __construct(Cart $cart)
    {
    	$this->cart = $cart;
    //    $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
	$categories = [
		[
			'image' => '',
			'brand' => 'LifeStyle',
			'tagline' => '',
			'url' => 'lifestyle'
		],
		[
			'image' => '',
			'brand' => 'Jabong',
			'tagline' => '',
			'url' => 'jabong'
		],
		[
			'image' => '',
			'brand' => 'Shopper Stop',
			'tagline' => '',
			'url' => 'shopper-stop'
		],
		[
			'image' => '',
			'brand' => 'Fastrack',
			'tagline' => '',
			'url' => 'fastrack'
		],
		[
			'image' => '',
			'brand' => 'MyLifeCare',
			'tagline' => '',
			'url' => 'mylifecare'
		],
		[
			'image' => '',
			'brand' => 'Cafe Coffee Day',
			'tagline' => '',
			'url' => 'cafe-coffee-day'
		],
		[
			'image' => '',
			'brand' => 'Amazon',
			'tagline' => '',
			'url' => 'amazon'
		],
		[
			'image' => '',
			'brand' => 'Woohoo Gift Card',
			'tagline' => '',
			'url' => 'woohoo-gift-card'
		]
	];
        return view('home', [
		'cart_items' => $this->cart->totalItems(),
		'categories' => $categories 
	]);
    }
}
