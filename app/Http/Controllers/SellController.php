<?php namespace App\Http\Controllers;

use App\Http\Requests\SellFormRequest;
use App\GiftCard;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Crypt;
use Response;
use View;

require_once '/home/robert/work/projects/gb/gbservermage/SVClientUtility/Utility.php';

class SellController extends Controller
{
	const SVPropertiesPath = '/home/robert/work/projects/gb/gbservermage/SVClientUtility/TEST0QA_gc_serverobj.properties';
	public function getAddCard()
	{
		return view('sell.add');
	}

	public function postAddCard(SellFormRequest $request)
	{
		$card_number = $request->input('card-number');
		$pin = $request->input('pin');
		$this->checkBalance($card_number, $pin);
		return Response::make('Card Added');
	}

	private function checkBalance($card_num, $pin)
	{
		$txnId = (new \Utility())->getTxnId();
		$svProperties = $this->getSVProperties();
		$svRequest = \GCWebPos::balanceEnquiry($svProperties, 
			$card_num, 
			$pin, 
			$txnId, 
			'', 
			''
		);
		$svResponse = $svRequest->execute();
		if($svResponse->getErrorCode() == 0)
		{
			$this->saveCard(
				$card_num,
				$pin,
				$svResponse->getAmount(),
				$svResponse->getCardExpiry()
			);
		//	$this->deActivateCard($card_num);
		}
	}

	private function saveCard($card_num, $pin, $balance, $expiry_date)
	{
		$card = new GiftCard;
		$card->card_number = $card_num;
		$card->encyrpted_pin = Crypt::encrypt($pin);
		$card->balance = $balance;
		$card->expiry_date = date('Y-m-d\TH:i:s\Z"', $expiry_date);
		$card->user_id = 1;

		$card->save();
	}

	private function getSVProperties()
	{
		return \SVServerData::load(self::SVPropertiesPath);
	}

	private function deActivateCard($card_num)
	{
		$svProperties = $this->getSVProperties();
		$txnId = (new \Utility())->getTxnId();
		$svRequest = \GCWebPos::deactivate($svProperties, 
			$card_num,  
			$txnId
		);

		$svResponse = $svRequest->execute();

		var_dump($svResponse);
	}
}
