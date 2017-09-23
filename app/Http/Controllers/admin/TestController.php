<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;

class TestController extends Controller
{
    public function get_wheat()
    {
        $result = Admin::get_wheat();
        /*foreach ($result as $key => $val){
            $array = explode(',',$val->child);
            for ($i = 0;$i<count($array)-1;$i++){
                dump($array[$i]);
            }
        }*/
        return $result ? responseToJson(0,'success',$result) : responseToJson(1,'error','未查询到结果');
    }
}
