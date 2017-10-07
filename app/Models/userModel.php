<?php
/**
 * Created by PhpStorm.
 * User: star
 * Date: 2017/10/1
 * Time: 18:24
 */

namespace App\Models;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class userModel extends Model
{

    protected $table = 'user';

    public function login(Request $request){

       return $this->whereRaw('phone = ? and password = ?',[$request->input('phone'),md5($request->input('password'))])->first();
    }
}