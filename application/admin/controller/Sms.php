<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Input;

class Sms extends Common
{
    public function _initialize(){
        parent::_initialize();
    }
    public function index()
    {
        return $this->fetch();
    }
    //短信列表
    public function smsList()
    {
        if(Request()->isPost()){
            $list=db('sms')->order('add_time DESC')->select();
            if($list){
                foreach ($list as $key => $value) {
                   $list[$key]['add_time']=date('Y-m-d H:i:s',$value['add_time']);
                }
                return $result = ['code'=>0,'msg'=>'','data'=>$list];
            }
        }
        return $this->fetch();
    }

    //搜索机构
    public function search_sms()
    {
        if(Request()->isPost()) {
            $keywords = input('keywords');
            $type= input('type');
            $where=array();
            if(!empty($type)) {
                if($type=='OK'){
                    $where['result']='OK';
                }else{
                    $where['result']=array('neq','OK');
                }
            }
            if(!empty($keywords)){
                $where['mobile']=$keywords;
            }
            $list=db('sms')->where($where)->order('add_time DESC')->select();
            if($list){
                foreach ($list as $key => $value) {
                    $list[$key]['add_time']=date('Y-m-d H:i:s',$value['add_time']);
                }
                return $result = ['code'=>0,'msg'=>'','data'=>$list];
            }else{
                return $result = ['code'=>0,'msg'=>'','data'=>$list];
            }
        }
    }
    //删除短信
    public function smsDel()
    {
        if(Request()->isPost()){
            $id=input('id');
            $res=db('sms')->where('id',$id)->delete();
            if($res){
                return json(['code'=>1, 'msg'=>'删除成功！']);
            }else{
                return json(['code'=>0, 'msg'=>'删除失败！']);
            }
        }
    }
    
}
