<?php


namespace app\index\controller;

use app\index\model\StudentModel;
use app\index\model\Teacher;
use think\Controller;
use think\Request;
class Register extends Login
{
    public function index()
    {
        $this->display();
    }
    public function register(){
        $data = Request::instance()->post();
        if($data["tRegister"]){//老师注册
            $teacher = new Teacher();
            $result = $teacher->register($data);
            if($result == -1) {
                $this->error("用户名已存在",url("\Register\index"));
            }else{
                $this->success("注册成功，请登录",url("\Login\index"));
            }
        }else{//学生注册
            $student = new StudentModel();
            $result = $student->register($data);
            if($result = -1){
                $this->error("用户名已存在",url("\Register\index"));
            }else{
                $this->success("注册成功，请登录",url("\Login\index"));
            }
        }
    }
}
//register
//tRegiser
//