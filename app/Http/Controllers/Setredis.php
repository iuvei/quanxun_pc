<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Redis;


class Setredis extends Command 
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'redis:send';
 
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '这是同步page_view到mysql的命令.';

     public function __construct(){
        parent::__construct();
        $redis = new redis();
        $redis->connect('127.0.0.1', 6379);
    }

    public function handle(){
        $keys = $redis->keys('activity_click_*');
        foreach ($keys as $key) {
            $id = substr($key,15);
            $click = $redis->get($key);
            $page_view = Activity::activity_info()->where('a_id', '=', $id)->select('a_page_views')->first();
            $up_date = [
                'a_page_views' => $page_view->a_page_views+1,
            ];
            // 修改数据浏览量
            Activity::activity_info()->where('a_id', '=', $id)->update($up_date);
            }
        try {
            // Delete clicks in redis
            $redis->delete($keys);            
        } catch(\Exception $e){
            echo  response()->json(['status'=>'error', 'content'=>'删除浏览量失败']);
        }
        return response()->json(['status'=>'success', 'content'=>'删除浏览量成功']);
    }    
}