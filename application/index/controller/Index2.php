<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Input;

class Index extends Controller
{
	
  public function _initialize(){
    parent::_initialize();
  }

  public function index()
  {

    return $this->fetch();
  }

  public function optional()
  {

    return $this->fetch();
  }

  public function position()
  {

    return $this->fetch();
  }

  public function login()
  {

    return $this->fetch();
  }

  public function reg()
  {

    return $this->fetch();
  }

  public function mine()
  {

    return $this->fetch();
  }

  public function log()
  {

    return $this->fetch();
  }

  public function about()
  {

    return $this->fetch();
  }

   public function trade()
  {

    return $this->fetch();
  } 

  public function withdraw()
  {

    return $this->fetch();
  }  


 public function stock()
  {

    return $this->fetch();
  }    
}
