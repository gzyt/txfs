<?php
namespace app\admin\controller;

use app\admin\controller\Base;
class Index extends Base
{
    //加载首页模板
    public function index()
    {
        $this->isLogin();
        return $this->fetch('index'); //渲染首页模板
    }
}


