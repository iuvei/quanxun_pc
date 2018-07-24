<?php

namespace App\Http\Controllers;

use Auth;
use Log;
use Storage;
use App\Model\Domain;
use App\Model\Company;
use App\Model\Company_type;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    use \App\Http\Controllers\Handler;

    // 域名管理
    public function domain(Request $request){
        $select_data = [
            'domain.d_id',
            'domain.d_company_id',
            'domain.d_url',
            'domain.d_default',
            'domain.d_weight',
            'domain.d_createtime',
            'company.c_name'
        ];
        $domain_name = $request->domain_name;
        $company_id = $request->company_id;
        if($request->active == 'search') {
            if($request->company_id != ''){ // 如果公司id不為空
                $domain_info = Domain::domain_info()
                    ->join('company', 'd_company_id', '=', 'c_id')
                    ->where('d_company_id', $company_id)
                    ->where('d_url', 'like', "%$domain_name%")
                    ->select($select_data)
                    ->orderBy('d_weight', 'desc')
                    ->orderBy('d_createtime', 'desc')
                    ->paginate(10);
            }else{
                $domain_info = Domain::domain_info()
                    ->join('company', 'd_company_id', '=', 'c_id')
                    ->where('d_url', 'like', "%$domain_name%")
                    ->select($select_data)
                    ->orderBy('d_weight', 'desc')
                    ->orderBy('d_createtime', 'desc')
                    ->paginate(10);
            }
        }else{
            $domain_info = Domain::domain_info()
                ->join('company', 'd_company_id', '=', 'c_id')
                ->select($select_data)
                ->orderBy('d_weight', 'desc')
                ->orderBy('d_createtime', 'desc')
                ->paginate(10);
        }
        $company_info = Company::company_info()
            ->select('c_id', 'c_name')
            ->get();
        $data = [
            'domain_info' => $domain_info,
            'company_info' => $company_info,
            'company_id' => $company_id,
            'url' => $domain_name
        ];
        return view('domain.domain', $data);
    }

    // 域名批量替換（檢查域名是否存在）
    public function domain_change(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('domain')->with(['edit_status' => $check_info['msg_info']]);
        }
        if($request->active == 'search'){
            $domain_info = Domain::domain_info()
                ->join('company', 'd_company_id', '=', 'c_id')
                ->where('d_url', $request->old_url)
                ->select('d_url')
                ->first();
            if($domain_info != ''){
                return 'ok';
            }else{
                return 'no';
            }
        }else if($request->active == 'change'){
            $change_info = Domain::domain_info()
                ->where('d_url', $request->old_url)
                ->select('d_id')
                ->get();
            $d_id = '';
            foreach ($change_info as $val){
                $d_id .= $val->d_id.',';
            }
            $change_id = trim($d_id,',');
            $change_id = explode(',', $change_id);
            $count = count($change_id);
            try {
                for ($i=0; $i<$count; $i++){
                    Domain::domain_info()->where('d_id', $change_id[$i])->update(['d_url'=>$request->new_url]);
                }
            } catch(\Exception $e){
                return 'fail';
            }
            return 'success';
        }
    }

    // 域名批量删除
    public function domain_del(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('domain')->with(['edit_status' => $check_info['msg_info']]);
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
                Domain::domain_info()->where('d_id', $ids[$i])->delete();
            }
        } catch(\Exception $e){
            return response()->json(['status' => 'error', 'res_desc' => '删除失败!']);
        }
        return response()->json(['status' => 'success', 'res_desc' => '删除成功!']);
    }

    // 添加域名
    public function domain_add(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('domain')->with(['edit_status' => $check_info['msg_info']]);
        }
        if($request->isMethod('post')){
            try {
                Domain::domain_info()->insert(
                    [
                        'd_url' => $request->domain_url,
                        'd_weight' => $request->domainsort,
                        'd_company_id' => $request->domain_company,
                        'd_createtime' => date('Y-m-d H:i:s'),
                        'd_updatetime' => date('Y-m-d H:i:s'),
                        'd_default' => $request->is_default,
                    ]
                );
            } catch(\Exception $e){
                return redirect()->route('domain')->with(['edit_status' => '添加失败 !']);
            }
            return redirect()->route('domain')->with(['edit_status' => '添加成功 !']);
        }else{
            $company = Company::company_info()
                ->select('c_id', 'c_name')
                ->get();
            return view('domain.domain_add',['company'=>$company]);
        }
    }

    // 域名信息修改
    public function domain_edit(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('domain')->with(['edit_status' => $check_info['msg_info']]);
        }
        if($request->isMethod('post')){
            try {
                Domain::domain_info()
                    ->where('d_id', $request->id)
                    ->update(
                        [
                            'd_url' => $request->domain_url,
                            'd_weight' => $request->domainsort,
                            'd_company_id' => $request->domain_company,
                            'd_updatetime' => date('Y-m-d H:i:s'),
                            'd_default' => $request->is_default,
                        ]
                    );
            } catch(\Exception $e){
                return response()->json(['status' => 'error', 'res_desc' => '修改失败!']);
            }
            return response()->json(['status' => 'success', 'res_desc' => '修改成功!']);
        }else{
            $domain_info = Domain::domain_info()->where('d_id', $request->id)->first();
            $company = Company::company_info()
                ->select('c_id', 'c_name')
                ->get();
            return view('domain.domain_edit',['domain_info'=>$domain_info, 'company'=>$company]);
        }
    }
}