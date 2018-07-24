<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class RolePower extends Model
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
    protected $table = 'role_power';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'rp_id';

    public function scoperole_power_info($query){
        $query;
    }
}