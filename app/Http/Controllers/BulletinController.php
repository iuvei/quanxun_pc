<?php

namespace App\Http\Controllers;

use Auth;
use Log;
use Illuminate\Http\Request;
use App\Model\Bulletin;
use Storage;

class BulletinController extends Controller
{
    use \App\Http\Controllers\Handler;

    public function index(Request $request){
        $select_data = [
            'b_id',
            'b_title',
            'b_content_info',
            'b_status',
            'b_starttime',
            'b_endtime',
            'b_weights'
        ];
        if(!empty($request->bulletin_name)){
            $bulletin_info = Bulletin::bulletin_info()
                ->where('b_title', 'like', "%$request->bulletin_name%")
                ->select($select_data)
                ->orderBy('b_createtime','desc')
                ->paginate(15);
        }else{
            $bulletin_info = Bulletin::bulletin_info()
                ->select($select_data)
                ->orderBy('b_createtime','desc')
                ->paginate(15);
        }
        $bulletin_count = $bulletin_info->count();
        return view('bulletin.index',['bulletin_info' => $bulletin_info, 'bulletin_count' => $bulletin_count,'bulletin_name' => $request->bulletin_name]);
    }
    public function add(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('bulletin')->with(['edit_status' => $check_info['msg_info']]);
        }
        if($request->isMethod('post')){
            $bulletin_count = Bulletin::bulletin_info()->select('b_id')->orderBy('b_id', 'desc')->first();
            try {
                Bulletin::bulletin_info()->insert(
                    [
                        'b_title' => $request->b_title,
                        'b_content_info' => $request->contents,
                        'b_createtime' => date('Y-m-d H:i:s'),
                        'b_updatetime' => date('Y-m-d H:i:s'),
                        'b_starttime' => $request->b_starttime,
                        'b_endtime' => $request->b_endtime,
                        'b_weights' => $bulletin_count['r_id'] + 1,
                        'b_status' => $request->b_status
                    ]
                );
            }catch (\Exception $e){
                echo $e->getMessage();
                return redirect()->route('bulletin')->with(['edit_status' => '新增公告失败 !']);
            }
            return redirect()->route('bulletin')->with(['edit_status' => '新增公告成功 !']);
        }else{
            $bulletin_info_count = Bulletin::bulletin_info()->count();
            return view('bulletin.add',['bulletin_info_count' => $bulletin_info_count]);
        }
    }

    public function del(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('bulletin')->with(['edit_status' => $check_info['msg_info']]);
        }
        $id = explode(',', $request->id);
        $lenth_id = count($id);
        try {
            //删除数据
            for ($i=0; $i< $lenth_id; $i++){
                Bulletin::del_bulletin($id[$i])->delete();
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
            return redirect()->route('bulletin')->with(['edit_status' => $check_info['msg_info']]);
        }
        if($request->isMethod('post')){
            $up_date = [
                'b_title' => $request->b_title,
                'b_content_info' => $request->contents,
                'b_updatetime' => date('Y-m-d H:i:s'),
                'b_starttime' => $request->b_starttime,
                'b_endtime' => $request->b_endtime,
                'b_status' => $request->b_status
            ];
            try {
                Bulletin::edit_bulletin($request->id)->update($up_date);
            } catch(\Exception $e){
                return redirect()->action('BulletinController@index')->with(['edit_status' => '修改公告失败 !']);
            }
            return redirect()->action('BulletinController@index')->with(['edit_status' => '修改公告成功 !']);
        }else{
            $request_sel = [
                'b_id',
                'b_title',
                'b_content_info',
                'b_status',
                'b_starttime',
                'b_endtime',
                'b_weights',
            ];
            $bulletin_info = Bulletin::bulletin_info()
                ->where('b_id', '=', "$request->id")
                ->select($request_sel)
                ->first();
            return view('bulletin.edit',['bulletin_info'=>$bulletin_info]);
        }
    }
     // 公告-内容显示
    public function show(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('bulletin')->with(['edit_status' => $check_info['msg_info']]);
        }
        $request_sel = [
            'b_title',
            'b_content_info'
        ];
        $bulletin_info = Bulletin::bulletin_info()->where('b_id', '=', $request->id)->select($request_sel)->first();
        return view('bulletin.show', ['bulletin_info'=>$bulletin_info]);
    }
}