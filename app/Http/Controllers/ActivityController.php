<?php

namespace App\Http\Controllers;

use Auth;
use Log;
use Image;
use Illuminate\Http\Request;
use App\Model\Activity;
use App\Model\Activity_type;
use App\Model\Company;
use Storage;
date_default_timezone_set('PRC');
class ActivityController extends Controller
{
    use \App\Http\Controllers\Handler;

    // 活动-显示-搜索
    public function index(Request $request){
        $request_sel = [
            'activity.a_id',
            'activity.a_title',
            'activity.a_activity_type_id',
            'activity.a_company_id',
            'activity.a_image240x130',
            'activity.a_status',
            'activity.a_starttime',
            'activity.a_endtime',
            'activity.a_page_views',
            'activity.a_weights',
            'activity_type.at_type',
            'company.c_id',
            'company.c_name'
        ];
        $time = time()+(8*60*60)-175;
        $date = date('Y-m-d H:i:s', $time);
        $type = isset($request->type) ? $request->type : 1;
        if($type == 1){
            $company_type = '=';
            $companyId = 1;
        }else{
            $company_type = '!=';
            $companyId = 1;
        }
        $where = [
            'activity.a_is_del' => 0,
            'activity.a_activity_type_id' => $request->activity_type,
            'company.c_id' => $request->activity_company,
        ];
        if($request->active){ // 搜索操作
            if($request->a_type_info != ''){ // 发布状态不为空 release status
                switch ($request->a_type_info){
                    case 1:
                        $where['activity.a_status'] = 1;
                        $a_starttime_status = '>';
                        $a_endtime_status = '>';
                        break;
                    case 2:
                        $where['activity.a_status'] = 1;
                        $a_starttime_status = '<';
                        $a_endtime_status = '>';
                        break;
                    case 3:
                        $where['activity.a_status'] = 1;
                        $a_starttime_status = '<';
                        $a_endtime_status = '<';
                        break;
                    case 4:
                        $where['activity.a_status'] = 0;
                        $a_starttime_status = '>';
                        $a_endtime_status = '>';
                        $date = '0000-00-00 00:00:00';
                        break;
                }
                $whereAll = [];
                foreach ($where as $key => $val){
                    if(!is_null($val) || $val != ''){
                        $whereAll[$key] = $val;
                    }
                }
                $activity_info = Activity::activity_info()
                    ->join('activity_type', 'activity.a_activity_type_id', '=', 'activity_type.at_id')
                    ->join('company', 'activity.a_company_id', '=', 'company.c_id')
                    ->select($request_sel)
                    ->where('activity.a_title', 'like', "%$request->activity_name%")
                    ->where('activity.a_starttime', "$a_starttime_status", $date)
                    ->where('activity.a_endtime', "$a_endtime_status", $date)
                    ->where($whereAll)
                    ->where('company.c_id', $company_type, $companyId)
                    ->orderBy('activity.a_weights','desc')
                    ->orderBy('activity.a_createtime','desc')
                    ->paginate(6);
            }else{
                $whereAll = [];
                foreach ($where as $key => $val){
                    if(!is_null($val) || $val != ''){
                        $whereAll[$key] = $val;
                    }
                }
                $activity_info = Activity::activity_info()
                    ->join('activity_type', 'activity.a_activity_type_id', '=', 'activity_type.at_id')
                    ->join('company', 'activity.a_company_id', '=', 'company.c_id')
                    ->select($request_sel)
                    ->where('activity.a_title', 'like', "%$request->activity_name%")
                    ->where($whereAll)
                    ->where('company.c_id', $company_type, $companyId)
                    ->orderBy('activity.a_weights','desc')
                    ->orderBy('activity.a_createtime','desc')
                    ->paginate(6);
            }
        }else{ // 显示列表
            $activity_info = Activity::activity_info()
                ->join('activity_type', 'activity.a_activity_type_id', '=', 'activity_type.at_id')
                ->join('company', 'a_company_id', '=', 'c_id')
                ->select($request_sel)
                ->where('activity.a_is_del', '=', 0)
                ->where('company.c_id', $company_type, $companyId)
                ->orderBy('activity.a_weights','desc')
                ->orderBy('activity.a_createtime','desc')
                ->paginate(6);
        }
        $activity_type = Activity_type::type_info()
            ->select('at_id','at_type')
            ->get();
        $activity_company = Company::company_info()
            ->select('c_id','c_name')
            ->get();
        $activity_count = $activity_info->count();
        $data_info = [
            'activity' => $activity_info,
            'activity_type' => $activity_type,
            'activity_company' => $activity_company,
            'activity_count' => $activity_count,
            'activity_name' => $request->activity_name,
            'company' => $request->activity_company,
            'type'=>$request->activity_type,
            'a_type_info'=>$request->a_type_info,
            'a_type'=>$type
        ];
        return view('activity.index', $data_info);
    }

    // 活动-添加
    public function add(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('activity')->with(['edit_status' => $check_info['msg_info']]);
        }
        if($request->isMethod('post')){
            $activity_info = Activity::activity_info()->select('a_id')->orderBy('a_id', 'desc')->first();
            if($activity_info == ''){
                $request->activitysort = $activity_info->a_id = 0;
            }else{
                $request->activitysort = $activity_info->a_id + 1;
            }
            $file = $request->file('activity_file');
            $file_name = '';
            foreach ($file as $val){
                // 获取文件相关信息
                $ext = $val->getClientOriginalExtension();     // 扩展名
                $img_type = ['jpg', 'jpeg', 'gif', 'png', 'bmp'];
                if(in_array($ext, $img_type)){
                    $realPath = $val->getRealPath();   //临时文件的绝对路径
                    // 上传文件
                    $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                    // 使用新建的uploads本地存储空间（目录）
                    $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
                    if(!$bool){
                        return response()->json(['status' => 'error', 'res_desc' => '图片上传失败!']);
                    }
                    $file_name .= '/img/activity/' . $filename . ',';
                }else{
                    return redirect()->route('activity')->with(['edit_status' => '图片格式错误 ，只支持jpg，jpeg，gif，png，bmp 格式!', 'type' => $request->type]);
                }
            }
            $file_url = explode(',', $file_name);
            $img_name240 = $file_url[0];
            $img_name700 = $file_url[1];
            try {
                //将数据插入表
                Activity::ins_activity($request, $img_name240, $img_name700);
            } catch(\Exception $e){
                return redirect()->route('activity')->with(['edit_status' => '新增活动失败 !', 'type' => $request->type]);
            }
            return redirect()->route('activity')->with(['edit_status' => '新增活动成功 !', 'type' => $request->type]);
        }else{
            $activity_company = Company::company_info()
                ->select('c_id','c_name')
                ->get();
            $activity_type = Activity_type::type_info()
                ->select('at_id','at_type')
                ->get();
            return view('activity.add',['activity_type'=>$activity_type,'activity_company'=>$activity_company]);
        }
    }

    // 活动-删除
    public function del(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('activity')->with(['edit_status' => $check_info['msg_info']]);
        }
        $info = [
            'a_is_del' => 1
        ];
        $id = explode(',', $request->id);
        $lenth_id = count($id);
        try {
            //删除数据
            for ($i=0; $i< $lenth_id; $i++){
                Activity::del_activity($id[$i])->update($info);
            }
        } catch(\Exception $e){
            return response()->json(['status' => 'error', 'res_desc' => '删除失败!']);
        }
        return response()->json(['status' => 'success', 'res_desc' => '删除成功!']);
    }

    // 活动-修改
    public function edit(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('activity')->with(['edit_status' => $check_info['msg_info']]);
        }
        if($request->isMethod('post')){
            $file = $request->file('activity_file');
            $imgname = '';
            if($file == ''){
                $imgname = '';
            }else{
                foreach ($file as $val){
                    // 获取文件相关信息
                    $ext = $val->getClientOriginalExtension();     // 扩展名
                    $img_type = ['jpg', 'jpeg', 'gif', 'png', 'bmp'];
                    if(in_array($ext, $img_type)){
                        $realPath = $val->getRealPath();   //临时文件的绝对路径
                        // 上传文件
                        $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                        // 使用新建的uploads本地存储空间（目录）
                        $bool = Storage::disk('uploads')->put($filename, file_get_contents($realPath));
                        if(!$bool){
                            return redirect()->action('ActivityController@index')->with(['edit_status' => '图片上传失败!']);
                        }
                        $imgname .= '/img/activity/' . $filename . ',';
                    }else{
                        return redirect()->action('ActivityController@index')->with(['edit_status' => '图片格式错误 ，只支持jpg，jpeg，gif，png，bmp 格式!']);
                    }
                }
            }
            $imgname = explode(',', $imgname);
            $up_date = [
                'a_title' => $request->activitytitle,
                'a_company_id' => $request->activity_company,
                'a_activity_type_id' => $request->activitytype,
                'a_introduction' => $request->abstract,
                'a_content_info' => $request->contents,
                'a_status' => $request->is_release,
                'a_starttime' => $request->commentdatemin,
                'a_endtime' => $request->commentdatemax,
                'a_updatetime' => date('Y-m-d H:i:s')
            ];
            $file_status = $request->file_status;
            if($file_status == 1){
                $up_date['a_image700xn'] = $imgname[0];
            }elseif($file_status == 2){
                $up_date['a_image240x130'] = $imgname[0];
                $up_date['a_image700xn'] = $imgname[1];
            }elseif($file_status == 3){
                $up_date['a_image240x130'] = $imgname[0];
            }
            try {
                Activity::edit_activity($request->id)->update($up_date);
            } catch(\Exception $e){
                return redirect()->action('ActivityController@index')->with(['edit_status' => '修改活动失败 !']);
            }
            return redirect()->action('ActivityController@index')->with(['edit_status' => '修改活动成功 !']);
        }else{
            $request_sel = [
                'a_id',
                'a_title',
                'a_activity_type_id',
                'a_company_id',
                'a_content_info',
                'a_image240x130',
                'a_image700xn',
                'a_status',
                'a_starttime',
                'a_endtime',
                'a_weights',
                'a_introduction',
                'a_page_views',
                'at_type',
                'c_name'
            ];
            $activity_info = Activity::activity_info()
                ->join('activity_type', 'a_activity_type_id', '=', 'at_id')
                ->join('company', 'a_company_id', '=', 'c_id')
                ->where('a_id', $request->id)
                ->select($request_sel)
                ->first();
            $activity_company = Company::company_info()
                ->select('c_id','c_name')
                ->get();
            $activity_type = Activity_type::type_info()
                ->select('at_id','at_type')
                ->get();
            return view('activity.edit',['activity_info'=>$activity_info, 'activity_type'=>$activity_type, 'activity_company'=>$activity_company]);
        }
    }

    // 活动-内容显示
    public function show(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('activity')->with(['edit_status' => $check_info['msg_info']]);
        }
        $request_sel = [
            'a_title',
            'a_content_info'
        ];
        $activity_info = Activity::activity_info()->where('a_id', '=', $request->id)->select($request_sel)->first();
        return view('activity.show', ['activity_info'=>$activity_info]);
    }

    // 活动-排序
    public function sotr(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('activity')->with(['edit_status' => $check_info['msg_info']]);
        }
        $sort = $request->sort;
        $type = $request->type;
        // 上移
        if($type == 1){
            if($request->com_id == 1){
                $activity_prve = Activity::activity_info()->where('a_weights', '>', $sort)->where('a_company_id', 1)->where('a_is_del', '!=', 1)->orderBy('a_weights', 'asc')->first();
            }else{
                $activity_prve = Activity::activity_info()->where('a_weights', '>', $sort)->where('a_company_id', '!=', 1)->where('a_is_del', '!=', 1)->orderBy('a_weights', 'asc')->first();
            }
            try {
                Activity::activity_info()->where('a_id', $activity_prve->a_id)->update(['a_weights'=>$sort]);
            }catch (\Exception $e){
                return response()->json(['status' => 'error', 'res_desc' => '操作失败!']);
            }
            try {
                Activity::activity_info()->where('a_id', $request->id)->update(['a_weights'=>$activity_prve->a_weights]);
            }catch (\Exception $e){
                return response()->json(['status' => 'error', 'res_desc' => '操作失败!']);
            }
            return response()->json(['status' => 'error', 'res_desc' => '操作成功!']);
        }else{
            if($request->com_id == 1){
                $activity_last = Activity::activity_info()->where('a_weights', '<', $sort)->where('a_company_id', 1)->where('a_is_del', '!=', 1)->orderBy('a_weights', 'desc')->first();
            }else{
                $activity_last = Activity::activity_info()->where('a_weights', '<', $sort)->where('a_company_id', '!=', 1)->where('a_is_del', '!=', 1)->orderBy('a_weights', 'desc')->first();
            }
            try {
                Activity::activity_info()->where('a_id', $activity_last->a_id)->update(['a_weights'=>$sort]);
            }catch (\Exception $e){
                return response()->json(['status' => 'error', 'res_desc' => '操作失败!']);
            }
            try {
                Activity::activity_info()->where('a_id', $request->id)->update(['a_weights'=>$activity_last->a_weights]);
            }catch (\Exception $e){
                return response()->json(['status' => 'error', 'res_desc' => '操作失败!']);
            }
            return response()->json(['status' => 'error', 'res_desc' => '操作成功!']);
        }
    }
}