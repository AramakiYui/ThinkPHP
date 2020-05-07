<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class Index
{
    public function index()
    {
        $t_id = "100001";

//        $data = Db::table("teacher")->where("t_id=".$t_id)->find();
        $time = array('date'=>'20200507','t_id'=>"$t_id");
//        $data = Db::table("time")->where("date=".$time["date"])->select("date");
        $data = Db::table("time")->where("date=".$time["date"])->value("date");
        $html = var_dump($data);
        return "<h1>$html</h1>";
    }
}
