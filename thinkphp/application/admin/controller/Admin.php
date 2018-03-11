<?php
namespace app\admin\controller;

use app\admin\controller\Base;
use think\Request;
use app\admin\model\User;
use think\Session;
use think\Db;

class Admin extends Base
{
  //加载管理员模板
    public function adminList()
    {
        $this->view->assign('count',User::count());//查询user表内所有数据个数
        
        //判断当前是不是admin用户
        //先通过session获取到用户登陆名
        $userName = Session::get('user_info.user_name');
        if ($userName == 'admin') {
            $list = User::all();  //admin用户可以查看所有记录,数据要经过模型获取器处理
        } else {
            //为了共用列表模板,使用了all(),其实这里用get()符合逻辑,但有时也要变通
            //非admin只能看自己信息,数据要经过模型获取器处理
            $list = User::all(['user_name'=>$userName]);
        }
        
        
        $this -> view -> assign('list', $list);
        return $this->fetch('admin/admin_list'); //渲染管理员模板
    }
    //加载管理员角色模板
    public function adminRole()
    {
        return $this->fetch('admin/admin-role'); //渲染管理员角色模板
    }
    //加载管理员权限模板
    public function adminPermission()
    {
        return $this->fetch('admin/admin-permission'); //渲染管理员权限模板
    }
    //添加管理员
    public function adminAdd()
    {
        return $this->fetch('admin/admin-add'); //渲染管理员添加模板
    }
    //添加操作
    public function addUser(Request $request)
    {
        $data = $request -> param();
        $status = 1;
        $message = '添加成功';
        //验证规则
        $rule = [
            'adminName|用户名' =>'require',  //用户名不能为空
            'password|密码' =>'require',  //密码不能为空
            'email|邮箱' =>'require|email'   //验证码不能为空
        ];
        //自定义验证失败的提示信息
        $msg = [
            'adminName' =>['require'=>'用户名不能为空!'],
            'password' =>['require'=>'密码不能为空!'],
            'email' =>[
                'require'=>'邮箱不能为空!',
                'email' => '请输入正确的邮箱!'
            ]
        ];
        //登录验证
        $result = $this->validate($data,$rule,$msg);
    
        if ($result===true)
        {
            if (User::get(['user_name'=> $data['adminName']])) {
                //如果在表中查询到该用户名
                $status = 0;
                $message = '用户名重复,请重新输入~~';
            }else if (User::get(['user_email'=> $data['email']])) {
                //查询表中找到了该邮箱,修改返回值
                $status = 0;
                $message = '邮箱重复,请重新输入~~';
            }else {
                //添加管理员
                $users=[
                    'user_name'=>$data['adminName'],
                    'user_password'=>md5($data['password']),
                    'user_email'=>$data['email'],
                    'reg_date'=>date('Y-m-d'),
                    'last_date'=>'null',
                    'role'=>$data['adminRole'],
                    'status'=>$data['adminStatus'],
                    'user_count'=>'0',
                ];
                Db::name('user')->insert($users);
                if ($users === null) {
                    $status = 0;
                    $message = '添加失败~~';
                }
            }
        }
        return ['status'=>$status, 'message'=>$message,'data'=>$data];
    }
    //管理员状态变更
    public function setStatus(Request $request)
    {
        $user_id = $request -> param('user_id');
        $result = User::get($user_id);
        if($result->getData('status') == 1) {
            User::update(['status'=>0],['user_id'=>$user_id]);
        } else {
            User::update(['status'=>1],['user_id'=>$user_id]);
        }
    }
    
    //修改管理员信息
    public function adminEdit(Request $request)
    {
        $user_id = $request -> param('user_id');
        $result = User::get($user_id);
        $info = Db::table('user')->where('user_id',$user_id)->find();
        $this->view->assign('title','编辑管理员信息');
        $this->view->assign('keywords','Tp-zxing');
        $this->view->assign('desc','内容管理系统');
        $this->view->assign('user_info',$info);
        return $this->fetch('admin/admin_edit'); //渲染管理员添加模板
    }
    
    //更新数据操作
    public function editUser(Request $request)
    {
        //获取表单返回的数据
        $data = $request -> param();
        
        $user = new User();
        //更新数据
        $result=$user->save([
            'user_name'=>$data['name'],
            'user_password'=>$data['password'],
            'user_email'=>$data['email'],
            'status'=>$data['status'],
            'role'=>$data['role']
        ],['user_id'=>$data['id']]);
        //检测数据更新是否成功
        if (true == $result) {
            return ['status'=>1, 'message'=>'修改成功'];
        } else {
            return ['status'=>0, 'message'=>'修改失败,请检查'];
        }
    }
    
    //删除操作
    public function deleteUser(Request $request)
    {
        $id = $request -> param('user_id');
        Db::table('user')->where('user_id',$id)->update(['delete_time'=>date('Y-m-d')]);
        User::destroy($id);
    
    }
    //批量删除
    public function datadel(Request $request){
        $data[] = $request -> param();
        for($i=0;$i<sizeof($data);$i++){
            Db::table('user')->where('user_id',$data[$i])->update(['delete_time'=>date('Y-m-d')]);
            User::destroy($data[$i]);
        }
        return ['message'=>'删除成功','status'=>'1','data'=>$data];
            
    }
    //恢复删除操作
    public function unDelete()
    {
        Db::table('user')->where('user_id','>',0)->update(['delete_time'=>NULL]); 
    }
}