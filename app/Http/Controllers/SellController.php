<?php namespace App\Http\Controllers;

use App\Http\Requests\SellFormRequest;
use App\Http\Requests\ValidateCardRequest;
use App\GiftCard;
use App\StoredValue;
use App\Brands;
use App\Jobs\ResetPinAfterListing;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Bus\DispatchesJobs;
use JulioBitencourt\Cart\Cart;

use Response;
use View;


class SellController extends Controller
{
	use DispatchesJobs;
	private $sv;
	protected $cart;


	
	public function __construct(Cart $cart)
	{
		$this->cart = $cart;
	}

	public function getAddCard()
	{
		return view('sell.add', [
			'cart_items' => $this->cart->totalItems()
		]) ;
	}

	public function postAddCard(SellFormRequest $request)
	{
		$card_number = str_replace(' ', '', $request->input('card-number'));
		$pin = $request->input('pin');
		$sell_price = $request->input('price');	
		$balance = $request->input('balance');
		$expiry = $request->input('date');
		$brand = $this->findBrandBySVName($request->input('brand_sv'));

		$card = $this->saveCard(
				$card_number,
				$pin,
				$balance,
				$sell_price,
				$expiry,
				$brand
		);
		
		//dispatch event change pin.
		$this->dispatch(new ResetPinAfterListing(
				$card->id, 
				$card_number, 
				Crypt::encrypt($pin)
			)
		);
		return redirect()->action('UserController@getMyCards');

	}

	public function postCheckBalance(ValidateCardRequest $request)
	{
		$card_number = str_replace(' ', '', $request->input('card-number'));
		$pin = $request->input('pin');
		$checkBalanceResponse = $this->sv->checkBalance($card_number, $pin);
		if($checkBalanceResponse->getErrorCode() != 0)
		{
			return response()
					->json([
				'status' => 'fail',
				'message' => 'unable to fetch balance.',
			], 422);
		}
		$balance = $checkBalanceResponse->getAmount();;
		$expiry = $checkBalanceResponse->getCardExpiry();
		$params = $checkBalanceResponse->getParams();
		$brand = $params['IssuerName'];

		if($request->ajax())
		{
			$data = [
				'balance' => $balance,
				'expiry' => date('Y-m-d\TH:i:s\Z', $expiry),
				'brand' => $brand
			];

			return response()->json([
				'status' => 'success',
				'data' => $data
			]);
		}
		else
		{
			
		}
	}

	private function findBrandBySVName($brand_sv)
	{
		return Brands::where('sv_name', $brand_sv)->get()->first();
	}

	private function saveCard($card_num, $pin, $balance, $sell_price, $expiry_date, $brand)
	{
		$user = Auth::user();
		 
		$card = new GiftCard;
		$card->card_number = $card_num;
		$card->encyrpted_pin = Crypt::encrypt($pin);
		$card->balance = $balance;
		$card->offer_price = $sell_price;
		$card->expiry_date = $expiry_date;//date('Y-m-d\TH:i:s\Z', $expiry_date);
		$card->user_id = $user->id;
		$card->brand_id = $brand->id;
		$card->status = 'validating';

		$card->save();
		
		return $card;
	}

}
