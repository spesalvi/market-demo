<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;


class SellFormRequest extends FormRequest
{
	public function rules()
	{
		return [
			'card-number' => 'required',
			'pin' => 'required'
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
