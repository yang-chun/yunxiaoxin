<?php
namespace addons\gongzicha\controller;


use addons\gongzicha\model\VoteBaoming;
use app\common\controller\Addon;
use think\Controller;

class Admin extends Addon
{
    public $adminLogin=true;//需要管理员登录才可操作本控制器
    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
        
    }

    public function index(){
        $bmModel = new VoteBaoming();
        if($keyword=input('keyword')){
            $result=$bmModel
                ->where(['mpid'=>$this->mid])
                ->where('bm_id|username','like','%'.$keyword.'%')
                ->order('vote_total DESC')
                ->paginate(20);
        }else{
            $result=$bmModel
                ->where(['mpid'=>$this->mid])
                ->order('vote_total DESC')
                ->paginate(20);
        }
        $this->assign('data',$result);
        $this->fetch();
    }

    public function details(){
        $this->fetch();
    }
    
    public function addExcel(){
        print_r(input("post."));
        if(request()->isPost()){
            $file = request()->file('file');

            // 移动到框架应用根目录/public/uploads/ 目录下
            $info = $file->move(ROOT_PATH . 'public' .DS.'uploads'. DS . 'excel');
            if($info){
                //获取文件所在目录名
                $path=ROOT_PATH . 'public' . DS.'uploads'.DS .'excel/'.$info->getSaveName();
                //加载PHPExcel类
                
                // vendor("PHPExcel.PHPExcel");
                $objReader=new \PHPExcel();
                $objPHPExcel = $objReader->load($path,$encode='utf-8');//获取excel文件
                $sheet = $objPHPExcel->getSheet(0); //激活当前的表
                $highestRow = $sheet->getHighestRow(); // 取得总行数
                $highestColumn = $sheet->getHighestColumn(); // 取得总列数
                $a=0;
                //将表格里面的数据循环到数组中
                for($i=2;$i<=$highestRow;$i++)
                {
                    //*为什么$i=2? (因为Excel表格第一行应该是姓名，年龄，班级，从第二行开始，才是我们要的数据。)
                    $data[$a]['name'] = $objPHPExcel->getActiveSheet()->getCell("A".$i)->getValue();//姓名
                    $data[$a]['age'] = $objPHPExcel->getActiveSheet()->getCell("B".$i)->getValue();//年龄
                    $data[$a]['class'] = $objPHPExcel->getActiveSheet()->getCell("C".$i)->getValue();//班级
                     // 这里的数据根据自己表格里面有多少个字段自行决定
                    $a++;
                }
 
                //往数据库添加数据
                $res = Db::name('student')->insertAll($data);
                if($res){
                        $this->success('操作成功！');
                }else{
                        $this->error('操作失败！');
                   }
            }else{
                // 上传失败获取错误信息
                $this->error($file->getError());
            }
        }



    }

    public function voteHidden(){
        $bmModel = new VoteBaoming();
        $where['bm_id']=input('id');
        $where['mpid']=$this->mid;
        $bmModel->save(['status'=>input('status')],$where);
        ajaxMsg('1','操作成功');
    }

    public function voteSetinc(){
        if(!is_numeric(input('vote'))){
            ajaxMsg('0','输入的不是数字');
        }
        $bmModel = new VoteBaoming();
        $where['bm_id']=input('id');
        $where['mpid']=$this->mid;
        $bmModel->where($where)->setInc('vote_total',input('vote'));

    }

}