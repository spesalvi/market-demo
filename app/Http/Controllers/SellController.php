<?php namespace App\Http\Controllers;

use App\Http\Requests\SellFormRequest;
use App\GiftCard;
use App\StoredValue;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Response;
use View;


class SellController extends Controller
{
	private $sv;

	
	public function __construct(StoredValue $sv)
	{
		$this->sv = $sv;
	}
	public function getAddCard()
	{
		return view('sell.add');
	}

	public function postAddCard(SellFormRequest $request)
	{
		$card_number = $request->input('card-number');
		$pin = $request->input('pin');
		$svResponse = $this->sv->checkBalance($card_number, $pin);
		if($svResponse->getErrorCode() == 0)
		{
			$this->saveCard(
				$card_number,
				$pin,
				$svResponse->getAmount(),
				$svResponse->getCardExpiry()
			);
		//	$this->deActivateCard($card_num);
		}
		return Response::make('Card Added');
	}

	private function saveCard($card_num, $pin, $balance, $expiry_date)
	{
		$user = Auth::user();
		 
		$card = new GiftCard;
		$card->card_number = $card_num;
		$card->encyrpted_pin = Crypt::encrypt($pin);
		$card->balance = $balance;
		$card->expiry_date = date('Y-m-d\TH:i:s\Z"', $expiry_date);
		$card->user_id = $user->id;

		$card->save();
	}

}
