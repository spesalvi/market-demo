<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use JulioBitencourt\Cart\Cart;
use Razorpay\Api\Api;

class PurchaseController extends Controller
{
	const KEY_RAZORPAY = 'MfAD1JyfcaSQRwoHeLvLEAVk';
	protected $cart;

	public function __construct(Cart $cart)
	{
		$this->cart  = $cart;
	}

	public function done(Request $request)
	{
		$response = $this->capturePayment($request->input('razorpay_payment_id'));
		if($response->status == 'captured') {
			$this->cart->destroy();
			echo 'Transaction complete. Card details will be mailed to your email.';
		} else {
			echo 'Transaction failed. Please try again.';
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
