<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LabelRequest extends FormRequest
{

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'laname' => 'required|min:1|max:20|unique:label',
			'lastatus' => 'nullable',
		];
	}

}