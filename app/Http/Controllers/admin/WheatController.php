<?php
/**
 * Created by PhpStorm.
 * User: star
 * Date: 2017/9/11
 * Time: 17:27
 */

namespace App\Http\Controllers\admin;


use App\Http\Controllers\Controller;
use App\Models\wheatAttrModel;
use App\Models\WheatModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Mockery\Exception;


class WheatController extends Controller
{
    public $wheat;
    public $wheatAttr;

    public function __construct()
    {
        $this->wheat = new WheatModel();
        $this->wheatAttr = new wheatAttrModel();
    }

    public function test()
    {
        dd(DB::select('select idwheat,name from wheat where idwheat IN (select fatherid from connect where sunid = ?)', [1]));
    }


    public function add(Request $request)
    {

        $validator = Validator::make($request->all()['data'],['name'=>'bail|required','child'=>'bail|required|format','code'=>'bail|required','breeder'=>'bail|required','place'=>'bail|required','date1'=>'bail|required'],
            ['required'=>':attribute为空'],
            ['name'=>'品种名称','child'=>'子产品','code'=>'审定编号','breeder'=>'育种者','place'=>'育种地点','date1'=>'审核日期','child'=>'子产品']);

        if($validator->fails()){
            return responseToJson(500,'error',$validator->errors()->all());
        }

        DB::beginTransaction();
        try {
            $this->wheat->addWheat($request);
            $id = $this->wheat->queryId()->id;
            $this->wheatAttr->addAttr($id, $request->input('data'));
            $ids = explode(',',$request->input('data')['child']);
            $this->wheat->updateUse_times($ids,1);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return responseToJson(500, 'error', 'something was wrong');
        }

        return responseToJson(200, 'success', 'yes');
    }

    public function queryAll(Request $request){

        $id = $request->input('id');
        $data = $this->wheat->queryAll($id);

        if(sizeof($data) == 1){
            $data[0]->verify_time = date('Y-m-d',$data[0]->verify_time);
            return responseToJson(200,'success',$data);
        }else{
            return responseToJson(404,'error','not found');
        }
    }

    public function update(Request $request){
        $validator = Validator::make($request->all()['data'],['name'=>'bail|required','child'=>'bail|required|format','code'=>'bail|required','breeder'=>'bail|required','place'=>'bail|required','date1'=>'bail|required'],
            ['required'=>':attribute为空'],
            ['name'=>'品种名称','child'=>'子产品','code'=>'审定编号','breeder'=>'育种者','place'=>'育种地点','date1'=>'审核日期','child'=>'子产品']);

        if($validator->fails()){
            return responseToJson(500,'error',$validator->errors()->all());
        }

        DB::beginTransaction();
        try {
            $this->wheat->updates($request);
            $this->wheatAttr->updates($request->input('data')['id'], $request->input('data'));
            DB::commit();
        }catch(Exception $e){
            DB::rollback();
            return responseToJson(500, 'error', 'something was wrong');
        }
        return responseToJson(200, 'success', 'yes');
    }
}