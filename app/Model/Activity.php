<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Activity extends Model
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
    protected $table = 'activity';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'a_id';

    public function scopeactivity_info($query){
        $query;
    }

    /**
     * 活动-新增
     */
    public function scopeins_activity($query, $request, $img_name240, $img_name700){
        $query->insert(
            [
                'a_title' => $request->activitytitle,
                'a_company_id' => $request->activity_company,
                'a_activity_type_id' => $request->activitytype,
                'a_introduction' => $request->abstract,
                'a_content_info' => $request->contents,
                'a_image240x130' => $img_name240,
                'a_image700xn' => $img_name700,
                'a_status' => $request->is_release,
                'a_starttime' => $request->commentdatemin,
                'a_endtime' => $request->commentdatemax,
                'a_createtime' => date('Y-m-d H:i:s'),
                'a_updatetime' => date('Y-m-d H:i:s'),
                'a_weights' => $request->activitysort
            ]
        );
    }

    /**
     *  活动-删除
     */
    public function scopedel_activity($query, $id){
        $query->where('a_id', $id);
    }

    /**
     * 活动-修改
     */
    public function scopeedit_activity($query, $id){
        $query->where('a_id', $id);
    }
}