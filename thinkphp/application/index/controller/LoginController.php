<?php


namespace app\index\controller;


use app\index\model\StudentModel;
use app\index\model\TeacherModel;
use think\Controller;
use think\Db;
use think\Request;
class LoginController extends IndexController
{
    public function index()
    {
        if (session('teacher')) {
            $this->redirect('/teacher.php?c=index');
        }
        if(session("student")){
            $this->redirect('/student.php?c=index');
        }
        return $this->fetch();
    }
//用户登录
    //输入检查函数
    public function inputCheck(){
        $post = Request::instance()->post();
        if($post["id"] == null) $this->error("用户名不能为空",url("\Index\index"));
        if($post["password"] == null) $this->error("密码不能为空",url("\Index\index"));
        return true;
    }

    public function Time_update()
    {
        $now_time = date("y-m-d");
        foreach(Db::table("time")->select() as $db)
        {
            if(strtotime($now_time) > strtotime($db['date']))
            {
                if($db['free'] == 2)
                {
                    $db['free']=3;
                    Db::table("time")->update($db);
                }
                elseif ($db['free'] == 0)
                {
                    $db['free']=1;
                    Db::table("time")->update($db);
                }
            }
        }
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
                $this->Time_update();
                $this->success("登录成功",url("teacher/index"));
            }else{
                $this->error("登录失败，用户名或密码错误",url("Index/index"));
            }
        }else{//学生登录
            $stu_id = Request::instance()->post("id");
            $stu_password = Request::instance()->post("password");
            $student = new StudentModel();
            if($student->checkPassword($stu_id,$stu_password)){
                session("student",$stu_id);
                $this->Time_update();
                $this->success("登录成功",url("Student/index"));

            }else{
                $this->error("登录失败,用户名或密码错误",url("Index/index"));
            }

        }
    }
}
//login param
//post:
//tLogin :是否是教师登录
//id :登录的用户名
//password