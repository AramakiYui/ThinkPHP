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
            $student  = new StudentModel();
            $stu_data = $student->getDataFromSQL(session("student"));
            $time_data = $student->ListOfSubscribed(session("student"));
//            print_r($time_data);
            $this->assign("time",$time_data);
            $this->assign("stu_data",$stu_data);
            return $this->fetch();
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
    //seq
    public function subscribeTime(){
        $stu_data = Request::instance()->param();
        $subscribe = new StudentModel();
        $subscribeRes = $subscribe->subscribe($stu_data["seq"],$stu_data["stu_id"]);
        if($subscribeRes == -1){
            echo "<script>alert('预约失败')</script>";
            return $this->subscribeView();
//            $this->error("预约失败");
        }else{
            echo "<script>alert('预约成功')</script>";
            return $this->subscribeView();
//            $this->success("预约成功");
        }
    }
    public function logOff(){
        session("student",null);
        $this->success("注销成功",url("index/Index/index"));
    }
    public function managerView(){
        $student  = new StudentModel();
        $stu_data = $student->getDataFromSQL(session("student"));
        $time_data = $student->ListOfSubscribed(session("student"));
//            print_r($time_data);
        $this->assign("time",$time_data);
        $this->assign("stu_data",$stu_data);
        return $this->fetch("stu_manager");
    }
    public function subscribeView(){
        $student  = new StudentModel();
        $stu_data = $student->getDataFromSQL(session("student"));
        $time_data = $student->ListOfPublished();
//            print_r($time_data);
        $this->assign("time",$time_data);
        $this->assign("stu_data",$stu_data);
        return $this->fetch("stu_subscribe");
    }
    public function informationView(){
        $student  = new StudentModel();
        $stu_data = $student->getDataFromSQL(session("student"));
        $this->assign("stu_data",$stu_data);
        return $this->fetch("stu_information");
    }
    public function editInformation(){
        $edit = Request::instance()->post();
//        print_r($edit);
        if(session("student") != $edit["stu_id"]){
            echo "<script>alert('您无法修改别人的信息')</script>";
            return $this->informationView();
            //$this->error("您无法修改别人的信息");
        }else{
            $updateC = new StudentModel();
            $res = $updateC->editInformation($edit);
//            print_r($edit);
            if($res == 0){
                echo "<script>alert('修改失败')</script>";
                return $this->informationView();
//                $this->error("修改失败");
            }else{
                echo "<script>alert('修改成功')</script>";
                return $this->informationView();
//                $this->success("修改成功");
            }
        }
    }
    public function deleteTime(){
        $delete = Request::instance()->param();
//        print_r($delete);
        if(session("student") != $delete["stu_id"]){
            $this->error("您无法删除不由您预约的时间");
        }else{
            $deleteC = new StudentModel();
            $res = $deleteC->deleteFromSQL($delete);
            if($res == 0){
                echo "<script>alert('操作失败')</script>";
                return $this->managerView();
//                $this->error("操作失败");
            }else{
                echo "<script>alert('操作成功')</script>";
                return $this->managerView();
//                $this->success("操作成功");
            }
        }
    }
    public function searchByName(){
        $search = Request::instance()->param();
        $student = new StudentModel();
        $stu_data = $student->getDataFromSQL(session("student"));
        $dataSearched = $student->searchByName($search);
        $this->assign("time",$dataSearched);
        $this->assign("stu_data",$stu_data);
        return $this->fetch("stu_subscribe");
    }
    public function searchByTime(){
        $search = Request::instance()->param();
        if(empty($search["date"]) && empty($search["time_seg"])){
            echo "<script>alert('查询参数缺失')</script>";
            return $this->subscribeView();
        }
        $student = new StudentModel();
        $stu_data = $student->getDataFromSQL(session("student"));
        $dataSearched = $student->searchByTime($search);
        $this->assign("time",$dataSearched);
        $this->assign("stu_data",$stu_data);
        return $this->fetch("stu_subscribe");
    }
}