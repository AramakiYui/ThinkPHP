<?php


namespace app\index\model;

use think\Db;
use think\Model;

class Teacher extends Model
{
//登录相关
    //获取密码的函数
    protected function getPassword($t_id){
        $password = Db::table("teacher")->where("t_id",$t_id)->find();
        if($password === null) {
            return false;
        } else {
            return $password['t_password'];
        }
    }
    //密码加密函数
    protected function encryptPassword($password){
        return sha1(md5('$password').'sui_ji_shu');
    }
    //登录函数
    public function checkPassword($t_id,$t_password)
    {
        if ($this->getPassword($t_id) === $t_password) {
            return true;
        } else{
            return false;
        }
    }
    //获取信息
    public function getdata($t_id){
        return Db::table("teacher")->where("t_id",$t_id)->find();
    }
//注册相关
    //注册函数
    //@param $teacher 老师的信息数组
    function register($teacher){
        if(Db::table("teacher")->where("t_id",$teacher["t_id"])->find() !== null){
            return -1;//教师用户名已存在
        }else{
            $teacher["t_password"] = $this->encryptPassword($teacher["t_password"]);
            return Db::table("teacher")->insert($teacher);
        }
    }

}