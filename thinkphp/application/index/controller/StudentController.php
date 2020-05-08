<?php


namespace app\index\controller;


use app\index\model\StudentModel;
use app\index\model\TeacherModel;
use think\Controller;
use think\Request;

class StudentController extends Controller
{
    public function index(){
        if(session("student")) {
            $this->display();
        }elseif(session("teacher")){
            $this->error("请进入教师登录入口",url("\student\index"));
        }else{
            $this->error("请先登录",url("\Login\index"));
        }
    }
    //查看老师发布的状态
    //需要的参数:
    //GET:
    //t_name：老师的名字，值为N/A表示所有老师
    //page:页数，表示当前的页面
    public function listOfTeacher(){
        $t_name = Request::instance()->get("t_name");
        $page = Request::instance()->get("page");
        $time = new StudentModel();
        $t_display = $time->scanTime($t_name,$page);
        $this->assign("t_display",$t_display);
        $this->display("/Student/listOfTeacher");
    }
    //查看自己已经订阅的时间
    public function listOfMy(){
        $myTime = new StudentModel();
        $stu_id = session("student");
        $myTimeData = $myTime->listOfMy($stu_id);
        $this->assign("myTimeData",$myTimeData);
        $this->display("/Student/listOfMy");
    }
    //订阅发布的时间表
    //需要的参数
    //GET
    //t_id,date,time_seg,
    public function subscribeTime(){
        $t_data = Request::instance()->get();
        $subscribe = new StudentModel();
        $subscribeRes = $subscribe->subscribe($t_data,session("student"));
        if($subscribeRes == -1){
            $this->error("订阅失败",url("/Student/listOfTeacher"));
        }else{
            $this->success("订阅成功",url("/Student/listOfTeacher"));
        }
    }
}