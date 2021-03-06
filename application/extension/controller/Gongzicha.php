<?php
// +----------------------------------------------------------------------
// | [RhaPHP System] Copyright (c) 2017 http://www.rhaphp.com/
// +----------------------------------------------------------------------
// | [RhaPHP] 并不是自由软件,你可免费使用,未经许可不能去掉RhaPHP相关版权
// +----------------------------------------------------------------------
// | Author: Geeson <qimengkeji@vip.qq.com>
// +----------------------------------------------------------------------


namespace app\extension\controller;



use think\Db;
use think\Exception;
use think\facade\Request;
use think\facade\Session;
use think\facade\Url;
use think\Validate;
use PHPExcel;

class Gongzicha extends Base
{
    protected $excel_id;
    public $excelTitle;
    public $contentList;



    public function initialize()
    {

        parent::initialize(); // TODO: Change the autogenerated stub

    }

    public function index()
    {
        $keyword = input('keyword');
         if ($keyword) {
            $idcard[] = ['idcard', 'like', "%{$keyword}%"];
            $realname[] = ['realname', 'like', "%{$keyword}%"];
        }else{
            $idcard = '';
            $realname = '';
        }
        $result = Db::name('excel_row')
            ->where('status=1')
            ->where($idcard)
            ->whereOr($realname)
            ->order('id','desc')
            ->paginate(10,false,['query' => ['keyword'=>$keyword]]
        );
        $page = $result->render();
        $this->assign('keyword',$keyword);
        $this->assign('count',$result->total());
        $this->assign('data',$result);
        $this->assign('page', $page);
        return view();
    }

    // 导入页面 弃用
    // public function import(){
    //     return view();
    // }

    // 详情页面
    public function details(){
        $id['id'] = input('get.id');
        $data = Db::name('excel_row')
        ->where($id)
        ->find();
        $info = unserialize($data['content']);
        $this->assign('list',$info);
        $this->assign('salary_final',$data['salary_final']);
        return view();
    }

    // 删除一条数据
    public function delete(){
        $id = input('post.');
        $res = Db::name('excel_row')
        ->where($id)
        ->update(
            ['status'=>'-1']
        );
        if ($res) {
            ajaxMsg(1,'删除成功!');
        }else{
            ajaxMsg(0,'删除失败!');
        }
    }

    // 上传工资表
    public function upload(){

        if ($_FILES['file']['error'] != 0) {
            ajaxMsg('0','请选择文件!');
        }
        if(request()->isPost()){
            $file = request()->file('file');
            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' .DS.'uploads'. DS . 'excel');
            if($info){
                //获取文件所在目录名
                //ROOT_PATH . 'public' . DS.'uploads'.DS .'excel/'.
                $path = $info->getSaveName();
                $excel_id = Db::name("excel")->insertGetId([
                'createtime'=> time(),
                    'path'=>$path,
                    'original_name' =>$_FILES['file']['name']
                ]);
                $complete_path = ROOT_PATH . 'public' . DS.'uploads'.DS .'excel/'.$info->getSaveName();
                //获取文件后缀
                $extension = strtolower( pathinfo($complete_path, PATHINFO_EXTENSION) );

                if ($extension =='xlsx') {
                    $objReader = new \PHPExcel_Reader_Excel2007();
                    $objExcel = $objReader ->load($complete_path);
                } else if ($extension =='xls') {
                    $objReader = new \PHPExcel_Reader_Excel5();
                    $objExcel = $objReader ->load($complete_path);
                } else if ($extension=='csv') {
                    $PHPReader = new \PHPExcel_Reader_CSV();

                    //默认输入字符集
                    $PHPReader->setInputEncoding('GBK');

                    //默认的分隔符
                    $PHPReader->setDelimiter(',');

                    //载入文件
                    $objExcel = $PHPReader->load($file);
                }else{
                    ajaxMsg('0','文件格式错误!');
                }
                $sheet = $objExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow(); // 取得总行数
                $colsNum = $sheet->getHighestColumn(); // 取得总列数
                $highestColumm = \PHPExcel_Cell::columnIndexFromString($colsNum);
                if ($highestColumm < 5) {
                    $this->error('工资表 文件少于5列');
                }

                if ($highestColumm > 60) {
                    $highestColumm = 60;
                }

                /** 循环读取每个单元格的数据 */
                $row_count = 0;
                $fail_arr = [];

                // //获取行的数组
                $column_name_arr = [];
                for ($column = 1; $column <= $highestColumm; $column++) {
                    $column_name = $sheet->getCellByColumnAndRow($column - 1, 1)->getCalculatedValue();
                    if (!empty($column_name)) {
                        $column_name_arr[$column] = $column_name;
                    } else {
                        $column_name_arr[$column] = '未知项';
                    }
                }
                // 1姓名
                // 2身份证号码
                // 3实发

                //获取行的数组 end
                for ($row = 2; $row <= $highestRow; $row++) {
                    $content = [];
                    for ($column = 1; $column <= $highestColumm; $column++) {
                        $calculatedValue = $sheet->getCellByColumnAndRow($column - 1, $row)->getCalculatedValue();
                        $content[$column_name_arr[$column]] = $calculatedValue ? $calculatedValue : '';
                    }

                    if (empty($content['身份证号码'])) {
                        $fail_arr[] = '行' . $row . ' 身份证号码缺少,请输入合法标题(身份证号码)';
                        continue;
                    }
                    if (empty($content['员工姓名'])) {
                        $fail_arr[] = '行' . $row . ' 姓名缺少,请输入合法标题(员工姓名)';
                        continue;
                    }
                    if (empty($content['实发工资'])) {
                        $fail_arr[] = '行' . $row . ' 实发缺少,请输入合法值(实发工资)';
                        continue;
                    }
 
                    DB::name('excel_cache')->insertGetId([
                        'excel_id' => $excel_id,
                        'content' => serialize($content),
                        'createtime' => time(),
                        'idcard' => $content['身份证号码'],
                        'realname' => $content['员工姓名'],
                        'salary_final' => $content['实发工资']
                    ]);
                    //新增一条工资 end
                    $row_count++;
                }
                if (count($fail_arr)>0) {
                    $msg['status'] = '-1';
                    $msg['msg'] = date('H:i:s')." 导入内部员工工资成功！新增" . $row_count . "条，失败" . count($fail_arr) . "条";
                    $msg['error'] = $fail_arr;
                    $msg['excel_id'] = $excel_id;
                    return $msg;
                }else{
                    $msg['status'] = '1';
                    $msg['msg'] = date('H:i:s')." 导入内部员工工资成功！新增" . $row_count . "条，失败" . count($fail_arr) . "条";
                    $msg['excel_id'] = $excel_id;
                    return $msg;
                }
            }
        }else{
            ajaxMsg('0','文件有误!');
        } 
    }

    // 预览数据
    public function preview(){
        $excel_id = input('get.');

        $res = Db::name('excel_cache')
        ->where($excel_id)
        ->limit(10)
        ->select();
        if (empty($res)) {
            $this->error('未找到相应数据!', 'index');
        }
        // $content = unserialize($res[0]['content']);
        $content = '';
        foreach ($res as $key => $value) {
            $content[] = unserialize($value['content']);
        }
        $this->assign('content',$content[0]);
        $this->assign('list',$content);
        $this->assign('excel_id',$excel_id['excel_id']);
        return view();

    }

    // 预览取消
    public function cancel(){
        $excel_id = input('excel_id');
        if (Db::name('excel_cache')
        ->where(array('excel_id'=>$excel_id))
        ->delete()) {
            $msg = Db::name('excel')
            ->where(array('id'=>$excel_id))
            ->delete();
            if ($msg) {
                ajaxMsg('1','已取消!');
            }
        }
    }

    // 生成工资单
    public function generate(){
        $excel_id = input('excel_id');
        $excel_name = input('excel_name');
        if (Db::name('excel')
            ->where(array('id'=>$excel_id))
            ->update(array('excel_name'=>$excel_name))) {
            $res = Db::name('excel_cache')
            ->where(array('excel_id'=>$excel_id))
            ->select();
            $error = 0;
            $errorInfo = '';
            foreach ($res as $key => $val) {
                $data['mpid'] = $this->mpid;
                $data['content'] = $val['content'];
                $data['excel_id'] = $val['excel_id'];
                $data['createtime'] = time();
                $data['idcard'] = $val['idcard'];
                $data['realname'] = $val['realname'];
                $data['salary_final'] = $val['salary_final'];
                if (!Db::name('excel_row')->insert($data)) {
                    $errorInfo = '生成失败'.$error++;
                }
            }
            if ($error>0) {
                ajaxMsg('0',$errorInfo);
            }else{
                ajaxMsg('1','生成成功!');
            }
        }else{
            ajaxMsg('0','工资名称更新失败!');
        }
    } 

    // 弃用
    // public function addExcel(){
    //     $file_name = input('post.file_name');

    //     if (empty($file_name)) {
    //         ajaxMsg('0','请输入标题!');
    //     }

    //     if ($_FILES['file']['error'] != 0) {
    //         ajaxMsg('0','请选择文件!');
    //     }
    //     if(request()->isPost()){
    //         $file = request()->file('file');

    //         // 移动到框架应用根目录/public/uploads/ 目录下
    //         $info = $file->move(ROOT_PATH . 'public' .DS.'uploads'. DS . 'excel');

    //         if($info){
    //             //获取文件所在目录名
    //             $path=ROOT_PATH . 'public' . DS.'uploads'.DS .'excel/'.$info->getSaveName();
    //             $excel_id = Db::name("excel")->insertGetId([
    //                 'fiel_name'=> $file_name,
    //                 'createtime'=> time(),
    //                 'path'=>$path
    //             ]);

    //             //获取文件后缀
    //             $extension = strtolower( pathinfo($path, PATHINFO_EXTENSION) );

    //             if ($extension =='xlsx') {
    //                 $objReader = new \PHPExcel_Reader_Excel2007();
    //                 $objExcel = $objReader ->load($path);
    //             } else if ($extension =='xls') {
    //                 $objReader = new \PHPExcel_Reader_Excel5();
    //                 $objExcel = $objReader ->load($path);
    //             } else if ($extension=='csv') {
    //                 $PHPReader = new \PHPExcel_Reader_CSV();

    //                 //默认输入字符集
    //                 $PHPReader->setInputEncoding('GBK');

    //                 //默认的分隔符
    //                 $PHPReader->setDelimiter(',');

    //                 //载入文件
    //                 $objExcel = $PHPReader->load($file);
    //             }else{
    //                 ajaxMsg('0','文件格式错误!');
    //             }
    //             $sheet = $objExcel->getSheet(0);
    //             $highestRow = $sheet->getHighestRow(); // 取得总行数
    //             $colsNum = $sheet->getHighestColumn(); // 取得总列数
    //             $highestColumm = \PHPExcel_Cell::columnIndexFromString($colsNum);
    //             if ($highestColumm < 5) {
    //                 $this->error('工资表 文件少于5列');
    //             }

    //             if ($highestColumm > 60) {
    //                 $highestColumm = 60;
    //             }

    //             /** 循环读取每个单元格的数据 */
    //             $row_count = 0;
    //             $fail_arr = [];

    //             // //获取行的数组
    //             $column_name_arr = [];
    //             for ($column = 1; $column <= $highestColumm; $column++) {
    //                 $column_name = $sheet->getCellByColumnAndRow($column - 1, 1)->getCalculatedValue();
    //                 if (!empty($column_name)) {
    //                     $column_name_arr[$column] = $column_name;
    //                 } else {
    //                     $column_name_arr[$column] = '未知项';
    //                 }
    //             }
    //             // 1姓名
    //             // 2身份证号码
    //             // 3实发

    //             //获取行的数组 end
    //             for ($row = 2; $row <= $highestRow; $row++) {
    //                 $content = [];
    //                 for ($column = 1; $column <= $highestColumm; $column++) {
    //                     $calculatedValue = $sheet->getCellByColumnAndRow($column - 1, $row)->getCalculatedValue();
    //                     $content[$column_name_arr[$column]] = $calculatedValue ? $calculatedValue : '';
    //                 }

    //                 if (empty($content['身份证号码'])) {
    //                     $fail_arr[] = '行' . $row . ' 身份证号码缺少,请输入合法标题(身份证号码)';
    //                     continue;
    //                 }
    //                 if (empty($content['员工姓名'])) {
    //                     $fail_arr[] = '行' . $row . ' 姓名缺少,请输入合法标题(员工姓名)';
    //                     continue;
    //                 }
    //                 if (empty($content['实发工资'])) {
    //                     $fail_arr[] = '行' . $row . ' 实发缺少,请输入合法值(实发工资)';
    //                     continue;
    //                 }
    //                 DB::name('excel_row')->insertGetId([
    //                     'mpid' => $this->mpid,
    //                     'realname' => $content['员工姓名'],
    //                     'idcard' => $content['身份证号码'],
    //                     'salary_final' => $content['实发工资'],
    //                     'content' => serialize($content),
    //                     'createtime' => time(),
    //                     'file_id' => $excel_id,
    //                     // 'input_user_id' => session('ADMIN_ID'),
    //                 ]);
    //                 //新增一条工资 end
    //                 $row_count++;
    //             }
    //             echo date('H:i:s'), " 导入内部员工工资成功！新增" . $row_count . "条，失败" . count($fail_arr) . "条";
    //             if (!empty($fail_arr)) {
    //                 foreach ($fail_arr as $key => $value) {
    //                     echo '<br />' . $value;
    //                 }
    //             }

    //         }else{
    //             // 上传失败获取错误信息
    //             // $this->error($file->getError());
    //         }
    //     }
    // }
}
