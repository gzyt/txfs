<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;

use think\Session;
use app\admin\controller\Base;
class Picture extends Base
{
    //图片管理界面
    public function pic_list()
    {
        return $this->view->fetch('picture/picture-list');
    }
    //图片添加界面
    public function pic_add()
    {
        return $this->view->fetch('picture/picture-add');
    }
    //图片展示界面
    public function pic_show()
    {
        return $this->view->fetch('picture/picture-show');
    }
}