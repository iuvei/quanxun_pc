<?php

namespace App\Http\Controllers;

use Auth;
use Log;
use Image;
use Illuminate\Http\Request;
use App\Model\NewsInformation;
use App\Model\NewsInformation_type;
use App\Model\Company;
use Storage;

class NewsInformationController extends Controller
{
    use \App\Http\Controllers\Handler;

    public function index(Request $request){
        $request_sel = [
            'n_id',
            'n_title',
            'n_news_type_id',
            'n_company_id',
            'n_image',
            'n_status',
            'n_page_views',
            'nt_type',
            'nt_pattern',
            'c_name'
        ];
        if(!empty($request->news_type)){
            $newsinformation_info = NewsInformation::newsinformation_info()
                ->join('news_type', 'n_news_type_id', '=', 'nt_id')
                ->join('company', 'n_company_id', '=', 'c_id')
                ->where('n_is_del', '=', 0)
                ->where('n_title', 'like', "%$request->newsinformation_name%")
                ->where('nt_type', '=', "$request->news_type")
                ->select($request_sel)
                ->orderBy('n_createtime','desc')
                ->paginate(6);
        }else if($request->newsinformation_name && empty($request->news_type)){
            $newsinformation_info = NewsInformation::newsinformation_info()
                ->join('news_type', 'n_news_type_id', '=', 'nt_id')
                ->join('company', 'n_company_id', '=', 'c_id')
                ->where('n_is_del', '=', 0)
                ->where('n_title', 'like', "%$request->newsinformation_name%")
                ->select($request_sel)
                ->orderBy('n_createtime','desc')
                ->paginate(6);
        }else{
            $newsinformation_info = NewsInformation::newsinformation_info()
                ->join('news_type', 'n_news_type_id', '=', 'nt_id')
                ->join('company', 'n_company_id', '=', 'c_id')
                ->where('n_is_del', '=', 0)
                ->select($request_sel)
                ->orderBy('n_createtime','desc')
                ->paginate(6);
        }
        $newsinformation_type  = NewsInformation_type::type_info()
            ->select('nt_id','nt_type')
            ->groupBy('nt_type')
            ->get();
        $newsinformation_count = $newsinformation_info->count();
        $data = [
            'news_info' => $newsinformation_info,
            'nt_info' => $newsinformation_type,
            'news_count' => $newsinformation_count,
            'news_name' => $request->newsinformation_name,
            'news_type' => $request->news_type
        ];
        return view('newsinformation.index', $data);
    }
    public function add(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('newsinformation')->with(['edit_status' => $check_info['msg_info']]);
        }
        if($request->isMethod('post')){
            $news_info = NewsInformation::newsinformation_info()->select('n_id')->orderBy('n_id', 'desc')->first();
            if($news_info == ''){
                $request->new_weights = $news_info->n_id = 0;
            }else{
                $request->new_weights = $news_info->n_id + 1;
            }
            $file = $request->file('news_file');
            // 获取文件相关信息
            $ext = $file->getClientOriginalExtension();     // 扩展名
            $img_type = ['jpg', 'jpeg', 'gif', 'png', 'bmp'];
            if(in_array($ext, $img_type)) {
                $realPath = $file->getRealPath();   //临时文件的绝对路径
                // 上传文件
                $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                // 使用新建的uploads本地存储空间（目录）
                $bool = Storage::disk('newsinformation')->put($filename, file_get_contents($realPath));
            }else{
                return redirect()->route('newsinformation')->with(['status' => '图片格式错误 ，只支持jpg，jpeg，gif，png，bmp 格式 !']);
            }
            if(!$bool){
                return redirect()->route('newsinformation')->with(['status' => '图片上传失败 !']);
            }else{
                $file_url = '/img/newsinformation/' . $filename;
                //根据 newstype 和 newspattern 查找 n_news_type_id
                $news_type = NewsInformation_type::type_info()
					->where('nt_type', $request->newstype)
					->where('nt_pattern', $request->newspattern)
					->select('nt_id')
					->first();
				if (!$news_type) { 
					return redirect()->action('NewsInformationController@add')->with(['status' => '没有匹配的新闻类型 !']); 
				}
				$request->newstype = $news_type->nt_id;
                try {
                    //将数据插入表
                    NewsInformation::ins_newsinformation($request, $file_url);                    
                } catch(\Exception $e){
                    return redirect()->route('newsinformation')->with(['status' => '新增咨询失败 !']);
                }
				return redirect()->route('newsinformation')->with(['status' => '新增咨询成功 !']);
            }
        }elseif(!empty($request->newstype)){
            $newsinformation_pattern = NewsInformation_type::type_info()
                ->select('nt_pattern')
                ->where('nt_type', '=', $request->newstype)
                ->get();
                return $newsinformation_pattern;
        }else{
            $company_type = Company::company_info()
                            ->select('c_id','c_name')
                            ->get();
            $newsinformation_type = NewsInformation_type::type_info()
                ->select('nt_id','nt_type')
                ->groupBy('nt_type')
                ->get();            
            return view('newsinformation.add',['company_type'=>$company_type,'newsinformation_type'=>$newsinformation_type]);
        }
    }

    public function del(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('newsinformation')->with(['edit_status' => $check_info['msg_info']]);
        }
        $info = [
            'n_is_del' => 1
        ];
        $id = explode(',', $request->id);
        $lenth_id = count($id);
        try {
            //删除数据
            for ($i=0; $i< $lenth_id; $i++){
                NewsInformation::del_newsinformation($id[$i])->update($info);
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
            return redirect()->route('newsinformation')->with(['edit_status' => $check_info['msg_info']]);
        }
        if($request->isMethod('post')){
            $file = $request->file('news_file');
            if(!$file){// 获取文件相关信息
                $imgname = '';
            }else{
                $ext = $file->getClientOriginalExtension();     // 扩展名
                $realPath = $file->getRealPath();   //临时文件的绝对路径
                // 上传文件
                $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $ext;
                // 使用新建的uploads本地存储空间（目录）
                $bool = Storage::disk('newsinformation')->put($filename, file_get_contents($realPath));
                if(!$bool){
                    return response()->json(['status' => 'error', 'res_desc' => '图片上传失败!']);
                }
                $imgname = '/img/newsinformation/' . $filename;
            }
            $up_date = [
                'n_title' => $request->newstitle,
                'n_company_id' => $request->news_company,
                'n_news_type_id' => $request->newstype,
                'n_introduction' => $request->abstract,
                'n_content_info' => $request->contents,
                'n_image' => $imgname,
                'n_status' => $request->is_release,
                'n_updatetime' => date('Y-m-d H:i:s')
            ];
            if($imgname == ''){
                unset($up_date['n_image']);
            }
            //根据 newstype 和 newspattern 查找 n_news_type_id
			$news_type = NewsInformation_type::type_info()
				->where('nt_type', $request->newstype)
				->where('nt_pattern', $request->newspattern)
				->select('nt_id')
				->first();
			$up_date['n_news_type_id'] = $news_type->nt_id;
            try {
                NewsInformation::edit_newsinformation($request->id)->update($up_date);
            } catch(\Exception $e){
                return redirect()->action('NewsInformationController@index')->with(['edit_status' => '修改资讯失败 !']);
            }
            return redirect()->action('NewsInformationController@index')->with(['edit_status' => '修改资讯成功 !']);
        }elseif(!empty($request->newstype)){
            $newsinformation_pattern = NewsInformation_type::type_info()
                ->select('nt_pattern')
                ->where('nt_type', '=', "$request->newstype")
                ->get();
                return $newsinformation_pattern;
        }else{
            $request_sel = [
                'n_id',
                'n_title',
                'n_news_type_id',
                'n_company_id',
                'n_content_info',
                'n_image',
                'n_status',
                'n_weights',
                'n_introduction',
                'n_page_views',
                'nt_type',
                'nt_pattern',
                'c_name'
            ];
            $newsinformation_info = NewsInformation::newsinformation_info()
                ->join('news_type', 'n_news_type_id', '=', 'nt_id')
                ->join('company', 'n_company_id', '=', 'c_id')
                ->where('n_id', '=', "$request->id")
                ->select($request_sel)
                ->first();
            $company_type = Company::company_info()
                ->select('c_id','c_name')
                ->get();
            $newsinformation_type = NewsInformation_type::type_info()
                ->select('nt_id','nt_type')                
                ->groupBy('nt_type')
                ->get();
            $newsinformation_pattern = NewsInformation_type::type_info()
                ->select('nt_id','nt_pattern')
                ->where('nt_type', '=', "$newsinformation_info->nt_type")
                ->groupBy('nt_pattern')
                ->get();
				$data = [
					'newsinformation_info'=>$newsinformation_info, 
					'company_type'=>$company_type, 
					'newsinformation_type'=>$newsinformation_type, 
					'newsinformation_pattern'=>$newsinformation_pattern
				];
            return view('newsinformation.edit', $data);
        }
    }
     // 资讯-内容显示
    public function show(Request $request){
        // 检查权限
        $check_info = $this->ChcekUser_Power($request);
        $check_info = json_decode($check_info,1);
        if($check_info['msg'] == 'Fail'){
            return redirect()->route('newsinformation')->with(['edit_status' => $check_info['msg_info']]);
        }
        $request_sel = [
            'n_title',
            'n_content_info'
        ];
        $newsinformation_info = NewsInformation::newsinformation_info()->where('n_id', '=', $request->id)->select($request_sel)->first();
        return view('newsinformation.show', ['newsinformation_info'=>$newsinformation_info]);
    }
}