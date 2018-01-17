<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{
	protected $tabel = 'label';

	public $primaryKey = 'laid';

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