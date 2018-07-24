<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Company_type extends Model
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
    protected $table = 'company_type';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ct_id';

    /*
     * 查询活动类型
     */
    public function scopecompany_info($query){
        $query;
    }
}