<?php

namespace App\Http\Controllers;

use Auth;
use Log;
use Storage;
use App\Model\Domain;
use App\Model\Company;
use App\Model\Company_type;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    use \App\Http\Controllers\Handler;

    // 公司列表
    public function company(Request $request){
        $type = $request->type;
        $company_name = $request->company_name;
        $select_data = [
            'c_id',
            'c_name',
            'c_introduction',
            'c_business_type',
            'c_operatings',
            'c_license_type',
            'c_foundationtime',
            'c_scores',
            'c_image163x92',
            'c_returns',
            'c_certified',
        ];
        // 所有公司
        $company_info = Company::company_info()
            ->select($select_data)
            ->orderBy('c_createtime', 'desc')
            ->paginate(6);
        // 公司类型
        $company_type = Company_type::company_info()
            ->select('ct_id','ct_type')
            ->get();
        $data = [
            'company_info' => $company_info,
            'company_name' => $company_name,
            'company_type' => $company_type,
            'type' => $type,
        ];
        return view('company.company', $data);
    }

    // 添加公司
    public function add(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('company')->with(['edit_status' => $check_info['msg_info']]);
        }
        if($request->isMethod('post')){
            $file = $request->file('c_image163x92');
            $file_name = '';
            // 获取文件相关信息
            $ext = $file->getClientOriginalExtension();     // 扩展名
            $img_type = ['jpg', 'jpeg', 'gif', 'png', 'bmp'];
            if(in_array($ext, $img_type)){
                $realPath = $file->getRealPath();   //临时文件的绝对路径
                // 上传文件
                $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                // 使用新建的company本地存储空间（目录）
                $bool = Storage::disk('company')->put($filename, file_get_contents($realPath));
                if(!$bool){
                    return redirect()->route('company')->with(['edit_status' => '图片上传失败 !']);
                }
                $file_name .= '/img/company/' . $filename;
            }else{
                return redirect()->route('company')->with(['edit_status' => '图片格式错误 ，只支持jpg，jpeg，gif，png，bmp 格式!']);
            }
            $c_type_id = implode(',', $request->c_type_id);
            $request->c_type_id = $c_type_id;
            try {
                Company::Ins_company_info($request, $file_name);
            } catch(\Exception $e){
                return redirect()->route('company')->with(['edit_status' => '添加失败 !']);
            }
            return redirect()->route('company')->with(['edit_status' => '添加成功 !']);
        }else{
            $company_type = Company_type::company_info()->get();
            return view('company.add',['company_type'=>$company_type]);
        }
    }

    public function del(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('company')->with(['edit_status' => $check_info['msg_info']]);
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
                Company::company_info()->where('c_id', $ids[$i])->delete();
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
            return redirect()->route('company')->with(['edit_status' => $check_info['msg_info']]);
        }
        if($request->isMethod('post')){
            $file = $request->file('c_image163x92');
            $imgname = '';
            if($file == ''){
                $imgname = '';
            }else{
                // 获取文件相关信息
                $ext = $file->getClientOriginalExtension();     // 扩展名
                $img_type = ['jpg', 'jpeg', 'gif', 'png', 'bmp'];
                if(in_array($ext, $img_type)){
                    $realPath = $file->getRealPath();   //临时文件的绝对路径
                    // 上传文件
                    $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                    // 使用新建的uploads本地存储空间（目录）
                    $bool = Storage::disk('company')->put($filename, file_get_contents($realPath));
                    if(!$bool){
                        return redirect()->route('company')->with(['edit_status' => '图片上传失败 !']);
                    }
                    $imgname .= '/img/company/' . $filename;
                }else{
                    return redirect()->route('company')->with(['edit_status' => '图片格式错误 ，只支持jpg，jpeg，gif，png，bmp 格式 !']);
                }
            }
            $c_type_id = implode(',', $request->c_type_id);
            $request->c_type_id = $c_type_id;

            $update_data = [
                'c_name' => $request->c_name,
                'c_type_id' => $request->c_type_id,
                'c_introduction' => $request->c_introduction,
                'c_business_type' => $request->c_business_type,
                'c_operatings' => $request->c_operatings,
                'c_license_type' => $request->c_license_type,
                'c_foundationtime' => $request->c_foundationtime,
                'c_scores' => $request->c_scores,
                'c_image163x92' => $imgname,
                'c_returns' => $request->c_returns,
                'c_certified' => $request->c_certified,
                'c_updatetime' => date('Y-m-d H:i:s'),
            ];
            if($imgname == ''){
                unset($update_data['c_image163x92']);
            }

            try {
                Company::company_info()->where('c_id', $request->id)->update($update_data);
            } catch(\Exception $e){
                return redirect()->route('company')->with(['edit_status' => '修改失败 !']);
            }
            return redirect()->route('company')->with(['edit_status' => '修改成功 !']);
        }else{
            $id = $request->id;
            $company_info = Company::company_info()->where('c_id', $id)->first();
            $company_type = Company_type::company_info()->get();
            return view('company.edit', ['company_info' => $company_info, 'company_type'=>$company_type]);
        }
    }

    public function search(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('company')->with(['edit_status' => $check_info['msg_info']]);
        }
        $company_name = $request->company_name;
        $type = $request->company_type;
        $select_data = [
            'c_id',
            'c_name',
            'c_introduction',
            'c_business_type',
            'c_operatings',
            'c_license_type',
            'c_foundationtime',
            'c_scores',
            'c_image163x92',
            'c_returns',
            'c_certified',
        ];
        // 所有公司
        if($type!=''){
            $company_info = Company::company_info()
                ->select($select_data)
                ->where('c_type_id', 'like', "%$type%")
                ->where('c_name', 'like', "%$company_name%")
                ->orderBy('c_createtime', 'desc')
                ->paginate(6);
        }else{
            $company_info = Company::company_info()
                ->select($select_data)
                ->where('c_name', 'like', "%$company_name%")
                ->orderBy('c_createtime', 'desc')
                ->paginate(6);
        }
        // 公司类型
        $company_type = Company_type::company_info()
            ->select('ct_id','ct_type')
            ->get();
        $data = [
            'company_info' => $company_info,
            'company_name' => $company_name,
            'company_type' => $company_type,
            'type' => $type,
        ];
        return view('company.company', $data);
    }
}