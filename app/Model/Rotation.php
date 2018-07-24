<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Rotation extends Model
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
    protected $table = 'rotation_map';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'rm_id';

    public function scoperotation_info($query){
        $query;
    }
}