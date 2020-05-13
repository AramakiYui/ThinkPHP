<?php


namespace app\index\controller;

use app\index\model\StudentModel;
use app\index\model\Teacher;
use app\index\model\TeacherModel;
use think\Controller;
use think\Request;
class RegisterController extends LoginController
{
    public function register(){
        $data = Request::instance()->post();
        if($data["tRegister"]){//老师注册
            $teacher = new TeacherModel();
            $result = $teacher->register($data);
            if($result == -1) {
                $this->error("用户名已存在",url("\Index\index"));
            }elseif($result == -2){
                $this->error("两次密码输入不一致",url("\Index\index"));
            } else{
                $this->success("注册成功，请登录",url("\Index\index"));
            }
        }else{//学生注册
            $student = new StudentModel();
            $result = $student->register($data);
            if($result = -1){
                $this->error("用户名已存在",url("\\"));
            }elseif($result == -2){
                $this->error("两次密码输入不一致",url("\\"));
            } else{
                $this->success("注册成功，请登录",url("\\"));
            }
        }
    }
}
//register
//tRegiser
//