<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use DB;

class RoleUser extends Model
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
    protected $table = 'role_user';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ru_id';

    public function scoperole_user_info($query){
        $query;
    }

    public function scoperole_user_add($query, $r_id, $u_id){
        $query->insert(
            [
                'r_id' => $r_id,
                'u_id' => $u_id,
            ]
        );
    }
}