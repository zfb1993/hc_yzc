<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Input;

class User extends Common
{
    public function _initialize(){
        parent::_initialize();
    }
    public function index()
    {
        $user=$this->userData();
        $this->assign('user',$user);
        return $this->fetch();
    }
    //用户列表
    public function userList()
    {
        $user=$this->userData();
        $this->assign('user',$user);
        return $this->fetch();
    }
    //添加用户
    public function userAdd()
    {
        if(Request()->isPost()){
            $data=[
                'username'=>input('username'),
                'pwd'=>md5(input('pwd')),
                'realname'=>input('realname'),
                'tel'=>input('tel'),
                'email'=>input('email'),
                'level'=>input('level'),
                'edit_order'=>input('edit_order'),
                'judge_order'=>input('judge_order'),
                'create_time'=>time(),
                'update_time'=>time()
            ];
            $res=db('edit_user_info')->insert($data);
            if($res){
                return json(['code'=>1, 'msg'=>'新用户添加成功,继续添加！', 'url'=>url('user/userList')]);
            }else{
                return json(['code'=>0, 'msg'=>'添加失败,请重新添加！']);
            }
        }   
        return $this->fetch();
    }
    //编辑用户
    public function userEdit()
    {
        $id=input('id');
        if(Request()->isPost()){
            $data=[
                'realname'=>input('realname'),
                'tel'=>input('tel'),
                'email'=>input('email'),
                'level'=>input('level'),
                'edit_order'=>input('edit_order'),
                'judge_order'=>input('judge_order'),
                'update_time'=>time()
            ];
            $res=db('edit_user_info')->where('id',$id)->update($data);
            if($res){
                return json(['code'=>1, 'msg'=>'更新成功！', 'url'=>url('user/userList')]);
            }else{
                return json(['code'=>0, 'msg'=>'更新失败！']);
            }
        }
        $user=db('edit_user_info')->where('id',$id)->find();
        $this->assign('user',$user);
        return $this->fetch();
    }
    //删除用户
    public function userDel()
    {
        $id=input('id');
        $res=db('edit_user_info')->where('id',$id)->delete();
        if($res){
            return json(['code'=>1, 'msg'=>'删除成功！', 'url'=>url('user/userList')]);
        }else{
            return json(['code'=>0, 'msg'=>'删除失败！']);
        }
    }
    //重置密码
    public function resetPwd($id='')
    {
        $id=input('id');
        $oldpwd=md5('111111');
        //dump($oldpwd);die;
        $res=db('edit_user_info')->where('id',$id)->update(['pwd'=>'']);
        $res=db('edit_user_info')->where('id',$id)->update(['pwd'=>$oldpwd]);
        if($res){
            return json(['code'=>1, 'msg'=>'密码初始化成功！', 'url'=>url('user/userList')]);
        }else{
            return json(['code'=>0, 'msg'=>'密码初始化失败！']);
        }
    }
    
    //用户业绩
    public function userRecord()
    {
        $res=$this->userData();
        $this->assign('list',$res);
        return $this->fetch();
    }
    //查看用户业绩记录
    public function userRecView()
    {
        $id=input('id');
        $res=db('edit_user_info')->where('id',$id)->find();
        //未完成的编辑任务
        $edittask=db('edit_list_state')->where(['editor_id'=>$res['id'],'judge_id'=>NULL])->where('state','NEQ','done')->select();
        //已完成的编辑任务
        $endtask=db('edit_list_state')->where(['editor_id'=>$res['id'],'judge_id'=>NULL,'state'=>'done'])->select();
        //返工次数
        foreach ($endtask as $key => $value) {
            $redo_num=db('edit_list_state_history')->where('list_id',$endtask[$key]['list_id'])->where('type','redo')->count('id');
            $endtask[$key]=array_merge($endtask[$key],['redo_num'=>$redo_num]);
        }

        //进行中的审核任务
        $checking=db('edit_list_state')->where('judge_id',$res['id'])->where('state','checking')->select();
        $this->assign('checking',$checking);
        //未通过的审核任务
        $unpass=db('edit_list_state')->where('judge_id',$res['id'])->where('state','checked')->select();
        $this->assign('unpass',$unpass);
        //通过的审核任务
        $pass=db('edit_list_state')->where('judge_id',$res['id'])->where('state','done')->select();
        $this->assign(['list'=>$res,'edittask'=>$edittask,'endtask'=>$endtask,'pass'=>$pass]);
        return $this->fetch();
    }
    //用户数据
    private function userData()
    {
        $res=db('edit_user_info')->where('level','NEQ','Z')->select();
        return $res;
    }
    
}
