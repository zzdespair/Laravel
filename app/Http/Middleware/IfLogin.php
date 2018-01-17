<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Http\Request;
use App\Model\Admin;
class IfLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
      $admin_info = session('admin_info');
      if ($admin_info === null) {
     		return redirect()->action('Admin\LoginController@index');
      }else{

        $admin = Admin::where('adid','=',$admin_info['adid'])->first(["adsessionid", 'adstatus']);

        switch ($admin['adstatus']) {
          case 2:
            $request->session()->flush();
            return redirect()->action('Admin\LoginController@index')->withErrors(['账号被锁定']);

            break;
          
          case 3:
            $request->session()->flush();
            return redirect()->action('Admin\LoginController@index')->withErrors(['账号被禁用']);
            break;
        }

        if ($request->session()->getId() != $admin['adsessionid']) {
          $request->session()->flush();
          return redirect()->action('Admin\LoginController@index')->withErrors(['你的账号在另一端登录','如不是本人请及时修改密码']);
        }
      }
      return $next($request);

    }
}
