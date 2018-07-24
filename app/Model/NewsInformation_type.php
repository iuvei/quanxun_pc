<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class NewsInformation_type extends Model
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
    protected $table = 'news_type';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'nt_id';

    /*
     * 查询活动
     */
    public function scopetype_info($query){
        $query;
    }
}