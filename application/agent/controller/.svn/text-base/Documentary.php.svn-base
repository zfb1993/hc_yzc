<?php
namespace app\agent\controller;
use think\Controller;
use think\Db;
use think\Input;

class Documentary extends Common{
    public function _initialize(){
        parent::_initialize();
    }

  //跟单
    public function index(){
        return $this->fetch();
    }

    public function getcusId(){
        $agent=Db('customer')->field('zid,true_name,user_name')->select();
        $data['action'] = 'QueryFollowUser';
        $apiurl = getcofig('WINDOWS_URL');
        $res=http($apiurl,$data,'GET');
        $res = substr($res,0,strlen($res)-1);
        $res=substr($res,1);
        $resArr=json_decode($res,true);
        foreach($resArr as $v){
            $arr[] = $v['account'];
        }
        $cus = new Customer();
        $user=$cus->getAllCustomer();
        $agen = [];
        if(!empty($user)) {
            foreach ($user as $v) {
                $agen[] = $v['user_name'];
            }
        }
        $aa = [];
        foreach($agent as $k=>$v){
            if(in_array($v['user_name'],$arr)){
                unset($agent[$k]);
            }
            if(in_array($v['user_name'],$agen)){
                $aa[] = $v;
            }
        }
        $agent = array_values($agent);
        $data['gen'] = $aa;
        $data['yang'] = $agent;
        return json($data);

    }

    public function getffId(){
        $agent=Db('customer')->field('zid,true_name,user_name')->select();
        $id = input('id');
        $data['childid'] = $id;
        $data['action'] = 'QueryFollowInfo';
        $apiurl = getcofig('WINDOWS_URL');
        $res=http($apiurl,$data,'GET');
        $res = substr($res,0,strlen($res)-1);
        $res=substr($res,1);
        $resArr=json_decode($res,true);
        $arr[] = Db('customer')->where('zid',$id)->value('user_name');
        foreach($resArr as $vv){
            $arr[] = Db('customer')->where('zid',$vv['Followed'])->value('user_name');
        }
        foreach($agent as $k=>$v){
            if(in_array($v['user_name'],$arr)){
                unset($agent[$k]);
            }
        }
        $agent = array_values($agent);
        return json($agent);
    }

    public function follow(){
        $data['action'] = 'QueryFollowUser';
        $apiurl = getcofig('WINDOWS_URL');
        $res=http($apiurl,$data,'GET');
        $res = substr($res,0,strlen($res)-1);
        $res=substr($res,1);
        $resArr=json_decode($res,true);
        $cus = new Customer();
        $user=$cus->getAllCustomer();
        $agent = [];
        if(!empty($user)) {
            foreach ($user as $v) {
                $agent[] = $v['user_name'];
            }
        }
        foreach($resArr as $k=>&$v){
            if(!in_array($v['account'],$agent)){
                unset($resArr[$k]);
                continue;
            }
          $v['true_name'] = Db('customer')->where('mobile = '.$v['account'])->value('true_name');
        }
        return json(array('code'=>0,'data'=>$resArr));
    }

    public function add_follow(){
        $data = input('post.');
        if($data['childid'] == $data['followed']){
            return json(array('code'=>2,'msg'=>'跟单账号和样板账号不能一样'));
        }
        if( $data['childid'] == ''){
            return json(array('code'=>2,'msg'=>'请选择跟单账号'));
        }
        if( $data['followed'] == ''){
            return json(array('code'=>2,'msg'=>'请选择样板账号'));
        }
        $data['action'] = 'FollowInsert';
        $apiurl = getcofig('WINDOWS_URL');
        $res=http($apiurl,$data,'GET');
        $resArr=json_decode($res,true);
        if($resArr['error'] == 0){
            return json(array('code'=>1,'msg'=>'跟单成功'));
        }
    }

    public function suspend(){
        $data = input('post.');
        $data['action'] = 'UpdateAccount';
        $data['enablefollow'] =  $data['enablefollow']==0?1:0;
        $apiurl = getcofig('WINDOWS_URL');
        $res=http($apiurl,$data,'GET');
        $resArr=json_decode($res,true);
        if($resArr['error'] == 0){
            return json(array('code'=>1,'msg'=>'跟单状态修改成功'));
        }
    }

    public function followed(){
        $id = input('id');
        $data['childid'] = $id;
        $data['action'] = 'QueryFollowInfo';
        $apiurl = getcofig('WINDOWS_URL');
        $res=http($apiurl,$data,'GET');
        $res = substr($res,0,strlen($res)-1);
        $res=substr($res,1);
        $resArr=json_decode($res,true);
        foreach($resArr as &$v){
            $v['mobile'] =  Db('customer')->where('zid',$v['Followed'])->value('user_name');
        }
        return json(array('code'=>0,'data'=>$resArr));

    }

    public function delfollow(){
        $data['childid'] = input('childid');
        $data['followed'] = input('followed');
        $data['action'] = 'FollowDelete';
        $apiurl = getcofig('WINDOWS_URL');
//        print_r($data);
        $res=http($apiurl,$data,'GET');
        $resArr=json_decode($res,true);
        if($resArr['error'] == 0){
            return json(array('code'=>1,'msg'=>'跟单删除成功'));
        }else{
            return json(array('code'=>2,'msg'=>$resArr['errormsg']));
        }
    }

    public function suppfoll(){
        $data['action'] = 'FollowInsert';
        $data['childid'] = input('childid');
        $data['followed'] = input('followed');
        $data['enable'] = input('enable')==0?1:0;
        $apiurl = getcofig('WINDOWS_URL');
        $res=http($apiurl,$data,'GET');
        $resArr=json_decode($res,true);
        if($resArr['error'] == 0){
            return json(array('code'=>1,'msg'=>'跟单状态修改成功'));
        }
    }

}
