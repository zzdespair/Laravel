<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	protected $tabel = 'category';

	public $primaryKey = 'caid';

	public $timestamps = true;

	protected $guarded = [];

	public function freshTimestamp()
	{
		return time();
	}	

	public function fromDateTime($value)
	{
		return $value;
	}
}