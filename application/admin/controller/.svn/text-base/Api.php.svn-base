<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Input;

class Api extends Common
{
  public function _initialize(){
    parent::_initialize();
  }
  public function index()
  {
    return $this->fetch();
  }
  //支付接口
  public function payApi()
  {
    //api_type接口类型：0-支付接口,1-短信接口;
    if(Request()->isPost()){
      $list=Db('api_config')->where('api_type',0)->select();
      foreach ($list as $k => $v) {
        switch ($list[$k]['status']) {
          case 1:
            $list[$k]['status']='启用';
            break;
          
          default:
            $list[$k]['status']='禁用';
            break;
        }
      }
      if($list){
        return $result = ['code'=>0,'msg'=>'','count'=>count($list),'data'=>$list];
      }
    }
    return $this->fetch();
  }
  
  //短信接口
  public function smsApi()
  {
    //api_type接口类型：0-支付接口,1-短信接口;
    if(Request()->isPost()){
      $list=Db('api_config')->where('api_type',1)->select();
      if($list){
        return $result = ['code'=>0,'msg'=>'','count'=>count($list),'data'=>$list];
      }
    }
    return $this->fetch();
  }
  //短信接口配置
  public function smsApiConfig()
  {
    //api_type接口类型：0-支付接口,1-短信接口;
    if(Request()->isPost()){
      $data['api_name']=input('api_name');
      $data['api_para']=input('api_para');
      $data['memo']=input('memo');
      $data['status']=input('status',1);
      $id=input('id');
      if(empty( $id)){
        return $result = ['code'=>-1,'msg'=>'请求参数错误'];
      }
      if(Db('api_config')->where('id',$id)->update($data)){
        return $result = ['code'=>1,'msg'=>'保存成功'];
      }
    }else{
      return $result = ['code'=>-1,'msg'=>'请求参数错误'];
    }

  }
  //
    
}
