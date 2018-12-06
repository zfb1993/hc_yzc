<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Input;

class Company extends Common
{
    public function _initialize(){
        parent::_initialize();
    }
    public function index()
    {
        return $this->fetch();
    }
    //期货公司列表
    public function companyList()
    {
        if(Request()->isPost()){
            $list=db('company')->where('status',0)->select();
            if($list){
                return $result = ['code'=>0,'msg'=>'','data'=>$list];
            }
        }
        return $this->fetch();
    }
    //添加期货公司
    public function companyAdd()
    {
        if(Request()->isPost()){
            $data=[
                'c_name'=>input('c_name'),
                'c_bh'=>input('c_bh'),
                'ctp_num'=>input('ctp_num'),
                'market_ip'=>input('market_ip'),
                'trade_ip'=>input('trade_ip'),
                'add_time'=>time()
            ];
            $res=db('company')->insert($data);
            if($res){
                return json(['code'=>1, 'msg'=>'添加成功！']);
            }else{
                return json(['code'=>0, 'msg'=>'添加失败！']);
            }
        }   
    }
    //编辑期货公司
    public function companyEdit()
    {
        if(Request()->isPost()){
            $id=input('id');
            $data=[
                'c_name'=>input('c_name'),
                'c_bh'=>input('c_bh'),
                'ctp_num'=>input('ctp_num'),
                'market_ip'=>input('market_ip'),
                'trade_ip'=>input('trade_ip'),
                'update_time'=>time()
            ];
            $res=db('company')->where('id',$id)->update($data);
            if($res){
                return json(['code'=>1, 'msg'=>'更新成功！']);
            }else{
                return json(['code'=>0, 'msg'=>'更新失败！']);
            }
        }
        
    }
    //删除期货公司
    public function companyDel()
    {
        if(Request()->isPost()){
            $id=input('id');
            $res=db('company')->where('id',$id)->delete();
            if($res){
                return json(['code'=>1, 'msg'=>'删除成功！']);
            }else{
                return json(['code'=>0, 'msg'=>'删除失败！']);
            }
        }
    }
    
}
