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

                $filename = date('Y-m-d') . '-' . uniqid() . '.' . $ext;

                $bool = Storage::disk('import')->put($filename, file_get_contents($realPath));
                if ($bool) {
                    //dump($filename);//2017-09-25-59c84e6fe125e.xlsx,//2017-09-25-59c8530a937c3.xls
                    $result = self::read_excel();
                    return $result ? responseToJson(0, 'success', '上传成功!') : responseToJson(0, 'error', '上传失败!');
                }
            }
        }
    }

    public function read_excel()
    {

        $filePath = storage_path() . '/app/import/' . iconv('UTF-8', 'GBK', '2017-09-25-59c8b4c0addd3') . '.xlsx';
        $insert = [];
        $data = Excel::load($filePath)->all()->toArray();
        foreach ($data as $key => $value) {
            if ($value['原名'] != null) {
                $insert[$key]['name'] = $value['原名'] == null ? '' : $value['原名'];
                $insert[$key]['child'] = $value['组合每个品种之间用英文分割开'] == null ? '' : $value['组合每个品种之间用英文分割开'];
                $insert[$key]['place'] = $value['育种单位'] == null ? '' : $value['育种单位'];
                $insert[$key]['verify_time'] = $value['审定年份'] == null ? 0 : $value['审定年份'];
                $insert[$key]['use_times'] = $value['利用次数'] == null ? 0 : $value['利用次数'];
            }
        }
        $result = Admin::wheat_import($insert);
        return $result ? $result : 0;
    }
}
