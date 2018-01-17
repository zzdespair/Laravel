<?php
namespace App\Http\Controllers\Admin;

use Crypt;
use Illuminate\Http\Request;
use App\Model\Article;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Encryption\DecryptException;

class LoginController extends Controller
{
	public function index(Request $request)
	{
		if (session('admin_info') !== null) {
			return redirect()->action('Admin\IndexController@index');
		}
		// var_dump($request->session()->getId());
		// var_dump(Crypt::encrypt('123456'));
		// dump(Crypt::decrypt('eyJpdiI6IkZEYUV4NW9qZFRKY2VtWFwvUHA0MUhnPT0iLCJ2YWx1ZSI6IlFaTjY1bmpoc3BwXC9BYTVoeGt2dklnPT0iLCJtYWMiOiIzZWJmMjljMGM1NTFjYWNmNTgxOTgxN2JjNDAyZWE4MWVlNDgyNTc3NTIzYWJlZmZlODI5ZWM4MjczZWNjN2NhIn0'));
		return view("admin.login");
	}

	public function log(Request $request)
	{
		$data = $request->all();
		$list = $this->getAdminData($request,$data);
		return $list;
		// return $list;
		
	}

	private function getAdminData($request,$data)
	{
		$number = $data['admin_number'];
		$list = DB::table('admin')->where('adnumber',$number)->first();
		if ($list) {
			
			try {
			    $password = Crypt::decrypt($list->adpassword);
			} catch (DecryptException $e) {
			    return 2;
			}
			if ($data['password'] !== $password) {
				$detaile = [
					'zladid' => $list->adid,
					'zlip' => $request->ip(),
					'zltime' => time(),
					'zlstatus' => 2,
				];
				DB::table('login_detaile')->insert($detaile);
				$count = DB::table('login_detaile')->where([
					['zltime','>',time()-1800],
					['zladid','=',$list->adid],
					['zlstatus','=',2]
					])->count();
				if ($count > 10) {
					DB::table('admin')->where('adid',$list->adid)->update(['adstatus'=>3]);
					return 4;
				}
				return 3;
			}else{
				switch ($list->adstatus) {
					case 1:
						session(['admin_info' => (array)$list]);
						$sessions = $request->session()->getId();
						DB::table('admin')->where('adid',$list->adid)->update(['adsessionid'=>$sessions]);
						$detaile = [
							'zladid' => $list->adid,
							'zlip' => $request->ip(),
							'zltime' => time(),
							'zlstatus' => 1,
						];
						DB::table('login_detaile')->insert($detaile);
						return 1;
						break;
					case 2:
						return 5;
						break;
					case 3:
						return 6;
						break;
					default:
						return 7;
						break;
				}
				
			}
		}else{
			return 8;
		}
	}

	public function logout(Request $request)
	{
		$request->session()->flush();
		return redirect()->action('Admin\LoginController@index');
	}

}