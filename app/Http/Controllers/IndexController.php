<?php

namespace App\Http\Controllers;

use Auth;
use Log;
use Image;//依赖包的Image静态方法生成缩略图
use App\Model\Power;
use App\Model\Users;
use App\Model\Role;
use App\Model\RoleUser;
use App\Model\RolePower;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function welcome(){
        $user_info = Users::users_info()->where('name', Auth::user()->name)->first();
        return view('index.welcome', ['user_info' => $user_info]);
    }

    public function index(){
        // 用户id
        $uid = Users::users_info()->select('id')->where('name', Auth::user()->name)->first();
        // 用户对应的角色id
        $ur_id = RoleUser::role_user_info()->select('r_id')->where('u_id', $uid->id)->first();
        // 根据角色id查找权限
        $p_info = RolePower::role_power_info()->select('p_id')->where('r_id', $ur_id->r_id)->get();
        $p_id = '';
        foreach ($p_info as $item) {
            $p_id .= $item['p_id'] . ',';
        }
        $p_id = explode(',', trim($p_id, ','));
        $power_finfo = Power::power_info()->where('f_id', 0)->get();
        $new_power_finfo = [];
        foreach ($power_finfo as $value){
            if(in_array($value['p_id'], $p_id)){
                $new_power_finfo[] = $value;
            }
        }
        $power_cinfo = Power::power_info()->where('p_url', '!=', '/')->get();
        $new_power_cinfo = [];
        foreach ($power_cinfo as $value){
            if(in_array($value['p_id'], $p_id)){
                $new_power_cinfo[] = $value;
            }
        }
        return view('index.index', ['power_finfo' => $new_power_finfo, 'power_cinfo' => $new_power_cinfo]);
    }
}