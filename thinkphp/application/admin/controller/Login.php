<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\model\User;
use think\Session;
use app\admin\controller\Base;
class Login extends Base
{
    //登录界面
    public function Login()
    {
        $this->alreadLogin();//检测用户是否重复登录
        return $this->view->fetch('index');
        
    }
    
    
    //登录验证
    public function checkLogin(Request $request){
        //初始化返回参数
        $status = 0;    //当前状态
        $result = '';   //提示信息
        $data = $request-> param(); //返回数据
        
        //验证规则
        
       $rule = [
           'username|用户名' =>'require',  //用户名不能为空
           'password|密码' =>'require',  //密码不能为空
           'verify|验证码' =>'require|captcha'   //验证码不能为空
       ];
       
       //自定义验证失败的提示信息
       $msg = [
           'username' =>['require'=>'用户名不能为空!'],
           'password' =>['require'=>'密码不能为空!'],
           'verify' =>[
               'require'=>'验证码不能为空!',
               'captcha' => '验证码错误!'
           ]
       ];
       //登录验证
       $result = $this->validate($data,$rule,$msg);
       
       //验证数据
       if($result === true){
           //查询数据
           $maps=[
               'user_name' => $data['username'],
               'user_password' => $data['password']
           ]; 
           //查询用户信息
           $user = User::get($maps);
           if($user==null){
               $result = "用户不存在";
           }else {
               $status = 1;
               $result= "登录成功";
               
               //设置用户登录信息
               Session::set('user_id',$user->user_id);//获取用户id
               Session::set('user_info',$user->getData());//获取用户所有信息
               
               //更新用户登录次数:自增1
               $user -> setInc('user_count');
           }
       }
        return ['status'=>$status,'message'=>$result,'data'=>$data];
    }
    
    //注销登录
    public function logout(){
        
        //更新最新登录时间
        User::update(['last_date'=>time()],['user_id'=> Session::get('user_id')]);
        Session::delete('user_id');
        Session::delete('user_info');
        $this->success("请稍后，正在返回登录界面",'login/login');
    }
    
    
}
