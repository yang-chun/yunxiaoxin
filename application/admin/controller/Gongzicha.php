<?php
// +----------------------------------------------------------------------
// | [RhaPHP System] Copyright (c) 2017 http://www.rhaphp.com/
// +----------------------------------------------------------------------
// | [RhaPHP] 并不是自由软件,你可免费使用,未经许可不能去掉RhaPHP相关版权
// +----------------------------------------------------------------------
// | Author: Geeson <qimengkeji@vip.qq.com>
// +----------------------------------------------------------------------


namespace app\admin\controller;

use think\captcha\Captcha;
use think\Controller;
use think\Db;
use think\facade\Cookie;
use think\facade\Request;
use think\facade\Session;


class Gongzicha extends Controller
{
    public function index()
    {
        return view('gongzicha/index');
    }

    public function details(){
    	return view('gongzicha/details');
    }
}