<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;

use think\Session;
use app\admin\controller\Base;
class Product extends Base
{
    //产品管理列表界面
    public function pro_list()
    {
        return $this->view->fetch('product/product-list');
    }
    //产品添加界面
    public function pro_add()
    {
        return $this->view->fetch('product-add');
    }
    //产品分类界面
    public function pro_category()
    {
        return $this->view->fetch('product/product-category');
    }
    //产品分类界面
    public function pro_category_add()
    {
        return $this->view->fetch('product/product-category-add');
    }
    //品牌管理界面
    public function pro_brand()
    {
        return $this->view->fetch('product/product-brand');
    }
}
