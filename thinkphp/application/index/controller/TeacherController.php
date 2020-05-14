<?php


namespace app\index\controller;


use app\index\model\TeacherModel;
use think\Controller;
use think\Request;

class TeacherController extends Controller
{
    public function index(){
        if(session("teacher")) {
            $teacher  = new TeacherModel();
            $t_data = $teacher->getDataFromSQL(session("teacher"));
            $time_data = $teacher->ListOfPublished(session("teacher"));
            for($i = 0;$i < count($time_data);$i++){
                if($time_data[$i]["free"] == 1||$time_data[$i]["free"] == 0){
                    $time_data[$i]["stu_name"] = "无";
                }else{
                    $nameSubscribed = $teacher->nameOfSubscribedStu($time_data[$i]["seq"]);
                    $time_data[$i]["stu_name"] = $nameSubscribed;
                }
            }
            $this->assign("t_data",$t_data);
            $this->assign("time",$time_data);
            return $this->fetch();
        }elseif(session("student")){
            $this->error("请进入学生登录入口",url("index\Student\index"));
        }else{
            $this->error("请先登录",url("index\index\index"));
        }
    }
    public function manager(){
        $teacher = new TeacherModel();
        $data = $teacher->ListOfPublished(session("teacher"));
        for($i = 0;$i < count($data);$i++){
            if($data[$i]["free"] == 1||$data[$i]["free"] == 0){
                $data[$i]["stu_name"] = "无";
            }else{
                $nameSubscribed = $teacher->nameOfSubscribedStu($data[$i]["seq"]);
                $data[$i]["stu_name"] = $nameSubscribed;
            }
        }
        $t_data = $teacher->getDataFromSQL(session("teacher"));
        $this->assign("t_data",$t_data);
        $this->assign("time",$data);
//        print_r($data);
        return $this->fetch("manager");
    }
    public function information(){
        $teacher = new TeacherModel();
        $t_data = $teacher->getDataFromSQL(session("teacher"));
        $this->assign("t_data",$t_data);
        return $this->fetch();
    }
    public function publishTime(){
        $time = Request::instance()->post();
        $time["t_id"] = session("teacher");

        //输入检测
        if(!empty($time["date"]) && !empty($time["place"]) && !empty($time["t_id"]) && !empty($time["class"]) && !empty($time["time_seg"])){
            $add = new TeacherModel();
            $result = $add->publish($time);
            switch($result){
//                case -1: $this->error("地点和已有的地点冲突","\index\Teacher\index"); break;
//                case -2: $this->error("时间和已发布的时间有冲突","\index\Teacher\index"); break;
//                default : $this->success("发布成功","/index/Teacher/index/");
                case -1: $this->error("地点和已有的地点冲突"); break;
                case -2: $this->error("时间和已发布的时间有冲突"); break;
                default : $this->success("发布成功");
            }
        }else{//输入有部分为空
            //print_r($time);
            $this->error("输入有误，请重新输入");
        }
    }
    //查看自己已经订阅的时间
    public function listOfPublished(){
        $myTime = new TeacherModel();
        $t_id = session("teacher");
        $published = $myTime->listOfPublished($t_id);
        if($published == 0){
            $this->error("您没有发布任何时间",url("/index/Teacher/index"));
        }
        $this->assign("myTimeData",$published);
        $this->display("/Teacher/listOfPublished");
    }
    public function deleteTime(){
//        $delete = Request::instance()->get();
        $delete = Request::instance()->param();
        print_r($delete);
        if(session("teacher") != $delete["t_id"]){
            $this->error("您无法删除不由您发布的预约");
        }else{
            $deleteC = new TeacherModel();
            $res = $deleteC->deleteFromSQL($delete);
            if($res == -1){
                $this->error("该时间段已被预约,无法删除");
            }else if($res == 0){
                $this->error("删除失败");
            }else{
                $this->success("删除成功");
            }
        }
    }
    public function editTime(){
        $edit = Request::instance()->param();
//        print_r($edit);
        if(session("teacher") != $edit["t_id"]){
            $this->error("您无法修改不由您发布的预约");
        }else{
            $updateC = new TeacherModel();
            $res = $updateC->editTime($edit);
            if($res == 0){
                $this->error("修改失败");
            }else{
                $this->success("修改成功");
            }
        }
    }
    public function editInformation(){
        $edit = Request::instance()->post();
        if(session("teacher") != $edit["t_id"]){
            $this->error("您无法修改别人的信息");
        }else{
            $updateC = new TeacherModel();
            $res = $updateC->editInformation($edit);
//            print_r($edit);
            if($res == 0){
                $this->error("修改失败");
            }else{
                $this->success("修改成功");
            }
        }
    }
}
//t_id 自己的用户名
//delete 1表示删除
//seq表示删除的编号
