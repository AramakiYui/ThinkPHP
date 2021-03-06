<?php


namespace app\index\controller;


use app\index\model\StudentModel;
use app\index\model\TeacherModel;
use think\Controller;
use think\Request;
use think\Model;
class Login extends Controller
{
    public function index()
    {
        if (session('teacher')) {
            $this->redirect('/teacher.php?c=index');
        }
        if(session("student")){
            $this->redirect('/student.php?c=index');
        }
        $this->display();
    }
//用户登录
    //输入检查函数
    public function inputCheck(){
        $post = Request::instance()->post();
        if($post["id"] == null) $this->error("用户名不能为空",url("\Login\index"));
        if($post["password"] == null) $this->error("密码不能为空",url("\Login\index"));
        return true;
    }
    public function check(){
        $this->inputCheck();
        $tLogin = Request::instance()->post('tLogin');
        if($tLogin){//老师登录
            $t_id = Request::instance()->post("id");
            $t_password = Request::instance()->post("password");
            $teacher = new TeacherModel();
            if($teacher->checkPassword($t_id,$t_password)){
                session("teacher",$t_id);
                $this->success("登录成功",url("Teacher/index"));
            }else{
                $this->error("登录失败，用户名或密码错误",url("Teacher/index"));
            }
        }else{//学生登录
            $stu_id = Request::instance()->post("id");
            $stu_password = Request::instance()->post("password");
            $student = new StudentModel();
            if($student->checkPassword($stu_id,$stu_password)){
                session("student",$stu_id);
                $this->success("登录成功",url("Student/index"));
            }else{
                $this->error("登录失败,用户名或密码错误",url("Student/index"));
            }

        }
    }
}
//login param
//post:
//tLogin :是否是教师登录
//id :登录的用户名
//password