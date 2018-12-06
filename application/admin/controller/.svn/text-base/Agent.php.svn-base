<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Input;

class Agent extends Common
{
  public function _initialize(){
    parent::_initialize();
  }
  public function index()
  {
    return $this->fetch();
  }
  //机构管理
  public function insManage()
  {
    if(Request()->isPost()){
		$page=input('page');
		$limit=input('limit');
		$pre=($page-1)*$limit;
		$count=Db('agentor')->where('status','IN',[0,1])->count();
      $list=$this->getAgentorData(1,$pre,$limit);
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
		}
        return $result = ['code'=>0,'msg'=>'获取成功','count'=>$count,'data'=>$list];
      }else{
		return $result = ['code'=>-1,'msg'=>'暂无机构数据...'];
	  }
    }
    return $this->fetch();
  }
  //选择代理
  public function agentInfo()
  {
    if(Request()->isPost()){
        //$list=Db('agent_config')->field('id,name')->where('id',1)->select();
	    ////所有一级代理  $agentor=[];
		$list=Db('agentor')->field('id,user_name,true_name')->where('pid',0)->select();
		if($list){
			foreach ($list as $i => $value) {
				//所有二级代理
				$two_agent=$this->findSubAgentor($list[$i]['id']);
				if($two_agent){
					//array_push($list[$i],$two_agent);
					foreach ($two_agent as $j => $value) {
						//所有三级代理
						$three_agent=$this->findSubAgentor($two_agent[$j]['id']);
						if($three_agent){
							//array_push($two_agent[$j],$three_agent);
							foreach ($three_agent as $k => $value) {
								//所有四级代理
								$four_agent=$this->findSubAgentor($three_agent[$k]['id']);
								if($four_agent){
								  array_push($three_agent[$k],$four_agent);
								  //array_push($two_agent[$j],$three_agent);
								  //array_push($list[$i],$two_agent);
								}
								
							}
							array_push($two_agent[$j],$three_agent);
						}
						
					}
					array_push($list[$i],$two_agent);
				}
			}
		}



        $zNodes=[];
        for($i=0;$i<count($list);$i++){
			$newArr1=[];
			if(count($list[$i])>0){
				$newArr1['id']=$i+1; //顶层 1
				$newArr1['pId']=0; // 0
				$newArr1['name']=$list[$i]['true_name'].'-'.$list[$i]['user_name'];
				$newArr1['open']=false;
				array_push($zNodes,$newArr1);
				if(isset($list[$i][0])){
					$newArr2=[];
					for($j=0;$j<count($list[$i][0]);$j++){
						//dump($i);die;
						$newArr2['id']=($i+1)*10+($j+1); //二层 11
						$newArr2['pId']=($i+1); // 1
						$newArr2['name']=$list[$i][0][$j]['true_name'].'-'.$list[$i][0][$j]['user_name'];
						$newArr2['open']=false;
						array_push($zNodes,$newArr2);
						if(isset($list[$i][0][$j][0])){
							$newArr3=[];
							for($k=0;$k<count($list[$i][0][$j][0]);$k++){
								$newArr3['id']=($i+1)*100+($j+1)*10+($k+1); //三层 111
								$newArr3['pId']=($i+1)*10+($j+1); // 11
								$newArr3['name']=$list[$i][0][$j][0][$k]['true_name'].'-'.$list[$i][0][$j][0][$k]['user_name'];
								$newArr3['open']=false;
								array_push($zNodes,$newArr3);
								if(isset($list[$i][0][$j][0][$k][0])){
									$newArr4=[];
									for($l=0;$l<count($list[$i][0][$j][0][$k][0]);$l++){
										$newArr4['id']=($i+1)*1000+($j+1)*100+($k+1)*10+($l+1); //四层 1111
										$newArr4['pId']=($i+1)*100+($j+1)*10+($k+1); // 111
										$newArr4['name']=$list[$i][0][$j][0][$k][0][$l]['true_name'].'-'.$list[$i][0][$j][0][$k][0][$l]['user_name'];
										$newArr4['open']=false;
										array_push($zNodes,$newArr4);
									}
								}
							}
						}
					}
				}
			}
        }

		return json($zNodes);
    }
   // dump($zNodes);die;
    return $this->fetch();
  }
  //我的流水
  public function myInsFlow()
  {
    if(Request()->isPost()){
	  $aid=input('id');
	  $page=input('page');
	  $limit=input('limit');
	  if($page==1){
			$pre=$page;
	  }else{
		  $pre=($page-1)*$limit;
	  }
	  $count=Db('flow_log')->where('aid',$aid)->where('type',0)->count();
	  if($count>1){
		$list=Db('flow_log')->where('aid',$aid)->where('type',0)->limit($pre,$limit)->order('add_time DESC')->select();
	  }else{
		$list=Db('flow_log')->where('aid',$aid)->where('type',0)->order('add_time DESC')->select();
	  }
      
      if($list){
        foreach ($list as $key => $value) {
          $res=Db('agentor')->where('id',$list[$key]['aid'])->find();
          $list[$key]['user_name']=$res['user_name'];
          $list[$key]['true_name']=$res['true_name'];
          $list[$key]['p_name']=$res['p_name'];
          switch ($list[$key]['type']) {
            case 0:
              $list[$key]['type']='返佣';
              break;
            case 1:
              $list[$key]['type']='返佣';
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
		return $result = ['code'=>-1,'msg'=>'暂无今日机构流水数据...'];
	  }
    }
  }
  //所有下级代理
  public function findSubAgentor($id){
    $agent=Db('agentor')->field('id,user_name,true_name')->where(['status'=>0,'pid'=>$id])->select();
    if($agent){
      return $agent;
    }else{
      return array();
    }
  }
  //机构编辑
  public function edit_insManage()
  {
    if(Request()->isPost()){
      $id=input('id');
      $user_pwd=trim(input('user_pwd'));
	  $mzh_id=input('mzh_id');
	  $sxf_id=input('sxf_id');
	  $fk_id=input('fk_id');
	  $status=input('status');
      $id_card=input('id_card');
      $bank_name=input('bank_name');
      $bank_card=input('bank_card');
      $agent=Db('agentor')->where('id',$id)->find();
      if($agent){
		  if($user_pwd!=''){
            $user_pwd = md5($user_pwd);
			$res=Db('agentor')->where('id',$id)->update(['user_pwd'=>$user_pwd,'id_card'=>$id_card,'bank_name'=>$bank_name,'bank_card'=>$bank_card,'mzh_id'=>$mzh_id,'status'=>$status,'sxf_id'=>$sxf_id,'fk_id'=>$fk_id]);
			if($res){
			  return json(['code'=>1,'msg'=>'资料修改成功']);
			}else{
			  return json(['code'=>0,'msg'=>'资料修改失败']);
			}
		}else{
			$res=Db('agentor')->where('id',$id)->update(['id_card'=>$id_card,'bank_name'=>$bank_name,'bank_card'=>$bank_card,'mzh_id'=>$mzh_id,'status'=>$status,'sxf_id'=>$sxf_id,'fk_id'=>$fk_id]);
			if($res){
			  return json(['code'=>1,'msg'=>'资料修改成功']);
			}else{
			  return json(['code'=>0,'msg'=>'资料修改失败']);
			}
		}
      }else{
		return json(['code'=>-1,'msg'=>'未找到该用户']);
	  }
    }
  }
  //机构设置
  public function set_insManage()
  {
    if(Request()->isPost()){
      $id=input('id');
      $data=[
        'jszq'=>input('jszq'),
        'ptglf'=>intval(trim(input('ptglf'))),
        'lrfc'=>intval(trim(input('lrfc'))),
        'sxf'=>intval(trim(input('sxf'))),
        'jsfwf'=>intval(trim(input('jsfwf')))
      ];
      $agent=Db('agentor')->where('id',$id)->find();
      if($agent){
        $res=Db('agentor')->where('id',$id)->update($data);
        if($res){
          return json(['code'=>1,'msg'=>'设置成功']);
        }else{
          return json(['code'=>0,'msg'=>'设置失败']);
        }
      }
    }
  }

  //机构手续费设置
  public function insSetting(){

      if(Request()->isPost()){
        $fields['user_name']=input('user_name');
        $fields['cid']=input('cid');
        $fields['rate']=input('rate',0);
        $fields['remark']=input('remark');
        $action=input('action','list');
        $data=[
            'user_name'=>$fields['user_name'],
            'cid'=>$fields['cid'],
            'rate'=>$fields['rate'],
            'remark'=>$fields['remark']
        ];
        switch($action){
          case 'list':
                $res=Db('fanyong_setting')->where('user_name',$fields['user_name'])->select();
                return json(['code'=>0,'msg'=>'获取数据完成','user_name'=>$fields['user_name'],'data'=>$res]);
                break;
          case 'del':
                Db('fanyong_setting')->where('id',input('id'))->delete();
                return json(['code'=>1,'msg'=>'操作成功！','data'=>'']);
                break;
          case 'edit':
            if(empty($fields['user_name'])||empty($fields['cid']))
            $res=Db('fanyong_setting')->where('user_name',$fields['user_name'])->where('cid',$fields['cid'])->find();
            if(empty($res) && empty(input('id'))){
              $result=Db('fanyong_setting')->insert($data);
              if($result){
                return json(['code'=>1,'msg'=>'设置成功','url'=>url('riskSetting')]);
              }else{
                return json(['code'=>0,'msg'=>'设置失败']);
              }
            }else{
              $id=input('id');
              $updateData['rate']= $fields['rate'];
              $updateData['remark']= $fields['remark'];
              $result=Db('fanyong_setting')->where(['id'=>$id])->update($updateData,true);
              if($result){
                return json(['code'=>1,'msg'=>'设置成功','url'=>url('insSetting')]);
              }else{
                return json(['code'=>0,'msg'=>'设置失败']);
              }
            }
                break;
          default:
                break;
        }
      }
      $list=Db('risk_setting')->where(['id'=>1,'status'=>0])->find();
      $this->assign('list',$list);
      return $this->fetch();

  }
  //注册机构或代理
  public function add_ins()
  {
    if(Request()->isPost()){
      $aid=input('aid');
      $agent_class=Db('agent_config')->where('id',$aid)->find();
      $mobile=trim(input('mobile'));
      $res=Db('agentor')->where('mobile',$mobile)->find();
      if(!$res){
        $data=[
          'aid'=>$aid,
          'user_name'=>$mobile,
          'user_pwd'=>md5(trim(input('user_pwd'))),
          'true_name'=>trim(input('true_name')),
          'p_name'=>trim(input('true_name')),
          'ins_name'=>trim(input('true_name')),
          'agent_class'=>$agent_class['name'],
          'mobile'=>$mobile,
          'code'=>mt_rand(1000,9999),
          'add_time'=>time()
        ];
        $result=Db('agentor')->insert($data);
        if($result){
          return json(['code'=>1,'msg'=>'用户注册成功！']);
        }else{
          return json(['code'=>0,'msg'=>'用户注册失败！']);
        }
      }else{
        return json(['code'=>0,'msg'=>'用户手机号已存在！']);
      }
    }
  }
  //注册代理
  public function register()
  {
    if(Request()->isPost()){
      $pid=input('pid');
      $agent=Db('agentor')->where('id',$pid)->find();
      $aid=$agent['aid']+1;
      if($aid>4){
        return json(['code'=>0,'msg'=>'当前用户为四级代理不能在其下面注册新代理']);
      }
      $agent_class=Db('agent_config')->where('id',$aid)->find();
      if($agent){
        $data=[
          'aid'=>$aid,
          'tid'=>$agent['tid'],
          'pid'=>$agent['id'],
          'zg_id'=>$agent['zg_id'],
          'mzh_id'=>$agent['mzh_id'],
          'sxf_id'=>$agent['sxf_id'],
          'fk_id'=>$agent['fk_id'],
          'user_name'=>trim(input('mobile')),
          'user_pwd'=>md5(trim(input('user_pwd'))),
          'true_name'=>trim(input('true_name')),
          'p_name'=>$agent['true_name'],
          'ins_name'=>$agent['ins_name'],
          'agent_class'=>$agent_class['name'],
          'mobile'=>trim(input('mobile')),
          'code'=>mt_rand(1000,9999),
          'add_time'=>time()
        ];
        $res=Db('agentor')->where('mobile',$data['mobile'])->find();
        if(!$res){
          Db('agentor')->insert($data);
          return json(['code'=>1,'msg'=>'用户注册成功！']);
        }else{
          return json(['code'=>0,'msg'=>'该代理用户手机号已存在,请更换手机号注册']);
        }
      }else{
        return json(['code'=>0,'msg'=>'代理用户不存在']);
      }
    }
  }
  //删除代理
  public function del_agentor(){
    if(Request()->isPost()){
      $id=input('id');
	  $res=Db('customer')->where('pid',$id)->find();
      if(!$res){
		  Db('agentor')->where('id',$id)->delete();
          return json(['code'=>1,'msg'=>'删除成功！']);
      }else{
        return json(['code'=>0,'msg'=>'该代理下有客户不能删除']);
      }
    }
  }
  //删除代理,加入黑名单管理
  public function userDel()
  {
    if(Request()->isPost()){
      $id=input('id');
      $res=$this->setAgentor($id,-1);//加入黑名单
      if($res){
        return json(['code'=>1,'msg'=>'黑名单添加成功！']);
      }else{
        return json(['code'=>0,'msg'=>'删除失败！']);
      }
    }
  }

  //代理黑名单
  public function userBlack()
  {
    if(Request()->isPost()){
      $id=input('id');
      $res=$this->setAgentor($id,2);//彻底删除
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
    $list=Db('agentor')->where('status',-1)->select();
    if($list){
      foreach ($list as $k => $v) {
        switch ($list[$k]['status']) {
          case 1:
            $list[$k]['status']='锁定';
            break;
          case -1:
            $list[$k]['status']='黑名单';
            break;
          default:
            $list[$k]['status']='正常';
            break;
        }
        if($list[$k]['add_time']!=NULL){
          $list[$k]['add_time']=date('Y-m-d H:i:s',$v['add_time']);
        }else{
          $list[$k]['add_time']='';
        }
      }
      return $result=['code'=>0,'msg'=>'','data'=>$list];
    }
  }
  //获取所有代理ID
  public function getAgentId()
  {
    $agent=Db('agentor')->field('id,true_name')->select();
    if($agent){
      return json($agent);
    }
  }
  //查看代理资料
  public function userInfo()
  {
    $id=input('id');
    $list=$this->getAgentorInfo($id);
    if($list){
      $this->assign('list',$list);
    }
    return $this->fetch();
  }
  //获取上级代理信息
    public function getPrefAgentor()
    {
        if(Request()->isPost()){
            $id=input('id');
            $pid=input('pid');
            $res=Db('agentor')->where('id',$pid)->find();
            if($res){
                return $res;
            }else{
                $data=Db('agentor')->where('id',$id)->find();
                return $data;
            }
        }
    }
  //获取代理下的所有下级代理
  public function getSubAgentor($id)
  {
    $res=Db('agentor')->where('pid',$id)->select();
    foreach($res as &$v){
      $v['add_time'] = date('Y-m-d H:i:s',$v['add_time']);
    }
    if($res){
      return $res;
    }
  }
  //查看下级代理数据
  public function subAgentorList()
  {
    if(Request()->isPost()){
      $id=input('id');
      $list=$this->getSubAgentor($id);
      if($list){
        return $result = ['code'=>0,'msg'=>'获取成功','data'=>$list];
      }else{
        return $result = ['code'=>-1,'msg'=>'数据为空'];
      }
    } 
  }
  //获取代理下的所有客户
  public function getSubCustomer($id)
  {
    $res=Db('customer')->where('aid',$id)->select();
    foreach($res as &$v){
      $v['add_time'] = date('Y-m-d H:i;s',$v['add_time']);
    }
    if($res){
      return $res;
    }
  }
  //查看代理下的客户数据
  public function subCustomerList()
  {
    if(Request()->isPost()){
      $id=input('id');
      $list=$this->getSubCustomer($id);
      if($list){
        return $result = ['code'=>0,'msg'=>'获取成功','data'=>$list];
      }else{
        return $result = ['code'=>-1,'msg'=>'数据为空'];
      }
    }
  }

  //代理管理
  public function agentManage(){
        if(Request()->isPost()){
            $list=Db('agentor')->where('aid','NEQ',1)->where('pid',session('aid'))->where('status','IN',[0,1])->select();

            foreach($list as $v){
                $list2=$this->getSubAgentor($v['id']);
                if(is_array($list2)){
                    $list = array_merge($list,$list2);
                    foreach($list2 as $vv){
                        $list3=$this->getSubAgentor($vv['id']);
                        if(is_array($list3)){
                            $list = array_merge($list,$list3);
                            foreach($list3 as $vvv) {
                            $list4 = $this->getSubAgentor($vvv['id']);
                                if(is_array($list4)) {
                                    $list = array_merge($list, $list4);
                                }
                            }
                        }
                    }
                }
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
          switch ($list[$key]['status']) {
            case 1:
              $list[$key]['status']='锁定';
              break;
            case -1:
              $list[$key]['status']='黑名单';
              break;
            case 0:
              $list[$key]['status']='正常';
              break;
          }
		}
          $count = count($list);
        return $result = ['code'=>0,'msg'=>'获取成功','count'=>$count,'data'=>$list];
      }else{
		return $result = ['code'=>-1,'msg'=>'暂无代理数据...'];
	  }
    }
    return $this->fetch();
  }

  //经纪人管理
  public function agentList()
  {
    
    return $this->fetch();
  }
  //经纪人审核
  public function agentCheck()
  {
    
    return $this->fetch();
  }
  //搜索机构
  public function search_ins()
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
			$pre=($page-1)*$limit;
		}
		if($ins_name!=''&&$start_time!=''&&$end_time!=''&&$keywords!=''){
		  $new_ins_name=explode(',',$ins_name);
		  $agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
		  $aid=[];
		  foreach ($agent as $key => $value) {
			array_push($aid, $agent[$key]['id']);
		  }
		  $count=Db('agentor')->where('id','IN',$aid)->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->where('add_time','between time',[$start_time,$end_time])->count();
		  if($count>$limit){
			$list=Db('agentor')->where('id','IN',$aid)->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->where('add_time','between time',[$start_time,$end_time])->limit($pre,$limit)->select();
		  }else{
			  $list=Db('agentor')->where('id','IN',$aid)->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->where('add_time','between time',[$start_time,$end_time])->select();
		  }
		  
		}else if($ins_name!=''&&$start_time!=''&&$end_time!=''){
		  $new_ins_name=explode(',',$ins_name);
		  $agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
		  $aid=[];
		  foreach ($agent as $key => $value) {
			array_push($aid, $agent[$key]['id']);
		  }
		  $count=Db('agentor')->where('id','IN',$aid)->where('add_time','between time',[$start_time,$end_time])->count();
		  if($count>$limit){
			  $list=Db('agentor')->where('id','IN',$aid)->where('add_time','between time',[$start_time,$end_time])->limit($pre,$limit)->select();
		  }else{
			  $list=Db('agentor')->where('id','IN',$aid)->where('add_time','between time',[$start_time,$end_time])->select();
		  }
		  
		}else if($ins_name!=''&&$start_time!=''){
		  $new_ins_name=explode(',',$ins_name);
		  $agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
		  $aid=[];
		  foreach ($agent as $key => $value) {
			array_push($aid, $agent[$key]['id']);
		  }
		  $count=Db('agentor')->where('id','IN',$aid)->where('add_time','between time',[$start_time,$e_time])->count();
		  if($count>$limit){
			  $list=Db('agentor')->where('id','IN',$aid)->where('add_time','between time',[$start_time,$e_time])->limit($pre,$limit)->select();
		  }else{
			  $list=Db('agentor')->where('id','IN',$aid)->where('add_time','between time',[$start_time,$e_time])->select();
		  }
		  
		}else if($start_time!=''&&$end_time!=''&&$keywords!=''){
			$count=Db('agentor')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->where('add_time','between time',[$start_time,$end_time])->count();
			if($count>$limit){
				$list=Db('agentor')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->where('add_time','between time',[$start_time,$end_time])->limit($pre,$limit)->select();
			}else{
				$list=Db('agentor')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->where('add_time','between time',[$start_time,$end_time])->select();
			}
		  
		}else if($start_time!=''&&$keywords!=''){
			$count=Db('agentor')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->where('add_time','between time',[$start_time,$e_time])->count();
			if($count>$limit){
				$list=Db('agentor')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->where('add_time','between time',[$start_time,$e_time])->limit($pre,$limit)->select();
			}else{
				$list=Db('agentor')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->where('add_time','between time',[$start_time,$e_time])->select();
			}
		  
		}else if($start_time!=''&&$end_time!=''){
			$count=Db('agentor')->where('add_time','between time',[$start_time,$end_time])->count();
			if($count>$limit){
				$list=Db('agentor')->where('add_time','between time',[$start_time,$end_time])->limit($pre,$limit)->select();
			}else{
				$list=Db('agentor')->where('add_time','between time',[$start_time,$end_time])->select();
			}
		  
		}else if($start_time!=''){
			$count=Db('agentor')->where('add_time','between time',[$start_time,$e_time])->count();
			if($count>$limit){
				$list=Db('agentor')->where('add_time','between time',[$start_time,$e_time])->limit($pre,$limit)->select();
			}else{
				$list=Db('agentor')->where('add_time','between time',[$start_time,$e_time])->select();
			}
		  
		}else if($ins_name!=''){
		  $new_ins_name=explode(',',$ins_name);
		  $agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
		  $aid=[];
		  foreach ($agent as $key => $value) {
			array_push($aid, $agent[$key]['id']);
		  }
		  $count=Db('agentor')->where('id','IN',$aid)->count();
		  if($count>$limit){
			$list=Db('agentor')->where('id','IN',$aid)->limit($pre,$limit)->select();
		  }else{
			  $list=Db('agentor')->where('id','IN',$aid)->select();
		  }
		  
		}else if($keywords!=''){
			$count=Db('agentor')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->count();
			if($count>$limit){
				$list=Db('agentor')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->limit($pre,$limit)->select();
			}else{
				$list=Db('agentor')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->select();
			}
		  
		}else{
			$list=false;
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
				switch ($list[$key]['status']) {
				  case 1:
				  $list[$key]['status']='锁定';
				  break;
				  case -1:
				  $list[$key]['status']='黑名单';
				  break;
				  default:
				  $list[$key]['status']='正常';
				  break;
				}
				if($list[$key]['add_time']!=NULL){
				  $list[$key]['add_time']=date('Y-m-d H:i:s',$value['add_time']);
				}else{
				  $list[$key]['add_time']='';
				}
			  }
			return $result = ['code'=>0,'msg'=>'获取成功','count'=>$count,'data'=>$list];
		  }else{
			return $result = ['code'=>-1,'msg'=>'没有搜索到相关数据'];
		  }
    }
  }
  //机构检索
  public function ins_serch()
  {
    $list=Db('agent_config')->field('id,name')->select();
	$count=Db('agent_config')->field('id,name')->count();
    foreach ($list as $k => $v) {
      $agentor=Db('agentor')->field('agent_name')->where(['aid'=>$list[$k]['id'],'status'=>0])->select();
      array_push($list[$k], $agentor);
    }
    return $result=['code'=>0,'msg'=>'获取成功','count'=>$count,'data'=>$list];
  }
  //删除或禁用客户
  private function setAgentor($id,$flag)
  {
    //$flag=2为彻底删除，-1为软删除即加入黑名单，1为禁用；
    if($flag==1){//设置禁用
      $res=Db('agentor')->where('id',$id)->update(['status'=>1]);
      if($res){
        return true;
      }else{
        return false;
      }
    }else if($flag==-1){//加入黑名单
      $res=Db('agentor')->where('id',$id)->update(['status'=>-1]);
      if($res){
        return true;
      }else{
        return false;
      }
    }else if($flag==2){//彻底删除
      $res=Db('agentor')->where('id',$id)->delete();
      if($res){
        return true;
      }else{
        return false;
      }
    }else if($flag==0){//设置启用
      $res=Db('agentor')->where('id',$id)->update(['status'=>0]);
      if($res){
        return true;
      }else{
        return false;
      }
    }
  }
  //获取某一客户的资料
  private function getAgentorInfo($id)
  {
    $res=Db('agentor')->where('id',$id)->find();
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
  //获取代理用户数据
  private function getAgentorData($level,$pre,$limit){
    if($level==1){
      $res=Db('agentor')->where('aid','EQ',1)->where('status','IN',[0,1])->limit($pre,$limit)->select();
    }else if($level==2){
      $res=Db('agentor')->where('aid','NEQ',1)->where('status','IN',[0,1])->limit($pre,$limit)->select();
    }else{
        $res=Db('agentor')->where('status','IN',[0,1])->limit($pre,$limit)->select();
    }
    if($res){
      foreach ($res as $k => $v) {
        switch ($res[$k]['status']) {
          case 1:
            $res[$k]['status']='锁定';
            break;
          case -1:
            $res[$k]['status']='黑名单';
            break;
          case 0:
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

  //获取数据
  public function getData()
  {
	if(Request()->isPost()){
		$zg=Db('zg_sys')->where('status',0)->select();
		$mzh=Db('mzh_config')->where('status',0)->select();
		$fk=Db('fk_config')->where('status',0)->select();
		$sxf_mb=Db('sxf_mb')->where('status',0)->select();
		return json(['zg'=>$zg,'mzh'=>$mzh,'fk'=>$fk,'sxf_mb'=>$sxf_mb]);
	}
  }


 
}
