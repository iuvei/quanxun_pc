<?php

namespace App\Http\Controllers;

use Auth;
use App\Model\Users;
use App\Model\Role;
use App\Model\RoleUser;
use App\Model\Power;
use App\Model\RolePower;

trait Handler
{
    function ChcekUser_Power($request){
        // 查找用户角色
        $user_info = Users::users_info()->select('id')->where('name', Auth::user()->name)->first();
        $r_id = RoleUser::role_user_info()->select('r_id')->where('u_id', $user_info->id)->first();
        // 获取当前操作权限
        $routh_info = $request->s;
        $power_info = Power::power_info()->select('p_id', 'p_name')->where('p_url', "$routh_info")->first();
        // 查找用户是否有此权限
        $r_info = RolePower::role_power_info()->where('r_id', $r_id->r_id)->where('p_id', $power_info->p_id)->first();
        if($r_info == ''){
            $return_arrat = ['msg'=>'Fail', 'msg_info'=>'您没有' . $power_info->p_name . '的权限！请联系管理员！'];
            return json_encode($return_arrat);
        }
    }
}