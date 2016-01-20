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
	$category_data = $this->getCategories();
	$categories = array();
	foreach($category_data as $data)
	{
		$categories[] = [
			'image' => $data->brand_logo->large,
			'brand' => $data->name,
			'tagline' => '',
			'url' => str_slug($data->name)
		];
	}
        return view('home', [
		'cart_items' => $this->cart->totalItems(),
		'categories' => $categories 
	]);
    }

    private function getCategories()
    {
    	$consumer_key = 'b64350b6b45c8fed49aa9983bf197844';
	$consumer_secret = '85b3ce2964a63c8fb07d868a58f13b69';
	$oauth_token = 'd5608ad8dbd007c0d5cd10688e7d428d';
	$oauth_secret = '9f11ac72c96ffd96a00ee58cf67b2d2a';

	$client = new \OAuth(
		$consumer_key, 
		$consumer_secret,
		 OAUTH_SIG_METHOD_HMACSHA1, 
		OAUTH_AUTH_TYPE_AUTHORIZATION
	);
	$client->enableDebug();
	$client->setToken($oauth_token, $oauth_secret);
	try {
		$client->fetch(
			'http://local.giftbig.com/rest/catalog', 
			'', 
			OAUTH_HTTP_METHOD_GET, 
			[
				'Content-Type' => 'application/json',
				'Accept' => '*/*'
			]
		);
		$result = $client->getLastResponse();
		$result = json_decode($result);
		return ($result->_embedded->products);
 	} catch(\Exception $e) {
		return [];
	}	
    }
}
