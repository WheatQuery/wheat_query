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
        $result = DB::table('wheat')->where('is_delete',0)->offset($num)->limit($page)->get();
        $count = DB::table('wheat')->where('is_delete',0)->count();
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
        self::get_times();
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

    /**
     * 搜索小麦品种
     * @param $value
     * @return int
     */
    public static function search($value)
    {
        $result = DB::table('wheat')->where('name','like','%'.$value.'%')->orWhere('child','like','%'.$value.'%')->get();
        return !$result->isEmpty() ? $result : 0;
    }

    /**
     * 批量删除小麦
     * @param $wheat_id 小麦id数组
     * @return int
     */
    public static function batch_delete($wheat_id)
    {
        $time = time();
        $result = DB::table('wheat')->whereIn('id',$wheat_id)->update([
            'update_time'=> $time,
            'update_user_id'=>get_session_user_id(),
            'is_delete'=> 1,
            'delete_at'=>$time
        ]);
        DB::table('wheat')->whereIn('id',$wheat_id)->decrement('use_times',-1);
        return $result ? 1 : 0;
    }
}