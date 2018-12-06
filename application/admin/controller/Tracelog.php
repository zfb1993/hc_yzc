<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Input;

class Tracelog extends Common
{
    public function _initialize(){
    parent::_initialize();
  }

	//客户资金流水日志查询
    public function accountInfoLog()
  {
    if(Request()->isPost() || !empty(input('export'))){
		$keywords=input('keywords');
		$whereArr=$where=array();
		$start = input('start_time').' 00:00:00';
		$end =input('end_time').' 23:59:59';

		if(!empty(input('start_time'))){
			$whereArr['create_time']=array('>=',$start);
		}

		if(!empty(input('end_time'))){
			$whereArr['create_time']=array('<=',$end);
		}
		if(!empty(input('start_time')) && !empty(input('end_time'))) $whereArr['create_time']=array('between',array($start,$end));

		$ins_name=input('ins_name');

		$page=input('page');
		$limit=input('limit');
		$pre=($page-1)*$limit;
		$uid=[];
        if(!empty($ins_name)){
			$new_ins_name=explode(',',$ins_name);
			$agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
			$aid=[];
			foreach ($agent as $key => $value) {
				array_push($aid, $agent[$key]['id']);
			}
			$user=Db('customer')->where('pid','IN',$aid)->select();
			foreach($user as $key=>$value){
				array_push($uid,$user[$key]['user_name']);
			}
			$whereArr['zaccount']=array('in',$uid);
		}

		if(!empty($keywords)){
			$whereArr['zaccount']=$keywords;
		}

		if(!empty(input('sear'))){
			$all['prebalance'] = 0;
			$all['available'] = 0;
			$all['deposit'] = 0;
			$all['crj'] = 0;
			$all['balance'] = 0;
			$all['withdraw'] = 0;
			$inlist=Db::connect(config('db_trade'))->name('account_info_log')->where($whereArr)->order('create_time','DESC')->select();
			foreach($inlist as $v){
				$all['prebalance'] += $v['prebalance'];
				$all['available'] += $v['available'];
				$crj = $v['deposit']-$v['withdraw'];
				$all['crj'] += $crj;
				$all['deposit'] += $v['deposit'];
				$all['withdraw'] += $v['withdraw'];
				$all['balance'] += $v['balance'];
			}
			return $result = ['code'=>0,'data'=>$all];
			die;
		}

		$count=Db::connect(config('db_trade'))->name('account_info_log')->where($whereArr)->count();
		$list=Db::connect(config('db_trade'))->name('account_info_log')
			->where($whereArr)
			->limit($pre,$limit)
			->order('create_time','DESC')
			->select();
		if(!empty($list)){
			foreach($list as $key=>$value){
				$user=Db('customer')->where('user_name',$list[$key]['zaccount'])->find();
				$list[$key]['true_name']=$user['true_name'];
				$list[$key]['mobile']=$user['mobile'];
				$list[$key]['p_name']=$user['p_name'];
				$list[$key]['available']=intval($list[$key]['available']);  //可用资金
				$list[$key]['prebalance']=intval($list[$key]['prebalance']);  //上日结存
				$list[$key]['balance']=intval($list[$key]['balance']);  //当日结存==客户权益
				$list[$key]['crj']=(intval($list[$key]['deposit'])-intval($list[$key]['withdraw']));  //出入金
				$list[$key]['deposit']=intval($list[$key]['deposit']);  //入金
				$list[$key]['withdraw']=intval($list[$key]['withdraw']);  //出金
				$list[$key]['commission']=intval($list[$key]['commission']);  //手续费
				$list[$key]['currmargin']=intval($list[$key]['currmargin']);  //保证金
				$list[$key]['fxd']=empty($list[$key]['balance']) ? '0%': strval(round(($list[$key]['currmargin']/$list[$key]['balance'])*100,2)).'%'; //风险度
				$list[$key]['closeprofit']=intval($list[$key]['closeprofit']);  //平仓盈亏
				$list[$key]['positionprofit']=intval($list[$key]['positionprofit']);  //持仓盈亏
				$list[$key]['total_profit']=$list[$key]['closeprofit']+$list[$key]['positionprofit']; //总盈亏
			}
			if(!empty(input('export'))){
				//姓名  账号   手机号    所属机构   账户余额  注册时间
				$xlsName  = "客户资金查询";
				$xlsCell  = array(
					array('create_time','时间'),
					array('zaccount','账号'),
					array('true_name','姓名'),
					array('mobile','手机号'),
					array('p_name','上级代理'),
					array('prebalance','上日结存'),
					array('available','可用资金'),
					array('balance','客户权益'),
					array('crj','出入金'),
					array('deposit','入金'),
					array('withdraw','出金'),
					array('fxd','风险度'),
					array('commission','总手续费'),
					array('currmargin','保证金'),
					array('closeprofit','平仓盈亏'),
					array('positionprofit','持仓盈亏'),
					array('total_profit','总盈亏')
				);
				$xlsData  = $list;
				$this->exportExcel($xlsName,$xlsCell,$xlsData);
				return $result=['code'=>-1,'msg'=>'未搜索到相关数据...'];
			}else{
				return $result = ['code'=>0,'msg'=>'获取成功!','count'=>$count,'data'=>$list];
			}

		}else{
			return $result = ['code'=>-1,'msg'=>'未搜索到客户资金数据...'];
		}

	}
    return $this->fetch();
  }

	//客户成交流水日志查询
	public function tradeInfoLog()
	{
		if(Request()->isPost() || !empty(input('export'))){
			$keywords=input('keywords');
			$whereArr=$where=array();
			$start = input('start_time');
			$end =input('end_time');
		    $start=str_replace('-','',$start);
			$end=str_replace('-','',$end);
			if(!empty(input('start_time'))){
				$whereArr['TradingDay']=array('>=',$start);
			}
			if(!empty(input('end_time'))){
				$whereArr['TradingDay']=array('<=',$end);
			}
			if(!empty(input('start_time')) && !empty(input('end_time'))) $whereArr['TradingDay']=array('between',array($start,$end));
			$ins_name=input('ins_name');
			$page=input('page');
			$limit=input('limit');
			$pre=($page-1)*$limit/2;
			$uid=[];
			if(!empty($ins_name)){
				$new_ins_name=explode(',',$ins_name);
				$agent=Db('agentor')->where('user_name','IN',$new_ins_name)->field('id')->select();
				$aid=[];
				foreach ($agent as $key => $value) {
					array_push($aid, $agent[$key]['id']);
				}
				$user=Db('customer')->where('pid','IN',$aid)->select();
				foreach($user as $key=>$value){
					array_push($uid,$user[$key]['zid']);
				}
				$whereArr['AccountID']=array('in',$uid);
			}

			if(!empty($keywords)){
				$zid=Db('customer')->where('user_name',$keywords)->value('zid');
				$whereArr['AccountID']=$zid;
			}
			$count2=Db::connect(config('db_trade'))->name('trader_close_log')->where($whereArr)->count();
			$list2=Db::connect(config('db_trade'))->name('trader_close_log')
				->where($whereArr)
				->limit($pre,$limit/2)
				->order('TradingDay','DESC')
				->select();
			$whereArr['Status']=array('in',array('3','4'));
			$count1=Db::connect(config('db_trade'))->name('trader')->where($whereArr)->count();
			$list1=Db::connect(config('db_trade'))->name('trader')
				->where($whereArr)
				->limit($pre,$limit/2)
				->order('TradingDay','DESC')
				->select();
			$count = $count1+$count2;

			$list = array_merge($list1,$list2);

//print_r($list);die;
			if(!empty($list)){
				foreach($list as $key=>$value){
					$user=Db('customer')->where('zid',$list[$key]['AccountID'])->find();
					$list[$key]['true_name']=$user['true_name'];
					$list[$key]['mobile']=$user['mobile'];
					$list[$key]['user_name']=$user['user_name'];
					$list[$key]['p_name']=$user['p_name'];
					if($list[$key]['CombOffsetFlag']=="0"){
						$list[$key]['CombOffsetFlag']='开仓';
					}else{
						$list[$key]['CombOffsetFlag']='平仓';
					}

					if($list[$key]['Direction']==="0"){
						$list[$key]['Direction']='看涨';
					}elseif($list[$key]['Direction']==="1"){
						$list[$key]['Direction']='看跌';
					}else{
						$list[$key]['Direction']='未知';
					}
					$riqi[] = $value['TradingDay'];

				/*	{field:'tradedate',align:'center',title:'日期', width:130, sort: true},
					{field:'zaccount',align:'center',title:'账号', width:130},
					{field:'true_name',align:'center',title:'姓名', width:100},
					{field:'p_name',align:'center', title:'上级代理',width:100},
					{field:'instrumentid', align:'center',title:'合约',width:80},
					{field:'direction', align:'center',title:'方向',width:100},
					{field:'offset', align:'center',title:'买卖',width:100},
					{field:'tradeprice', align:'center',title:'价格',width:80},
					{field:'tradevolume', align:'center',title:'数量',width:80},
					{field:'commission', align:'center',title:'手续费',width:80},
					{field:'tradetime', align:'center',title:'时间',width:130,sort: true},
					{field:'tradeid', align:'center',title:'成交编号',width:100},
					{field:'ip', align:'center',title:'报单IP',width:150},*/
				}
				array_multisort($riqi,SORT_DESC,$list);
//				print_r($list);
				if(!empty(input('export'))){
					//姓名  账号   手机号    所属机构   账户余额  注册时间
//					print_r($list)
					foreach($list as &$v){
						if(!isset($v['OpenVolume'])){
							$v['OpenVolume'] = 0;
							$v['OpenBond'] = 0;
							$v['OrderSysID'] = 0;
						}
						if(!isset($v['DealVolume'])){
							$v['DealVolume'] = 0;
						}
						if(!isset($v['Profit'])){
							$v['Profit'] = 0;
						}
					}
					$xlsName  = "客户成交查询";
					$xlsCell  = array(
						array('TradingDay','交易日期'),
						array('InsertTime','交易时间'),
						array('true_name','姓名'),
						array('user_name','账号'),
						array('p_name','上级代理'),
						array('InstrumentID','合约'),
						array('CombOffsetFlag','买卖'),
						array('OpenPrice','开仓价格'),
						array('DealVolume','开仓数量'),
						array('ClosePrice','平仓价格'),
						array('CloseVolume','平仓数量'),
						array('Charge','手续费'),
						array('OpenBond','保证金'),
						array('Profit','盈亏'),
						array('OrderSysID','成交编号')
					);
					$xlsData  = $list;
					$this->exportExcel($xlsName,$xlsCell,$xlsData);
					return $result=['code'=>-1,'msg'=>'未搜索到相关数据...'];
				}else{
					return $result = ['code'=>0,'msg'=>'获取成功!','count'=>$count,'data'=>$list];
				}

			}else{
				return $result = ['code'=>-1,'msg'=>'未搜索到客户资金数据...'];
			}

		}
		return $this->fetch();
	}

    //经纪人结算
    public function agent_settlement()
  {
    if(Request()->isPost()){
		$page=input('page',1);
		$limit=input('limit',10);
		if($page==1){
			$pre=$page;
		}else{
			$pre=($page-1)*$limit;
		}

		$where['money']= array('gt',0);
		$now_date = date('Y-m-d',time());
		$start =  strtotime($now_date);
		$end   =   strtotime($now_date." 23:59:59");
		$where['date']= array(array('egt',$start),array('elt',$end ));

		$count=Db('user_settlement_log')->where($where)->count();
	
		$list=Db('user_settlement_log')->where($where)->order('date DESC')->limit($pre,$limit)->select();
		
		if($list){
			foreach($list as $key=>$value){
				$list[$key]['date']=date('Y-m-d H:i:s',$value['date']);
				$list[$key]['status']=($list[$key]['status']==0)?'未结算':'已结算';
				if(!empty($list[$key]['aid'])){
					$list[$key]['p_account']=Db::name('agentor')->where('id',$list[$key]['aid'])->value('user_name');
				}
			}
			return $result = ['code'=>0,'msg'=>'获取成功!','count'=>$count,'data'=>$list];
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

}
