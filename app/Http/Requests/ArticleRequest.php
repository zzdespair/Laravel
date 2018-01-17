<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		return [
			'artitle' => 'required|min:1|max:20|unique:article',
			'artitle' => 'max:85',
			'arcaid' => 'required|integer',
		];
	}

}