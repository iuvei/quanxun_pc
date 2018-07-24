<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Domain extends Model
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
    protected $table = 'domain';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'd_id';

    /*
     * 查询活动类型
     */
    public function scopedomain_info($query){
        $query;
    }
}