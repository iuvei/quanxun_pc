<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Recommend extends Model
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
    protected $table = 'recommend';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'p_id';

    public function scoperecommend_info($query){
        $query;
    }
}