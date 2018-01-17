<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
	protected $tabel = 'article';

	public $primaryKey = 'arid';

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