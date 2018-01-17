<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'caname' => 'required|min:1|max:20|unique:category',
			'castatus' => 'nullable',
		];
	}

}