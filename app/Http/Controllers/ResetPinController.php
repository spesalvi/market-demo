<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\StoredValue;
use App\Http\Controllers\Controller;

class ResetPinController extends Controller
{

	public function postReset(Request $request)
	{
		$card_number = $request->input('card_number');
		$sv = new StoredValue();

		$resetResponse = $sv->changePin($card_number);

		if($resetResponse->getErrorCode() != 0)
		{
			
		}
		return response()->
			json([
					'pin' => $resetResponse->getCardPin()
				]
			);


	}
    //
}
