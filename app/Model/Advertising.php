<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Advertising extends Model
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
    protected $table = 'advertisement';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ad_id';

    public function scopeadvertising_info($query){
        $query;
    }

    public function scopeins_advertising($query, $request, $img_name){
        $query->insert(
            [
                'ad_company_id' => $request->advertising_company,
                'ad_url' => $request->advertising_url,
                'ad_image479x70' => $img_name,
                'ad_status' => $request->is_release,
                'ad_starttime' => $request->commentdatemin,
                'ad_endtime' => $request->commentdatemax,
                'ad_createtime' => date('Y-m-d H:i:s'),
                'ad_updatetime' => date('Y-m-d H:i:s'),
                'ad_weight' => $request->weigth,
            ]
        );
    }
}