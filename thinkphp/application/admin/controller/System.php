<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;

use think\Session;
use app\admin\controller\Base;
class System extends Base
{
    //系统设置界面
    public function sys_base()
    {
        return $this->view->fetch('system/system-base');
    }
    //栏目管理界面
    public function sys_category()
    {
        return $this->view->fetch('system/system-category');
    }
    //栏目管理界面
    public function sys_category_add()
    {
        return $this->view->fetch('system/system-category-add');
    }
    //数据字典界面
    public function sys_data()
    {
        return $this->view->fetch('system/system-data');
    }
    //屏蔽词界面
    public function sys_shielding()
    {
        return $this->view->fetch('system/system-shielding');
    }
    //系统日志界面
    public function sys_log()
    {
        return $this->view->fetch('system/system-log');
    }
}