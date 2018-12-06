<?php
namespace app\agent\controller;
use think\Controller;
use think\Db;
use think\Input;

class Customer extends Common
{
  public function _initialize(){
    parent::_initialize();
  }
  public function index()
  {
    
    return $this->fetch();
  }
  //客户注册
  public function register()
  {
	$aid=session('aid');
    if(Request()->isPost()){
      $agent=Db('agentor')->where('id',$aid)->find();
      if($agent){
        $data=[
		  'aid'=>$agent['id'],
          'tid'=>$agent['tid'],
          'pid'=>$agent['pid'],
          'user_name'=>trim(input('mobile')),
          'user_pwd'=>md5(trim(input('user_pwd'))),
          'true_name'=>trim(input('true_name')),
          'p_name'=>$agent['true_name'],
          'ins_name'=>$agent['ins_name'],
          'mobile'=>trim(input('mobile')),
          'code'=>mt_rand(1000,9999),
          'add_time'=>time()
        ];
        $res=Db('customer')->insert($data);
        if($res){
          return json(['code'=>1,'msg'=>'用户注册成功！']);
        }else{
          return json(['code'=>0,'msg'=>'用户注册失败！']);
        }
      }
    }
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
  //搜索
  public function user_search(){
  if(Request()->isPost()||!empty(input('export'))){
    $keywords=input('keywords');
    $start_time=input('start_time');
    $e_time=date('Y-m-d',strtotime("+1 day",strtotime($start_time)));
    $end_time=input('end_time');
    if($end_time!=''){
      $end_time=date('Y-m-d',strtotime("+1 day",strtotime($end_time)));
    }
    $ins_name=input('ins_name');
	  $type=input('type');
	  $where=array();
	  if(!empty($type)){
		  $where['is_true']=$type-1;
	  }
	  $page=input('page');
	  $limit=input('limit');
	  $pre=($page-1)*$limit;
	  if(!empty(input('export'))){
		  $limit=10000;
		  $pre=0;
	  }
	//获取当前代理及所有子代理
	$agent=$this->getAllAgentor();
	$allAgentorAid=[];
	array_push($allAgentorAid,session('aid'));
	if($agent){
	  foreach($agent as $key=>$value){
		  array_push($allAgentorAid,$agent[$key]['id']);
	  }
	}

	if($ins_name!=''&&$start_time!=''&&$end_time!=''&&$keywords!=''){
	  $new_ins_name=explode(',',$ins_name);
      $agent=Db('agentor')->where('user_name','IN',$new_ins_name)->field('id')->select();
      $aid=[];
      foreach ($agent as $key => $value) {
		  if(in_array($agent[$key]['id'],$allAgentorAid)){
			  array_push($aid, $agent[$key]['id']);
		  }

      }
		$count=Db('customer')->where($where)->where('aid','IN',$aid)->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->where('add_time','between time',[$start_time,$end_time])->count();
      $list=Db('customer')->where($where)->where('aid','IN',$aid)->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->where('add_time','between time',[$start_time,$end_time])->limit($pre,$limit)->select();
	}else if($ins_name!=''&&$start_time!=''&&$end_time!=''){
	  $new_ins_name=explode(',',$ins_name);
      $agent=Db('agentor')->where('user_name','IN',$new_ins_name)->field('id')->select();
      $aid=[];
      foreach ($agent as $key => $value) {
		  if(in_array($agent[$key]['id'],$allAgentorAid)){
			  array_push($aid, $agent[$key]['id']);
		  }
      }
	  $count=Db('customer')->where($where)->where('aid','IN',$aid)->where('add_time','between time',[$start_time,$end_time])->count();
      $list=Db('customer')->where($where)->where('aid','IN',$aid)->where('add_time','between time',[$start_time,$end_time])->limit($pre,$limit)->select();
	}else if($ins_name!=''&&$start_time!=''){
	  $new_ins_name=explode(',',$ins_name);
      $agent=Db('agentor')->where('user_name','IN',$new_ins_name)->field('id')->select();
      $aid=[];
      foreach ($agent as $key => $value) {
		  if(in_array($agent[$key]['id'],$allAgentorAid)){
			  array_push($aid, $agent[$key]['id']);
		  }
      }
		$count=Db('customer')->where($where)->where('aid','IN',$aid)->where('add_time','between time',[$start_time,$e_time])->count();
      $list=Db('customer')->where($where)->where('aid','IN',$aid)->where('add_time','between time',[$start_time,$e_time])->select();
	}else if($start_time!=''&&$end_time!=''&&$keywords!=''){
		$count=Db('customer')->where($where)->where('aid','IN',$allAgentorAid)->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->where('add_time','between time',[$start_time,$end_time])->count();
      $list=Db('customer')->where($where)->where('aid','IN',$allAgentorAid)->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->where('add_time','between time',[$start_time,$end_time])->limit($pre,$limit)->select();
    }else if($start_time!=''&&$keywords!=''){
		$count=Db('customer')->where($where)->where('aid','IN',$allAgentorAid)->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->where('add_time','between time',[$start_time,$e_time])->count();
      $list=Db('customer')->where($where)->where('aid','IN',$allAgentorAid)->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->where('add_time','between time',[$start_time,$e_time])->limit($pre,$limit)->select();
    }else if($start_time!=''&&$end_time!=''){
		$count=Db('customer')->where($where)->where('aid','IN',$allAgentorAid)->where('add_time','between time',[$start_time,$end_time])->count();
      $list=Db('customer')->where($where)->where('aid','IN',$allAgentorAid)->where('add_time','between time',[$start_time,$end_time])->limit($pre,$limit)->select();
    }else if($start_time!=''){
		$count=Db('customer')->where($where)->where('aid','IN',$allAgentorAid)->where('add_time','between time',[$start_time,$e_time])->count();
      $list=Db('customer')->where($where)->where('aid','IN',$allAgentorAid)->where('add_time','between time',[$start_time,$e_time])->limit($pre,$limit)->select();
    }else if($ins_name!=''){
      $new_ins_name=explode(',',$ins_name);
      $agent=Db('agentor')->where('user_name','IN',$new_ins_name)->field('id')->select();
      $aid=[];
      foreach ($agent as $key => $value) {
		  if(in_array($agent[$key]['id'],$allAgentorAid)){
			  array_push($aid, $agent[$key]['id']);
		  }
      }
		$count=Db('customer')->where($where)->where('aid','IN',$aid)->count();
      $list=Db('customer')->where($where)->where('aid','IN',$aid)->limit($pre,$limit)->select();
    }else if($keywords!=''){
		$count=Db('customer')->where($where)->where('aid','IN',$allAgentorAid)->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->count();
      $list=Db('customer')->where($where)->where('aid','IN',$allAgentorAid)->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->limit($pre,$limit)->select();
    }else{
		$list=false;
		$count=0;
	}
    
    if($list){

		  foreach($list as $key=>$value){
			$zg=Db('zg_sys')->where('id',$list[$key]['zg_id'])->find();
			if($zg){
			  $list[$key]['zname']=$zg['name'];
			}else{
			  $list[$key]['zname']='';
			}
			$mzh=Db('mzh_config')->where('id',$list[$key]['mzh_id'])->find();
			if($mzh){
			  $list[$key]['mzh']=$mzh['account'];
			}else{
			  $list[$key]['mzh']='';
			}
			$fk=Db('fk_config')->where('id',$list[$key]['fk_id'])->find();
			if($fk){
			  $list[$key]['bh']=$fk['account'];
			}else{
			  $list[$key]['bh']='';
			}
			$sxf_mb=Db('sxf_mb')->where('id',$list[$key]['sxf_id'])->find();
			if($sxf_mb){
			  $list[$key]['zsxf']=$sxf_mb['bh'];
			}else{
			  $list[$key]['zsxf']='';
			}
			if($list[$key]['add_time']!=NULL){
			  $list[$key]['add_time']=date('Y-m-d H:i:s',$value['add_time']);
			}else{
			  $list[$key]['add_time']='';
			}
			  if($list[$key]['update_time']!=NULL){
				  $list[$key]['update_time']=date('Y-m-d H:i:s',$list[$key]['update_time']);
			  }else{
				  $list[$key]['update_time']='';
			  }
			  unset($list[$key]['mobile']);
			  unset($list[$key]['user_name']);
		  }
		if(!empty(input('export'))){
			//姓名  账号   手机号    所属机构   账户余额  注册时间
			$xlsName  = "客户列表查询";
			$xlsCell  = array(
				array('true_name','姓名'),
				array('zid','交易账号'),
				array('p_name','上级代理'),
				array('ins_name','所属机构'),
				array('total_money','账户余额'),
				array('add_time','注册时间'),
				array('update_time','审核时间')
			);
			$xlsData  = $list;
			$this->exportExcel($xlsName,$xlsCell,$xlsData);
			return $result=['code'=>-1,'msg'=>'未搜索到相关数据...'];
		}else{
			return $result = ['code'=>0,'msg'=>'获取成功!','count'=>$count,'data'=>$list];
		}

      }else{
		return $result = ['code'=>-1,'msg'=>'没有搜索到相关数据'];
	  }
    }
  }
  //客户列表
  public function userList()
  {
    if(Request()->isPost()){
		$page=input('page');
		$limit=input('limit');
		$pre=($page-1)*$limit;
		//获取当前代理下的所有代理下的客户
		$user=$this->getAllCustomer();
		if($user){
			$count=count($user);
			$list=$this->pagedown($user,$pre,$limit);
			foreach($list as $key=>$value){
				unset($list[$key]['mobile']);
				unset($list[$key]['user_name']);
				if($list[$key]['add_time']!=NULL){
					$list[$key]['add_time']=date('Y-m-d H:i:s',$list[$key]['add_time']);
				}else{
					$list[$key]['add_time']='';
				}
				if($list[$key]['update_time']!=NULL){
					$list[$key]['update_time']=date('Y-m-d H:i:s',$list[$key]['update_time']);
				}else{
					$list[$key]['update_time']='';
				}
			}
			return $result = ['code'=>0,'msg'=>'获取成功','count'=>$count,'data'=>$list];
		}else{
			return $result = ['code'=>-1,'msg'=>'暂无代理客户数据'];
		}
    }
    return $this->fetch();
  }
  //分页处理函数
  public function pagedown($arr,$page,$limit){
	$newArr=array_slice($arr,$page,$limit);
	return $newArr;
  }
  //客户资料
  public function userInfo()
  {
    $id=input('id');
    $list=$this->getCustomerInfo($id);
    if($list){
		$zg=Db('zg_sys')->where('id',$list['zg_id'])->find();
		if($zg){
			$list['zname']=$zg['name'];
		}else{
			$list['zname']='';
		}
		$mzh=Db('mzh_config')->where('id',$list['mzh_id'])->find();
		if($mzh){
			$list['mzh']=$mzh['account'];
		}else{
			$list['mzh']='';
		}
		$fk=Db('fk_config')->where('id',$list['fk_id'])->find();
		if($fk){
			$list['fkbh']=$fk['account'];
		}else{
			$list['fkbh']='';
		}
		$sxf_mb=Db('sxf_mb')->where('id',$list['sxf_id'])->find();
		if($sxf_mb){
			$list['sxfbh']=$sxf_mb['bh'];
		}else{
			$list['sxfbh']='';
		}
      
      $this->assign('list',$list);
    }
    return $this->fetch();
  }

  //删除客户,加入黑名单管理
  public function userDel()
  {
    if(Request()->isPost()){
      $id=input('id');
      $res=$this->setCustomer($id,-1);//加入黑名单
      if($res){
        return json(['code'=>1,'msg'=>'黑名单添加成功！']);
      }else{
        return json(['code'=>0,'msg'=>'删除失败！']);
      }
    }
  }

  //客户黑名单
  public function userBlack()
  {
    if(Request()->isPost()){
      $id=input('id');
      $res=$this->setCustomer($id,2);//彻底删除
      if($res){
        return json(['code'=>1,'msg'=>'删除成功！']);
      }else{
        return json(['code'=>0,'msg'=>'删除失败！']);
      }
    }
    return $this->fetch();
  }
  //获取所有黑名单用户
  public function getUserBlack()
  {
    $list=[];
    if(Request()->isPost()){
		//获取当前代理下的所有代理
		$agent=$this->getAllAgentor();
		if($agent){
			foreach($agent as $key=>$value){
				$user=$this->getAllCustomer($agent[$key]['id'],-1);
				if($user){
					$list=array_merge($list,$user);
				}
			}
			
		}
        if($list){
			return $result = ['code'=>0,'msg'=>'获取成功','count'=>count($list),'data'=>$list];
        }else{
			return $result = ['code'=>-1,'msg'=>'暂无黑名单数据...'];
		}
    }
  }

  //获取所有代理ID
  public function getAgentId()
  {
	$aid=session('aid');
    $agent=Db('agentor')->where('id',$aid)->field('id,true_name')->find();
    if($agent){
      return json($agent);
    }
  }

  //客户资金查询
  public function myMoneySearch()
  {
    if(Request()->isPost()){
		$page=input('page');
		$limit=input('limit');
		if($page==1){
			$pre=$page;
		}else{
			$pre=($page-1)*$limit;
		}
		$uid=input('id');
		$count=Db('account_info_log')->where('uid',$uid)->whereTime('create_time','today')->count();
		if($count>$limit){
			$list=Db('account_info_log')->where('uid',$uid)->whereTime('create_time','today')->limit($pre,$limit)->select();
		}else{
			$list=Db('account_info_log')->where('uid',$uid)->whereTime('create_time','today')->select();
		}
		if($list){
			foreach ($list as $key=>$value){
				$user=Db('customer')->where('id',$uid)->find();
				$list[$key]['true_name']=$user['true_name'];
				$list[$key]['mobile']=$user['mobile'];
				$list[$key]['p_name']=$user['p_name'];
				$list[$key]['available']=intval($list[$key]['available'])/100;  //可以资金
				$list[$key]['prebalance']=intval($list[$key]['prebalance'])/100;  //上日结存
				$list[$key]['balance']=intval($list[$key]['balance'])/100;  //当日结存==客户权益
				$list[$key]['crj']=(intval($list[$key]['deposit'])-intval($list[$key]['withdraw']))/100;  //出入金
				$list[$key]['currmargin']=intval($list[$key]['currmargin'])/100;  //保证金
				$list[$key]['fxd']=strval(round(($list[$key]['currmargin']/$list[$key]['balance'])*100,2)).'%'; //风险度
				$list[$key]['closeprofit']=intval($list[$key]['closeprofit'])/100;  //平仓盈亏
				$list[$key]['positionprofit']=intval($list[$key]['positionprofit'])/100;  //持仓盈亏
				$list[$key]['total_profit']=$list[$key]['closeprofit']+$list[$key]['positionprofit']; //总盈亏
			}
			return $result = ['code'=>0,'msg'=>'获取成功!','count'=>count($list),'data'=>$list];
		}else{
			return $result = ['code'=>-1,'msg'=>'暂无今日资金数据...'];
		}
	}
    return $this->fetch();
  }
  //搜索客户资金
  public function search_money()
  {
	if(Request()->isPost()||!empty(input('export'))){
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
		if(!empty(input('export'))){
			$limit=10000;
			$pre=0;
		}
		//获取当前代理及所有子代理
		$agent=$this->getAllAgentor();
		$allAgentorAid=[];
		array_push($allAgentorAid,session('aid'));
		if($agent){
			foreach($agent as $key=>$value){
				array_push($allAgentorAid,$agent[$key]['id']);
			}
		}

		if($ins_name!=''&&$keywords!=''&&$start_time!=''&&$end_time!=''){
			$new_ins_name=explode(',',$ins_name);
			$agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
			$aid=[];
			foreach ($agent as $key => $value) {
				if(in_array($agent[$key]['id'],$allAgentorAid)){
					array_push($aid, $agent[$key]['id']);
				}
			}
			$user=Db('customer')->where('pid','IN',$aid)->where('true_name|mobile|p_name','like','%'.$keywords.'%')->select();
			$uid=[];
			foreach($user as $key=>$value){
				array_push($uid,$user[$key]['id']);
			}
			$count=Db('account_info_log')->where('uid','IN',$uid)->where('update_time','between time',[$start_time,$end_time])->count();
			if($count>$limit){
				$list=Db('account_info_log')->where('uid','IN',$uid)->where('update_time','between time',[$start_time,$end_time])->limit($pre,$limit)->select();
			}else{
				$list=Db('account_info_log')->where('uid','IN',$uid)->where('update_time','between time',[$start_time,$end_time])->select();
			}
		}else if($ins_name!=''&&$keywords!=''&&$start_time!=''){
			$new_ins_name=explode(',',$ins_name);
			$agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
			$aid=[];
			foreach ($agent as $key => $value) {
				if(in_array($agent[$key]['id'],$allAgentorAid)){
					array_push($aid, $agent[$key]['id']);
				}
			}
			$user=Db('customer')->where('pid','IN',$aid)->where('true_name|mobile|p_name','like','%'.$keywords.'%')->select();
			$uid=[];
			foreach($user as $key=>$value){
				array_push($uid,$user[$key]['id']);
			}
			$count=Db('account_info_log')->where('uid','IN',$uid)->where('update_time','between time',[$start_time,$e_time])->count();
			if($count>$limit){
				$list=Db('account_info_log')->where('uid','IN',$uid)->where('update_time','between time',[$start_time,$e_time])->limit($pre,$limit)->select();
			}else{
				$list=Db('account_info_log')->where('uid','IN',$uid)->where('update_time','between time',[$start_time,$e_time])->select();
			}
			
		}else if($ins_name!=''&&$keywords!=''){
			$new_ins_name=explode(',',$ins_name);
			$agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
			$aid=[];
			foreach ($agent as $key => $value) {
				if(in_array($agent[$key]['id'],$allAgentorAid)){
					array_push($aid, $agent[$key]['id']);
				}
			}
			$user=Db('customer')->where('pid','IN',$aid)->where('true_name|mobile|p_name','like','%'.$keywords.'%')->select();
			$uid=[];
			foreach($user as $key=>$value){
				array_push($uid,$user[$key]['id']);
			}
			$count=Db('account_info_log')->where('uid','IN',$uid)->count();
			if($count>$limit){
				$list=Db('account_info_log')->where('uid','IN',$uid)->limit($pre,$limit)->select();
			}else{
				$list=Db('account_info_log')->where('uid','IN',$uid)->select();
			}
		}else if($ins_name!=''&&$start_time!=''){
			$new_ins_name=explode(',',$ins_name);
			$agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
			$aid=[];
			foreach ($agent as $key => $value) {
				if(in_array($agent[$key]['id'],$allAgentorAid)){
					array_push($aid, $agent[$key]['id']);
				}
			}
			$user=Db('customer')->where('pid','IN',$aid)->select();
			$uid=[];
			foreach($user as $key=>$value){
				array_push($uid,$user[$key]['id']);
			}
			$count=Db('account_info_log')->where('uid','IN',$uid)->where('update_time','between time',[$start_time,$e_time])->count();
			if($count>$limit){
				$list=Db('account_info_log')->where('uid','IN',$uid)->where('update_time','between time',[$start_time,$e_time])->limit($pre,$limit)->select();
			}else{
				$list=Db('account_info_log')->where('uid','IN',$uid)->where('update_time','between time',[$start_time,$e_time])->select();
			}
			
		}else if($start_time!=''&&$end_time!=''&&$keywords!=''){
		  $user=Db('customer')->where('aid','IN',$allAgentorAid)->field('id')->where('true_name|mobile|p_name','like','%'.$keywords.'%')->select();
		  $uid=[];
		  foreach($user as $key=>$value){
			array_push($uid,$user[$key]['id']);
		  }
		  $count=Db('account_info_log')->where('uid','IN',$uid)->where('update_time','between time',[$start_time,$end_time])->count();
		  if($count>$limit){
			  $list=Db('account_info_log')->where('uid','IN',$uid)->where('update_time','between time',[$start_time,$end_time])->limit($pre,$limit)->select();
		  }else{
			  $list=Db('account_info_log')->where('uid','IN',$uid)->where('update_time','between time',[$start_time,$end_time])->select();
		  }
		}else if($start_time!=''&&$keywords!=''){
		  $user=Db('customer')->where('aid','IN',$allAgentorAid)->field('id')->where('true_name|mobile|p_name','like','%'.$keywords.'%')->select();
		  $uid=[];
		  foreach($user as $key=>$value){
			array_push($uid,$user[$key]['id']);
		  }
		  $count=Db('account_info_log')->where('uid','IN',$uid)->where('update_time','between time',[$start_time,$e_time])->count();
		  if($count>$limit){
			  $list=Db('account_info_log')->where('uid','IN',$uid)->where('update_time','between time',[$start_time,$e_time])->limit($pre,$limit)->select();
		  }else{
			  $list=Db('account_info_log')->where('uid','IN',$uid)->where('update_time','between time',[$start_time,$e_time])->select();
		  }
		}else if($start_time!=''&&$end_time!=''){
			$user=Db('customer')->where('aid','IN',$allAgentorAid)->field('id')->select();
			$uid=[];
			foreach($user as $key=>$value){
				array_push($uid,$user[$key]['id']);
			}
		  $count=Db('account_info_log')->where('uid','IN',$uid)->where('update_time','between time',[$start_time,$end_time])->count();
		  if($count>$limit){
			$list=Db('account_info_log')->where('uid','IN',$uid)->where('update_time','between time',[$start_time,$end_time])->limit($pre,$limit)->select();
		  }else{
			$list=Db('account_info_log')->where('uid','IN',$uid)->where('update_time','between time',[$start_time,$end_time])->select();
		  }
		}else if($start_time!=''){
			$user=Db('customer')->where('aid','IN',$allAgentorAid)->field('id')->select();
			$uid=[];
			foreach($user as $key=>$value){
				array_push($uid,$user[$key]['id']);
			}
		  $count=Db('account_info_log')->where('aid','IN',$allAgentorAid)->where('update_time','between time',[$start_time,$e_time])->count();
		  if($count>$limit){
			$list=Db('account_info_log')->where('aid','IN',$allAgentorAid)->where('update_time','between time',[$start_time,$e_time])->limit($pre,$limit)->select();
		  }else{
			$list=Db('account_info_log')->where('aid','IN',$allAgentorAid)->where('update_time','between time',[$start_time,$e_time])->select();
		  }
		}else if($ins_name!=''){
		  $new_ins_name=explode(',',$ins_name);
		  $agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
		  $aid=[];
		  foreach ($agent as $key => $value) {
			  if(in_array($agent[$key]['id'],$allAgentorAid)){
				  array_push($aid, $agent[$key]['id']);
			  }
		  }
		  $user=Db('customer')->where('pid','IN',$aid)->select();
		  $uid=[];
		  foreach($user as $key=>$value){
			array_push($uid,$user[$key]['id']);
		  }
		  $count=Db('account_info_log')->where('uid','IN',$uid)->count();
		  if($count>$limit){
			  $list=Db('account_info_log')->where('uid','IN',$uid)->limit($pre,$limit)->select();
		  }else{
			  $list=Db('account_info_log')->where('uid','IN',$uid)->select();
		  }
		}else if($keywords!=''){
		  $user=Db('customer')->where('aid','IN',$allAgentorAid)->field('id')->where('true_name|mobile|p_name','like','%'.$keywords.'%')->select();
		  $uid=[];
		  foreach($user as $key=>$value){
			array_push($uid,$user[$key]['id']);
		  }
		  $count=Db('account_info_log')->where('uid','IN',$uid)->count();
		  if($count>$limit){
			  $list=Db('account_info_log')->where('uid','IN',$uid)->limit($pre,$limit)->select();
		  }else{
			  $list=Db('account_info_log')->where('uid','IN',$uid)->select();
		  }
		}else{
			$list=false;
		}
        if($list){
			foreach($list as $key=>$value){
				$user=Db('customer')->where('id',$list[$key]['uid'])->find();
				$list[$key]['true_name']=$user['true_name'];
				$list[$key]['mobile']='****';
				$list[$key]['p_name']=$user['p_name'];
				$list[$key]['available']=intval($list[$key]['available'])/100;  //可以资金
				$list[$key]['prebalance']=intval($list[$key]['prebalance'])/100;  //上日结存
				$list[$key]['balance']=intval($list[$key]['balance'])/100;  //当日结存==客户权益
				$list[$key]['crj']=(intval($list[$key]['deposit'])-intval($list[$key]['withdraw']))/100;  //出入金
				$list[$key]['currmargin']=intval($list[$key]['currmargin'])/100;  //保证金
				$list[$key]['fxd']=empty($list[$key]['balance']) ? '0%': strval(round(($list[$key]['currmargin']/$list[$key]['balance'])*100,2)).'%'; //风险度
				$list[$key]['closeprofit']=intval($list[$key]['closeprofit'])/100;  //平仓盈亏
				$list[$key]['positionprofit']=intval($list[$key]['positionprofit'])/100;  //持仓盈亏
				$list[$key]['total_profit']=$list[$key]['closeprofit']+$list[$key]['positionprofit']; //总盈亏
			}
			if(!empty(input('export'))){
				//姓名  账号   手机号    所属机构   账户余额  注册时间
				$xlsName  = "客户资金查询";
				$xlsCell  = array(
					array('create_time','时间'),
					array('zid','账号'),
					array('true_name','姓名'),
					array('mobile','手机号'),
					array('p_name','上级代理'),
					array('prebalance','上日结存'),
					array('available','可用资金'),
					array('balance','客户权益'),
					array('crj','出入金'),
					array('fxd','风险度'),
					array('commission','手续费'),
					array('currmargin','保证金'),
					array('closeprofit','平仓盈亏'),
					array('positionprofit','持仓盈亏'),
					array('total_profit','总盈亏')
				);
				$xlsData  = $list;
				$this->exportExcel($xlsName,$xlsCell,$xlsData);
				return $result=['code'=>-1,'msg'=>'未搜索到相关数据...'];
			}else{
				if(empty($count)) $count=count($list);
				return $result = ['code'=>0,'msg'=>'获取成功!','count'=>$count,'data'=>$list];
			}
		}else{
			return $result = ['code'=>-1,'msg'=>'未搜索到客户资金数据...'];
		}
    }
  }
  //客户资金查询
  public function moneySearch()
  {
    if(Request()->isPost()||!empty(input('export'))){
		$page=input('page');
		$limit=input('limit');
		$pre=($page-1)*$limit;
		if(!empty(input('export'))){
			$limit=10000;
			$pre=0;
		}
		$res=$this->getAllCustomer();
		if($res){
			$uid=[];
			foreach($res as $i=>$v){
				array_push($uid,$res[$i]['id']);
			}
			$count=Db('account_info_log')->where('uid','IN',$uid)->count();
			if($count>$limit){
				$list=Db('account_info_log')->where('uid','IN',$uid)->limit($pre,$limit)->order('create_time DESC')->select();
			}else{
				$list=Db('account_info_log')->where('uid','IN',$uid)->order('create_time DESC')->select();
			}
			if($list){
				foreach ($list as $key=>$value){
					$user=Db('customer')->where('id',$list[$key]['uid'])->find();
					$list[$key]['true_name']=$user['true_name'];
					$list[$key]['mobile']='****';
					$list[$key]['p_name']=$user['p_name'];
					$list[$key]['available']=intval($list[$key]['available'])/100;  //可以资金
					$list[$key]['prebalance']=intval($list[$key]['prebalance'])/100;  //上日结存
					$list[$key]['balance']=intval($list[$key]['balance'])/100;  //当日结存==客户权益
					$list[$key]['crj']=(intval($list[$key]['deposit'])-intval($list[$key]['withdraw']))/100;  //出入金
					$list[$key]['currmargin']=intval($list[$key]['currmargin'])/100;  //保证金
					$list[$key]['fxd']=empty($list[$key]['balance']) ? '0%': strval(round(($list[$key]['currmargin']/$list[$key]['balance'])*100,2)).'%'; //风险度
					$list[$key]['closeprofit']=intval($list[$key]['closeprofit'])/100;  //平仓盈亏
					$list[$key]['positionprofit']=intval($list[$key]['positionprofit'])/100;  //持仓盈亏
					$list[$key]['total_profit']=$list[$key]['closeprofit']+$list[$key]['positionprofit']; //总盈亏
				}
				if(!empty(input('export'))){
					//姓名  账号   手机号    所属机构   账户余额  注册时间
					$xlsName  = "客户资金查询";
					$xlsCell  = array(
						array('create_time','时间'),
						array('zid','账号'),
						array('true_name','姓名'),
						array('mobile','手机号'),
						array('p_name','上级代理'),
						array('prebalance','上日结存'),
						array('available','可用资金'),
						array('balance','客户权益'),
						array('crj','出入金'),
						array('fxd','风险度'),
						array('commission','手续费'),
						array('currmargin','保证金'),
						array('closeprofit','平仓盈亏'),
						array('positionprofit','持仓盈亏'),
						array('total_profit','总盈亏')
					);
					$xlsData  = $list;
					$this->exportExcel($xlsName,$xlsCell,$xlsData);
					return $result=['code'=>-1,'msg'=>'未搜索到相关数据...'];
				}else{
					if(empty($count)) $count=count($list);
					return $result = ['code'=>0,'msg'=>'获取成功!','count'=>$count,'data'=>$list];
				}
			}else{
				return $result = ['code'=>-1,'msg'=>'暂无客户资金数据...'];
			}
		}else{
			return $result = ['code'=>-1,'msg'=>'暂无客户资金数据...'];
		}
	}
    return $this->fetch();
  }
	public function exportExcel($expTitle,$expCellName,$expTableData){
		//Loader::import("PHPExcel\PHPExcel",EXTEND_PATH);
		include_once EXTEND_PATH.'PHPExcel/PHPExcel.php';//方法二
		$xlsTitle = iconv('utf-8', 'gb2312', $expTitle);//文件名称
		$fileName = $expTitle.date('_YmdHis');//or $xlsTitle 文件名称可根据自己情况设定
		$cellNum = count($expCellName);
		$dataNum = count($expTableData);
		//$objPHPExcel = new PHPExcel();//方法一
		$objPHPExcel = new \PHPExcel();//方法二
		$cellName = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ');
		$objPHPExcel->getActiveSheet(0)->mergeCells('A1:'.$cellName[$cellNum-1].'1');//合并单元格
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $expTitle.' '.date('Y-m-d H:i:s'));
		for($i=0;$i<$cellNum;$i++){
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue($cellName[$i].'2', $expCellName[$i][1]);
		}
		// Miscellaneous glyphs, UTF-8
		for($i=0;$i<$dataNum;$i++){
			for($j=0;$j<$cellNum;$j++){
				$objPHPExcel->getActiveSheet(0)->setCellValue($cellName[$j].($i+3), $expTableData[$i][$expCellName[$j][0]]);
			}
		}
		ob_end_clean();//这一步非常关键，用来清除缓冲区防止导出的excel乱码
		header('pragma:public');
		header('Content-type:application/vnd.ms-excel;charset=utf-8;name="'.$xlsTitle.'.xls"');
		header("Content-Disposition:attachment;filename=$fileName.xls");//"xls"参考下一条备注
		$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');//"Excel2007"生成2007版本的xlsx，"Excel5"生成2003版本的xls
		$objWriter->save('php://output');
		exit;
	}
    //客户成交查询
  public function myMoneyFlow()
  {
    if(Request()->isPost()){
		$uid=input('id');
		$page=input('page');
		$limit=input('limit');
		if($page==1){
			$pre=$page;
		}else{
			$pre=($page-1)*$limit;
		}
		$count=Db('user_trade')->where('uid',$uid)->whereTime('create_time','today')->count();
		if($count>$limit){
			$list=Db('user_trade')->where('uid',$uid)->whereTime('create_time','today')->limit($pre,$limit)->select();
		}else{
			$list=Db('user_trade')->where('uid',$uid)->whereTime('create_time','today')->select();
		}
		if($list){
			foreach ($list as $key=>$value){
				$user=Db('customer')->where('id',$uid)->find();
				$list[$key]['true_name']=$user['true_name'];
				$list[$key]['p_name']=$user['p_name'];
				$list[$key]['tradedate']=substr($value['tradedate'],0,4).'-'.substr($value['tradedate'],4,2).'-'.substr($value['tradedate'],6);
				//$list[$key]['tradetime']=date('H:i:s',$value['tradetime']);
				$list[$key]['tradetime']=substr($value['tradetime'],0,2).':'.substr($value['tradetime'],2,2).':'.substr($value['tradetime'],4,2);
			}
			return $result = ['code'=>0,'msg'=>'获取成功!','count'=>count($list),'data'=>$list];
		}else{
			return $result = ['code'=>-1,'msg'=>'暂无今日成交数据...'];
		}
	}
    return $this->fetch();
  }
  //客户成交查询
  public function moneyFlow()
  {
    if(Request()->isPost()){
		$page=input('page');
		$limit=input('limit');
		if($page==1){
			$pre=$page;
		}else{
			$pre=($page-1)*$limit;
		}
		$res=$this->getAllCustomer();
		if($res){
			$uid=[];
			foreach($res as $i=>$v){
				array_push($uid,$res[$i]['id']);
			}
			$count=Db('user_trade')->where('uid','IN',$uid)->count();
			if($count>$limit){
				$list=Db('user_trade')->where('uid','IN',$uid)->limit($pre,$limit)->order('tradedate DESC')->select();
			}else{
				$list=Db('user_trade')->where('uid','IN',$uid)->order('tradedate DESC')->select();
			}
			
			if($list){
				foreach ($list as $key=>$value){
					$user=Db('customer')->where('id',$list[$key]['uid'])->find();
					$list[$key]['true_name']=$user['true_name'];
					$list[$key]['p_name']=$user['p_name'];
					$list[$key]['tradedate']=substr($value['tradedate'],0,4).'-'.substr($value['tradedate'],4,2).'-'.substr($value['tradedate'],6);
					//$list[$key]['tradetime']=date('H:i:s',$value['tradetime']);
					$list[$key]['tradetime']=substr($value['tradetime'],0,2).':'.substr($value['tradetime'],2,2).':'.substr($value['tradetime'],4,2);
				}
				return $result = ['code'=>0,'msg'=>'获取成功!','count'=>$count,'data'=>$list];
			}else{
				return $result = ['code'=>-1,'msg'=>'暂无客户成交数据...'];
			}
		}else{
			return $result = ['code'=>-1,'msg'=>'暂无客户成交数据...'];
		}
	}
    return $this->fetch();
  }
  //搜索客户成交记录
  public function search_flow()
  {
	if(Request()->isPost()||!empty(input('export'))){
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
		if(!empty(input('export'))){
			$limit=10000;
			$pre=0;
		}
		//获取当前代理及所有子代理
		$agent=$this->getAllAgentor();
		$allAgentorAid=[];
		array_push($allAgentorAid,session('aid'));
		if($agent){
			foreach($agent as $key=>$value){
				array_push($allAgentorAid,$agent[$key]['id']);
			}
		}

		if($ins_name!=''&&$start_time!=''&&$end_time!=''&&$keywords!=''){
		  $new_ins_name=explode(',',$ins_name);
		  $agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
		  $aid=[];
		  foreach ($agent as $key => $value) {
			  if(in_array($agent[$key]['id'],$allAgentorAid)){
				  array_push($aid, $agent[$key]['id']);
			  }
		  }
		  $user=Db('customer')->where('aid','IN',$aid)->where('true_name|mobile|p_name','like','%'.$keywords.'%')->select();
		  $uid=[];
		  foreach($user as $key=>$value){
			array_push($uid,$user[$key]['id']);
		  }
		  $count=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$end_time])->count();
		  if($count>$limit){
			$list=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$end_time])->limit($pre,$limit)->select();
		  }else{
			$list=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$end_time])->select();
		  }
		}else if($ins_name!=''&&$start_time!=''&&$end_time!=''){
		  $new_ins_name=explode(',',$ins_name);
		  $agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
		  $aid=[];
		  foreach ($agent as $key => $value) {
			  if(in_array($agent[$key]['id'],$allAgentorAid)){
				  array_push($aid, $agent[$key]['id']);
			  }
		  }
		  $user=Db('customer')->where('aid','IN',$aid)->select();
		  $uid=[];
		  foreach($user as $key=>$value){
			array_push($uid,$user[$key]['id']);
		  }
		  $count=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$end_time])->count();
		  if($count>$limit){
			  $list=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$end_time])->limit($pre,$limit)->select();
		  }else{
			  $list=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$end_time])->select();
		  }
		  
		}else if($ins_name!=''&&$start_time!=''){
		  $new_ins_name=explode(',',$ins_name);
		  $agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
		  $aid=[];
		  foreach ($agent as $key => $value) {
			  if(in_array($agent[$key]['id'],$allAgentorAid)){
				  array_push($aid, $agent[$key]['id']);
			  }
		  }
		  $user=Db('customer')->where('aid','IN',$aid)->select();
		  $uid=[];
		  foreach($user as $key=>$value){
			array_push($uid,$user[$key]['id']);
		  }
		  $count=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$e_time])->count();
		  if($count>$limit){
			$list=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$e_time])->limit($pre,$limit)->select();
		  }else{
			$list=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$e_time])->select();
		  }
		  
		}else if($start_time!=''&&$end_time!=''&&$keywords!=''){
		  $user=Db('customer')->where('aid','IN',$allAgentorAid)->field('id')->where('true_name|mobile|p_name','like','%'.$keywords.'%')->select();
		  $uid=[];
		  foreach($user as $key=>$value){
			array_push($uid,$user[$key]['id']);
		  }
			$count=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$end_time])->count();
		  $list=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$end_time])->select();
		}else if($start_time!=''&&$keywords!=''){
		  $user=Db('customer')->where('aid','IN',$allAgentorAid)->field('id')->where('true_name|mobile|p_name','like','%'.$keywords.'%')->select();
		  $uid=[];
		  foreach($user as $key=>$value){
			array_push($uid,$user[$key]['id']);
		  }
		  $count=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$e_time])->count();
		  if($count>$limit){
			$list=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$e_time])->limit($pre,$limit)->select();
		  }else{
			$list=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$e_time])->select();
		  }
		  
		}else if($start_time!=''&&$end_time!=''){
			$user=Db('customer')->where('aid','IN',$allAgentorAid)->field('id')->select();
			$uid=[];
			foreach($user as $key=>$value){
				array_push($uid,$user[$key]['id']);
			}
			$count=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$end_time])->count();
			if($count>$limit){
				 $list=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$end_time])->limit($pre,$limit)->select();
			}else{
				 $list=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$end_time])->select();
			}
		 
		}else if($start_time!=''){
			$user=Db('customer')->where('aid','IN',$allAgentorAid)->field('id')->select();
			$uid=[];
			foreach($user as $key=>$value){
				array_push($uid,$user[$key]['id']);
			}
			$count=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$e_time])->count();
			if($count>$limit){
				$list=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$e_time])->limit($pre,$limit)->select();
			}else{
				$list=Db('user_trade')->where('uid','IN',$uid)->where('create_time','between time',[$start_time,$e_time])->select();
			}
		  
		}else if($ins_name!=''){
		  $new_ins_name=explode(',',$ins_name);
		  $agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
		  $aid=[];
		  foreach ($agent as $key => $value) {
			  if(in_array($agent[$key]['id'],$allAgentorAid)){
				  array_push($aid, $agent[$key]['id']);
			  }
		  }
		  $user=Db('customer')->where('aid','IN',$aid)->select();
		  $uid=[];
		  foreach($user as $key=>$value){
			array_push($uid,$user[$key]['id']);
		  }
		  $count=Db('user_trade')->where('uid','IN',$uid)->count();
		  if($count>$limit){
			$list=Db('user_trade')->where('uid','IN',$uid)->limit($pre,$limit)->select();
		  }else{
			$list=Db('user_trade')->where('uid','IN',$uid)->select();
		  }
		  
		}else if($keywords!=''){
		  $user=Db('customer')->field('id')->where('true_name|mobile|p_name','like','%'.$keywords.'%')->select();
		  $uid=[];
		  foreach($user as $key=>$value){
			  if(in_array($agent[$key]['id'],$allAgentorAid)){
				  array_push($aid, $agent[$key]['id']);
			  }
		  }
		  $count=Db('user_trade')->where('uid','IN',$uid)->count();
		  if($count>$limit){
			  $list=Db('user_trade')->where('uid','IN',$uid)->limit($pre,$limit)->select();
		  }else{
			  $list=Db('user_trade')->where('uid','IN',$uid)->select();
		  }
		  
		}else{
			$count=0;
			$list=false;
		}
    
        if($list){
			foreach($list as $key=>$value){
				$user=Db('customer')->where('id',$list[$key]['uid'])->find();
				$list[$key]['true_name']=$user['true_name'];
				$list[$key]['p_name']=$user['p_name'];
				$list[$key]['tradedate']=substr($value['tradedate'],0,4).'-'.substr($value['tradedate'],4,2).'-'.substr($value['tradedate'],6);
				//$list[$key]['tradetime']=date('H:i:s',$value['tradetime']);
				$list[$key]['tradetime']=substr($value['tradetime'],0,2).':'.substr($value['tradetime'],2,2).':'.substr($value['tradetime'],4,2);
			}
			if(!empty(input('export'))){
				//姓名  账号   手机号    所属机构   账户余额  注册时间
				$xlsName  = "成交记录查询";
				$xlsCell  = array(
					array('tradedate','日期'),
					array('zid','账号'),
					array('true_name','姓名'),
					array('p_name','上级代理'),
					array('instrumentid','合约'),
					array('direction','方向'),
					array('offset','买卖'),
					array('tradeprice','价格'),
					array('tradevolume','数量'),
					array('commission','手续费'),
					array('tradetime','时间'),
					array('tradeid','成交编号'),
					array('ip','报单IP')
				);
				$xlsData  = $list;
				$this->exportExcel($xlsName,$xlsCell,$xlsData);
				return $result=['code'=>-1,'msg'=>'未搜索到相关数据...'];
			}else{
				return $result = ['code'=>0,'msg'=>'获取成功!','count'=>$count,'data'=>$list];
			}
		}else{
			return $result = ['code'=>-1,'msg'=>'未搜索到客户成交数据...'];
		}
    }	
  }
  //搜索
  public function mySearchMoney()
  {
	if(Request()->isPost()){
		$uid=input('id');
		$start_time=input('start_time');
		$e_time=date('Y-m-d',strtotime("+1 day",strtotime($start_time)));
		$end_time=input('end_time');
		if($end_time!=''){
		  $end_time=date('Y-m-d',strtotime("+1 day",strtotime($end_time)));
		}
		if($start_time!=''&&$end_time!=''){
			$list=Db('account_info_log')->where('uid',$uid)->where('create_time','between time',[$start_time,$end_time])->select();
		}else if($start_time!=''){
			$list=Db('account_info_log')->where('uid',$uid)->where('create_time','between time',[$start_time,$e_time])->select();
		}else{
			$list=false;
		}

		if($list){
			foreach ($list as $key=>$value){
				$user=Db('customer')->where('id',$uid)->find();
				$list[$key]['true_name']=$user['true_name'];
				$list[$key]['mobile']=$user['mobile'];
				$list[$key]['p_name']=$user['p_name'];
				$list[$key]['available']=intval($list[$key]['available'])/100;  //可以资金
				$list[$key]['prebalance']=intval($list[$key]['prebalance'])/100;  //上日结存
				$list[$key]['balance']=intval($list[$key]['balance'])/100;  //当日结存==客户权益
				$list[$key]['crj']=(intval($list[$key]['deposit'])-intval($list[$key]['withdraw']))/100;  //出入金
				$list[$key]['currmargin']=intval($list[$key]['currmargin'])/100;  //保证金
				$list[$key]['fxd']=strval(round(($list[$key]['currmargin']/$list[$key]['balance'])*100,2)).'%'; //风险度
				$list[$key]['closeprofit']=intval($list[$key]['closeprofit'])/100;  //平仓盈亏
				$list[$key]['positionprofit']=intval($list[$key]['positionprofit'])/100;  //持仓盈亏
				$list[$key]['total_profit']=$list[$key]['closeprofit']+$list[$key]['positionprofit']; //总盈亏
			}
			return $result = ['code'=>0,'msg'=>'获取成功!','count'=>count($list),'data'=>$list];
		}else{
			return $result = ['code'=>-1,'msg'=>'暂未搜索到成交数据...'];
		}
		
	}
  }
  //搜索
  public function mySearchMoneyFlow()
  {
	if(Request()->isPost()){
		$uid=input('id');
		$start_time=input('start_time');
		$e_time=date('Y-m-d',strtotime("+1 day",strtotime($start_time)));
		$end_time=input('end_time');
		if($end_time!=''){
		  $end_time=date('Y-m-d',strtotime("+1 day",strtotime($end_time)));
		}
		if($start_time!=''&&$end_time!=''){
			$list=Db('user_trade')->where('uid',$uid)->where('create_time','between time',[$start_time,$end_time])->select();
		}else if($start_time!=''){
			$list=Db('user_trade')->where('uid',$uid)->where('create_time','between time',[$start_time,$e_time])->select();
		}else{
			$list=false;
		}
		if($list){
			foreach ($list as $key=>$value){
				$user=Db('customer')->where('id',$uid)->find();
				$list[$key]['true_name']=$user['true_name'];
				$list[$key]['p_name']=$user['p_name'];
				$list[$key]['tradedate']=substr($value['tradedate'],0,4).'-'.substr($value['tradedate'],4,2).'-'.substr($value['tradedate'],6);
				//$list[$key]['tradetime']=date('H:i:s',$value['tradetime']);
				$list[$key]['tradetime']=substr($value['tradetime'],0,2).':'.substr($value['tradetime'],2,2).':'.substr($value['tradetime'],4,2);
			}
			return $result = ['code'=>0,'msg'=>'获取成功!','count'=>count($list),'data'=>$list];
		}else{
			return $result = ['code'=>-1,'msg'=>'暂未搜索到成交数据...'];
		}
	}
  }
  //删除或禁用客户
  private function setCustomer($id,$flag)
  {
    //$flag=2为彻底删除，-1为软删除即加入黑名单，1为禁用；
    if($flag==1){//设置禁用
      $res=Db('customer')->where('id',$id)->update(['status'=>1]);
      if($res){
        return true;
      }else{
        return false;
      }
    }else if($flag==-1){//加入黑名单
      $res=Db('customer')->where('id',$id)->update(['status'=>-1]);
      if($res){
        return true;
      }else{
        return false;
      }
    }else if($flag==2){//彻底删除
      $res=Db('customer')->where('id',$id)->delete();
      if($res){
        return true;
      }else{
        return false;
      }
    }else if($flat==0){//设置启用
      $res=Db('customer')->where('id',$id)->update(['status'=>0]);
      if($res){
        return true;
      }else{
        return false;
      }
    }
  }
  //获取某一客户的资料
  private function getCustomerInfo($id)
  {
    $res=Db('customer')->where('id',$id)->find();
    if($res){
      switch ($res['status']) {
        case 0:
          $res['status']='正常';
          break;
        case -1:
          $res['status']='黑名单';
          break;
        case 1:
          $res['status']='禁用';
          break;
      }
      if($res['add_time']!=NULL){
        $res['add_time']=date('Y-m-d H:i:s',$res['add_time']);
      }else{
        $res['add_time']='';
      }
    }
    return $res;
  }


  //获取所有客户数据
  private function getCustomerData(){
    $res=Db('customer')->where('status','IN',[0,1])->select();
    if($res){
      foreach ($res as $k => $v) {
        switch ($res[$k]['status']) {
          case 1:
            $res[$k]['status']='锁定';
            break;
          case -1:
            $res[$k]['status']='黑名单';
            break;
          default:
            $res[$k]['status']='正常';
            break;
        }
        if($res[$k]['add_time']!=NULL){
          $res[$k]['add_time']=date('Y-m-d H:i:s',$v['add_time']);
        }else{
          $res[$k]['add_time']='';
        }
      }
    }
    return $res;
  }
    
}
