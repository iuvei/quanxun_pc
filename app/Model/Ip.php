<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class Ip extends Model
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
    protected $table = 'ip';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'i_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'i_ip',
        'i_info'
    ];

    /*
     * 限制访问ip
     */
    public function scopeip_info($query){
        $query;
    }
}