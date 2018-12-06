<?php
namespace app\mobile\controller;
use think\Controller;
use think\Db;
class User extends Controller
{
    /**
     * @name
     * @return mixed
     */
    public function person(){
        return $this->fetch();
    }

}