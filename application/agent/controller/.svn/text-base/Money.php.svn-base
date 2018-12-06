<?php
namespace app\agent\controller;
use think\Controller;
use think\Db;
use think\Input;

class Money extends Common
{
  public function _initialize(){
    parent::_initialize();
  }
  public function index()
  {
    return $this->fetch();
  }
  //获取当前代理下的所有的代理
  public function getAllAgentor(){
	$aid=session('aid');
	$agent=Db('agentor')->where('id',$aid)->where('status','IN',[0,1])->find();
	switch($agent['aid']){
		case 1:
			$agent=[];
			//获取一级代理下的所有子代理
			$two_agent=$this->getSubAgentor($aid);
			if($two_agent){
				foreach($two_agent as $i=>$v){
					//当前代理下每个二级代理下的所有三级代理
					$three_agent=$this->getSubAgentor($two_agent[$i]['id']);
					if($three_agent){
						foreach($three_agent as $j=>$v){
							//当前代理下每个二级代理下的每个三级代理的所有四级代理
							$four_agent=$this->getSubAgentor($three_agent[$j]['id']);
							if($four_agent){
								$agent=array_merge($agent,$four_agent);
							}
						}
						$agent=array_merge($agent,$three_agent);
					}
				}
				$agent=array_merge($agent,$two_agent);
				return $agent;
			}else{
				$agent=Db('agentor')->where('id',$aid)->where('status','IN',[0,1])->select();
				return $agent;
			}
			break;
		case 2:
			$agent=[];
			//获取二级代理下的所有子代理
			$three_agent=$this->getSubAgentor($aid);
			if($three_agent){
				foreach($three_agent as $j=>$v){
					//当前代理下每个三级代理下的每个四级代理的所有四级代理
					$four_agent=$this->getSubAgentor($three_agent[$j]['id']);
					if($four_agent){
						$agent=array_merge($agent,$four_agent);
					}
				}
				$agent=array_merge($agent,$three_agent);
				return $agent;
			}else{
				$agent=Db('agentor')->where('id',$aid)->where('status','IN',[0,1])->select();
				return $agent;
			}
			break;
		case 3:
			$agent=[];
			//获取三级代理下的所有子代理
			$four_agent=$this->getSubAgentor($aid);
			if($four_agent){
				$agent=array_merge($agent,$four_agent);
				return $agent;
			}else{
				$agent=Db('agentor')->where('id',$aid)->where('status','IN',[0,1])->select();
				return $agent;
			}
			break;
		case 4:
			$agent=Db('agentor')->where('id',$aid)->where('status','IN',[0,1])->select();
			return $agent;
			break;
	}
	
  }
  //获取某代理$aid下的所有子代理
  public function getSubAgentor($aid)
  {
	$res=Db('agentor')->where('pid',$aid)->where('status','IN',[0,1])->select();
	if($res){
		return $res;
	}
  }

  //获取当前代理及所有子代理下的客户
  public function getAllCustomer()
  {
	//获取当前代理及所有子代理
	$agent=$this->getAllAgentor();
	if($agent){
		$aid=[];
		foreach($agent as $key=>$value){
			array_push($aid,$agent[$key]['id']);
		}
		array_push($aid,session('aid'));
		//$aid=array_unique($aid);
		$list=Db('customer')->where('aid','IN',$aid)->select();
		if($list){
			return $list;
		}
	}else{
		$list=Db('customer')->where('aid',session('aid'))->select();
		return $list;
	}
	
  }
  //获取某代理$aid下的所有客户
  public function getSubCustomer($aid,$type){
	if($type==-1){
		$res=Db('customer')->where('aid',$aid)->where('status',-1)->select();
	}else{
		$res=Db('customer')->where('aid',$aid)->where('status','IN',[0,1])->select();
	}
	if($res){
		return $res;
	}
  }

  //客户流水
  public function cusFlow()
  {
    if(Request()->isPost()){
	  //获取当前代理及所有子代理下的客户
	  $customer=$this->getAllCustomer();
	  if($customer){
		  $cid=[];
		  foreach($customer as $key=>$value){
			array_push($cid,$customer[$key]['id']);
		  }
		  $page=input('page');
		  $limit=input('limit');
		  if($page==1){
			  $pre=$page;
		  }else{
			  $pre=($page-1)*$limit;
		  }
		  $count=Db('flow_log')->where('uid','IN',$cid)->count();
		  if($count>$limit){
			  $list=Db('flow_log')->where('uid','IN',$cid)->limit($pre,$limit)->select();
		  }else{
			  $list=Db('flow_log')->where('uid','IN',$cid)->select();
		  }
		  if($list){
			  foreach($list as $key=>$value){
				$user=Db('customer')->where('id',$list[$key]['uid'])->find();
				if($user){
					$list[$key]['user_name']=$user['user_name'];
					$list[$key]['true_name']=$user['true_name'];
					$list[$key]['p_name']=$user['p_name'];
				}
				if($list[$key]['type']==0){
					$list[$key]['type']='提现';
				}else{
					$list[$key]['type']='充值';
				}
				$list[$key]['add_time']=date('Y-m-d H:i:s',$value['add_time']);
				if($list[$key]['check_time']!=NULL){
					$list[$key]['check_time']=date('Y-m-d H:i:s',$value['check_time']);
				}else{
					$list[$key]['check_time']='';
				}
			  }
			  return $result = ['code'=>0,'msg'=>'获取成功!','count'=>count($list),'data'=>$list];
		  }
	  }else{
			return $result = ['code'=>-1,'msg'=>'暂无客户流水...'];
	  }
    }
    return $this->fetch();
  }
  //搜索流水记录
  public function search_flow()
  {
	if(Request()->isPost()){
		$keywords=input('keywords');
		$start_time=input('start_time');
		$e_time=date('Y-m-d',strtotime("+1 day",strtotime($start_time)));
		$end_time=input('end_time');
		if($end_time!=''){
		  $end_time=date('Y-m-d',strtotime("+1 day",strtotime($end_time)));
		}
		$ins_name=input('ins_name');
		$page=input('page');
		$limit=input('limit');
		$pre=($page-1)*$limit;
		$type=input('type');

		$customer=$this->getAllCustomer();
		$cid = [];
		array_push($cid, session('aid'));
		if($customer) {
			$cid = [];
			foreach ($customer as $key => $value) {
				array_push($cid, $customer[$key]['id']);
			}
		}

		if($type!=-1){
			if($keywords!=''){
				$user=Db('customer')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->field('id')->select();
				$uid=[];
				foreach($user as $key=>$value){
					if(in_array($user[$key]['id'],$cid)){
						array_push($uid,$user[$key]['id']);
					}
				}
				$count=Db('flow_log')->where('uid','IN',$uid)->where('type',$type)->count();
				if($count>$limit){
					$list=Db('flow_log')->where('uid','IN',$uid)->where('type',$type)->limit($pre,$limit)->select();
				}else{
					$list=Db('flow_log')->where('uid','IN',$uid)->where('type',$type)->select();
				}
				
			}else if($start_time!=''&&$end_time!=''){
				$count=Db('flow_log')->where('uid','IN',$cid)->where('add_time','between time',[$start_time,$end_time])->where('type',$type)->count();
				if($count>$limit){
					$list=Db('flow_log')->where('uid','IN',$cid)->where('add_time','between time',[$start_time,$end_time])->where('type',$type)->limit($pre,$limit)->select();
				}else{
					$list=Db('flow_log')->where('uid','IN',$cid)->where('add_time','between time',[$start_time,$end_time])->where('type',$type)->select();
				}
			}else if($start_time!=''){
				$count=Db('flow_log')->where('uid','IN',$cid)->where('add_time','between time',[$start_time,$e_time])->where('type',$type)->count();
				if($count>$limit){
					$list=Db('flow_log')->where('uid','IN',$cid)->where('add_time','between time',[$start_time,$e_time])->where('type',$type)->limit($pre,$limit)->select();
				}else{
					$list=Db('flow_log')->where('uid','IN',$cid)->where('add_time','between time',[$start_time,$e_time])->where('type',$type)->select();
				}
				
			}else if($start_time!=''&&$end_time!=''&&$keywords!=''){
				$user=Db('customer')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->select();
				$uid=[];
				foreach($user as $key=>$value){
					if(in_array($user[$key]['id'],$cid)){
						array_push($uid,$user[$key]['id']);
					}
				}
				$count=Db('flow_log')->where('uid','IN',$uid)->where('add_time','between time',[$start_time,$end_time])->where('type',$type)->count();
				if($count>$limit){
					$list=Db('flow_log')->where('uid','IN',$uid)->where('add_time','between time',[$start_time,$end_time])->where('type',$type)->limit($pre,$limit)->select();
				}else{
					$list=Db('flow_log')->where('uid','IN',$uid)->where('add_time','between time',[$start_time,$end_time])->where('type',$type)->select();
				}
				
			}else if($start_time!=''&&$keywords!=''){
				$user=Db('customer')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->select();
				$uid=[];
				foreach($user as $key=>$value){
					if(in_array($user[$key]['id'],$cid)){
						array_push($uid,$user[$key]['id']);
					}
				}
				$count=Db('flow_log')->where('uid','IN',$uid)->where('add_time','between time',[$start_time,$e_time])->where('type',$type)->count();
				if($count>$limit){
					$list=Db('flow_log')->where('uid','IN',$uid)->where('add_time','between time',[$start_time,$e_time])->where('type',$type)->limit($pre,$limit)->select();
				}else{
					$list=Db('flow_log')->where('uid','IN',$uid)->where('add_time','between time',[$start_time,$e_time])->where('type',$type)->select();
				}
				
			}else if($ins_name!=''){
				$new_ins_name=explode(',',$ins_name);
				$agent=Db('agentor')->where('user_name','IN',$new_ins_name)->field('id')->select();
				$aid=[];
				foreach ($agent as $key => $value) {
					array_push($aid, $agent[$key]['id']);
				}
				$user=Db('customer')->where('pid','IN',$aid)->select();
				$uid=[];
				foreach($user as $key=>$value){
					if(in_array($user[$key]['id'],$cid)){
						array_push($uid,$user[$key]['id']);
					}
				}
				$count=Db('flow_log')->where('uid','IN',$uid)->where('type',$type)->count();
				if($count>$limit){
					$list=Db('flow_log')->where('uid','IN',$uid)->where('type',$type)->limit($pre,$limit)->select();
				}else{
					$list=Db('flow_log')->where('uid','IN',$uid)->where('type',$type)->select();
				}
				
			}
		}else{
			if($keywords!=''){
				$user=Db('customer')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->field('id')->select();
				$uid=[];
				foreach($user as $key=>$value){
					if(in_array($user[$key]['id'],$cid)){
						array_push($uid,$user[$key]['id']);
					}
				}
				$count=Db('flow_log')->where('uid','IN',$uid)->count();
				if($count>$limit){
					$list=Db('flow_log')->where('uid','IN',$uid)->limit($pre,$limit)->select();
				}else{
					$list=Db('flow_log')->where('uid','IN',$uid)->select();
				}
				
			}else if($start_time!=''&&$end_time!=''){
				$count=Db('flow_log')->where('uid','IN',$cid)->where('add_time','between time',[$start_time,$end_time])->count();
				if($count>$limit){
					$list=Db('flow_log')->where('uid','IN',$cid)->where('add_time','between time',[$start_time,$end_time])->limit($pre,$limit)->select();
				}else{
					$list=Db('flow_log')->where('uid','IN',$cid)->where('add_time','between time',[$start_time,$end_time])->select();
				}
				
			}else if($start_time!=''){
				$count=Db('flow_log')->where('uid','IN',$cid)->where('add_time','between time',[$start_time,$e_time])->count();
				if($count>$limit){
					$list=Db('flow_log')->where('uid','IN',$cid)->where('add_time','between time',[$start_time,$e_time])->limit($pre,$limit)->select();
				}else{
					$list=Db('flow_log')->where('uid','IN',$cid)->where('add_time','between time',[$start_time,$e_time])->select();
				}
				
			}else if($start_time!=''&&$end_time!=''&&$keywords!=''){
				$user=Db('customer')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->select();
				$uid=[];
				foreach($user as $key=>$value){
					if(in_array($user[$key]['id'],$cid)){
						array_push($uid,$user[$key]['id']);
					}
				}
				$count=Db('flow_log')->where('uid','IN',$uid)->where('add_time','between time',[$start_time,$end_time])->count();
				if($count>$limit){
					$list=Db('flow_log')->where('uid','IN',$uid)->where('add_time','between time',[$start_time,$end_time])->limit($pre,$limit)->select();
				}else{
					$list=Db('flow_log')->where('uid','IN',$uid)->where('add_time','between time',[$start_time,$end_time])->select();
				}
				
			}else if($start_time!=''&&$keywords!=''){
				$user=Db('customer')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->select();
				$uid=[];
				foreach($user as $key=>$value){
					if(in_array($user[$key]['id'],$cid)){
						array_push($uid,$user[$key]['id']);
					}
				}
				$count=Db('flow_log')->where('uid','IN',$uid)->where('add_time','between time',[$start_time,$e_time])->count();
				if($count>$limit){
					$list=Db('flow_log')->where('uid','IN',$uid)->where('add_time','between time',[$start_time,$e_time])->limit($pre,$limit)->select();
				}else{
					$list=Db('flow_log')->where('uid','IN',$uid)->where('add_time','between time',[$start_time,$e_time])->select();
				}
				
			}else if($ins_name!=''){
				$new_ins_name=explode(',',$ins_name);
				$agent=Db('agentor')->where('user_name','IN',$new_ins_name)->field('id')->select();
				$aid=[];
				foreach ($agent as $key => $value) {
					array_push($aid, $agent[$key]['id']);
				}
				$user=Db('customer')->where('pid','IN',$aid)->select();
				$uid=[];
				foreach($user as $key=>$value){
					if(in_array($user[$key]['id'],$cid)){
						array_push($uid,$user[$key]['id']);
					}
				}
				$count=Db('flow_log')->where('uid','IN',$uid)->count();
				if($count>$limit){
					$list=Db('flow_log')->where('uid','IN',$uid)->limit($pre,$limit)->select();
				}else{
					$list=Db('flow_log')->where('uid','IN',$uid)->select();
				}
			}else{
				return $result = ['code'=>-1,'msg'=>'暂无搜索结果数据...',];
			}
		}
    
		if($list){
			foreach ($list as $key => $value) {
			  $res=Db('customer')->where('id',$list[$key]['uid'])->find();
			  $list[$key]['user_name']=$res['user_name'];
			  $list[$key]['true_name']=$res['true_name'];
			  $list[$key]['p_name']=$res['p_name'];
			  switch ($list[$key]['type']) {
				case 0:
				  $list[$key]['type']='提现';
				  break;
				case 1:
				  $list[$key]['type']='充值';
				  break;
			  }
			  if($list[$key]['add_time']!=NULL){
				$list[$key]['add_time']=date('Y-m-d H:i:s',$value['add_time']);
			  }else{
				$list[$key]['add_time']='';
			  }
			  if($list[$key]['check_time']!=NULL){
				$list[$key]['check_time']=date('Y-m-d H:i:s',$value['check_time']);
			  }else{
				$list[$key]['check_time']='';
			  }
			}
			return $result = ['code'=>0,'msg'=>'获取成功!','count'=>$count,'data'=>$list];
		  }else{
			return $result = ['code'=>-1,'msg'=>'暂无搜索结果数据...',];
		}
    }
  }
  //机构流水
  public function insFlow()
  {
    if(Request()->isPost()){
	  //获取当前代理及所有子代理
	  $agent=$this->getAllAgentor();
	  if($agent){
		  $aid=[];
		  foreach($agent as $key=>$value){
			array_push($aid,$agent[$key]['id']);
		  }
		  array_push($aid,session('aid'));
		  $list=Db('flow_log')->where('aid','IN',$aid)->select();
		  if($list){
			  foreach($list as $key=>$value){
				$agent=Db('agentor')->where('id',$list[$key]['aid'])->find();
				if($agent){
					$list[$key]['user_name']=$agent['user_name'];
					$list[$key]['true_name']=$agent['true_name'];
					$list[$key]['p_name']=$agent['p_name'];
				}
				if($list[$key]['type']==0){
					$list[$key]['type']='提现';
				}else{
					$list[$key]['type']='返佣';
				}
				$list[$key]['add_time']=date('Y-m-d H:i:s',$value['add_time']);
				$list[$key]['check_time']=date('Y-m-d H:i:s',$value['check_time']);
			  }
			   
			  return $result = ['code'=>0,'msg'=>'获取成功!','count'=>count($list),'data'=>$list];
		  }
	  }else{
			return $result = ['code'=>-1,'msg'=>'暂无代理流水...'];
	  }
    }
    return $this->fetch();
  }

  //搜索机构流水
  public function search_insflow()
  {
	if(Request()->isPost()){
		$keywords=input('keywords');
		$start_time=input('start_time');
		$e_time=date('Y-m-d',strtotime("+1 day",strtotime($start_time)));
		$end_time=input('end_time');
		if($end_time!=''){
		  $end_time=date('Y-m-d',strtotime("+1 day",strtotime($end_time)));
		}
		$ins_name=input('ins_name');
		$page=input('page');
		$limit=input('limit');
		if($page==1){
			$pre=$page;
		}else{
			$page=($page-1)*$limit;
		}
		$type=input('type');
		if($type!=-1){
			if($keywords!=''){
				$user=Db('agentor')->field('id')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->select();
				$uid=[];
				foreach($user as $key=>$value){
					array_push($uid,$user[$key]['id']);
				}
				$count=Db('flow_log')->where('aid','IN',$uid)->where('type',$type)->count();
				if($count>$limit){
					$list=Db('flow_log')->where('uid','IN',$uid)->where('type',$type)->limit($pre,$limit)->select();
				}else{
					$list=Db('flow_log')->where('uid','IN',$uid)->where('type',$type)->select();
				}
				
			}else if($start_time!=''&&$end_time!=''){
				$count=Db('flow_log')->where('aid','NEQ','')->where('add_time','between time',[$start_time,$end_time])->where('type',$type)->count();
				if($count>$limit){
					$list=Db('flow_log')->where('aid','NEQ','')->where('add_time','between time',[$start_time,$end_time])->where('type',$type)->limit($pre,$limit)->select();
				}else{
					$list=Db('flow_log')->where('aid','NEQ','')->where('add_time','between time',[$start_time,$end_time])->where('type',$type)->select();
				}
			}else if($start_time!=''){
				$count=Db('flow_log')->where('aid','NEQ','')->where('add_time','between time',[$start_time,$e_time])->where('type',$type)->count();
				if($count>$limit){
					$list=Db('flow_log')->where('aid','NEQ','')->where('add_time','between time',[$start_time,$e_time])->where('type',$type)->limit($pre,$limit)->select();
				}else{
					$list=Db('flow_log')->where('aid','NEQ','')->where('add_time','between time',[$start_time,$e_time])->where('type',$type)->select();
				}
				
			}else if($start_time!=''&&$end_time!=''&&$keywords!=''){
				$user=Db('agentor')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->select();
				$uid=[];
				foreach($user as $key=>$value){
					array_push($uid,$user[$key]['id']);
				}
				$count=Db('flow_log')->where('aid','IN',$uid)->where('add_time','between time',[$start_time,$end_time])->where('type',$type)->count();
				if($count>$limit){
					$list=Db('flow_log')->where('aid','IN',$uid)->where('add_time','between time',[$start_time,$end_time])->where('type',$type)->limit($pre,$limit)->select();
				}else{
					$list=Db('flow_log')->where('aid','IN',$uid)->where('add_time','between time',[$start_time,$end_time])->where('type',$type)->select();
				}
				
			}else if($start_time!=''&&$keywords!=''){
				$user=Db('agentor')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->select();
				$uid=[];
				foreach($user as $key=>$value){
					array_push($uid,$user[$key]['id']);
				}
				$count=Db('flow_log')->where('aid','IN',$uid)->where('add_time','between time',[$start_time,$e_time])->where('type',$type)->count();
				if($count>$limit){
					$list=Db('flow_log')->where('aid','IN',$uid)->where('add_time','between time',[$start_time,$e_time])->where('type',$type)->limit($pre,$limit)->select();
				}else{
					$list=Db('flow_log')->where('aid','IN',$uid)->where('add_time','between time',[$start_time,$e_time])->where('type',$type)->select();
				}
				
			}else if($ins_name!=''){
				$new_ins_name=explode(',',$ins_name);
				$agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
				$aid=[];
				foreach ($agent as $key => $value) {
					array_push($aid, $agent[$key]['id']);
				}
				$user=Db('agentor')->where('id','IN',$aid)->select();
				$uid=[];
				foreach($user as $key=>$value){
					array_push($uid,$user[$key]['id']);
				}
				$count=Db('flow_log')->where('aid','IN',$uid)->where('type',$type)->count();
				if($count>$limit){
					$list=Db('flow_log')->where('aid','IN',$uid)->where('type',$type)->limit($pre,$limit)->select();
				}else{
					$list=Db('flow_log')->where('aid','IN',$uid)->where('type',$type)->select();
				}
				
			}
		}else{
			if($keywords!=''){
				$user=Db('agentor')->field('id')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->select();
				$uid=[];
				foreach($user as $key=>$value){
					array_push($uid,$user[$key]['id']);
				}
				$count=Db('flow_log')->where('aid','IN',$uid)->count();
				if($count>$limit){
					$list=Db('flow_log')->where('aid','IN',$uid)->limit($pre,$limit)->select();
				}else{
					$list=Db('flow_log')->where('aid','IN',$uid)->select();
				}
				
			}else if($start_time!=''&&$end_time!=''){
				$count=Db('flow_log')->where('aid','NEQ','')->where('add_time','between time',[$start_time,$end_time])->count();
				if($count>$limit){
					$list=Db('flow_log')->where('aid','NEQ','')->where('add_time','between time',[$start_time,$end_time])->limit($pre,$limit)->select();
				}else{
					$list=Db('flow_log')->where('aid','NEQ','')->where('add_time','between time',[$start_time,$end_time])->select();
				}
				
			}else if($start_time!=''){
				$count=Db('flow_log')->where('aid','NEQ','')->where('add_time','between time',[$start_time,$e_time])->count();
				if($count>$limit){
					$list=Db('flow_log')->where('aid','NEQ','')->where('add_time','between time',[$start_time,$e_time])->limit($pre,$limit)->select();
				}else{
					$list=Db('flow_log')->where('aid','NEQ','')->where('add_time','between time',[$start_time,$e_time])->select();
				}
				
			}else if($start_time!=''&&$end_time!=''&&$keywords!=''){
				$user=Db('agentor')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->select();
				$uid=[];
				foreach($user as $key=>$value){
					array_push($uid,$user[$key]['id']);
				}
				$count=Db('flow_log')->where('aid','IN',$uid)->where('add_time','between time',[$start_time,$end_time])->count();
				if($count>$limit){
					$list=Db('flow_log')->where('aid','IN',$uid)->where('add_time','between time',[$start_time,$end_time])->limit($pre,$limit)->select();
				}else{
					$list=Db('flow_log')->where('aid','IN',$uid)->where('add_time','between time',[$start_time,$end_time])->select();
				}
				
			}else if($start_time!=''&&$keywords!=''){
				$user=Db('agentor')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->select();
				$uid=[];
				foreach($user as $key=>$value){
					array_push($uid,$user[$key]['id']);
				}
				$count=Db('flow_log')->where('aid','IN',$uid)->where('add_time','between time',[$start_time,$e_time])->count();
				if($count>$limit){
					$list=Db('flow_log')->where('aid','IN',$uid)->where('add_time','between time',[$start_time,$e_time])->limit($pre,$limit)->select();
				}else{
					$list=Db('flow_log')->where('aid','IN',$uid)->where('add_time','between time',[$start_time,$e_time])->select();
				}
				
			}else if($ins_name!=''){
				$new_ins_name=explode(',',$ins_name);
				$agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
				$aid=[];
				foreach ($agent as $key => $value) {
					array_push($aid, $agent[$key]['id']);
				}
				$user=Db('agentor')->where('id','IN',$aid)->select();
				$uid=[];
				foreach($user as $key=>$value){
					array_push($uid,$user[$key]['id']);
				}
				$count=Db('flow_log')->where('aid','IN',$uid)->count();
				if($count>$limit){
					$list=Db('flow_log')->where('aid','IN',$uid)->limit($pre,$limit)->select();
				}else{
					$list=Db('flow_log')->where('aid','IN',$uid)->select();
				}
				
			}
		}
    
		if($list){
			foreach ($list as $key => $value) {
			  $res=Db('agentor')->where('id',$list[$key]['aid'])->find();
			  $list[$key]['user_name']=$res['user_name'];
			  $list[$key]['true_name']=$res['true_name'];
			  $list[$key]['p_name']=$res['p_name'];
			  switch ($list[$key]['type']) {
				case 0:
				  $list[$key]['type']='提现';
				  break;
				case 1:
				  $list[$key]['type']='充值';
				  break;
			  }
			  if($list[$key]['add_time']!=NULL){
				$list[$key]['add_time']=date('Y-m-d H:i:s',$value['add_time']);
			  }else{
				$list[$key]['add_time']='';
			  }
			  if($list[$key]['check_time']!=NULL){
				$list[$key]['check_time']=date('Y-m-d H:i:s',$value['check_time']);
			  }else{
				$list[$key]['check_time']='';
			  }
			}
			return $result = ['code'=>0,'msg'=>'获取成功!','count'=>$count,'data'=>$list];
		  }else{
			return $result = ['code'=>-1,'msg'=>'暂无搜索结果数据...',];
		}
    }
  }

  //充值提现
  public function payCheck()
  {
    
    return $this->fetch();
  }

  //出金入金
  public function ioMoney()
  {
    
    return $this->fetch();
  }
  












 
  //用户数据
  private function userData()
  {
    //$res=db('edit_user_info')->where('level','NEQ','Z')->select();
    //return $res;
  }
    
}
