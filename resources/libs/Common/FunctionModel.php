<?php
namespace Resources\libs\Common;

class FunctionModel {
	
	/**
	 * uuid 获取
	*/
	public function get_uuid()
	{
		$chars = md5(uniqid(mt_rand(), true));  
		$uuid  = substr($chars,0,8) . '-';  
		$uuid .= substr($chars,8,4) . '-';  
		$uuid .= substr($chars,12,4) . '-';  
		$uuid .= substr($chars,16,4) . '-';  
		$uuid .= substr($chars,20,12);  
		return $uuid;  
	} 
}