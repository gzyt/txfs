<?php
namespace app\admin\controller;

use think\Controller;
use think\Session;
class Base extends Controller
{
    protected function _initialize(){
        parent::_initialize();  //继承父类中的初始化操作
        define('user_id', Session::get('user_id'));
    }
    
    //检测用户是否登录
    protected function isLogin(){
        if(empty(user_id)){
            $this->error('用户未登录，请登录后再访问',url('login/login'));
        }
    }
    
    //检测用户是否重复登录
    
    protected function alreadLogin()
    {
        if(!empty(user_id)){
            $this->error('用户已经登录，请勿重复登录',url('index/index'));
        }
    }
}
