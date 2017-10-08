<?php
/**
 * Created by PhpStorm.
 * User: star
 * Date: 2017/10/1
 * Time: 18:22
 */

namespace App\Http\Controllers\login;


use App\Http\Controllers\Controller;
use App\Models\userModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    public $user;

    public function __construct()
    {
        $this->user = new userModel();
    }

    public function logining(Request $request){

       $validator =  Validator::make($request->all(),['phone'=>'required|email','password'=>'required'],
           ['required'=>':attribute为空','email'=>':attribute格式错误'],
           ['phone'=>'邮箱','password'=>'密码']);
       if($validator->fails()){
            return responseToJson(500,'error',$validator->errors()->all());
       }
        if(sizeof($data=$this->user->login($request))==1){
            Session::put('name',$data->name);
            Session::put('userId',$request->input('phone'));
            return responseToJson(200,'success',1);
        }else{
            return responseToJson(404,'error',0);
        }

    }

    public function logout(){

        Session::flush();
        return redirect('/login');
    }

}