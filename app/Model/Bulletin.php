<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class bulletin extends Model
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
    protected $table = 'bulletin';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'b_id';

    public function scopebulletin_info($query){
        $query;
    }

    /**
     *  公告-删除
     */
    public function scopedel_bulletin($query, $id){
        $query->where('b_id', $id);
    }

    /**
     * 公告-修改
     */
    public function scopeedit_bulletin($query, $id){
        $query->where('b_id', $id);
    }
}