<?php

namespace App\Http\Controllers;

use Auth;
use Log;
use Storage;
use App\Model\Users;
use App\Model\Role;
use App\Model\RoleUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    use \App\Http\Controllers\Handler;

    // 管理员-显示-搜索
    public function index(Request $request){
        $select_info = [
            'users.id',
            'users.name',
            'users.email',
            'users.created_at',
            'users.status',
            'role.r_name'
        ];
        if($request->users_name){
            $userinfo = RoleUser::role_user_info()
                ->join('users', 'users.id', '=', 'role_user.u_id')
                ->join('role', 'role.r_id', '=', 'role_user.r_id')
                ->where('name', 'like', "%$request->users_name%")
                ->select($select_info)
                ->paginate(15);
        }else{
            $userinfo = RoleUser::role_user_info()
                ->join('users', 'users.id', '=', 'role_user.u_id')
                ->join('role', 'role.r_id', '=', 'role_user.r_id')
                ->select($select_info)
                ->paginate(15);
        }
        $user_count = Users::users_info()->count();
        return view('users.index', ['userinfo' => $userinfo, 'user_count' => $user_count,'users_name'=>$request->users_name]);
    }

    // 管理员-添加
    public function add(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('users')->with(['edit_status' => $check_info['msg_info']]);
        }
        if($request->isMethod('post')){
            try {
                //将数据插入表
                $User_info = Users::insertGetId(
                    [
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'created_at' => date("Y-m-d H:i:s"),
                        'updated_at' => date("Y-m-d H:i:s"),
                        'status' => 0
                    ]);
                RoleUser::role_user_add($request->role, $User_info);
            } catch(\Exception $e){
                return redirect()->route('users')->with(['edit_status' => '添加管理员失败']);
            }
            return redirect()->route('users')->with(['edit_status' => '添加管理员成功']);
        }else{
            $role_info = Role::role_info()->get();
            return view('users.add', ['role_info' => $role_info]);
        }
    }

    // 管理员-删除
    public function del(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('users')->with(['edit_status' => $check_info['msg_info']]);
        }
        $id = explode(',', $request->id);
        $lenth_id = count($id);

        try {
            //删除数据
            for ($i=0; $i< $lenth_id; $i++){
                Users::users_info()->where('id', $id[$i])->delete();
                RoleUser::role_user_info()->where('u_id', $id[$i])->delete();
            }
        } catch(\Exception $e){
            return response()->json(['status' => 'error', 'res_desc' => '删除失败!']);
        }
        return response()->json(['status' => 'success', 'res_desc' => '删除成功!']);
    }

    // 管理员-修改
    public function edit(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('users')->with(['edit_status' => $check_info['msg_info']]);
        }
        if($request->isMethod('post')){
            try {
                if($request->password == '******'){
                    $up_date = [
                        'name' => $request->name,
                        'email' => $request->email,
                        'updated_at' => date("Y-m-d H:i:s")
                    ];
                }else{
                    $up_date = [
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'updated_at' => date("Y-m-d H:i:s")
                    ];
                }
                Users::users_info()->where('id', $request->id)->update($up_date);
                RoleUser::role_user_info()->where('u_id', $request->id)->update(['r_id' => $request->role]);
            } catch(\Exception $e){
                return redirect()->route('users')->with(['edit_status' => '修改失败']);
            }
            return redirect()->route('users')->with(['edit_status' => '修改成功']);
        }else{
            $select_info = [
                'users.id',
                'users.name',
                'users.email',
                'users.created_at',
                'users.status',
                'role.r_name',
                'role_user.r_id',
            ];
            $userinfo = RoleUser::role_user_info()
                ->join('users', 'users.id', '=', 'role_user.u_id')
                ->join('role', 'role.r_id', '=', 'role_user.r_id')
                ->where('users.id', $request->id)
                ->select($select_info)
                ->first();
            $role_info = Role::role_info()->get();
            return view('users.edit', ['userinfo'=>$userinfo, 'role_info'=>$role_info]);
        }
    }

    // 管理员-启用/停用
    public function enable(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('users')->with(['edit_status' => $check_info['msg_info']]);
        }
        $up_data = [
            'status' => $request->status
        ];
        if($request->status == 1){
            $content = '停用';
        }else{
            $content = '启用';
        }
        try {
            Users::users_info()->where('id', $request->id)->update($up_data);
        }catch (\Exception $e){
            return response()->json(['status' => 'error', 'res_desc' => $content.'失败!']);
        }
        return response()->json(['status' => 'error', 'res_desc' => $content.'成功!']);
    }

    // 退出登录
    public function loginout(Request $request){
        $user_info = Users::users_info()->where('name', Auth::user()->name)->first();
        $date = date('Y-m-d H:i:s');
        $update_data = [
            'updated_at' => $date,
            'ip' => $request->ip(),
            'login_num' => $user_info->login_num + 1
        ];
        Users::users_info()->where('name', Auth::user()->name)->update($update_data);
        Auth::logout();
        return redirect('/login');
    }
}