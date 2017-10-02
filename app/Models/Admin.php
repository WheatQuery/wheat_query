<?php
namespace app\Models;

use DB;
class Admin
{
    /**
     * 查询所有小麦品种
     * @return int
     */
    public static function get_wheat($num,$page)
    {
        $result = DB::table('wheat')->offset($num)->limit($page)->get();
        $count = DB::table('wheat')->count();
        $data['wheat'] = $result;
        $data['count'] = $count;
        return !$result->isEmpty() ? $data : 0;
    }

    /**
     * 导入Excel表格
     * @param $array
     * @return mixed
     */
    public static function wheat_import($array)
    {
        $error_data = [];
        $count = 0;
        foreach ($array as $key => $value){
            DB::beginTransaction();
            try {
                $wheat_id = DB::table('wheat')->insertGetId($value['wheat']);
                if($wheat_id){
                    $value['attr']['wheat_id'] = $wheat_id;
                    $attr = DB::table('wheat_attr')->insert($value['attr']);
                    if($attr){
                        DB::commit();
                        $count++;
                    }else{
                        DB::rollback();//事务回滚
                        $error_data[] = array_merge_recursive($value['wheat'],$value['attr']);
                    }
                }else{
                    DB::rollback();//事务回滚
                    $error_data[] = array_merge_recursive($value['wheat'],$value['attr']);
                }
            }catch (\Exception $e){
                DB::rollback();//事务回滚
                $error_data[] = array_merge_recursive($value['wheat'],$value['attr']);
            }
        }
        $data['error'] = $error_data;
        $data['count'] = $count;
        return $data;
    }

    /**
     * 统计每个小麦品种被利用的次数
     *
     */
    public static function get_times()
    {
        $wheat = DB::table('wheat')->select('id','name','child')->get();
        foreach ($wheat as $key1 => $value1){
            $count = 0;
            foreach ($wheat as $key2 => $value2){
                if($value2->child != ''){
                    if(strpos($value1->name,$value2->child) !== false){
                        $count++;
                    }
                }
            }
            //统计数据中小麦品种出现的次数
            $result = DB::table('wheat')->where('id','=',$value1->id)->update(['use_times'=>$count]);
            dump($result);
        }
    }
    /**
     * 查询单个小麦品种的详情信息
     * @param $name
     * @return array|int
     */
    public static function detail($name)
    {
        $data = [];
        $wheat = DB::table('wheat')->where('name','=',$name)->first();
        if($wheat){
            $nature = DB::table('wheat_attr')->where('wheat_id','=',$wheat->id)->first();
            $data['wheat'] = $wheat;
            $data['nature'] = $nature;
            return $data;
        }else{
            return 0;
        }
    }
}