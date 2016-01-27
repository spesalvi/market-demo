<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendPurchaseEmail;
use App\User;
use App\GiftCard;
use App\Order;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JulioBitencourt\Cart\Cart;
use Razorpay\Api\Api;

class PurchaseController extends Controller
{
	const KEY_RAZORPAY = 'MfAD1JyfcaSQRwoHeLvLEAVk';
	protected $cart;
	protected $user;

	public function __construct(Cart $cart, User $user)
	{
		$this->user = Auth::user();
		$this->cart  = $cart;
	}

	public function done(Request $request)
	{
		$response = $this->capturePayment($request->input('razorpay_payment_id'));
		if($response->status == 'captured') {
			$this->markItemsAsPurchased();
			$this->insertIntoOrders();
			$this->mailCardDetails();
			$this->cart->destroy();
			return redirect()->action('UserController@getMyCards');
		}
		echo 'Transaction failed. Please try again.';
	}

	private function markItemsAsPurchased()
	{
		foreach($this->cart->all() as $item)
		{
			GiftCard::where([
				['id',  $item['sku']],
				['status', 'incart'],
			])->update(['status' => 'purchased']);
		}
	}

	private function insertIntoOrders()
	{
		
		foreach($this->cart->all() as $item)
		{
			$card = GiftCard::where([
				['id', $item['sku']]

			])->get()->first();
			$order = new Order();
			$order->card_id = $item['sku'];
			$order->stored_value = $card->offer_price;
			$order->user_id = $this->user ? $this->user->id : 0;
			$order->brand_id = $card->brand->id;
			$order->purchase_value = $item['price'];

			$order->save();
		}
	}
	
	private function mailCardDetails()
	{
		foreach($this->cart->all() as $item)
		{
			$card_id = $item['sku'];	
			$this->dispatch(new SendPurchaseEmail($this->user->id, $card_id));	
			//$this->dispatch(new SendSaleAlertMail($card_id));
		}
	}

	private function capturePayment($id)
	{
		$api = new Api('rzp_test_C4L2rxsV1t84Ks', self::KEY_RAZORPAY);

		try {
			$payment = $api->payment->fetch($id);
			$data = $payment->capture(array(
					'amount' => $this->cart->total() * 100
				)
			);
		
			return $data;
		} catch(\Exception $e) {
			echo $e->getMessage();
		}
	}
	
}
