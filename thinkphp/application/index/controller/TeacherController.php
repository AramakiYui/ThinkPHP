<?php


namespace app\index\controller;


use app\index\model\TeacherModel;
use think\Controller;
use think\Request;

class TeacherController extends Controller
{
    public function index(){
        if(session("teacher")) {
            $this->display();
        }elseif(session("student")){
            $this->error("请进入学生登录入口",url("\student\index"));
        }else{
            $this->error("请先登录",url("\Login\index"));
        }
    }
    public function publishTime(){
        $time = Request::instance()->post();
        //输入检测
        if(isset($time["date"]) && isset($time["place"]) && isset($time["t_id"]) && isset($time["class"])){
            $add = new TeacherModel();
            $result = $add->publish($time);
            switch($result){
                case -1: $this->error("地点和已有的地点冲突",url("\TeacherController\index")); break;
                case -2: $this->error("时间和已发布的时间有冲突",url("\TeacherController\index")); break;
                default : $this->success("发布成功");
            }
        }else{//输入有部分为空
            $this->error("输入有误，请重新输入",url("\TeacherController\index"));
        }
    }
    //查看自己已经订阅的时间
    public function listOfPublished(){
        $myTime = new TeacherModel();
        $t_id = session("teacher");
        $published = $myTime->listOfPublished($t_id);
        if($published == 0){
            $this->error("您没有发布任何时间",url("/Teacher/index"));
        }
        $this->assign("myTimeData",$published);
        $this->display("/Teacher/listofPublished");
    }
    public function deleteTime(){
        $delete = Request::instance()->get();
        if(session("teacher") != $delete["t_id"]){
            $this->error("您无法删除不由您发布的预约",url("\TeacherController\index"));
        }elseif(isset($delete["date"])){
            $this->error("删除错误：缺少正确的参数",url("\TeacherController\index"));
        }else{
            $deleteC = new TeacherModel();
            $res = $deleteC->deleteFromSQL($delete);
            if($res == -1){
                $this->error("该时间段已被预约,无法删除",url("\TeacherController\index"));
            }else if($res == 0){
                $this->error("删除失败",url("\TeacherController\index"));
            }else{
                $this->success("删除成功");
            }
        }
    }
}
//t_id 自己的用户名
//delete 1表示删除
//data 要删除的日期
//time_seg 要删除的时间段
//Gittestttttttt
//gitttttt
