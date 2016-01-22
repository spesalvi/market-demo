<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ValidateCardRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
	    return true;
	    return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		return [
			'card-number' => 'required|unique:gift_cards,card_number|regex:/^[0-9]{16}$/',
			'pin' => 'required|regex:/^[0-9]{6}/'
		];
    }

    public function forbiddenResponse()
    {
	    return Response::make('Please login to transact', 403);
    }
}
