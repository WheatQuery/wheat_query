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
}