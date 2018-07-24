<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Power extends Model
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
    protected $table = 'power';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'p_id';

    public function scopepower_info($query){
        $query;
    }
}