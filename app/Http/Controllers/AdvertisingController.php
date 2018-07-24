<?php

namespace App\Http\Controllers;

use Auth;
use Log;
use Image;
use Storage;
use Illuminate\Http\Request;
use App\Model\Company;
use App\Model\Advertising;

class AdvertisingController extends Controller
{
    use \App\Http\Controllers\Handler;

    public function index(Request $request){
        $request_sel = [
            'advertisement.ad_id',
            'advertisement.ad_company_id',
            'advertisement.ad_url',
            'advertisement.ad_image479x70',
            'advertisement.ad_status',
            'advertisement.ad_starttime',
            'advertisement.ad_endtime',
            'advertisement.ad_weight',
            'company.c_name'
        ];
        $advertising_info = Advertising::advertising_info()
            ->join('company', 'advertisement.ad_company_id', '=', 'company.c_id')
            ->select($request_sel)
            ->orderBy('advertisement.ad_createtime', 'desc')
            ->orderBy('advertisement.ad_weight', 'desc')
            ->paginate(6);
        $advertising_count = $advertising_info->count();
        return view('advertising.index',['advertising_info'=>$advertising_info, 'advertising_count'=>$advertising_count]);
    }

    public function add(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('advertising')->with(['edit_status' => $check_info['msg_info']]);
        }
        if($request->isMethod('post')){
            $file = $request->file('advertising_file');
            // 获取文件相关信息
            $ext = $file->getClientOriginalExtension();     // 扩展名
            $img_type = ['jpg', 'jpeg', 'gif', 'png', 'bmp'];
            if(in_array($ext, $img_type)){
                $realPath = $file->getRealPath();   //临时文件的绝对路径
                // 上传文件
                $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                // 使用新建的uploads本地存储空间（目录）
                $bool = Storage::disk('advertising')->put($filename, file_get_contents($realPath));
                if(!$bool){
                    return redirect()->route('advertising')->with(['status' => '图片上传失败 !']);
                }
                $file_url = '/img/advertising/' . $filename;
            }else{
                return redirect()->route('advertising')->with(['edit_status' => '图片格式错误 ，只支持jpg，jpeg，gif，png，bmp 格式!']);
            }
            try {
                //将数据插入表
                Advertising::ins_advertising($request, $file_url);
            } catch(\Exception $e){
                return redirect()->route('advertising')->with(['edit_status' => '新增广告失败 !']);
            }
            return redirect()->route('advertising')->with(['edit_status' => '新增广告成功 !']);
        }else{
            $company = Company::company_info()
                ->select('c_id','c_name')
                ->get();
            return view('advertising.add', ['company'=>$company]);
        }
    }

    public function del(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('advertising')->with(['edit_status' => $check_info['msg_info']]);
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
            for ($i=0; $i<$lenth_id; $i++){
                Advertising::advertising_info()->where('ad_id', $ids[$i])->delete();
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
            return redirect()->route('advertising')->with(['edit_status' => $check_info['msg_info']]);
        }
        if($request->isMethod('post')){
            $file = $request->file('advertising_file');
            if($file == ''){
                $file_url = '';
            }else{
                // 获取文件相关信息
                $ext = $file->getClientOriginalExtension();     // 扩展名
                $img_type = ['jpg', 'jpeg', 'gif', 'png', 'bmp'];
                if(in_array($ext, $img_type)){
                    $realPath = $file->getRealPath();   //临时文件的绝对路径
                    // 上传文件
                    $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                    // 使用新建的uploads本地存储空间（目录）
                    $bool = Storage::disk('advertising')->put($filename, file_get_contents($realPath));
                    if(!$bool){
                        return redirect()->route('advertising')->with(['edit_status' => '图片上传失败!']);
                    }
                    $file_url = '/img/advertising/' . $filename;
                }else{
                    return redirect()->route('advertising')->with(['edit_status' => '图片格式错误 ，只支持jpg，jpeg，gif，png，bmp 格式 !']);
                }
            }
            $update_data = [
                'ad_company_id' => $request->advertising_company,
                'ad_url' => $request->advertising_url,
                'ad_image479x70' => $file_url,
                'ad_status' => $request->is_release,
                'ad_starttime' => $request->commentdatemin,
                'ad_endtime' => $request->commentdatemax,
                'ad_updatetime' => date('Y-m-d H:i:s'),
                'ad_weight' => $request->weigth,
            ];
            if($file_url == ''){
                unset($update_data['ad_image479x70']);
            }
            try {
                Advertising::advertising_info()->where('ad_id', $request->id)->update($update_data);
            } catch(\Exception $e){
                return redirect()->route('advertising')->with(['edit_status' => '修改活动失败 !']);
            }
            return redirect()->route('advertising')->with(['edit_status' => '修改活动成功 !']);
        }else{
            $id = $request->id;
            $advertising_info = Advertising::advertising_info()->where('ad_id', $id)->first();
            $company = Company::company_info()
                ->select('c_id','c_name')
                ->get();
            return view('advertising.edit', ['advertising_info'=>$advertising_info, 'company'=>$company]);
        }
    }
}