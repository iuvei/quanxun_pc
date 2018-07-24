<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Match extends Model
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
    protected $table = 'match';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'm_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'm_title',
        'm_status_time',
        'm_home_team',
        'm_change',
        'm_visiting_team',
        'm_recommend',
        'm_score',
        'm_result',
        'm_sort'
    ];

    public function scopematch_info($query){
        $query;
    }

    // 删除
    public function scopedel_match($query, $request){
        $query->where('m_id', $request->id);
    }

    // 搜索
    public function scopematch_search($query, $match_name){
        $query->where('m_home_team', 'like', "%$match_name%")
            ->orwhere(function($query) use ($match_name){
                $query->where('m_visiting_team', 'like', "%$match_name%");
            })->orwhere(function($query) use ($match_name){
                $query->where('m_title', 'like', "%$match_name%");
            });
    }
}