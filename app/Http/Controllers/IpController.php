<?php

namespace App\Http\Controllers;

use Auth;
use Log;
use Illuminate\Http\Request;
use App\Model\Ip;
use Storage;

class IpController extends Controller
{
    use \App\Http\Controllers\Handler;

    public function index(Request $request){
        if($request->ip_name != ''){
            $ip_count = Ip::ip_info()
                ->where('i_ip', 'like', "%$request->ip_name%")
                ->count();
            $ip_info = Ip::ip_info()
                ->where('i_ip', 'like', "%$request->ip_name%")
                ->paginate(15);
        }else{
            $ip_count = Ip::ip_info()
                ->count();
            $ip_info = Ip::ip_info()
                ->orderBy('i_id', 'desc')
                ->paginate(15);
        }
        return view('ip.index', ['ip_info'=>$ip_info, 'ip_count'=>$ip_count, 'ip_name'=>$request->ip_name]);
    }

    public function add(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('ip_info')->with(['edit_status' => $check_info['msg_info']]);
        }
        $match = new Ip;
        $match->fill($request->all());
        $status = $match->save();
        if($status){
            return response()->json(['status' => 'success', 'res_desc' => '添加成功!']);
        }else{
            return response()->json(['status' => 'error', 'res_desc' => '添加失败!']);
        }
    }

    public function del(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('ip_info')->with(['edit_status' => $check_info['msg_info']]);
        }
        $id = explode(',', $request->id);
        $lenth_id = count($id);
        try {
            //删除数据
            for ($i=0; $i< $lenth_id; $i++) {
                Ip::ip_info($request)->where('i_id', '=', $id[$i])->delete();
            }
        } catch(\Exception $e){
            return response()->json(['status' => 'error', 'res_desc' => '删除失败!']);
        }
        return response()->json(['status' => 'success', 'res_desc' => '删除成功!']);
    }
    
    public function edit(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('ip_info')->with(['edit_status' => $check_info['msg_info']]);
        }
        $id = $request->id;
        $val = $request->val;
        try {
            Ip::ip_info()->where('i_id', $id)->update(['i_ip' => $val]);
        } catch(\Exception $e){
            return response()->json(['status' => 'error', 'res_desc' => '修改失败!']);
        }
        return response()->json(['status' => 'success', 'res_desc' => '修改成功!']);
    }
}