<?php
namespace App\Model;
use Illuminate\Support\Facades\Config;

require '../resources/libs/Qiniu/autoload.php';

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;
use Resources\libs\Common\FunctionModel;

class Qiniu
{
	private $qiniu;

	function __construct()
	{
		$this->qiniu = Config::get('config.qiniu');
	}

	public function imge_upload($policy,$files)
	{
		$uploadManager = new UploadManager();

		$bucket = $this->qiniu['imge_bucket'];
		$token = $this->uploadToken($policy,$bucket);
	
		$FunctionModel = new FunctionModel;
		
		$key = $FunctionModel->get_uuid();
		$return = $uploadManager->putFile($token,$key,$files->getRealPath(),null,$files->getType(),false);

		return $return;
	}

	public function delete($bucket,$key)
	{
		$auth = new Auth($this->qiniu['accessKey'],$this->qiniu['secretKey']);

		$bucketMgr = new BucketManager($auth);

		$err = $bucketMgr->delete($bucket,$key);
		return $err;
	}

	private function uploadToken($policy,$bucket)
	{
		$auth = new Auth($this->qiniu['accessKey'],$this->qiniu['secretKey']);

		$token = $auth->uploadToken($bucket,null,3600,$policy);

		return $token;
	}

}