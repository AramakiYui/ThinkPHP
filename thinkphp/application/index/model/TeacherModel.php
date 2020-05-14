<?php


namespace app\index\model;

use think\Db;
use think\Model;

class TeacherModel extends Model
{
//登录相关
    //获取密码的函数
    protected function getPassword($t_id){
        $password = Db::table("teacher")->where("t_id",$t_id)->value("t_password");
        if($password === null) {
            return false;
        } else {
            return $password;
        }
    }
    //密码加密函数
    protected function encryptPassword($password){
        return sha1(md5('$password').'sui_ji_shu');
    }
    //登录函数
    public function checkPassword($t_id,$t_password)
    {
        if ($this->getPassword($t_id) === $this->encryptPassword($t_password)) {
            return true;
        } else{
            return false;
        }
    }
    //获取信息
    public function getDataFromSQL($t_id){
        return Db::table("teacher")->where("t_id",$t_id)->find();
    }
//注册相关
    //注册函数
    //@param $teacher 老师的信息数组
    function register($teacher){
        if(Db::table("teacher")->where("t_id",$teacher["t_id"])->find() !== null){
            return -1;//教师用户名已存在
        }else{
            $data_ins = array(  "t_id"         =>$teacher["t_id"],
                                "t_name"       =>$teacher["t_name"],
                                "t_email"      =>$teacher["t_email"],
                                "t_sex"        =>$teacher["t_sex"],
                                "t_age"        =>$teacher["t_age"],
                                "t_phone"      =>$teacher["t_phone"]);
            $data_ins["t_password"] = $this->encryptPassword($teacher["t_password"]);
            if($teacher["t_password"] !== $teacher["t_password_again"]) return -2;//两次密码不一样
            else return Db::table("teacher")->insert($data_ins);
        }
    }
//时间表相关
    //查找操作
    public function ListOfPublished($t_id){
        return Db::table("time")->where("t_id",$t_id)->select();
    }
    public function ListOfSubscribed($t_id){
        return Db::table("subscribe")->where("t_id",$t_id)->select();
    }
    public function nameOfSubscribedStu($seq){
        return Db::table("time")->join("subscribe s","time.seq=s.seq")
                                       ->join("student stu","s.stu_id=stu.stu_id")
                                       ->value("stu_name");
    }
    //发布操作
    public function publish($time){
        $date = Db::table("time")->where("date",$time["date"])->value("date");
        $time_seg = Db::table("time")->where("time_seg",$time["time_seg"])->value("time_seg");
        $place = Db::table("time")->where("place",$time["place"])->value("place");
        $t_id = Db::table("time")->where("t_id",$time["t_id"])->value("t_id");
        if($place !== null && $date !== null && $time_seg !== null){
            return -1;//地点和已有的地点冲突
        }
        else if($t_id !== null && $date !== null && $time_seg !== null){
            return -2;//时间和自己已发布的时间有冲突
        }else{
            return Db::table("time")->insert($time);
        }
    }
    //删除操作
    public function deleteFromSQL($time){//传入由get得到的参数
        $free = Db::table("time")->where("t_id",$time["t_id"])->select("free");
        if($free == 2) return -1;
        else{
            $data_del = array("seq"    =>$time["seq"],
                              "t_id"    =>$time["t_id"]);
            return Db::table("time")->where($data_del)->delete();
        }
//            return Db::table("time")->
//            where("date=".$time["date"] . "AND t_id = ".$time["t_id"] . "AND time_seg=".$time["time_seg"])->delete();
    }
    public function editTime($edit){
        $update = array(
            "date"      =>$edit["date"],
            "time_seg"  =>$edit["time_seg"],
            "place"     =>$edit["place"],
            "t_id"      =>$edit["t_id"]
        );
        $where = array("seq"=>$edit["seq"]);
        return Db::table("time")->where($where)->update($update);
    }
    public function editInformation($edit){
        $update = array(
            "t_name"    =>$edit["t_name"],
            "t_sex"     =>$edit["t_sex"],
            "t_age"     =>$edit["t_age"],
            "t_phone"   =>$edit["t_phone"]
        );
        $where = array("t_id"=>$edit["t_id"]);
        return Db::table("teacher")->where($where)->update($update);
    }
}

//未预约0
//未完成1 没人预约过了时间
//已预约2
//已完成3