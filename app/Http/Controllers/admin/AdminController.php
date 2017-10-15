<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Excel;

class AdminController extends Controller
{
    /**
     * 查询小麦品种
     * $num 分页，每页数量向
     * $page 当前页数
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function get_wheat(Request $request)
    {
        $num = $request->num;
        $page = $request->page;
        $result = Admin::get_wheat($num,$page);
        return $result ? responseToJson(0, 'success', $result) : responseToJson(1, 'error', '未查询到结果');
    }

    public function download()
    {
        $path = storage_path() . '/app/example/example.xlsx';
        if (file_exists($path)) {
            return response()->download($path);
        }
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(Request $request)
    {
        if ($request->method('POST')) {
            $file = $request->file('file');
            if ($file->isValid()) {
                //获取原文件名
                //$originalName = $file->getClientOriginalName();
                //扩展名
                $ext = $file->getClientOriginalExtension();
                //文件类型
                //$type = $file->getClientMimeType();
                //临时绝对路径
                $realPath = $file->getRealPath();
                $filename = date('Y-m-d') . '-' . uniqid();
                $filename_suffix = $filename . '.' . $ext;

                $bool = Storage::disk('import')->put($filename_suffix, file_get_contents($realPath));
                if ($bool) {
                    //dump($filename);//2017-09-25-59c84e6fe125e.xlsx,//2017-09-25-59c8530a937c3.xls
                    $result = self::read_excel($filename);
                    return $result ? responseToJson(0, 'success', $result) : responseToJson(0, 'error', $result);
                }
            }
        }
    }

    public function read_excel($filename)
    {
        $filePath = storage_path() . '/app/import/' . iconv('UTF-8', 'GBK', $filename) . '.xlsx';
        $insert = [];
        $error = [];
        $data = Excel::load($filePath)->all()->toArray();
        foreach ($data as $key => $value) {
            if ($value['原名'] != null && $value['品种来源每个品种之间用英文分割开'] != null) {
                try {
                    $insert[$key]['wheat']['name'] = $value['原名'];
                    $insert[$key]['wheat']['child'] = $value['品种来源每个品种之间用英文分割开'];
                    $insert[$key]['wheat']['verify_time'] = $value['审定年份'] == null ? 0 : strtotime($value['审定年份']);
                    $insert[$key]['wheat']['use_times'] = $value['利用次数'] == null ? 0 : $value['利用次数'];
                    $insert[$key]['wheat']['code'] = $value['审定编号'] == null ? '' : $value['审定编号'];
                    $insert[$key]['wheat']['place'] = $value['申请单位'] == null ? '' : $value['申请单位'];
                    $insert[$key]['wheat']['breeder'] = $value['育种者'] == null ? '' : $value['育种者'];
                    $insert[$key]['wheat']['opinion'] = $value['审定意见'] == null ? '' : $value['审定意见'];

                    $insert[$key]['attr']['ecology_type'] = $value['生态类型'] == null ? '' : $value['生态类型'];
                    $insert[$key]['attr']['seed_nature'] = $value['苗性'] == null ? '' : $value['苗性'];
                    $insert[$key]['attr']['tiler_nature'] = $value['分蘖特性'] == null ? '' : $value['分蘖特性'];
                    $insert[$key]['attr']['plant_type'] = $value['株型'] == null ? '' : $value['株型'];
                    $insert[$key]['attr']['spike_length'] = $value['穗下节长度'] == null ? '' : $value['穗下节长度'];
                    $insert[$key]['attr']['leaf_nature'] = $value['旗叶特征'] == null ? '' : $value['旗叶特征'];
                    $insert[$key]['attr']['spike_layer'] = $value['穗层'] == null ? '' : $value['穗层'];
                    $insert[$key]['attr']['plant_height'] = $value['株高'] == null ? '' : $value['株高'];
                    $insert[$key]['attr']['lodging'] = $value['抗倒特性'] == null ? '' : $value['抗倒特性'];
                    $insert[$key]['attr']['panicle_type'] = $value['穗型'] == null ? '' : $value['穗型'];
                    $insert[$key]['attr']['root_activ'] = $value['根系活力'] == null ? '' : $value['根系活力'];
                    $insert[$key]['attr']['yellow'] = $value['落黄'] == null ? '' : $value['落黄'];
                    $insert[$key]['attr']['panicle_num'] = $value['亩穗数'] == null ? 0 : $value['亩穗数'];
                    $insert[$key]['attr']['grain_num'] = $value['穗粒数'] == null ? 0 : $value['穗粒数'];
                    $insert[$key]['attr']['ths_weight'] = $value['千粒重'] == null ? 0 : $value['千粒重'];
                    $insert[$key]['attr']['resistance'] = $value['抗病性'] == null ? '' : $value['抗病性'];
                    $insert[$key]['attr']['protein'] = $value['蛋白质含量'] == null ? 0 : $value['蛋白质含量'];
                    $insert[$key]['attr']['volume'] = $value['容重'] == null ? 0 : $value['容重'];
                    $insert[$key]['attr']['wet_gluten'] = $value['湿面筋含量'] == null ? 0 : $value['湿面筋含量'];
                    $insert[$key]['attr']['fall_num'] = $value['降落数值'] == null ? 0 : $value['降落数值'];
                    $insert[$key]['attr']['precipitate'] = $value['沉淀指数'] == null ? 0 : $value['沉淀指数'];
                    $insert[$key]['attr']['water_uptake'] = $value['吸水量'] == null ? 0 : $value['吸水量'];
                    $insert[$key]['attr']['format_time'] = $value['形成时间'] == null ? 0 : $value['形成时间'];
                    $insert[$key]['attr']['steady_time'] = $value['稳定时间'] == null ? 0 : $value['稳定时间'];
                    $insert[$key]['attr']['weaken'] = $value['弱化度'] == null ? 0 : $value['弱化度'];
                    $insert[$key]['attr']['hardness'] = $value['硬度'] == null ? 0 : $value['硬度'];
                    $insert[$key]['attr']['white'] = $value['白度'] == null ? 0 : $value['白度'];
                    $insert[$key]['attr']['powder'] = $value['出粉率'] == null ? 0 : $value['出粉率'];
                    $insert[$key]['attr']['yield_result'] = $value['产量表现'] == null ? '' : $value['产量表现'];
                    $insert[$key]['attr']['tech_point'] = $value['栽培技术要点'] == null ? '' : $value['栽培技术要点'];
                } catch (\Exception $e) {
                    $error[] = $value;
                }
            }else{
                $error[] = $value;
            }
        }
        $result = Admin::wheat_import($insert);
        $error_data = [];
        if($result['error'] != [] && $error !=[]){
            $error_data = array_merge_recursive($result['error'],$error);   //控制器中拦截的错误数据和模型层中错误数据
        }
        $result_data['error'] = $error_data;
        $result_data['count'] = $result['count'];   //成功导入的条数
        return $result_data;
    }

    /**
     * 查询小麦品种详情
     * @param Request $request
     * @return 查询结果
     */
    public function get_detail(Request $request)
    {
        $name = $request->name;
        $result = Admin::detail($name);
        return $result ? responseToJson(0,'success',$result) : responseToJson(1,'error','没有查询到信息');
    }

    /**
     * 搜索小麦品种
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $value = $request->value;
        $result = Admin::search($value);
        return $result ? responseToJson(0,'success',$result) : responseToJson(1,'error','没有查询结果');
    }

    /**
     * 批量删除小麦品种
     */
    public function batch_delete(Request $request)
    {
        $wheat_id = $request->id;
        $result = Admin::batch_delete($wheat_id);
        return $request ? responseToJson(0,'success','删除成功！') : responseToJson(1,'error','删除失败!');
    }
    public function test()
    {
        /*$output = exec('F:/test.py');
        dump($output);*/

    }
}
