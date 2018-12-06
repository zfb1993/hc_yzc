<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Input;

class Investor extends Common
{
  public function _initialize(){
    parent::_initialize();
  }
  public function index()
  {

    return $this->fetch();
  }
    
}
