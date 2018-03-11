<?php
namespace app\admin\model;
use think\Model;
use traits\model\SoftDelete;
class User extends Model{

    //使用软删除
    use SoftDelete;
    protected $deleteTime = 'delete_time';
    
    // 保存自动完成列表
    protected $auto = [
        'delete_time' => NULL
    ];
    // 更新自动完成列表
    protected $update = [];
    // 是否需要自动写入时间戳 如果设置为字符串 则表示时间字段的类型
    protected $autoWriteTimestamp = true; //自动写入
    // 更新时间字段
    protected $updateTime = 'update_time';
    // 时间字段取出后的默认时间格式
    protected $dateFormat = 'Y年m月d日';
    //数据表中角色字段:role返回值处理
    public function getRoleAttr($value)
    {
        $role = [
            0=>'管理员',
            1=> '超级管理员'
        ];
        return $role[$value];
    }
    
    //状态字段:status返回值处理
    public function getStatusAttr($value)
    {
        $status = [
            0=>'已停用',
            1=> '已启用'
        ];
        return $status[$value];
    }
    //密码修改器
    public function setPasswordAttr($value)
    {
        return md5($value);
    }
    //登录时间获取器
    public function setLast_dateAttr($value)
    {
        return date('Y/m/d H:i',$value);
    }
}