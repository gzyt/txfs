<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;

use think\Session;
use app\admin\controller\Base;
class Article extends Base
{
    //文章管理界面
    public function art_list()
    {
        return $this->view->fetch('article/article-list');
    }
    //文章添加界面
    public function art_add()
    {
        return $this->view->fetch('article/article-add');
    }
    //文章修改界面
    public function art_edit()
    {
        return $this->view->fetch('article/article-edit');
    }
}
