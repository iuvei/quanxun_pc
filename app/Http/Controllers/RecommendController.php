<?php

namespace App\Http\Controllers;

use Auth;
use Log;
use Storage;
use App\Model\Recommend;
use App\Model\Company;
use Illuminate\Http\Request;

class RecommendController extends Controller
{
    use \App\Http\Controllers\Handler;

    public function index(){
        $recommend = Recommend::recommend_info()
            ->join('company', 'recommend.r_c_id', 'company.c_id')
            ->orderBy('r_weights', 'desc')
            ->orderBy('r_createtime', 'desc')
            ->paginate(6);
        return view('recommend.index', ['recommend' =>$recommend]);
    }

    public function add(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('recommend')->with(['edit_status' => $check_info['msg_info']]);
        }
        if($request->isMethod('post')){
            $recommend_count = Recommend::recommend_info()->select('r_id')->orderBy('r_id', 'desc')->first();
            $file = $request->file('r_img');
            $file_name = '';
            // 获取文件相关信息
            $ext = $file->getClientOriginalExtension();     // 扩展名
            $realPath = $file->getRealPath();   //临时文件的绝对路径
            // 上传文件
            $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
            // 使用新建的uploads本地存储空间（目录）
            $bool = Storage::disk('recommend')->put($filename, file_get_contents($realPath));
            if(!$bool){
                return response()->json(['status' => 'error', 'res_desc' => '图片上传失败!']);
            }
            $file_name .= '/img/recommend/' . $filename;
            try {
                Recommend::recommend_info()->insert(
                    [
                        'r_title' => $request->r_title,
                        'r_url' => $request->r_url,
                        'r_img' => $file_name,
                        'r_c_id' => $request->c_id,
                        'r_content' => $request->contents,
                        'r_createtime' => date('Y-m-d H:i:s'),
                        'r_start_time' => $request->commentdatemin,
                        'r_end_time' => $request->commentdatemax,
                        'r_weights' => $recommend_count['r_id'] + 1,
                        'r_is_show' => $request->is_show
                    ]
                );
            }catch (\Exception $e){
                return redirect()->route('recommend')->with(['edit_status' => '新增推荐活动失败 !']);
            }
            return redirect()->route('recommend')->with(['edit_status' => '新增推荐活动成功 !']);
        }else {
            $company = Company::company_info()
                ->select('c_id','c_name')
                ->get();
            return view('recommend.add', ['company' => $company]);
        }
    }

    public function del(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('recommend')->with(['edit_status' => $check_info['msg_info']]);
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
                Recommend::recommend_info()->where('r_id', $ids[$i])->delete();
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
            return redirect()->route('recommend')->with(['edit_status' => $check_info['msg_info']]);
        }
        if($request->isMethod('post')){
            $file = $request->file('r_img');
            $imgname = '';
            if($file == ''){
                $imgname = '';
            }else{
                // 获取文件相关信息
                $ext = $file->getClientOriginalExtension();     // 扩展名
                $realPath = $file->getRealPath();   //临时文件的绝对路径
                // 上传文件
                $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                // 使用新建的uploads本地存储空间（目录）
                $bool = Storage::disk('recommend')->put($filename, file_get_contents($realPath));
                if(!$bool){
                    return response()->json(['status' => 'error', 'res_desc' => '图片上传失败!']);
                }
                $imgname .= '/img/recommend/' . $filename;
            }
            $up_data = [
                'r_title' => $request->r_title,
                'r_url' => $request->r_url,
                'r_img' => $imgname,
                'r_content' => $request->contents,
                'r_createtime' => date('Y-m-d H:i:s'),
                'r_start_time' => $request->commentdatemin,
                'r_end_time' => $request->commentdatemax,
                'r_c_id' => $request->c_id,
                'r_is_show' => $request->is_show
            ];
            if($imgname == ''){
                unset($up_data['r_img']);
            }
            try {
                Recommend::recommend_info()->where('r_id', $request->id)->update($up_data);
            } catch(\Exception $e){
                return redirect()->route('recommend')->with(['edit_status' => '修改推荐活动失败 !']);
            }
            return redirect()->route('recommend')->with(['edit_status' => '修改推荐活动成功 !']);
        }else{
            $company = Company::company_info()
                ->select('c_id','c_name')
                ->get();
            $recommend_info = Recommend::recommend_info()
                ->where('r_id', $request->id)
                ->first();
            return view('recommend.edit', ['recommend_info' => $recommend_info, 'company' => $company]);
        }
    }

    public function sort(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('recommend')->with(['edit_status' => $check_info['msg_info']]);
        }
        $sort = $request->sort;
        $type = $request->type;

        // 上移
        if($type == 1){
            $recomment_prve = Recommend::recommend_info()->where('r_weights', '>', $sort)->orderBy('r_weights', 'asc')->first();
            try {
                Recommend::recommend_info()->where('r_id', $recomment_prve->r_id)->update(['r_weights'=>$sort]);
            }catch (\Exception $e){
                return response()->json(['status' => 'error', 'res_desc' => '操作失败!']);
            }
            try {
                Recommend::recommend_info()->where('r_id', $request->id)->update(['r_weights'=>$recomment_prve['r_weights']]);
            }catch (\Exception $e){
                return response()->json(['status' => 'error', 'res_desc' => '操作失败!']);
            }
            return response()->json(['status' => 'error', 'res_desc' => '操作成功!']);
        }else{
            $recomment_last = Recommend::recommend_info()->where('r_weights', '<', $sort)->orderBy('r_weights', 'desc')->first();
            try {
                Recommend::recommend_info()->where('r_id', $recomment_last->r_id)->update(['r_weights'=>$sort]);
            }catch (\Exception $e){
                return response()->json(['status' => 'error', 'res_desc' => '操作失败!']);
            }
            try {
                Recommend::recommend_info()->where('r_id', $request->id)->update(['r_weights'=>$recomment_last['r_weights']]);
            }catch (\Exception $e){
                return response()->json(['status' => 'error', 'res_desc' => '操作失败!']);
            }
            return response()->json(['status' => 'error', 'res_desc' => '操作成功!']);
        }
    }
}