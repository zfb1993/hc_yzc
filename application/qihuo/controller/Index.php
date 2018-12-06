<?php
namespace app\mobile\controller;
use think\Controller;
use think\Db;
use \think\Log;

class Index extends Controller
{
    /**
     * @name 推广系统入口
     */
    public function index()
    {
        //检查是否登陆
        $this->redirect('mobile/user/login');
    }
}
