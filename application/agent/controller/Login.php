<?php
namespace app\agent\controller;
use think\Controller;
use app\agent\model\Agentor;
class Login extends Controller
{
    public function _initialize(){
        if (session('aid')) {
            $this->redirect('agent/index/index');
        }
    }
    public function index(){
        if(request()->isPost()) {
            $agent = new Agentor();
            $data = input('post.');
            if(!$this->check($data['captcha'])){
                return json(array('code' => 2, 'msg' => '验证码错误，请重新输入'));
            }
            $num = $agent->login($data);
            if($num == 1){
                return json(['code' => 1, 'msg' => '登录成功!', 'url' => url('index/index')]);
            }else if($num==0) {
                return json(array('code' => 0, 'msg' => '用户名或者密码错误，请重新输入!'));
            }else if($num==-1){
                return json(array('code' => -1, 'msg' => '账户已被锁定，禁止登录!'));
            }else if($num==-2){
                return json(array('code' => -2, 'msg' => '该用户不存在!'));
            }
        }
        return $this->fetch();
    }
    public function check($code){
       return captcha_check($code);
    }
}