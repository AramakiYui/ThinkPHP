<?php


namespace app\index\model;


use think\Db;
use think\Model;

class StudentModel extends Model
{
    //获取密码的函数
    protected function getPassword($s_id){
        $password = Db::table("student")->where("stu_id",$s_id)->find();
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
        if ($this->getPassword($stu_id) === $this->encryptPassword($stu_password)) {
            return true;
        } else{
            return false;
        }
    }
    public function getDataFromSQL($stu_id){
        return Db::table("student")->where("stu_id",$stu_id)->find();
    }
//注册函数
    //@param $teacher 学生的信息数组
    function register($student){
        if(Db::table("student")->where("stu_id",$student["stu_id"])->find() !== null){
            return -1;//学生用户名已存在
        }else{
            $data_ins = array(  "stu_id"         =>$student["stu_id"],
                "stu_name"       =>$student["stu_name"],
                "stu_email"      =>$student["stu_email"],
                "stu_sex"        =>$student["stu_sex"],
                "stu_phone"      =>$student["stu_phone"]);
            $data_ins["stu_password"] = $this->encryptPassword($student["stu_password"]);
            if($student["stu_password"] !== $student["stu_password_again"]) return -2;//两次密码不一样
            $data_ins["stu_password"] = $this->encryptPassword($student["stu_password"]);
            return Db::table("student")->insert($data_ins);
        }
    }
//预约相关
    //查看已发布的预约表
    public function scanTime($t_name,$page){
        if($t_name == "N/A"){
            return Db::table("time")->page("$page,10")->find();
        }else{
            return Db::table("time")->where("t_name",$t_name)->page("$page,10")->find();
        }
    }
    //查看学生已订阅的时间
    public function ListOfMy($stu_id){
        return Db::table("subscribe")->where("stu_id",$stu_id)->find();
    }
    public function subscribe($t_data,$stu_id){
        $seq = Db::table("time")->where($t_data)->value("seq");
        $t_id = Db::table("time")->where($t_data)->value("t_id");
        $dataInsert = array("seq"=>"$seq","t_id"=>"$t_id","stu_id"=>"$stu_id");
        if($seq !== null && $t_id !== null && $stu_id !== null) {
            return Db::table("subscirbe")->insert("$dataInsert");
        }else{
            return -1;
        }
    }
}