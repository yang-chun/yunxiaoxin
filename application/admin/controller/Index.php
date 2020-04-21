<?php
// +----------------------------------------------------------------------
// | [RhaPHP System] Copyright (c) 2017 http://www.rhaphp.com/
// +----------------------------------------------------------------------
// | [RhaPHP] 并不是自由软件,你可免费使用,未经许可不能去掉RhaPHP相关版权
// +----------------------------------------------------------------------
// | Author: Geeson <qimengkeji@vip.qq.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

use think\facade\Request;

class Index extends Base
{
    public function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
    }
    public function index()
    {
        $this->redirect('mp/mp/index');
    }
    public function baseSetting()
    {
        if (Request::isAjax()) {
            $wid = input('wid');
            ## 如果存在wid 则更新；否则新增
            if ($wid) {
                $data['name'] = input('name');
                $data['appid'] = input('appid');
                $data['appsecret'] = input('appsecret');
                $res = db('mp')->where('id', 1)->update($data);
                if ($res) {
                    return ['status' => 1, 'msg' => '保存成功'];
                }
            } else {
                $data['appid'] = input('appid');
                $data['appsecret'] = input('appsecret');
//                $data['admin_id'] = session('admin_id');
                $res = db('mp')->insert($data);
                if ($res) {
                    return ['status' => 1, 'msg' => '新增成功'];
                }
            }
            return ['status' => 0, 'msg' => '数据库错误'];
        }
        $info = db('mp')->where('admin_id', 1)->find();
        return view('', ['info' => $info]);
    }
}
