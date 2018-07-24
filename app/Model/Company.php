<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Company extends Model
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
    protected $table = 'company';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'c_id';

    public function scopecompany_info($query){
        $query;
    }

    // 添加
    public function scopeIns_company_info($query, $request, $img_name){
        $query->insert([
            'c_name' => $request->c_name,
            'c_type_id' => $request->c_type_id,
            'c_introduction' => $request->c_introduction,
            'c_business_type' => $request->c_business_type,
            'c_operatings' => $request->c_operatings,
            'c_license_type' => $request->c_license_type,
            'c_foundationtime' => $request->c_foundationtime,
            'c_scores' => $request->c_scores,
            'c_image163x92' => $img_name,
            'c_returns' => $request->c_returns,
            'c_certified' => $request->c_certified,
            'c_createtime' => date('Y-m-d H:i:s'),
            'c_updatetime' => date('Y-m-d H:i:s'),
        ]);
    }
}