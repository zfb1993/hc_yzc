<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Input;
use app\admin\model\Admin;

class Manage extends Common
{
    public function _initialize(){
        parent::_initialize();
    }
    public function index()
    {
        return $this->fetch();
    }
    //管理员资料
    public function info()
    {
        $res=db('admin')->where('admin_id',session('aid'))->find();
        //dump($res);die;
        $this->assign('list',$res);
        return $this->fetch();
    }
    //更新管理员资料
    public function updateInfo()
    {
        $ip=Request()->ip();
        if(Request()->isPost()){
            $data=[
                'realname'=>input('realname'),
                'email'=>input('email'),
                'tel'=>input('tel'),
                'update_time'=>time(),
                'ip'=>$ip
            ];
            $res=db('admin')->where('admin_id',session('aid'))->update($data);
            if($res){
                return json(['code'=>1,'msg'=>'更新成功','url'=>url('manage/info')]);
            }else{
                return json(['code'=>0,'msg'=>'更新失败']);
            }
        }
    }
    //管理员密码设置
    public function pwdSet()
    {
        $res=db('admin')->where('admin_id',session('aid'))->find();
        $this->assign('admin',$res);
        return $this->fetch();
    }
    //修改管理员密码
    public function updatePwd()
    {
        if(Request()->isPost()){
            $data = input('post.');
            $admin = new Admin();
            $num = $admin->alterPwd($data);
            //dump($num);die;
            if($num==1){
                return json(['code'=>1, 'msg'=>'新密码设置成功！', 'url'=>url('index/main')]);
            }else{
                return json(['code'=>0, 'msg'=>'原始密码不正确，请重新输入']);
            }
        }
    }
    
}
