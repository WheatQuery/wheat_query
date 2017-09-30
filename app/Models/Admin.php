<?php
namespace app\Models;

use DB;
class Admin
{
    /**
     * 查询所有小麦品种
     * @return int
     */
    public static function get_wheat()
    {
        $result = DB::table('wheat')->get();
        return !$result->isEmpty() ? $result : 0;
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