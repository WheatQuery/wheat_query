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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;

class LoginController extends Controller
{

    public $user;

    public function __construct()
    {
        $this->user = new userModel();
    }

    public function logining(Request $request){

//       $validator =  Validator::make($request->all(),['phone'=>'required|email','password'=>'required'],
//           ['required'=>':attribute为空','email'=>':attribute格式错误'],
//           ['phone'=>'邮箱','password'=>'密码']);
//       if($validator->fails()){
//            return responseToJson(500,'error',$validator->errors()->all());
//       }
        if(sizeof($data=$this->user->login($request))==1){
            Session::put('name',$data->name);
            Session::put('userId',$data->id);
            Session::put('img',$data->avatar);
            Session::put('phone',$data->phone);
            return responseToJson(200,'success',1);
        }else{
            return responseToJson(404,'error',0);
        }

    }

    public function getUser(){
        try{
            return responseToJson(200,'success',['username'=>Session::get('name'),'avatar'=>Session::get('img')]);
        }catch (Exception $e){

        }
    }


    public function logout(){
        Session::flush();
        return redirect('/login');
    }

    public function repassword(Request $request){

        $validator = Validator::make($request->all()['data'],['oldPass'=>'bail|required','newPass'=>'bail|required','againPass'=>'bail|required'],
            ['required'=>':attribute为空'],
            ['oldPass'=>'密码','newPass'=>'新密码','againPass'=>'再次输入的密码']);

        if($validator->fails()){
            return responseToJson(500,'error',$validator->errors()->all());
        }

        if($request->input('data')['newPass'] != $request->input('data')['againPass']){
            return responseToJson(500,'error',["两次密码不一致"]);
        }

        $data=DB::table('user')->whereRaw('phone = ? and password = ?',[Session::get('phone'),md5($request->input('data')['newPass'])]);
        if(sizeof($data) == 1){
            $repass = DB::table('user')->where('phone',Session::get('phone'))->update(['password'=>md5($request->input('data')['newPass'])]);
            if($repass)
                return responseToJson(200,'success','ok');
            else
                return responseToJson(500,'error','no');
        }else{
            return responseToJson(500,'error','密码错误');
        }
    }

}