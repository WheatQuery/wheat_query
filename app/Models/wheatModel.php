<?php
/**
 * Created by PhpStorm.
 * User: star
 * Date: 2017/9/30
 * Time: 23:04
 */

namespace app\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class wheatModel extends Model
{

    protected $table = 'wheat';
    public $timestamps = false;
    protected $fillable = ['name', 'child', 'code', 'opinion', 'breeder', 'create_time', 'update_time', 'create_user_id', 'update_user_id', 'place', 'verify_time'];


    public function addWheat(Request $request)
    {

        $this->create(['name' => $request->input('data')['name'],
            'child' => $request->input('data')['child'],
            'code' => $request->input('data')['code'],
            'opinion' => $request->input('data')['opinion'],
            'breeder' => $request->input('data')['breeder'],
            'create_time' => time(),
            'update_time' => time(),
            'create_user_id' => Session::get('userId'),
            'update_user_id' => Session::get('userId'),
            'place' => $request->input('data')['place'],
            'verify_time' => strtotime($request->input('data')['date1'])
        ]);
    }

    public function queryId()
    {
        return $this->orderBy('id', 'desc')->get(['id'])->first();
    }

    public function queryAll($id){
        return DB::select('select * from wheat,wheat_attr where wheat.id = ? and wheat_attr.wheat_id = ?',[$id,$id]);
    }

    public function updates(Request $request){

        $this->where('id',$request->input('data')['id'])->update(['name' => $request->input('data')['name'],
            'child' => $request->input('data')['child'],
            'code' => $request->input('data')['code'],
            'opinion' => $request->input('data')['opinion'],
            'breeder' => $request->input('data')['breeder'],
            'create_time' => time(),
            'update_time' => time(),
            'create_user_id' => Session::get('userId'),
            'update_user_id' => Session::get('userId'),
            'place' => $request->input('data')['place'],
            'verify_time' => strtotime($request->input('data')['date1'])
        ]);
    }



    public function updateUse_times($ids,$isPositive){

        $this->whereIn('name',$ids)->increment('use_times',$isPositive);

    }

}