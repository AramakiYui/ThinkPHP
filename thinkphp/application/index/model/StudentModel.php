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
//查找操作
    public function getDataFromSQL($stu_id){
        return Db::table("student")->where("stu_id",$stu_id)->find();
    }
    public function ListOfPublished(){
        return Db::table("time")->join("teacher","time.t_id=teacher.t_id")->where("free",0)->select();
    }
    public function ListOfSubscribed($stu_id){
        return Db::table("time")->join("subscribe"," time.seq=subscribe.seq and stu_id=$stu_id")
                                       ->join("teacher"," time.t_id=teacher.t_id")
                                        ->select();
    }
    public function searchByName($search){
        $searched = "%".$search["search"]."%";
        return Db::table("teacher")
                    ->join("time","teacher.t_id=time.t_id")
                    ->where("free",0)
                    ->where("t_name","like","$searched")
                    ->select();
    }
    public function searchByTime($search){
        if(empty($search["date"])){
            return DB::table("teacher")
                        ->join("time","time.t_id=teacher.t_id")
                        ->where("free",0)
                        ->where("time_seg",$search["time_seg"])
                        ->select();
        }elseif(empty($search["time_seg"])){
            return DB::table("teacher")
                ->join("time","time.t_id=teacher.t_id")
                ->where("free",0)
                ->where("date",$search["date"])
                ->select();
        }else{
            return DB::table("teacher")
                ->join("time","time.t_id=teacher.t_id")
                ->where("free",0)
                ->where("date",$search["date"])
                ->where("time_seg",$search["time_seg"])
                ->select();
        }
    }
    //查看学生已订阅的时间
    public function ListOfMy($stu_id){
        return Db::table("subscribe")->where("stu_id",$stu_id)->find();
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
            else return Db::table("student")->insert($data_ins);
        }
    }
//预约相关
    //查看已发布的预约表
    public function scanTime($t_name,$page){
        if($t_name == "N/A"){
            return Db::table("time")->page("$page,20")->find();
        }else{
            return Db::table("time")->where("t_name",$t_name)->page("$page,20")->find();
        }
    }


    public function subscribe($seq,$stu_id){
        $t_id = Db::table("time")->where("seq",$seq)->value("t_id");
        $dataInsert = array("seq"=>"$seq","t_id"=>"$t_id","stu_id"=>"$stu_id");
        $free = array("free" => 2);
        if($seq != null && $t_id != null && $stu_id != null) {
            $res1 =  Db::table("subscribe")->insert($dataInsert);
            $res2 =  Db::table("time")->where("seq",$seq)->update($free);
            return $res1 & $res2;
        }else{
            return -1;
        }
    }
    public function editInformation($edit){
        $update = array(
            "stu_name"    =>$edit["stu_name"],
            "stu_sex"     =>$edit["stu_sex"],
            "stu_email"   =>$edit["stu_email"],
            "stu_phone"   =>$edit["stu_phone"]
        );
        $where = array("stu_id"=>$edit["stu_id"]);
        return Db::table("student")->where($where)->update($update);
    }
    public function deleteFromSQL($time){
        $delete = array(
            "seq"   =>$time["seq"],
        );
        $update = array("free"=>"0");
        $res1 = Db::table("subscribe")->where($delete)->delete();
        $res2 = Db::table("time")->where($delete)->update($update);
        return $res1 & $res2;
    }
}