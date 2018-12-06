<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Input;

class Message extends Common
{
    public function _initialize(){
        parent::_initialize();
    }
    //通知列表
    public function index()
    {
        $now=time();
    	$res=db('message')->select();
        foreach ($res as $key => $value) {
            if($now>$res[$key]['end_time']){
                db('message')->where('id',$res[$key]['id'])->update(['status'=>0]);
            }
        }
        $msg=db('message')->select();
    	$this->assign('list',$msg);
        return $this->fetch();
    }
    //修改通知内容
    public function msgAdd()
    {
        $now=time();
        if(Request()->isPost()){
            $date=[
                    'content'=>input('content'),
                    'end_time'=>strtotime(input('end_time')),
                    'create_time'=>time(),
                    'update_time'=>time(),
                ];
            $time=strtotime(input('set_time'));
            $switch=input('switch');
            if($switch==0){
                $res=db('message')->insert($date);
                if($res){
                    return json(['code'=>1, 'msg'=>'通知发送成功！', 'url'=>url('message/index')]);
                }else{
                    return json(['code'=>0, 'msg'=>'通知发送失败！']);
                }
            }
            if($switch==1 && $now==$time){
                $res=db('message')->insert($date);
                if($res){
                    return json(['code'=>1, 'msg'=>'通知发送成功！', 'url'=>url('message/index')]);
                }else{
                    return json(['code'=>0, 'msg'=>'通知发送失败！']);
                }
            }else{
                return json(['code'=>1, 'msg'=>'定时发送设置成功！', 'url'=>url('message/index')]);
            }
        }
        return $this->fetch();
    }
    //修改通知内容
    public function msgEdit()
    {
        $id=input('id');
        if(Request()->isPost()){
            $date=[
                'content'=>input('content'),
                'end_time'=>strtotime(input('end_time')),
                'update_time'=>time(),
                'status'=>1
            ];
            $res=db('message')->where('id',$id)->update($date);
            if($res){
                return json(['code'=>1, 'msg'=>'通知修改成功！', 'url'=>url('message/index')]);
            }else{
                return json(['code'=>0, 'msg'=>'通知修改失败！']);
            }
        }
        $res=db('message')->where('id',$id)->find();
        $this->assign('msg',$res);
        return $this->fetch();
    }
    //删除通知
    public function msgDel()
    {
        $id=input('id');
        $res=db('message')->where('id',$id)->delete();
        if($res){
            return json(['code'=>1, 'msg'=>'删除成功！', 'url'=>url('message/index')]);
        }else{
            return json(['code'=>0, 'msg'=>'删除失败！']);
        }
    }
    
}
