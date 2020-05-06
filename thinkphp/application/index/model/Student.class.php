<?php


namespace app\index\model;


use think\Db;

class Student
{
    //获取密码的函数
    protected function getPassword($t_id){
        $password = Db::table("student")->where("stu_id",$t_id)->find();
        if($password === null) {
            return false;
        } else {
            return $password['stu_password'];
        }
    }
    //密码加密函数
    protected function encryptPassword($password){
        return sha1(md5('$password').'sui_ji_shu');
    }
    //登录函数
    public function checkPassword($stu_id,$stu_password)
    {
        if ($this->getPassword($stu_id) === $stu_password) {
            return true;
        } else{
            return false;
        }
    }
    public function getdata($stu_id){
        return Db::table("student")->where("stu_id",$stu_id)->find();
    }
//注册函数
    //@param $teacher 学生的信息数组
    function register($student){
        if(Db::table("student")->where("stu_id",$student["stu_id"])->find() !== null){
            return -1;//学生用户名已存在
        }else{
            $student["stu_password"] = $this->encryptPassword($student["stu_password"]);
            return Db::table("teacher")->insert($student);
        }
    }
}