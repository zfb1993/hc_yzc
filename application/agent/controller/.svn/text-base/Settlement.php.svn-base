<?php
namespace app\agent\controller;
use think\Controller;
use think\Db;
use think\Input;

class Settlement extends Common
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
			$uid=[];
			foreach($list as $k=>$v){
				array_push($uid,$list[$k]['zid']);
			}
			return $uid;
		}
	}else{
		$list=Db('customer')->where('aid',session('aid'))->select();
		$uid=[];
		foreach($list as $k=>$v){
			array_push($uid,$list[$k]['zid']);
		}
		return $uid;
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
  
  //经纪人结算
  public function agent_settlement()
  {
	  if(Request()->isPost()||!empty(input('export'))){
		  $keywords=input('keywords');
		  $start_time=input('start_time');
		  $end_time=input('end_time');
		  $now_date = date('Ymd',time());
		  if(empty(input('start_time'))){
			  $start = $now_date;
		  }else{
			  $start=date('Ymd',strtotime($start_time));
		  }
		  if(empty(input('end_time'))){
			  $end   =   $now_date;
		  }else{
			  $end=date('Ymd',strtotime($end_time));
		  }
		  $page=input('page',1);
		  $limit=input('limit',10);
		  $pre=($page-1)*$limit;
		  $ins_name=input('ins_name');
		  $type=input('type');
		  $where=array();
		  if(isset($type) && $type !=-1){
			  $where['status']=$type;
		  }
		  if(!empty(input('export'))){
			  $limit=10000;
			  $pre=0;
		  }

		  //获取这个代理下所有客户列表
		  $zidArr=$this->getAllCustomer();
//		  $where['zaccount']=array('in',$zidArr);

//		  if(!empty($ins_name) && empty($keywords)){
//			  $new_ins_name=explode(',',$ins_name);
//			  $agent=Db('agentor')->where('user_name','IN',$new_ins_name)->field('id')->select();
//			  $aid=[];
//			  foreach ($agent as $key => $value) {
//				  array_push($aid, $agent[$key]['id']);
//			  }
//			  $customerList=Db('customer')->where($where)->where('aid','IN',$aid)->field('zid')->select();
//			  $zid=[];
//			  foreach ($customerList as $k => $v) {
//				  if(in_array($customerList[$k]['zid'],$zidArr)){
//					  array_push($zid, $customerList[$k]['zid']);
//				  }
//			  }
//			  $where['zaccount']=array('in',$zid);
//		  }

			$uid=[];
			if(!empty($ins_name)){
				$new_ins_name=explode(',',$ins_name);
				$agent_arr=Db('agentor')->where('user_name','IN',$new_ins_name)->field('id')->select();
				$agent_arr_new=array();
				foreach ($agent_arr as $v){
					array_push($agent_arr_new,$v['id']);
				}
				$agent=get_child_agentinfo_byid($agent_arr_new,0);
				$aid=join(',',$agent);
			}else{
				$agent=get_child_agentinfo_byid(array(session('aid')),0);
				$aid=join(',',$agent);
			}
			
			$user=Db('customer')->where('pid','IN',$aid)->select();
			foreach($user as $key=>$value){
				array_push($uid,$user[$key]['zid']);
			}
			$where['zaccount']=array('in',$uid);



		  if(!empty($keywords)){
			  $zid=Db::name('customer')->where('user_name',$keywords)->value('zid');
			  $zidSeach='';
			  if(in_array($zid,$zidArr)){
				  $zidSeach=$zid;
			  }
			  $where['zaccount']=$zidSeach;
		  }

		$where['tradedate']= array(array('egt',$start),array('elt',$end ));
		$count=Db::connect(config('db_trade'))->table('yp_trade_static')->where($where)->count();
		$list=Db::connect(config('db_trade'))->table('yp_trade_static')->where($where)->order('id DESC')->limit($pre,$limit)->select();
		if($list){
			$aid=session('aid');
			$level=Db::name('agentor')->where('id',$aid)->value('aid');
			foreach($list as $key=>$value){
				$list[$key]['status']=($list[$key]['status']==0)?'未结算':'已结算';
				$list[$key]['tradevolume']=$list[$key]['tradevolume']/2;
				if(!is_int($list[$key]['tradevolume'])){
					$list[$key]['tradevolume'] = round($list[$key]['tradevolume']);
				}
				if(!empty($list[$key]['zaccount'])){
					$customerInfo=Db::name('customer')->where('zid',$list[$key]['zaccount'])->find();

					if(!empty($customerInfo)){
						$list[$key]['user_name']=$customerInfo['user_name'];
						$list[$key]['true_name']=$customerInfo['true_name'];
					}
				}
				$list[$key]['p']='';

				switch($level){
					case 1:
						$list[$key]['p']=$list[$key]['p1'];
						break;
					case 2:
						$list[$key]['p']=$list[$key]['p2'];
						break;
					case 3:
						$list[$key]['p']=$list[$key]['p3'];
						break;
					case 4:
						$list[$key]['p']=$list[$key]['p4'];
						break;
					default:
						break;
				}

			}

			if(!empty(input('export'))){
				//姓名  账号   手机号    所属机构   账户余额  注册时间
				$xlsName  = "代理返佣结算报表";
				$xlsCell  = array(
					array('create_time','清算时间'),
					array('tradedate','交易日'),
					array('user_name','客户账号'),
					array('instrumentid','合约'),
					array('tradevolume','交易手数'),
					array('commission','总手续费'),
					array('p','返佣金额'),
					array('zaccount','客户ID'),
					array('true_name','客户姓名'),
					array('status','状态')
				);
				$xlsData  = $list;
				$this->exportExcel($xlsName,$xlsCell,$xlsData);
				return $result=['code'=>-1,'msg'=>'未搜索到相关数据...'];
			}else{
				return $result = ['code'=>0,'msg'=>'获取成功!','count'=>$count,'data'=>$list];
			}
		}else{
			return $result = ['code'=>-1,'msg'=>'暂无结算明细数据...'];
		}
	}
    return $this->fetch();
  }

  //搜索经纪人结算数据
  public function search_agent()
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
		$type=input('type');
		$page=input('page');
		$limit=input('limit');
		if($page==1){
			$pre=$page;
		}else{
			$pre=($page-1)*$limit;
		}

		$where['money']= array('gt',0);
		if($type!=-1){
			if($keywords!=''){
				$count=Db('user_settlement_log')->where($where)->where('true_name','like','%'.$keywords.'%')->where(['status'=>$type])->count();
				if($count>$limit){
					$list=Db('user_settlement_log')->where($where)->where('true_name','like','%'.$keywords.'%')->where(['status'=>$type])->order('date DESC')->limit($pre,$limit)->select();
				}else{
					$list=Db('user_settlement_log')->where($where)->where('true_name','like','%'.$keywords.'%')->where(['status'=>$type])->order('date DESC')->select();
				}
			}else if($start_time!=''&&$end_time!=''){
				$count=Db('user_settlement_log')->where($where)->where('date','between time',[$start_time,$end_time])->where(['status'=>$type])->count();
				if($count>$limit){
					$list=Db('user_settlement_log')->where($where)->where('date','between time',[$start_time,$end_time])->where(['status'=>$type])->order('date DESC')->limit($pre,$limit)->select();
				}else{
					$list=Db('user_settlement_log')->where($where)->where('date','between time',[$start_time,$end_time])->where(['status'=>$type])->order('date DESC')->select();
				}
			}else if($start_time!=''){
				$count=Db('user_settlement_log')->where($where)->where('date','between time',[$start_time,$e_time])->where(['status'=>$type])->count();
				if($count>$limit){
					$list=Db('user_settlement_log')->where($where)->where('date','between time',[$start_time,$e_time])->where(['status'=>$type])->order('date DESC')->limit($pre,$limit)->select();
				}else{
					$list=Db('user_settlement_log')->where($where)->where('date','between time',[$start_time,$e_time])->where(['status'=>$type])->order('date DESC')->select();
				}
			}else if($start_time!=''&&$end_time!=''&&$keywords!=''){
				$count=Db('user_settlement_log')->where($where)->where('uid','IN',$uid)->where('date','between time',[$start_time,$end_time])->where(['status'=>$type])->count();
				if($count>$limit){
					$list=Db('user_settlement_log')->where($where)->where('uid','IN',$uid)->where('date','between time',[$start_time,$end_time])->where(['status'=>$type])->order('date DESC')->limit($pre,$limit)->select();
				}else{
					$list=Db('user_settlement_log')->where($where)->where('uid','IN',$uid)->where('date','between time',[$start_time,$end_time])->where(['status'=>$type])->order('date DESC')->select();
				}
			}else if($start_time!=''&&$keywords!=''){
				$count=Db('user_settlement_log')->where($where)->where('true_name','like','%'.$keywords.'%')->where('date','between time',[$start_time,$e_time])->where(['status'=>$type])->count();
				if($count>$limit){
					$list=Db('user_settlement_log')->where($where)->where('true_name','like','%'.$keywords.'%')->where('date','between time',[$start_time,$e_time])->where(['status'=>$type])->order('date DESC')->limit($pre,$limit)->select();
				}else{
					$list=Db('user_settlement_log')->where($where)->where('true_name','like','%'.$keywords.'%')->where('date','between time',[$start_time,$e_time])->where(['status'=>$type])->order('date DESC')->select();
				}
			}else if($ins_name!=''){
				$new_ins_name=explode(',',$ins_name);
				$agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
				$aid=[];
				foreach ($agent as $key => $value) {
					array_push($aid, $agent[$key]['id']);
				}
				$count=Db('user_settlement_log')->where($where)->where('aid','IN',$aid)->where(['status'=>$type])->count();
				if($count>$limit){
					$list=Db('user_settlement_log')->where($where)->where('aid','IN',$aid)->where(['status'=>$type])->order('date DESC')->limit($pre,$limit)->select();
				}else{
					$list=Db('user_settlement_log')->where($where)->where('aid','IN',$aid)->where(['status'=>$type])->order('date DESC')->select();
				}
			}
		}else{
			if($keywords!=''){
				$count=Db('user_settlement_log')->where($where)->where('true_name','like','%'.$keywords.'%')->count();
				if($count>$limit){
					$list=Db('user_settlement_log')->where($where)->where('true_name','like','%'.$keywords.'%')->order('date DESC')->limit($pre,$limit)->select();
				}else{
					$list=Db('user_settlement_log')->where($where)->where('true_name','like','%'.$keywords.'%')->order('date DESC')->select();
				}
			}else if($start_time!=''&&$end_time!=''){
				$count=Db('user_settlement_log')->where($where)->where('date','between time',[$start_time,$end_time])->count();
				if($count>$limit){
					$list=Db('user_settlement_log')->where($where)->where('date','between time',[$start_time,$end_time])->order('date DESC')->limit($pre,$limit)->select();
				}else{
					$list=Db('user_settlement_log')->where($where)->where('date','between time',[$start_time,$end_time])->order('date DESC')->select();
				}
			}else if($start_time!=''){
				$count=Db('user_settlement_log')->where($where)->where('date','between time',[$start_time,$e_time])->count();
				if($count>$limit){
					$list=Db('user_settlement_log')->where($where)->where('date','between time',[$start_time,$e_time])->order('date DESC')->limit($pre,$limit)->select();
				}else{
					$list=Db('user_settlement_log')->where($where)->where('date','between time',[$start_time,$e_time])->order('date DESC')->select();
				}
			}else if($start_time!=''&&$end_time!=''&&$keywords!=''){
				$count=Db('user_settlement_log')->where($where)->where('uid','IN',$uid)->where('date','between time',[$start_time,$end_time])->count();
				if($count>$limit){
					$list=Db('user_settlement_log')->where($where)->where('uid','IN',$uid)->where('date','between time',[$start_time,$end_time])->order('date DESC')->limit($pre,$limit)->select();
				}else{
					$list=Db('user_settlement_log')->where($where)->where('uid','IN',$uid)->where('date','between time',[$start_time,$end_time])->order('date DESC')->select();
				}
			}else if($start_time!=''&&$keywords!=''){
				$count=Db('user_settlement_log')->where($where)->where('true_name','like','%'.$keywords.'%')->where('date','between time',[$start_time,$e_time])->count();
				if($count>$limit){
					$list=Db('user_settlement_log')->where($where)->where('true_name','like','%'.$keywords.'%')->where('date','between time',[$start_time,$e_time])->order('date DESC')->limit($pre,$limit)->select();
				}else{
					$list=Db('user_settlement_log')->where($where)->where('true_name','like','%'.$keywords.'%')->where('date','between time',[$start_time,$e_time])->order('date DESC')->select();
				}
			}else if($ins_name!=''){
				$new_ins_name=explode(',',$ins_name);
				$agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
				$aid=[];
				foreach ($agent as $key => $value) {
					array_push($aid, $agent[$key]['id']);
				}
				$count=Db('user_settlement_log')->where($where)->where('aid','IN',$aid)->count();
				if($count>$limit){
					$list=Db('user_settlement_log')->where($where)->where('aid','IN',$aid)->order('date DESC')->limit($pre,$limit)->select();
				}else{
					$list=Db('user_settlement_log')->where($where)->where('aid','IN',$aid)->order('date DESC')->select();
				}
			}
		}
    
		if($list){
			foreach ($list as $key => $value) {
			  $list[$key]['date']=date('Y-m-d H:i:s',$value['date']);
			  $list[$key]['status']=($list[$key]['status']==0)?'未结算':'已结算';
			  if(!empty($list[$key]['aid'])){
				$list[$key]['p_account']=Db::name('agentor')->where('id',$list[$key]['aid'])->value('user_name');
			  }
			}
			return $result = ['code'=>0,'msg'=>'获取成功!','count'=>count($list),'data'=>$list];
		  }else{
			return $result = ['code'=>-1,'msg'=>'暂无搜索结果数据...','count'=>count($list),'data'=>[]];
		}
    }
  }
  //结算异常
  public function abnormal()
  {
    if(Request()->isPost()){
		
	}
    return $this->fetch();
  }
  //统计报表
  public function statement()
  {
    if(Request()->isPost()){
		
	}
    return $this->fetch();
  }
    
}
