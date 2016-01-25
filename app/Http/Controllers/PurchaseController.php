<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Jobs\SendPurchaseEmail;
use App\User;

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
			$this->cart->destroy();
			$this->mailCardDetails('123', '3456');
			return redirect()->action('UserController@getMyCards');
		}
		echo 'Transaction failed. Please try again.';
	}
	
	private function mailCardDetails($cardnumber, $pin)
	{
		$this->dispatch(new SendPurchaseEmail($this->user->id, $cardnumber, $pin));	
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
