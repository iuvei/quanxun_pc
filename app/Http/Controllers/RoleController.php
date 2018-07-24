<?php

namespace App\Http\Controllers;

use Auth;
use Log;
use Storage;
use App\Model\Users;
use App\Model\Role;
use App\Model\RoleUser;
use App\Model\Power;
use App\Model\RolePower;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    use \App\Http\Controllers\Handler;

    public function index(){
        $select_data = [
            'r_id',
            'r_name',
        ];
        $role_info = Role::role_info()
            ->select($select_data)
            ->get();

        return view('role.index', ['role_info'=>$role_info]);
    }

    public function add(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('role')->with(['edit_status' => $check_info['msg_info']]);
        }
        if($request->isMethod('post')){
            // 添加角色
            try{
                $r_id = Role::role_info()->insertGetId([
                    'r_name' => $request->r_name
                ]);
            } catch (\Exception $e){
                return response()->json(['msg' => 'error', 'msg_info' => '操作失败！']);
            }
            $p_id = $request->p_id;
            // 需要给用户设置的权限
            $p_id_array = explode(',', $p_id);
            $p_count = count($p_id_array);
            // 给用户设置权限
            for ($i=0; $i<$p_count; $i++){
                try {
                    RolePower::insert([
                        'r_id' => $r_id,
                        'p_id' => $p_id_array[$i]
                    ]);
                } catch (\Exception $e){
                    return response()->json(['msg' => 'error', 'msg_info' => '操作失败！']);
                }
            }
            return response()->json(['msg' => 'success', 'msg_info' => '操作成功！']);
        }else{
            $info = RolePower::role_power_info()->select('p_id')->get();
            $i_id = '';
            foreach ($info as $info_val){
                $i_id .= $info_val['p_id'] . ',';
            }
            $select_data = [
                'p_id',
                'p_name',
                'f_id'
            ];
            // 找到所有父级权限
            $power_finfo = Power::power_info()->where('f_id', 0)->select($select_data)->get();
            $p_id = '';
            foreach ($power_finfo as $f_info){
                $p_id .= $f_info['p_id'] . ',';
            }
            $p_id = explode(',', trim($p_id, ','));
            // 根据父级权限查询子权限
            $power_cinfo = Power::power_info()->whereIn('f_id', $p_id)->select($select_data)->get();
            $c_id = '';
            foreach ($power_cinfo as $c_info){
                $c_id .= $c_info['p_id'] . ',';
            }
            $c_id = explode(',', trim($c_id, ','));
            // 查询子权限下面的权限
            $power_zinfo = Power::power_info()->whereIn('f_id', $c_id)->select($select_data)->get();
            // 把子权限父级id一样的放在一个数组
            $z_info = [];
            foreach ($power_zinfo as $zval){
                $z_info[$zval['f_id']][] = $zval;
            }

            $power_new_cinfo = [];
            foreach ($power_cinfo as $k_cinfo => $value){
                foreach ($z_info as $k_zinfo => $val){
                    if($value['p_id'] == $k_zinfo){
                        $power_new_cinfo['p_id'] = $value['p_id'];
                        $power_new_cinfo['p_name'] = $value['p_name'];
                        $power_new_cinfo['f_id'] = $value['f_id'];
                        $power_new_cinfo['z_info'] = $val;
                        $new_power_info[$value['f_id']][] = $power_new_cinfo;
                    }
                }
            }
            $power_new_pinfo = [];
            foreach ($power_finfo as $value){
                foreach ($new_power_info as $n_key => $val){
                    if($value['p_id'] == $n_key) {
                        $power_new_pinfo['p_id'] = $value['p_id'];
                        $power_new_pinfo['p_name'] = $value['p_name'];
                        $power_new_pinfo['f_id'] = $value['f_id'];
                        $power_new_pinfo['c_info'] = $val;
                        $power_info[$value['p_id']] = $power_new_pinfo;
                    }
                }
            }
            return view('role.add', ['power_info'=>$power_info]);
        }
    }

    public function edit(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('role')->with(['edit_status' => $check_info['msg_info']]);
        }
        if($request->isMethod('post')){
            $p_id = $request->p_id;
            $r_id = $request->r_id;
            // 需要给用户设置的权限
            $p_id_array = explode(',', $p_id);
            $p_count = count($p_id_array);
            // 删除用户所有的权限
            try{
                RolePower::role_power_info()->where('r_id', $r_id)->delete();
            }catch (\Exception $e){
                return response()->json(['msg' => 'error', 'msg_info' => '操作失败！']);
            }
            // 给用户设置权限
            for ($i=0; $i<$p_count; $i++){
                try {
                    RolePower::insert([
                        'r_id' => $r_id,
                        'p_id' => $p_id_array[$i]
                    ]);
                } catch (\Exception $e){
                    return response()->json(['msg' => 'error', 'msg_info' => '操作失败！']);
                }
            }
            return response()->json(['msg' => 'success', 'msg_info' => '操作成功！']);
        }else{
            $role_name = Role::role_info()->select('r_name')->where('r_id', $request->id)->first();
            $info = RolePower::role_power_info()->select('p_id')->where('r_id', $request->id)->get();
            $i_id = '';
            foreach ($info as $info_val){
                $i_id .= $info_val['p_id'] . ',';
            }
            $i_id = explode(',', trim($i_id, ','));
            $select_data = [
                'p_id',
                'p_name',
                'f_id'
            ];
            // 找到所有父级权限
            $power_finfo = Power::power_info()->where('f_id', 0)->select($select_data)->get();
            $p_id = '';
            foreach ($power_finfo as $f_info){
                $p_id .= $f_info['p_id'] . ',';
            }
            $p_id = explode(',', trim($p_id, ','));
            // 根据父级权限查询子权限
            $power_cinfo = Power::power_info()->whereIn('f_id', $p_id)->select($select_data)->get();
            $c_id = '';
            foreach ($power_cinfo as $c_info){
                $c_id .= $c_info['p_id'] . ',';
            }
            $c_id = explode(',', trim($c_id, ','));
            // 查询子权限下面的权限
            $power_zinfo = Power::power_info()->whereIn('f_id', $c_id)->select($select_data)->get();
            // 把子权限父级id一样的放在一个数组
            $z_info = [];
            foreach ($power_zinfo as $zval){
                $z_info[$zval['f_id']][] = $zval;
            }

            $power_new_cinfo = [];
            foreach ($power_cinfo as $k_cinfo => $value){
                foreach ($z_info as $k_zinfo => $val){
                    if($value['p_id'] == $k_zinfo){
                        $power_new_cinfo['p_id'] = $value['p_id'];
                        $power_new_cinfo['p_name'] = $value['p_name'];
                        $power_new_cinfo['f_id'] = $value['f_id'];
                        $power_new_cinfo['z_info'] = $val;
                        $new_power_info[$value['f_id']][] = $power_new_cinfo;
                    }
                }
            }
            $power_new_pinfo = [];
            foreach ($power_finfo as $value){
                foreach ($new_power_info as $n_key => $val){
                    if($value['p_id'] == $n_key) {
                        $power_new_pinfo['p_id'] = $value['p_id'];
                        $power_new_pinfo['p_name'] = $value['p_name'];
                        $power_new_pinfo['f_id'] = $value['f_id'];
                        $power_new_pinfo['c_info'] = $val;
                        $power_info[$value['p_id']] = $power_new_pinfo;
                    }
                }
            }
            return view('role.edit', ['power_info'=>$power_info, 'i_id'=>$i_id, 'r_name'=>$role_name->r_name, 'r_id'=>$request->id]);
        }
    }

    public function del(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('activity')->with(['edit_status' => $check_info['msg_info']]);
        }
        if(is_array($request->id)){
            $id = $request->id;
        }else{
            $id[] = $request->id;
        }
        $ids = explode(',', $request->id);
        $lenth_id = count($ids);
        try {
            //删除数据
            for ($i=0; $i< $lenth_id; $i++){
                Role::role_info()->where('r_id', $ids[$i])->delete();
            }
        } catch(\Exception $e){
            return response()->json(['status' => 'error', 'res_desc' => '删除失败!']);
        }
        return response()->json(['status' => 'success', 'res_desc' => '删除成功!']);
    }
}