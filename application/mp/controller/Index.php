<?php
// +----------------------------------------------------------------------
// | [RhaPHP System] Copyright (c) 2017 http://www.rhaphp.com/
// +----------------------------------------------------------------------
// | [RhaPHP] 并不是自由软件,你可免费使用,未经许可不能去掉RhaPHP相关版权
// +----------------------------------------------------------------------
// | Author: Geeson <qimengkeji@vip.qq.com>
// +----------------------------------------------------------------------

namespace app\mp\controller;

use app\common\model\Miniapp;
use app\common\model\Setting;
use think\Db;
use think\facade\Cache;
use think\facade\Request;
use app\admin\controller\Base;
use think\Validate;

class Index extends Base
{
    public function initialize()
    {
        return parent::initialize(); // TODO: Change the autogenerated stub
    }

    public function index()
    {
        if (empty($this->mpid) && !is_numeric($this->mpid)) {
            $this->error('参数有误');
        }
        $Mp = Db::name('mp')->where(['id' => $this->mpid])->find();
        $data['url'] = getHostDomain() . url('mp/Entr/index', ['mpid' => $this->mpid]);
        $data['valid_token'] = $Mp['valid_token'];
        $data['encodingaeskey'] = $Mp['encodingaeskey'];
        $this->assign('mp', $data);
        return view();

    }

    public function MpList()
    {
        $mpid = session('admin.mpid');
        $MpList = Db::name('mp')
            ->where(['id' => $mpid])
            ->select();
        foreach ($MpList as $key => $v) {
            $MpList[$key]['type'] = getMpType($v['type']);
        }
        $this->assign('menu_title', '公众号管理');
        $this->assign('mpList', $MpList);
        return view('mplist');
    }

    public function addMp()
    {
        $mp = Db::name('mp')->where(['admin_id' => $this->admin_id])->select();
        if (count($mp)) {
            $this->redirect('mp/index/mpList');
            return;
        }
        if (Request::isAjax()) {
            $data = input('post.');
            unset($data['image']);
            $validate = new Validate(
                [
                    'name' => 'require',
                    'appid' => 'require',
                    'appsecret' => 'require',
                    'logo' => 'require',
                    'qrcode' => 'require',
                ],
                [
                    'name.require' => '公众号名称不能为空',
                    'appid.require' => ' Appid不能为空',
                    'appsecret.require' => 'Appsecret不能为空',
                    'logo.require' => 'Logo不能为空',
                    'qrcode.require' => '二维码不能为空',
                ]
            );
            $result = $validate->check($data);

            if ($result === false) {
                ajaxMsg(0, $validate->getError());
            }

            $data['create_time'] = time();
            $data['admin_id'] = $this->admin_id;
            $data['valid_token'] = getRandChar('32');
            $data['token'] = getRandChar('32');
            $data['encodingaeskey'] = getRandChar('43');
            $mid = Db::name('mp')->insertGetId($data);
            if ($mid) {
                $setingData=[
                    'register_type'=>2,
                    'verify'=>0,
                    'up_score'=>0,
                    'up_money'=>0,
                    'keyword'=>'',
                    'picurl'=>'/public/static/images/def.jpg',
                    'ispwd'=>1,
                    'redirect_url'=>''
                ];
                $setingModel= new Setting();
                $setingModel->addSetting(['mpid' => $mid, 'name' => 'register','cate'=>'mp'], $setingData);
                ajaxMsg(1, '操作成功');
            } else {
                ajaxMsg(0, '操作失败');
            }
        }
        return view('addmp');
    }

    public function updateMp()
    {
        $mode = new \app\common\model\Mp();
        if (Request::isAjax()) {
            $data = input('post.');

            $mode->allowField(true)->save($data, ['id' => $data['id']]);
            Cache::clear();
            ajaxMsg(1, '更改成功');
        } else {
            if (!$mp = $mode->where(['id' => $this->mpid])->find()) {
                $this->error('没有此公众号');
            }

            $this->assign('mp', $mp);
            $this->assign('menu_title', '修改公众号');
            return view('updatemp');
        }
    }

    // public function delMp($id)
    // {
    //     $mode = new \app\common\model\Mp();
    //     $mode->where(['id' => $id, 'admin_id' => $this->admin_id])->delete();
    //     ajaxMsg(1, '操作成功');
    // }


    // public function addMiniapp()
    // {
    //     if (Request::isAjax()) {
    //         $data = input('post.');
    //         unset($data['image']);
    //         $validate = new Validate(
    //             [
    //                 'name' => 'require',
    //                 'appid' => 'require',
    //                 'appsecret' => 'require',
    //                 'logo' => 'require',
    //                 'qrcode' => 'require',
    //             ],
    //             [
    //                 'name.require' => '公众号名称不能为空',
    //                 'appid.require' => ' Appid不能为空',
    //                 'appsecret.require' => 'Appsecret不能为空',
    //                 'logo.require' => 'Logo不能为空',
    //                 'qrcode.require' => '二维码不能为空',
    //             ]
    //         );
    //         $result = $validate->check($data);
    //         if ($result === false) {
    //             ajaxMsg(0, $validate->getError());
    //         }
    //         $data['create_time'] = time();
    //         $data['admin_id'] = $this->admin_id;
    //         $data['token'] = getRandChar('32');
    //         $data['encodingaeskey'] = getRandChar('43');
    //         $mid = Db::name('miniapp')->insertGetId($data);
    //         if ($mid) {
    //             ajaxMsg(1, '操作成功');
    //         } else {
    //             ajaxMsg(0, '操作失败');
    //         }
    //     }
    //     $this->assign('menu_title', '小程序管理');
    //     return view('addminiapp');
    // }

    // public function upMiniapp()
    // {
    //     $id = input('id');
    //     $mode = new \app\common\model\Miniapp();
    //     if (Request::isAjax()) {
    //         $data = input('post.');
    //         unset($data['image']);
    //         $validate = new Validate(
    //             [
    //                 'name' => 'require',
    //                 'appid' => 'require',
    //                 'appsecret' => 'require',
    //                 'logo' => 'require',
    //                 'qrcode' => 'require',
    //             ],
    //             [
    //                 'name.require' => '小程序名称不能为空',
    //                 'appid.require' => ' Appid不能为空',
    //                 'appsecret.require' => 'Appsecret不能为空',
    //                 'logo.require' => 'Logo不能为空',
    //                 'qrcode.require' => '二维码不能为空',
    //             ]
    //         );
    //         $result = $validate->check($data);
    //         if ($result === false) {
    //             ajaxMsg(0, $validate->getError());
    //         }
    //         $res=$mode->save($data,['id'=>$id,'admin_id'=>$this->admin_id]);
    //         if ($res) {
    //             Cache::clear();
    //             ajaxMsg(1, '操作成功');
    //         } else {
    //             ajaxMsg(0, '数据没有发生改变');
    //         }
    //     }
    //     if (!$miniapp = $mode->where([['id', '=', $id], ['admin_id', '=', $this->admin_id]])->find()) {
    //         $this->error('没有此小程序');
    //     }
    //     $this->assign('miniapp', $miniapp);
    //     $this->assign('menu_title', '修改小程序');
    //     return view('upminiapp');
    // }

    // public function miniappLists()
    // {
    //     $where_mid=[];
    //     if($_mid=input('_mid')){
    //         $where_mid=[['a.id','=',$_mid]];
    //     }
    //     $miniappList = Db::name('miniapp')
    //         ->alias('a')
    //         ->where($where_mid)
    //         ->where(['a.admin_id' => $this->admin_id])
    //         ->join('__MINIAPP_ADDON__ b','b.addon=a.addon','LEFT')
    //         ->field('a.*,b.name as addon_name')
    //         ->paginate();
    //     $this->assign('page', $miniappList->render());
    //     $this->assign('menu_title', '小程序管理');
    //     $this->assign('miniappList', $miniappList);
    //     return view('miniapplists');
    // }
    // public function miniappSetingInfo(){
    //     $id=input('id');
    //     $mode = new \app\common\model\Miniapp();
    //     $miniapp=$mode->where([['id','=',$id],['admin_id','=',$this->admin_id]])->find();
    //     $this->assign('entrUrl',getHostDomain().'/miniprogram/'.$id);
    //     $this->assign('miniapp',$miniapp);
    //     $this->assign('host',$_SERVER['SERVER_NAME']);
    //     $this->assign('menu_title', '小程序配置信息');
    //     $this->assign('miniappApi', Request::domain() .Request::root(). '/api/' . $id. '/');
    //     return view('miniappsetinginfo');

    // }
    // public function delMiniapp()
    // {
    //     $res = Db::name('miniapp')
    //         ->where([['admin_id', '=', $this->admin_id], ['id', '=', input('id')]])->delete();
    //     if ($res) {
    //         ajaxMsg(1, '操作成功');
    //     } else {
    //         ajaxMsg(0, '操作失败');
    //     }
    // }

    public function plusApp(){
        $where=[];
        if(!empty($name=input('name'))){
            $where=[['name','like','%'.$name.'%']];
        }

        $mode = new \app\common\model\MiniappAddon();
        $result = $mode->where('status', 1)->where($where)
        ->paginate(15);
        $this->assign('page',$result->render());
        $this->assign('addons', $result);
        return view('plusapp');

    }
    public function toPlusApp(){
        if(Request::isAjax()){
            $model = new Miniapp();
            $model->save(['addon'=>input('name')],['id'=>input('mid')]);
            Cache::clear();
            ajaxMsg(1,'操作成功');
        }
    }
}


