<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Role extends Model
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
    protected $table = 'role';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'r_id';

    public function scoperole_info($query){
        $query;
    }
}