<?php
namespace app\agent\controller;
use think\Controller;
use think\Db;
use think\Input;
use app\agent\model\Agentor;

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
        $agent=db('agentor')->where('id',session('aid'))->find();
        //dump($res);die;
        $this->assign('agent',$agent);
        return $this->fetch();
    }
    //更新管理员资料
    public function updateInfo()
    {
        $ip=Request()->ip();
        if(Request()->isPost()){
            $data=[
                'true_name'=>input('true_name'),
                'mobile'=>input('mobile'),
				'id_card'=>input('id_card'),
				'bank_name'=>input('bank_name'),
				'bank_card'=>input('bank_card'),
				'bank_addr'=>input('bank_addr'),
				'user_logo'=>input('user_logo'),
				'card_id_img_top'=>input('card_id_img_top'),
				'card_id_img_bot'=>input('card_id_img_bot'),
				'bank_card_img_top'=>input('bank_card_img_top'),
                'update_time'=>time(),
                'login_ip'=>$ip
            ];
            $res=db('agentor')->where('id',session('aid'))->update($data,true);
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
        $agent=db('agentor')->where('id',session('aid'))->find();
        $this->assign('agent',$agent);
        return $this->fetch();
    }
    //修改管理员密码
    public function updatePwd()
    {
        if(Request()->isPost()){
            $data = input('post.');
            $agent = new Agentor();
            $num = $agent->alterPwd($data);
            //dump($num);die;
            if($num==1){
                return json(['code'=>1, 'msg'=>'新密码设置成功！', 'url'=>url('index/main')]);
            }else{
                return json(['code'=>0, 'msg'=>'原始密码不正确，请重新输入']);
            }
        }
    }
    
}
