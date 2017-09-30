<?php
namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Excel;

class AdminController extends Controller
{
    public function get_wheat()
    {
        $result = Admin::get_wheat();
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
/*array:1 [▼
    0 => array:38 [▼
    "原名" => "开麦22"
    "品种来源每个品种之间用英文分割开" => "周麦18,百农AK58,"
    "审定年份" => Carbon {#508 ▶}
    "利用次数" => 3.0
    "审定编号" => "豫审麦2014017"
    "申请单位" => "开封市农林科学研究院"
    "育种者" => "牛本永,赵国建,宋晓,吴欣,李绍伟,"
    "生态类型" => "属半冬性中熟品种，全生育期224.3～233.7天。"
    "苗性" => "幼苗半直立，苗期叶片细长，叶色浓绿，冬季抗寒性较好；"
    "分蘖特性" => "分蘖力强，成穗率中等，春季起身慢，两极分化快，"
    "株型" => "株型松紧适中"
    "穗下节长度" => "穗下节长"
    "旗叶特征" => "旗叶略长，上举，干尖，"
    "穗层" => "穗层整齐"
    "株高" => "株高75～77cm"
    "抗倒特性" => "秆弹性较好，抗倒伏能力强"
    "穗型" => "纺锤型穗，籽粒角质，饱满度好；"
    "根系活力" => "根系活力好，叶功能期长，耐后期高温，灌浆速度快"
    "落黄" => "成熟落黄好"
    "母穗数" => "35.3～39.3"
    "穗粒数" => "32～34.0"
    "千粒重" => "43.9～48.3"
    "抗病性" => "中抗条锈病,中感叶锈病,中感白粉病,中感纹枯病,高感赤霉病,"
    "蛋白质含量" => 16.63
    "容重" => 803.0
    "湿面筋含量" => 36.2
    "降落数值" => 434.0
    "沉淀指数" => 71.0
    "吸水量" => 61.9
    "形成时间" => 4.8
    "稳定时间" => 4.2
    "弱化度" => 98.0
    "硬度" => 64.0
    "白度" => 73.3
    "出粉率" => 71.40000000000001
    "产量表现" => null
    "栽培技术要点" => null
    "审定意见" => null
    ]
]*/
    public function read_excel($filename)
    {
        $filePath = storage_path() . '/app/import/' . iconv('UTF-8', 'GBK', $filename) . '.xlsx';
        $insert = [];
        $error = [];
        $data = Excel::load($filePath)->all()->toArray();
        foreach ($data as $key => $value) {
            if ($value['原名'] != null && $value['品种来源每个品种之间用英文分割开'] != null) {
                try {
                    $insert[$key]['wheat']['name'] = $value['原名'] == null ? '' : $value['原名'];
                    $insert[$key]['wheat']['child'] = $value['品种来源每个品种之间用英文分割开'] == null ? '' : $value['品种来源每个品种之间用英文分割开'];
                    $insert[$key]['wheat']['verify_time'] = $value['审定年份'] == null ? '' : strtotime($value['审定年份']);
                    $insert[$key]['wheat']['use_times'] = $value['利用次数'] == null ? '' : $value['利用次数'];
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
                    $insert[$key]['attr']['panicle_num'] = $value['母穗数'] == null ? '' : $value['母穗数'];
                    $insert[$key]['attr']['grain_num'] = $value['穗粒数'] == null ? '' : $value['穗粒数'];
                    $insert[$key]['attr']['ths_weight'] = $value['千粒重'] == null ? '' : $value['千粒重'];
                    $insert[$key]['attr']['resistance'] = $value['抗病性'] == null ? '' : $value['抗病性'];
                    $insert[$key]['attr']['protein'] = $value['蛋白质含量'] == null ? '' : $value['蛋白质含量'];
                    $insert[$key]['attr']['volume'] = $value['容重'] == null ? '' : $value['容重'];
                    $insert[$key]['attr']['wet_gluten'] = $value['湿面筋含量'] == null ? '' : $value['湿面筋含量'];
                    $insert[$key]['attr']['fall_num'] = $value['降落数值'] == null ? '' : $value['降落数值'];
                    $insert[$key]['attr']['precipitate'] = $value['沉淀指数'] == null ? '' : $value['沉淀指数'];
                    $insert[$key]['attr']['water_uptake'] = $value['吸水量'] == null ? '' : $value['吸水量'];
                    $insert[$key]['attr']['format_time'] = $value['形成时间'] == null ? '' : $value['形成时间'];
                    $insert[$key]['attr']['steady_time'] = $value['稳定时间'] == null ? '' : $value['稳定时间'];
                    $insert[$key]['attr']['weaken'] = $value['弱化度'] == null ? '' : $value['弱化度'];
                    $insert[$key]['attr']['hardness'] = $value['硬度'] == null ? '' : $value['硬度'];
                    $insert[$key]['attr']['white'] = $value['白度'] == null ? '' : $value['白度'];
                    $insert[$key]['attr']['powder'] = $value['出粉率'] == null ? '' : $value['出粉率'];
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
        $error_data = array_merge_recursive($result['error'],$error);   //控制器中拦截的错误数据和模型层中错误数据
        $result_data['error'] = $error_data;
        $result_data['count'] = $result['count'];
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
    public function test()
    {
        $str1 = '[\u4E00-\u9FA5A-Za-z0-9()_-x/]+[,]+$';
        dump(preg_match($str1,'hell123,nihao456,(不好/123),'));
        //周麦18,百农AK58,
        //开麦22
    }
}
