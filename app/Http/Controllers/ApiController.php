<?php

namespace App\Http\Controllers;

use Auth;
use Log;
use Redis;
use Image;
use Illuminate\Http\Request;
use App\Model\Activity;
use App\Model\Activity_type;
use App\Model\NewsInformation;
use App\Model\NewsInformation_type;
use App\Model\Company;
use App\Model\Match;
use App\Model\Domain;
use App\Model\Advertising;
use App\Model\Recommend;
use App\Model\Bulletin;
use App\Model\Rotation;
use Storage;

header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Headers:Origin, X-Requested-With, Content-Type, Accept,USER_ID,TOKEN");
header("Access-Control-Allow-Methods:HEAD, GET, POST, DELETE, PUT, OPTIONS");

class ApiController extends Controller
{

    // 活动-数据信息
    public function activity(){
        $request_sel = [
            'a_id',
            'a_title',
            'a_activity_type_id',
            'a_company_id',
            'a_image240x130',
            'a_image700xn',
            'a_status',
            'a_introduction',
            'a_content_info',
            'a_starttime',
            'a_endtime',
            'a_page_views',
            'at_type',
            'c_name'
        ];
        $time = time()+(8*60*60)-170;
        $date = date('Y-m-d H:i:s', $time);
        $other_info = Activity::activity_info()
            ->join('activity_type', 'a_activity_type_id', '=', 'at_id')
            ->join('company', 'a_company_id', '=', 'c_id')
            ->where('a_is_del', '=', 0)
            ->where('a_status', '=', 1)
            ->where('a_company_id', '!=', 1)
            ->where('a_endtime', '>', $date)
            ->select($request_sel)
            ->orderBy('a_weights','desc')
            ->orderBy('a_createtime','desc')
            ->take(15)
            ->get();
        $us_info = Activity::activity_info()
            ->join('activity_type', 'a_activity_type_id', '=', 'at_id')
            ->join('company', 'a_company_id', '=', 'c_id')
            ->where('a_is_del', '=', 0)
            ->where('a_status', '=', 1)
            ->where('a_company_id', '=', 1)
            ->where('a_endtime', '>', $date)
            ->select($request_sel)
            ->orderBy('a_weights','desc')
            ->orderBy('a_createtime','desc')
            ->take(15)
            ->get();
        $activity_info['other'] = $other_info;
        $activity_info['us'] = $us_info;
        return response()->json($activity_info);
    }

    // 活动-数据信息(活动页面)
    public function activity_all(){
        $request_sel = [
            'a_id',
            'a_title',
            'a_activity_type_id',
            'a_company_id',
            'a_image240x130',
            'a_image700xn',
            'a_status',
            'a_introduction',
            'a_content_info',
            'a_starttime',
            'a_endtime',
            'a_page_views',
            'at_type',
            'c_name'
        ];
        $time = time()+(8*60*60)-170;
        $date = date('Y-m-d H:i:s', $time);
        $activity_info = Activity::activity_info()
            ->join('activity_type', 'a_activity_type_id', '=', 'at_id')
            ->join('company', 'a_company_id', '=', 'c_id')
            ->where('a_is_del', '=', 0)
            ->where('a_status', '=', 1)
            ->where('a_endtime', '>', $date)
            ->select($request_sel)
            ->orderBy('a_weights','desc')
            ->orderBy('a_createtime','desc')
            ->paginate(14);
        return response()->json($activity_info);
    }

    // 活动-详情页
    public function activity_info(Request $request){
        $select_data = [
            'a_title',
            'a_content_info',
            'a_starttime',
            'a_endtime',
            'c_name'
        ];
        $activity_info = Activity::activity_info()
            ->join('company', 'a_company_id', '=', 'c_id')
            ->where('a_id', '=', $request->id)
            ->select($select_data)
            ->first();
        if($activity_info == null){
            return response()->json(['status'=>'error', 'content'=>'无此条信息']);
        }
        return response()->json([$activity_info]);
    }

    // 活动-点击量
    public function activity_page_view(Request $request){
        $a_page_views = Activity::activity_info()->where('a_id', '=', $request->id)->select('a_page_views')->first();
        try {
            $update_data = [
                'a_page_views' => $a_page_views->a_page_views + 1
            ];
            Activity::activity_info()->where('a_id', '=', $request->id)->update($update_data);
        } catch(\Exception $e){
            return response()->json(['status'=>'error', 'content'=>'修改浏览量失败']);
        }
        return response()->json(['status'=>'success', 'content'=>'修改浏览量成功']);
    }

    // 赛事-数据信息
    public function match(){
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
        ];
        $match_info = Match::match_info()
            ->where('m_is_del', '=', 0)
            ->select($request_sel)
            ->orderBy('m_is_top','desc')
            ->orderBy('m_sort','desc')
            ->paginate(10);
        return response()->json($match_info);
    }

    // 行业资讯-数据信息
    public function news(){
        $select_data = [
            'news.n_id',
            'news.n_title',
            'news.n_introduction',
            'news.n_image',
            'news.n_page_views',
            'news.n_news_type_id',
            'news_type.nt_type',
            'news_type.nt_pattern'
        ];

        $id = '';

        $pe_info = NewsInformation::newsinformation_info()
            ->join('news_type', 'news_type.nt_id', '=', 'news.n_news_type_id')
            ->select($select_data)
            ->where('news_type.nt_pattern', '体育')
            ->orderBy('n_createtime', 'desc')
            ->take(5)
            ->get();
        foreach ($pe_info as $pe_val){
            $id .= $pe_val['n_id'] . ',';
        }

        $rp_info = NewsInformation::newsinformation_info()
            ->join('news_type', 'news_type.nt_id', '=', 'news.n_news_type_id')
            ->select($select_data)
            ->where('news_type.nt_pattern', '真人')
            ->orderBy('n_createtime', 'desc')
            ->take(5)
            ->get();
        foreach ($rp_info as $pe_val){
            $id .= $pe_val['n_id'] . ',';
        }

        $pt_info = NewsInformation::newsinformation_info()
            ->join('news_type', 'news_type.nt_id', '=', 'news.n_news_type_id')
            ->select($select_data)
            ->where('news_type.nt_pattern', '电子')
            ->orderBy('n_createtime', 'desc')
            ->take(5)
            ->get();
        foreach ($pt_info as $pe_val){
            $id .= $pe_val['n_id'] . ',';
        }

        $id = trim($id, ',');
        $su_info = NewsInformation::newsinformation_info()
            ->join('news_type', 'news_type.nt_id', '=', 'news.n_news_type_id')
            ->select($select_data)
            ->whereNotIn('news_type.nt_pattern', [$id])
            ->orderBy('n_createtime', 'desc')
            ->take(5)
            ->get();

        $nt_new_info['real_people'] = $rp_info;
        $nt_new_info['sports'] = $pe_info;
        $nt_new_info['electronic'] = $pt_info;
        $nt_new_info['synthesis'] = $su_info;
        return response()->json($nt_new_info);
    }

    // 行业资讯-资讯内容
    public function news_info(Request $request){
        $select_data = [
            'news.n_title',
            'news.n_content_info',
            'news.n_createtime',
            'news.n_page_views',
            'company.c_name'
        ];
        $news_info = NewsInformation::newsinformation_info()
            ->join('company', 'company.c_id', '=', 'news.n_company_id')
            ->where('news.n_id', $request->id)
            ->select($select_data)
            ->first();
        if($news_info == null){
            return response()->json(['status'=>'error', 'content'=>'无此条信息']);
        }
        return response()->json([$news_info]);
    }

    // 首页 公司域名
    public function domain(){
        $select_data = [
            'domain.d_url',
            'company.c_name',
            'company.c_image163x92'
        ];
        $domain_info = Domain::domain_info()
            ->join('company', 'd_company_id', '=', 'c_id')
            ->select($select_data)
            ->where('d_default', 1)
            ->orderBy('d_weight', 'desc')
            ->orderBy('d_createtime', 'desc')
            ->take(6)
            ->get();
        return response()->json($domain_info);
    }

    // 广告位信息
    public function advertising(){
        $select_data = [
            'ad_url',
            'ad_image479x70'
        ];
        $time = time()+(8*60*60)-170;
        $date = date('Y-m-d H:i:s', $time);
        $advertising_info = Advertising::advertising_info()
            ->where('ad_starttime', '<', $date)
            ->where('ad_endtime', '>', $date)
            ->select($select_data)
            ->orderBy('ad_createtime', 'desc')
            ->orderBy('ad_weight', 'desc')
            ->take(2)
            ->get();
        return response()->json($advertising_info);
    } 
    // 公告
    public function bulletin(){
        $select_data = [
            'b_title',
            'b_content_info',
        ];
        $time = time()+(8*60*60)-170;
        $date = date('Y-m-d H:i:s', $time);
        $bulletin_info = Bulletin::bulletin_info()
                ->select($select_data)
                ->whereRaw("b_status = 1 and b_starttime < '$date' and b_endtime > '$date'")
                ->orderBy('b_createtime','desc')
                ->first();
        return response()->json($bulletin_info);
    }

    // 公告列表
    public function bulletin_all(){
        $select_data = [
            'b_title',
            'b_content_info',
            'b_createtime',
        ];
        $bulletin_info = Bulletin::bulletin_info()
            ->select($select_data)
            ->orderBy('b_createtime','desc')
            ->get();
        if($bulletin_info == ''){
            return response()->json('no data');
        }
        return response()->json($bulletin_info);
    }

    // 推荐活动
    public function recommend(){
        $select_data = [
            'r_id',
            'r_url',
            'r_img',
        ];
        $time = time()+(8*60*60)-170;
        $date = date('Y-m-d H:i:s', $time);
        $recommend_indo = Recommend::recommend_info()
            ->select($select_data)
            ->whereRaw("(r_is_show = 1 and r_end_time > '$date') or (r_is_show = 1 and r_start_time < '$date' and r_end_time > '$date')")
            ->orderBy('r_weights', 'desc')
            ->orderBy('r_createtime', 'desc')
            ->get();
        if($recommend_indo == ''){
            return response()->json('no data');
        }
        return response()->json($recommend_indo);
    }

    // 推荐活动搜索
    public function recommend_redi(Request $request){
        $time = time()+(8*60*60)-170;
        $date = date('Y-m-d H:i:s', $time);
        $recommend_info = Recommend::recommend_info()
            ->join('company', 'recommend.r_c_id', 'company.c_id')
            ->select('r_url', 'r_content','r_title','r_start_time','r_end_time','company.c_name')
            ->where('r_id', $request->id)
            ->whereRaw("(r_is_show = 1 and r_end_time > '$date') or (r_is_show = 1 and r_start_time < '$date' and r_end_time > '$date')")
            ->first();
        if($recommend_info == ''){
            return response()->json('no data');
        }
        if($recommend_info->r_url == ''){
            unset($recommend_info->r_url);
            return response()->json($recommend_info);
        }elseif($recommend_info->r_content == ''){
            unset($recommend_info->r_content);
            return response()->json($recommend_info);
        }
    }

    // 活动轮播
    public function rotation(Request $request){
        // 判断是那个页面的轮播
        $addr_id = $request->addr_id; // 1首页 2优惠活动 3行业资讯 4游戏技巧
        $time = time()+(8*60*60)-170;
        $date = date('Y-m-d H:i:s', $time);
        try{
            $rotation_info = Rotation::rotation_info()
                ->join('company', 'rotation_map.rm_c_id', 'company.c_id')
                ->select('rm_id','rm_url','rm_img','rm_title','rm_start_time','rm_end_time','company.c_name')
                ->whereRaw("rm_addr_id like '%$addr_id%' and rm_is_show = 1 and ((rm_end_time > '$date') or (rm_start_time < '$date' and rm_end_time > '$date'))")
                ->orderBy('rm_weights', 'desc')
                ->orderBy('rm_createtime', 'desc')
                ->take(4)
                ->get();
            if($rotation_info == ''){
                return response()->json(['msg' => 'no data']);
            }else{
                return response()->json([$rotation_info]);
            }
        }catch (\Exception $e){
            return response()->json(['msg' => '请求错误，请联系管理员！']);
        }
    }
}
