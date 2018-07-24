<?php

namespace App\Http\Controllers;

use Auth;
use Log;
use Storage;
use App\Model\Power;
use Illuminate\Http\Request;

class PowerController extends Controller
{
    public function index(){
        $select_data = [
            'p_id',
            'p_name',
            'f_id'
        ];
        // 找到所有父级权限
        $power_finfo = Power::power_info()->where('f_id', 0)->select($select_data)->get();
        $p_id = '';
        foreach ($power_finfo as $f_info){
            $p_id .= $f_info['p_id'] . ',';
        }
        $p_id = explode(',', trim($p_id, ','));
        // 根据父级权限查询子权限
        $power_cinfo = Power::power_info()->whereIn('f_id', $p_id)->select($select_data)->get();
        $c_id = '';
        foreach ($power_cinfo as $c_info){
            $c_id .= $c_info['p_id'] . ',';
        }
        $c_id = explode(',', trim($c_id, ','));
        // 查询子权限下面的权限
        $power_zinfo = Power::power_info()->whereIn('f_id', $c_id)->select($select_data)->get();
        $power_new_cinfo = [];
        foreach ($power_cinfo as $value){
            foreach ($power_zinfo as $val){
                if($value['p_id'] == $val['f_id']){
                    $power_new_cinfo[$value['f_id']][$value['p_name']][] = $val;
                }
            }
        }
        foreach ($power_finfo as $value){
            foreach ($power_new_cinfo as $key => $val){
                if($value['p_id'] == $key){
                    $power_info[$value['p_name']] = $val;
                }
            }
        }
        return view('power.index', ['power_info'=>$power_info]);
    }
}