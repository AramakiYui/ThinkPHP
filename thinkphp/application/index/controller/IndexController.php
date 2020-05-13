<?php
namespace app\index\controller;

use think\Controller;
use think\Db;

class IndexController extends Controller
{
    public function index()
    {
        $html = $this->fetch();
        return $html;
    }
}
