<?php

namespace App\Http\Controllers;

use Auth;
use Log;
use Storage;
use Illuminate\Http\Request;
use App\Model\Match;

class MatchController  extends Controller
{
    use \App\Http\Controllers\Handler;

    // 赛事数据显示-搜索
    public function index(Request $request){
        $request_sel = [
            'm_id',
            'm_title',
            'm_status_time',
            'm_home_team',
            'm_change',
            'm_visiting_team',
            'm_recommend',
            'm_score',
            'm_result',
            'm_sort',
            'm_is_top'
        ];
        if($request->match_name){
            $match_info_count = Match::match_search($request->match_name)
                ->select($request_sel)
                ->where('m_is_del', '=', 0)
                ->orderBy('m_is_top','desc')
                ->orderBy('m_sort','desc')
                ->count();

            $match_info = Match::match_search($request->match_name)
                ->select($request_sel)
                ->where('m_is_del', '=', 0)
                ->orderBy('m_is_top','desc')
                ->orderBy('m_sort','desc')
                ->paginate(15);
        }else{
            $match_info_count = Match::match_info()
                ->select($request_sel)
                ->where('m_is_del', '=', 0)
                ->orderBy('m_is_top','desc')
                ->orderBy('m_sort','desc')
                ->count();

            $match_info = Match::match_info()
                ->select($request_sel)
                ->where('m_is_del', '=', 0)
                ->orderBy('m_is_top','desc')
                ->orderBy('m_sort','desc')
                ->paginate(15);
        }
        $match_count = $match_info->count();
        return view('match.index', ['match_info'=>$match_info, 'match_count'=>$match_count, 'match_name'=>$request->match_name, 'match_info_count'=>$match_info_count]);
    }

    // 赛事添加
    public function add(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->action('MatchController@index')->with(['edit_status' => $check_info['msg_info']]);
        }
        if($request->isMethod('post')){
            $match = new Match;
            $match->fill($request->all());
            $status = $match->save();
            if($status){
                return redirect()->action('MatchController@add')->with(['edit_status' => '新增赛事信息成功 !']);
            }else{
                return redirect()->action('MatchController@add')->with(['edit_status' => '新增赛事信息失败 !']);
            }
        }else{
            $match_info_count = Match::match_info()->count();
            return view('match.add',['match_info_count' => $match_info_count]);
        }
    }

    // 赛事删除
    public function del(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->action('MatchController@index')->with(['edit_status' => $check_info['msg_info']]);
        }
        $info = [
            'm_is_del' => 1
        ];
        try {
            //删除数据
            Match::del_match($request)->update($info);
        } catch(\Exception $e){
            return response()->json(['status' => 'error', 'res_desc' => '删除失败!']);
        }
        return response()->json(['status' => 'success', 'res_desc' => '删除成功!']);
    }

    // 赛事修改
    public function edit(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->action('MatchController@index')->with(['edit_status' => $check_info['msg_info']]);
        }
        if($request->isMethod('post')){
            $update_data = [
                'm_id' => $request->m_id,
                'm_title' => $request->m_title,
                'm_status_time' => $request->m_status_time,
                'm_home_team' => $request->m_home_team,
                'm_change' => $request->m_change,
                'm_visiting_team' => $request->m_visiting_team,
                'm_recommend' => $request->m_recommend,
                'm_score' => $request->m_score,
                'm_result' => $request->m_result,
                'm_is_top' => $request->m_is_top,
            ];
            try {
                Match::match_info()->where('m_id', $request->m_id)->update($update_data);
            } catch(\Exception $e){
                return redirect()->action('MatchController@index')->with(['edit_status' => '修改赛事失败 !']);
            }
            return redirect()->action('MatchController@index')->with(['edit_status' => '修改赛事成功 !']);
        }else{
            $select_data = [
                'm_id',
                'm_title',
                'm_status_time',
                'm_home_team',
                'm_change',
                'm_visiting_team',
                'm_recommend',
                'm_score',
                'm_result',
                'm_is_top'
            ];
            $match_info = Match::match_info()->where('m_id', $request->id)->select($select_data)->first();
            return view('match.edit', ['match_info'=>$match_info]);
        }
    }

    // 赛事置顶
    public function is_top(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->action('MatchController@index')->with(['edit_status' => $check_info['msg_info']]);
        }
        $info = [
            'm_is_top' => $request->type
        ];
        try {
            // 置顶数据
            Match::del_match($request)->update($info);
        } catch(\Exception $e){
            return response()->json(['status' => 'error', 'res_desc' => '置顶失败!']);
        }
        return response()->json(['status' => 'success', 'res_desc' => '置顶成功!']);
    }

    // 赛事 上移/下移
    public function move(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->action('MatchController@index')->with(['edit_status' => $check_info['msg_info']]);
        }
        if($request->type == 1){
            $info = [
                'm_sort' => $request->sort + 1
            ];
        }else{
            $info = [
                'm_sort' => $request->sort - 1
            ];
        }
        try {
            Match::match_info()->where('m_id', $request->id)->update($info);
        } catch(\Exception $e){
            return response()->json(['status' => 'error', 'res_desc' => '操作失败!']);
        }
        return response()->json(['status' => 'success', 'res_desc' => '操作成功!']);
    }
}