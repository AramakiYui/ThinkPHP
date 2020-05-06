<?php


namespace app\index\model;

use think\Db;
use think\Model;

class TeacherModel extends Model
{
//登录相关
    //获取密码的函数
    protected function getPassword($t_id){
        $password = Db::table("teacher")->where("t_id=".$t_id)->find();
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
    public function getDataFromSQL($t_id){
        return Db::table("teacher")->where("t_id=".$t_id)->find();
    }
//注册相关
    //注册函数
    //@param $teacher 老师的信息数组
    function register($teacher){
        if(Db::table("teacher")->where("t_id=".$teacher["t_id"])->find() !== null){
            return -1;//教师用户名已存在
        }else{
            $teacher["t_password"] = $this->encryptPassword($teacher["t_password"]);
            return Db::table("teacher")->insert($teacher);
        }
    }
//时间表相关
    //发布操作
    public function publish($time){
        $date = Db::table("time")->where("date=".$time["date"])->find();
        $place = Db::table("time")->where("place=".$time["place"])->find();
        $t_id = Db::table("time")->where("t_id=".$time["t_id"])->find();
        if($place){
            return -1;//地点和已有的时间冲突
        }
        else if($t_id && $date){
            return -2;//时间和自己已发布的时间有冲突
        }else{
            return Db::table("time")->insert($time);
        }
    }
    //删除操作
    public function deleteFromSQL($time){//传入由get得到的参数
        return Db::table("time")->where("date=".$time["date"] . "AND t_id = ".$time["t_id"])->delete();
    }
}