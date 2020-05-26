<?php


namespace app\index\controller;

use app\index\model\StudentModel;
use app\index\model\TeacherModel;
use \think\Validate;
use think\Controller;
use think\Request;
class RegisterController extends LoginController
{
    public function inputCheckR($data)
    {
//        if(isset($data["stu_id"])&&(strlen($data["stu_id"]) != 9)) return true;
//        if(isset($data["t_id"])&&(strlen($data["t_id"]) != 6)) return true;
//
//        if(isset($data["stu_id"]) &&
//            !empty($data["stu_sex"])&&
//            !empty($data["stu_name"])&&
//            !empty($data["stu_email"])&&
//            !empty($data["stu_phone"])&&
//            !empty($data["stu_password"])&&
//            !empty($data["stu_password_again"]))
//            return true;
//
//        if(isset($data["t_id"]) &&
//            !empty($data["t_sex"])&&
//            !empty($data["t_name"])&&
//            !empty($data["t_email"])&&
//            !empty($data["t_phone"])&&
//            !empty($data["t_password"])&&
//            !empty($data["t_password_again"])&&
//            !empty($data["t_age"]))
//            return true;
//        return false;
        $validateStu	=	new	Validate([
            'stu_id'		        =>	'require|number|length:9',
            'stu_sex'               =>  'require',
            'stu_name'              =>  'require',
            'stu_email'	            =>	'email',
            'stu_phone'             =>  'number|length:11',
            'stu_password'          =>  'require',
            'stu_password_again'    =>  'require',]);
        $validateTea = new Validate([
        't_id'		            =>	'require|number|length:6',
        't_sex'                 =>  'require',
        't_name'                =>  'require',
        't_email'	            =>	'email',
        't_phone'               =>  'number|length:11',
        't_password'            =>  'require',
        't_password_again'      =>  'require',
        't_age'                 =>  'number|between:1,120']);

        if(!isset($data["stu_id"])){
            if(!$validateTea->check($data)){
                $error = $validateTea->getError();
                $this->error("$error");
//                echo "<script>alert($error)</script>";
//                return true;
            }
        }else{
            if(!$validateStu->check($data)){
                $error = $validateStu->getError();
                $this->error("$error");
//                return true;
            }
        }
        return false;
    }
    public function register(){
        $data = Request::instance()->post();
        $this->inputCheckR($data);
//        if($this->inputCheckR($data)){
//            return ;
//            //$this->error("所有的参数必须符合规范",url("\Index\index"));
//        }
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