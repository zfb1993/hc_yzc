<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Input;

class Config extends Common
{
    public function _initialize(){
        parent::_initialize();
    }
    public function index()
    {
        return $this->fetch();
    }
    //资管系统配置
    public function zgList()
    {
        if(Request()->isPost()){
            $list=db('zg_sys')->select();
            if($list){
                foreach ($list as $key => $value) {
                    $list[$key]['status']=($list[$key]['status']==0)?'正常':'禁止';
                }
                return $result = ['code'=>0,'msg'=>'','data'=>$list];
            }
        }
        return $this->fetch();
    }
    //手续费配置
    public function sxfList()
    {
        if(Request()->isPost()){
            $list=db('sxf_mb')->select();
            if($list){
                foreach ($list as $key => $value) {
					$res=Db('zg_sys')->where('id',$list[$key]['zid'])->find();
					$list[$key]['zname']=$res['name'];
                    $list[$key]['status']=($list[$key]['status']==0)?'正常':'禁止';
                }
            }
            return $result = ['code'=>0,'msg'=>'','data'=>$list];
        }
        return $this->fetch();
    }
    //风控配置
    public function fkList()
    {
        if(Request()->isPost()){
            $list=db('fk_config')->select();
            if($list){
                foreach ($list as $key => $value) {
					$res=Db('zg_sys')->where('id',$list[$key]['zid'])->find();
					$list[$key]['zname']=$res['name'];
                    $list[$key]['status']=($list[$key]['status']==0)?'正常':'禁止';
                }
                return $result = ['code'=>0,'msg'=>'','data'=>$list];
            }
        }
        return $this->fetch();
    }
    //母账户配置
    public function mzhList()
    {
        if(Request()->isPost()){
            $list=db('mzh_config')->select();
            if($list){
                foreach ($list as $key => $value) {
					$res=Db('zg_sys')->where('id',$list[$key]['zid'])->find();
					$list[$key]['zname']=$res['name'];
                    $list[$key]['status']=($list[$key]['status']==0)?'正常':'禁止';
                }
                return $result = ['code'=>0,'msg'=>'','data'=>$list];
            }
        }
        return $this->fetch();
    }
    //添加资管账号
    public function zgAdd()
    {
        if(Request()->isPost()){
            $data=[
                'name'=>input('name'),
                'account'=>input('account'),
                'password'=>$this->authcode(trim(input('password')),''),
                'market_ip'=>input('market_ip'),
                'trade_ip'=>input('trade_ip'),
                'server_ip'=>input('server_ip'),
                'memo'=>input('memo'),
                'add_time'=>time()
            ];
            $res=db('zg_sys')->insert($data);
            if($res){
                return json(['code'=>1, 'msg'=>'添加成功！']);
            }else{
                return json(['code'=>0, 'msg'=>'添加失败！']);
            }
        }   
    }
    //获取资管系统数据
    public function getZgData()
    {
        if(Request()->isPost()){
            $list=db('zg_sys')->where('status',0)->select();
            if($list){
                return json($list);
            }
        }
    }
    //获取手续费数据
    public function getSxfData()
    {
        if(Request()->isPost()){
            $list=db('sxf_mb')->where('status',0)->select();
            if($list){
                return json($list);
            }
        }
    }
    //添加手续费
    public function sxfAdd()
    {
        if(Request()->isPost()){
            $data=[
                'zid'=>input('zid'),
                'bh'=>input('bh'),
                'memo'=>input('memo'),
                'add_time'=>time()
            ];
            $res=db('sxf_mb')->insert($data);
            if($res){
                return json(['code'=>1, 'msg'=>'添加成功！']);
            }else{
                return json(['code'=>0, 'msg'=>'添加失败！']);
            }
        }   
    }
    //添加风控配置
    public function fkAdd()
    {
        if(Request()->isPost()){
            $data=[
                'zid'=>input('zid'),
                'name'=>input('name'),
                'account'=>input('account'),
                'memo'=>input('memo'),
                'add_time'=>time()
            ];
            $res=db('fk_config')->insert($data);
            if($res){
                return json(['code'=>1, 'msg'=>'添加成功！']);
            }else{
                return json(['code'=>0, 'msg'=>'添加失败！']);
            }
        }   
    }
    //添加母账户配置
    public function mzhAdd()
    {
        if(Request()->isPost()){
            $data=[
                'zid'=>input('zid'),
                'company'=>input('company'),
                'account'=>input('account'),
				'bh'=>input('bh'),
                'memo'=>input('memo'),
                'add_time'=>time()
            ];
            $res=db('mzh_config')->insert($data);
            if($res){
                return json(['code'=>1, 'msg'=>'添加成功！']);
            }else{
                return json(['code'=>0, 'msg'=>'添加失败！']);
            }
        }   
    }
    //编辑资管账号
    public function zgEdit()
    {
        if(Request()->isPost()){
            $id=input('id');
            if(input('password')!=''){
                $data=[
                    'name'=>input('name'),
                    'account'=>input('account'),
                    'password'=>$this->authcode(trim(input('password')),''),
                    'market_ip'=>input('market_ip'),
                    'trade_ip'=>input('trade_ip'),
                    'server_ip'=>input('server_ip'),
                    'memo'=>input('memo'),
                    'update_time'=>time()
                ];
            }else{
                $data=[
                    'name'=>input('name'),
                    'account'=>input('account'),
                    'market_ip'=>input('market_ip'),
                    'trade_ip'=>input('trade_ip'),
                    'server_ip'=>input('server_ip'),
                    'memo'=>input('memo'),
                    'update_time'=>time()
                ];
            }
            $res=db('zg_sys')->where('id',$id)->update($data);
            if($res){
                return json(['code'=>1, 'msg'=>'更新成功！']);
            }else{
                return json(['code'=>0, 'msg'=>'更新失败！']);
            }
        }
        
    }
    //编辑手续费
    public function sxfEdit()
    {
        if(Request()->isPost()){
            $id=input('id');
            $data=[
                'zid'=>input('zid'),
                'bh'=>input('bh'),
                'memo'=>input('memo'),
                'status'=>input('status'),
                'update_time'=>time()
            ];
            $res=db('sxf_mb')->where('id',$id)->update($data);
            if($res){
                return json(['code'=>1, 'msg'=>'更新成功！']);
            }else{
                return json(['code'=>0, 'msg'=>'更新失败！']);
            }
        }
        
    }
    //编辑风控配置
    public function fkEdit()
    {
        if(Request()->isPost()){
            $id=input('id');
            $data=[
                'zid'=>input('zid'),
                'name'=>input('name'),
                'account'=>input('account'),
                'memo'=>input('memo'),
                'status'=>input('status'),
                'update_time'=>time()
            ];
            $res=db('fk_config')->where('id',$id)->update($data);
            if($res){
                return json(['code'=>1, 'msg'=>'更新成功！']);
            }else{
                return json(['code'=>0, 'msg'=>'更新失败！']);
            }
        }
        
    }
    //编辑母账户配置
    public function mzhEdit()
    {
        if(Request()->isPost()){
            $id=input('id');
            $data=[
                'zid'=>input('zid'),
                'company'=>input('company'),
                'account'=>input('account'),
				'bh'=>input('bh'),
                'memo'=>input('memo'),
                'status'=>input('status'),
                'update_time'=>time()
            ];
            $res=db('mzh_config')->where('id',$id)->update($data);
            if($res){
                return json(['code'=>1, 'msg'=>'更新成功！']);
            }else{
                return json(['code'=>0, 'msg'=>'更新失败！']);
            }
        }
        
    }
    //删除资管账号
    public function zgDel()
    {
        if(Request()->isPost()){
            $id=input('id');
            $res=db('zg_sys')->where('id',$id)->delete();
            if($res){
                return json(['code'=>1, 'msg'=>'删除成功！']);
            }else{
                return json(['code'=>0, 'msg'=>'删除失败！']);
            }
        }
    }
    //删除手续费
    public function sxfDel()
    {
        if(Request()->isPost()){
            $id=input('id');
            $res=db('sxf_mb')->where('id',$id)->delete();
            if($res){
                return json(['code'=>1, 'msg'=>'删除成功！']);
            }else{
                return json(['code'=>0, 'msg'=>'删除失败！']);
            }
        }
    }
    //删除风控配置
    public function fkDel()
    {
        if(Request()->isPost()){
            $id=input('id');
            $res=db('fk_config')->where('id',$id)->delete();
            if($res){
                return json(['code'=>1, 'msg'=>'删除成功！']);
            }else{
                return json(['code'=>0, 'msg'=>'删除失败！']);
            }
        }
    }
    //删除母账户配置
    public function mzhDel()
    {
        if(Request()->isPost()){
            $id=input('id');
            $res=db('mzh_config')->where('id',$id)->delete();
            if($res){
                return json(['code'=>1, 'msg'=>'删除成功！']);
            }else{
                return json(['code'=>0, 'msg'=>'删除失败！']);
            }
        }
    }
    
}