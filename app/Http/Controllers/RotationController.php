<?php

namespace App\Http\Controllers;

use Log;
use Auth;
use Image;
use Storage;
use App\Model\Rotation;
use App\Model\Company;
use Illuminate\Http\Request;

class RotationController extends Controller
{
    use \App\Http\Controllers\Handler;

    public function index(Request $request){
        $select_data = [
            'rotation_map.rm_id',
            'rotation_map.rm_title',
            'rotation_map.rm_img',
            'rotation_map.rm_url',
            'rotation_map.rm_start_time',
            'rotation_map.rm_end_time',
            'rotation_map.rm_is_show',
            'company.c_name'
        ];
        $request->addr_id = isset($request->addr_id) ? $request->addr_id : 1;
        $rotation_info = Rotation::rotation_info()
            ->join('company', 'company.c_id', '=', 'rotation_map.rm_c_id')
            ->select($select_data)
            ->where('rm_addr_id', $request->addr_id)
            ->orderBy('rm_weights', 'desc')
            ->paginate(6);
        return view('rotation.index', ['rotation_info'=>$rotation_info, 'addr_id'=>$request->addr_id]);
    }

    public function add(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('rotation')->with(['edit_status' => $check_info['msg_info']]);
        }
        if($request->isMethod('post')){
            $request->addr_id = trim(implode(',', $request->addr_id), ',');
            $rotation_count = Rotation::rotation_info()->select('rm_id')->orderBy('rm_id', 'desc')->first();
            if($rotation_count == ''){
                $rm_weights = 1;
            }else{
                $rm_weights = $rotation_count->rm_id + 1;
            }
            $file = $request->file('rm_img');
            $file_name = '';
            // 获取文件相关信息
            $ext = $file->getClientOriginalExtension();     // 扩展名
            $img_type = ['jpg', 'jpeg', 'gif', 'png', 'bmp'];
            if(in_array($ext, $img_type)) {
                $realPath = $file->getRealPath();   //临时文件的绝对路径
                // 上传文件
                $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                // 使用新建的company本地存储空间（目录）
                $bool = Storage::disk('rotation')->put($filename, file_get_contents($realPath));
                if (!$bool) {
                    return redirect()->route('rotation')->with(['edit_status' => '图片上传失败 !']);
                }
                $file_name .= '/img/rotation/' . $filename;
            }else{
                return redirect()->route('rotation')->with(['edit_status' => '图片格式错误 ，只支持jpg，jpeg，gif，png，bmp 格式!']);
            }
            $ins_data = [
                'rm_img' => $file_name,
                'rm_url'=> $request->rm_url,
                'rm_weights'=> $rm_weights,
                'rm_addr_id' => $request->addr_id,
                'rm_start_time' => $request->commentdatemin,
                'rm_end_time' => $request->commentdatemax,
                'rm_c_id' => $request->c_id,
                'rm_title' => $request->rm_title,
                'rm_createtime' => date('Y-m-d H:i:s'),
                'rm_is_show' => $request->rm_is_show,
            ];
            try {
                //将数据插入表
                Rotation::rotation_info()->insert($ins_data);
            } catch(\Exception $e){
                return redirect()->route('rotation')->with(['edit_status' => '新增轮播图失败 !']);
            }
            return redirect()->route('rotation')->with(['edit_status' => '新增轮播图成功 !']);
        }else{
            $company = Company::company_info()->get();
            return view('rotation.add', ['company' => $company]);
        }
    }

    public function del(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('rotation')->with(['edit_status' => $check_info['msg_info']]);
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
                Rotation::rotation_info()->where('rm_id', $ids[$i])->delete();
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
            return redirect()->route('rotation')->with(['edit_status' => $check_info['msg_info']]);
        }
        if($request->isMethod('post')){
            $file = $file = $request->file('rm_img');
            $file_name = '';
            if($file == ''){
                $file_name = '';
            }else{
                // 获取文件相关信息
                $ext = $file->getClientOriginalExtension();     // 扩展名
                $img_type = ['jpg', 'jpeg', 'gif', 'png', 'bmp'];
                if(in_array($ext, $img_type)) {
                    $realPath = $file->getRealPath();   //临时文件的绝对路径
                    // 上传文件
                    $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                    // 使用新建的company本地存储空间（目录）
                    $bool = Storage::disk('rotation')->put($filename, file_get_contents($realPath));
                    if (!$bool) {
                        return redirect()->route('rotation')->with(['edit_status' => '图片上传失败 !']);
                    }
                    $file_name .= '/img/rotation/' . $filename;
                }else{
                    return redirect()->route('rotation')->with(['edit_status' => '图片格式错误 ，只支持jpg，jpeg，gif，png，bmp 格式 !']);
                }
            }
            $request->addr_id = trim(implode(',', $request->addr_id), ',');
            $up_data = [
                'rm_img' => $file_name,
                'rm_url'=> $request->rm_url,
                'rm_addr_id' => $request->addr_id,
                'rm_start_time' => $request->commentdatemin,
                'rm_end_time' => $request->commentdatemax,
                'rm_c_id' => $request->c_id,
                'rm_title' => $request->rm_title,
                'rm_is_show' => $request->rm_is_show,
            ];
            if($file_name == ''){
                unset($up_data['rm_img']);
            }
            try {
                Rotation::rotation_info()->where('rm_id', $request->id)->update($up_data);
            } catch(\Exception $e){
                return redirect()->route('rotation')->with(['edit_status' => '修改推荐活动失败 !']);
            }
            return redirect()->route('rotation')->with(['edit_status' => '修改推荐活动成功 !']);
        }else{
            $retation_info = Rotation::rotation_info()->where('rm_id', $request->id)->first();
            $company = Company::company_info()->get();
            return view('rotation.edit', ['rotation_info' => $retation_info, 'company' => $company]);
        }
    }

    public function sort(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('rotation')->with(['edit_status' => $check_info['msg_info']]);
        }
        $sort = $request->sort;
        $type = $request->type;

        $rotation_info = Rotation::rotation_info()->select('rm_end_time')->where('rm_id', $request->id)->first();
        // 上移
        if($type == 1){
            $rotation_prve = Rotation::rotation_info()->where('rm_weights', '>', $sort)->where('rm_addr_id', 'like', "%$request->addr_id%")->orderBy('rm_weights', 'asc')->first();
            try {
                Rotation::rotation_info()->where('rm_id', $rotation_prve['rm_id'])->update(['rm_weights'=>$sort, 'rm_end_time' => $rotation_prve['rm_end_time']]);
            }catch (\Exception $e){
                return response()->json(['status' => 'error', 'res_desc' => '操作失败!']);
            }
            try {
                Rotation::rotation_info()->where('rm_id', $request->id)->update(['rm_weights' => $rotation_prve['rm_weights'], 'rm_end_time' => $rotation_info->rm_end_time]);
            }catch (\Exception $e){
                return response()->json(['status' => 'error', 'res_desc' => '操作失败!']);
            }
            return response()->json(['status' => 'error', 'res_desc' => '操作成功!']);
        }else{
            $rotation_last = Rotation::rotation_info()->where('rm_weights', '<', $sort)->where('rm_addr_id', 'like', "%$request->addr_id%")->orderBy('rm_weights', 'desc')->first();
            try {
                Rotation::rotation_info()->where('rm_id', $rotation_last['rm_id'])->update(['rm_weights'=>$sort, 'rm_end_time' => $rotation_last['rm_end_time']]);
            }catch (\Exception $e){
                return response()->json(['status' => 'error', 'res_desc' => '操作失败!']);
            }
            try {
                Rotation::rotation_info()->where('rm_id', $request->id)->update(['rm_weights'=>$rotation_last['rm_weights'], 'rm_end_time' => $rotation_info->rm_end_time]);
            }catch (\Exception $e){
                return response()->json(['status' => 'error', 'res_desc' => '操作失败!']);
            }
            return response()->json(['status' => 'error', 'res_desc' => '操作成功!']);
        }
    }
}