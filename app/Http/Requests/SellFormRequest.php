<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;


class SellFormRequest extends FormRequest
{
	public function rules()
	{
		return [
			'card-number' => 'required|unique:gift_cards,card_number|regex:/^[0-9]{16}$/',
			'price' => 'required|regex:/^[0-9]\.[0-9]{2}+/',
			'balance' => 'required|regex:/^[0-9]\.[0-9]{2}+/',
			'date' => 'required|date_format:Y-m-d\TH:i:s\Z',
			'pin' => 'required|regex:/^[0-9]{6}/'
		];
	}

	public function authorize()
	{
		return true;
		return \Auth::check();
	}

	public function forbiddenResponse()
	{
		return Response::make('Please login to transact', 403);
	}
}
