<?php
namespace app\Models;

use DB;
class Admin
{
    public static function get_wheat()
    {
        $result = DB::table('wheat')->get();
        return !$result->isEmpty() ? $result : 0;
    }
    public static function wheat_import($array)
    {
        $result = DB::table('wheat')->insert($array);
        return $result ? $result : 0;
    }
}