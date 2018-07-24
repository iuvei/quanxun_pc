<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;


class NewsInformation extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'news';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'n_id';

    public function scopenewsinformation_info($query){
        $query;
    }

    /**
     * 新增活动
     */
    public function scopeins_newsinformation($query, $request, $img_name){
        $tools = [
                'n_title' => $request->newstitle,
                'n_company_id' => $request->company_type,
                'n_news_type_id' => $request->newstype,
                'n_introduction' => $request->abstract,
                'n_content_info' => $request->contents,
                'n_image' => $img_name,
                'n_status' => $request->is_release,
//                'n_starttime' => $request->commentdatemin,
//                'n_endtime' => $request->commentdatemax,
                'n_createtime' => date('Y-m-d H:i:s'),
                'n_updatetime' => date('Y-m-d H:i:s'),
                'n_weights' => $request->new_weights,
            ];
        $query->insert($tools);
    }

    /**
     *  活动-删除
     */
    public function scopedel_newsinformation($query, $id){
        $query->where('n_id', $id);
    }

    /**
     * 活动-修改
     */
    public function scopeedit_newsinformation($query, $id){
        $query->where('n_id', $id);
    }
    
}