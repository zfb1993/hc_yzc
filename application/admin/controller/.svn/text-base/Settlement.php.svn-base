<?php
namespace app\admin\controller;
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
    if(Request()->isPost()){
		
	}
    return $this->fetch();
  }
  //机构结算
  public function ins_settlement()
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

		$count=Db('agent_settlement_log')->where($where)->count();

		$start_time=input('start_time');
		$e_time=date('Y-m-d',strtotime("+1 day",strtotime($start_time)));

		$list=Db('agent_settlement_log')->where($where)->order('date DESC')->limit($pre,$limit)->select();

		if($list){
			foreach($list as $key=>$value){
				$list[$key]['date']=date('Y-m-d H:i:s',$value['date']);
				$list[$key]['status']=($list[$key]['status']==0)?'未结算':'已结算';
			}
			return $result = ['code'=>0,'msg'=>'获取成功!','count'=>$count,'data'=>$list];
		}else{
			return $result = ['code'=>-1,'msg'=>'暂无结算数据...'];
		}
	}
    return $this->fetch();
  }

  //搜索机构结算数据
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
		//$type=input('type');
		$page=input('page');
		$limit=input('limit');
		if($page==1){
			$pre=$page;
		}else{
			$pre=($page-1)*$limit;
		}
		$where['money']= array('gt',0);
		if($start_time!=''&&$end_time!=''&&$keywords!=''){
			$count=Db('agent_settlement_log')->where($where)->where('true_name','like','%'.$keywords.'%')->where('date','between time',[$start_time,$end_time])->count();
			if($count>$limit){
				$list=Db('agent_settlement_log')->where($where)->where('true_name','like','%'.$keywords.'%')->where('date','between time',[$start_time,$end_time])->order('date DESC')->limit($pre,$page)->select();
			}else{
				$list=Db('agent_settlement_log')->where($where)->where('true_name','like','%'.$keywords.'%')->where('date','between time',[$start_time,$end_time])->order('date DESC')->select();
			}
		}else if($start_time!=''&&$end_time!=''){
			$count=Db('agent_settlement_log')->where($where)->where('date','between time',[$start_time,$end_time])->count();
			if($count>$limit){
				$list=Db('agent_settlement_log')->where($where)->where('date','between time',[$start_time,$end_time])->order('date DESC')->limit($pre,$page)->select();
			}else{
				$list=Db('agent_settlement_log')->where($where)->where('date','between time',[$start_time,$end_time])->order('date DESC')->select();
			}
		}else if($start_time!=''&&$keywords!=''){
			$count=Db('agent_settlement_log')->where($where)->where('true_name','like','%'.$keywords.'%')->where('date','between time',[$start_time,$e_time])->count();
			if($count>$limit){
				$list=Db('agent_settlement_log')->where($where)->where('true_name','like','%'.$keywords.'%')->where('date','between time',[$start_time,$e_time])->order('date DESC')->limit($pre,$page)->select();
			}else{
				$list=Db('agent_settlement_log')->where($where)->where('true_name','like','%'.$keywords.'%')->where('date','between time',[$start_time,$e_time])->order('date DESC')->select();
			}
		}else if($keywords!=''){
			$count=Db('agent_settlement_log')->where($where)->where('true_name','like','%'.$keywords.'%')->count();
			if($count>$limit){
				$list=Db('agent_settlement_log')->where($where)->where('true_name','like','%'.$keywords.'%')->order('date DESC')->limit($pre,$page)->select();
			}else{
				$list=Db('agent_settlement_log')->where($where)->where('true_name','like','%'.$keywords.'%')->order('date DESC')->select();
			}
		}else if($start_time!=''){
			$count=Db('agent_settlement_log')->where($where)->where('date','between time',[$start_time,$e_time])->count();
			if($count>$limit){
				$list=Db('agent_settlement_log')->where($where)->where('date','between time',[$start_time,$e_time])->order('date DESC')->limit($pre,$page)->select();
			}else{
				$list=Db('agent_settlement_log')->where($where)->where('date','between time',[$start_time,$e_time])->order('date DESC')->select();
			}
		}else if($ins_name!=''){
			$new_ins_name=explode(',',$ins_name);
			$agent=Db('agentor')->field('id')->where($where)->where('user_name','IN',$new_ins_name)->select();
			$aid=[];
			foreach ($agent as $key => $value) {
				array_push($aid, $agent[$key]['id']);
			}
			$count=Db('agent_settlement_log')->where($where)->where('aid','IN',$aid)->count();
			if($count>$limit){
				$list=Db('agent_settlement_log')->where($where)->where('aid','IN',$aid)->order('date DESC')->limit($pre,$page)->select();
			}else{
				$list=Db('agent_settlement_log')->where($where)->where('aid','IN',$aid)->order('date DESC')->select();
			}
		}
   // echo Db('agent_settlement_log')->getLastSql();die;
		if($list){
			foreach ($list as $key => $value) {
			  $list[$key]['date']=date('Y-m-d H:i:s',$value['date']);
			  $list[$key]['status']=($list[$key]['status']==0)?'未结算':'已结算';
			}
			$export_data=Db('export_data')->count();
			if($export_data>0){
				Db('export_data')->delete(true);
			}
			foreach($list as $i=>$v){
				Db('export_data')->insert([
					'id'=>$i+1,
					'a1'=>$v['date'],
					'a2'=>$v['true_name'],
					'a3'=>$v['money']
				]);
			}
			return $result = ['code'=>0,'msg'=>'获取成功!','count'=>$count,'data'=>$list];
		  }else{
			return $result = ['code'=>-1,'msg'=>'暂无搜索结果数据...','count'=>count($list),'data'=>[]];
		}
    }
  }

  //导出Excel
    public function export(){
		//时间   代理姓名  返佣金额   
		$xlsName  = "机构结算查询";
		$xlsCell  = array(
			array('id','序号'),
			array('a1','时间'),
			array('a2','代理姓名'),
			array('a3','返佣金额')
		);
		$xlsData  = Db::name('export_data')->Field('id,a1,a2,a3')->select();
        $this->exportExcel($xlsName,$xlsCell,$xlsData);
        //dump($file);die;
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
//		  $now_date = date('Y-m-d',time());
//		  if(empty(input('start_time'))){
//			  $start = $now_date.' 00:00:00';
//		  }else{
//			  $start=date('Y-m-d H:i:s',strtotime($start_time));
//		  }
//		  if(empty(input('end_time'))){
//			  $end   =   $now_date." 23:59:59";
//		  }else{
//			  $end=date('Y-m-d H:i:s',strtotime("+1 day",strtotime($end_time)));
//		  }
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

		  if(!empty($ins_name) && empty($keywords)){
			  $new_ins_name=explode(',',$ins_name);
			  $agent=Db('agentor')->where('user_name','IN',$new_ins_name)->field('id')->select();
			  $aid=[];
			  foreach ($agent as $key => $value) {
				  array_push($aid, $agent[$key]['id']);
			  }
			  $customerList=Db('customer')->where($where)->where('aid','IN',$aid)->field('zid')->select();
			  $zid=[];
			  foreach ($customerList as $k => $v) {
				  array_push($zid, $customerList[$k]['zid']);
			  }
			  $where['zaccount']=array('in',$zid);
		  }

		  if(!empty($keywords)){
			  $zid=Db::name('customer')->where('user_name',$keywords)->value('zid');
			  $where['zaccount']=$zid;
		  }
		  if($start_time != ''){
			  $stime = str_replace('-','',$start_time);;
			  $etime = str_replace('-','',$end_time);;
			  $where['tradedate'] = $stime;
			  if($end_time != ''){
				  $where['tradedate'] = ['BETWEEN',[$stime,$etime]];
			  }
		  }
//		$where['create_time']= array(array('egt',$start),array('elt',$end ));

		  if(!empty(input('sear'))) {
			  $all['tradevolume'] = 0;
			  $all['commission'] = 0;
			  $tlist=Db::connect(config('db_trade'))->table('yp_trade_static')->where($where)->order('id','DESC')->field('tradevolume,commission')->select();
			  foreach($tlist as $v){
				  $all['tradevolume'] += $v['tradevolume'];
				  $all['commission'] += $v['commission'];
			  }
			  
			  return $result = ['code'=>0,'data'=>$all];
			  die;
		  }

		$count=Db::connect(config('db_trade'))->table('yp_trade_static')->where($where)->count();
		$list=Db::connect(config('db_trade'))->table('yp_trade_static')->where($where)->order('id DESC')->limit($pre,$limit)->select();
		oplog('agent_settlement--->'.json_encode($list));
		if($list){
			foreach($list as $key=>$value){
				$list[$key]['status']=($list[$key]['status']==0)?'未结算':'已结算';
				$list[$key]['tradevolume']=$list[$key]['tradevolume']/2;
				if(!is_int($list[$key]['tradevolume'])){
					$list[$key]['tradevolume'] = round($list[$key]['tradevolume']);
				}
				$list[$key]['user_name']='';
				$list[$key]['true_name']='';
				if(!empty($list[$key]['zaccount'])){
					$customerInfo=Db::name('customer')->where('zid',$list[$key]['zaccount'])->find();

					if(!empty($customerInfo)){
						$list[$key]['user_name']=$customerInfo['user_name'];
						$list[$key]['true_name']=$customerInfo['true_name'];
					}
				}
				$list[$key]['p_account']='';
				$list[$key]['p_name']='';
				$list[$key]['p2_account']='';
				$list[$key]['p2_name']='';
				$list[$key]['p3_account']='';
				$list[$key]['p3_name']='';
				$list[$key]['p4_account']='';
				$list[$key]['p4_name']='';
				if(!empty($list[$key]['p1_zid'])){
					$p1Agent=Db::name('agentor')->where('id',$list[$key]['p1_zid'])->find();
					if(!empty($p1Agent)){
						$list[$key]['p_account']=$p1Agent['user_name'];
						$list[$key]['p_name']=$p1Agent['true_name'];
					}
				}

				if(!empty($list[$key]['p2_zid'])){
					$p2Agent=Db::name('agentor')->where('id',$list[$key]['p2_zid'])->find();
					if(!empty($p1Agent)){
						$list[$key]['p2_account']=$p2Agent['user_name'];
						$list[$key]['p2_name']=$p2Agent['true_name'];
					}
				}
				if(!empty($list[$key]['p3_zid'])){
					$p3Agent=Db::name('agentor')->where('id',$list[$key]['p3_zid'])->find();
					if(!empty($p1Agent)){
						$list[$key]['p3_account']=$p3Agent['user_name'];
						$list[$key]['p3_name']=$p3Agent['true_name'];
					}
				}
				if(!empty($list[$key]['p4_zid'])){
					$p4Agent=Db::name('agentor')->where('id',$list[$key]['p4_zid'])->find();
					if(!empty($p1Agent)){
						$list[$key]['p4_account']=$p4Agent['user_name'];
						$list[$key]['p4_name']=$p4Agent['true_name'];
					}
				}
			}
//			echo '<pre>';
//			print_r($list);die;
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
					array('p_name','一级代理名称'),
					array('p_account','一级代理'),
					array('p1','一级代理返佣'),
					array('p2_name','二级代理名称'),
					array('p2_account','二级代理'),
					array('p2','二级代理返佣'),
					array('p3_name','三级代理名称'),
					array('p3_account','三级代理'),
					array('p3','三级代理返佣'),
					array('zaccount','客户ID'),
					array('true_name','客户姓名'),
					array('status','状态')
				);
				$xlsData  = $list;
//				echo '<pre>';
//				print_r($xlsData);die;
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

	public function artificial(){
		if(Request()->isPost()){
			$day = input('day');
			if($day == ''|| $day == date('Y-m-d',time())){
				$day = date('Ymd',time());
				$g = date('G',time());
				if($g < 16 || $g >= 20){
					$data['code'] = 0;
					$data['errmsg'] = '默认检测当天，当天的只能在下午四点到八点间运行检测！';
					return json($data);
				}
			}
			$endtime = strtotime(date('Y-m-d 23:59:59',time()));
			$tt = strtotime($day.' 00:00:00');
			if($tt > $endtime){
				$data['code'] = 0;
				$data['errmsg'] = '不能选择未来时间';
				return json($data);
			}
			$day = str_replace('-','',$day);
			$msg = '';
			$i =0;

			//    资金状态
			$alist=Db::connect(config('db_trade'))->name('account_info_log')->where('tradedate',$day)->select();
			$yalist=Db::connect(config('db_trade'))->table('yp_account_info_log')->where('tradedate',$day)->select();
			oplog('count($yalist)--==0->'.count($yalist));
			oplog('count($alist)--!=0->'.count($alist));
			if(count($yalist) == 0 && count($alist) != 0){
				$data['acc'] = 0;
				oplog('account_info_log--->'.Db::connect(config('db_trade'))->name('account_info_log')->getlastsql());
				oplog('yp_account_info_log--->'.Db::connect(config('db_trade'))->name('yp_account_info_log')->getlastsql());
				
				$msg .= '资金状态没有<br />';
				$i++;
			}else{
				$data['acc'] = 1;
			}

			$tclist=Db::connect(config('db_trade'))->name('trader_close_log')->where('TradingDay',$day)->select();
			$ttlist=Db::connect(config('db_trade'))->name('trader')->where('TradingDay',$day)->where('status',3)->select();

			//持仓明细
			$ytlist=Db::connect(config('db_trade'))->table('yp_trade_position_detail')->where('tradedate',$day)->select();
			oplog('持仓明细---count($ytlist)==0--->'.count($ytlist));
			oplog('持仓明细---count($ttlist)!= 0--->'.count($ttlist));
			if(count($ytlist) == 0 && count($ttlist) != 0){
				$data['det'] = 0;
				$msg .= '持仓明细没有<br />';
				$i++;
			}else{
				$data['det'] = 1;
			}

			//持仓汇总
			$yplist=Db::connect(config('db_trade'))->table('yp_trade_position')->where('tradedate',$day)->select();
			oplog('持仓汇总-yp_trade_position--count($yplist)--==0->'.count($yplist));
			oplog('持仓汇总-trader---count($ttlist)--!=0->'.count($ttlist));
			if(count($yplist) == 0 && count($ttlist) != 0){
				$data['dal'] = 0;
				$msg .= '持仓汇总没有<br />';
				$i++;
			}else{
				$data['dal'] = 1;
			}


			//平仓记录
			$clist=Db::connect(config('db_trade'))->table('yp_close_position')->where('tradedate',$day)->select();
			oplog('平仓记录---count($clist)--==0->'.count($clist));
			oplog('平仓记录---count($tclist)--!=0->'.count($tclist));
			if(count($clist) == 0 && count($tclist) != 0){
				$data['clo'] = 0;
				$msg .= '平仓记录没有<br />';
				$i++;
			}else{
				$data['clo'] = 1;
			}

			//成交记录
			$yblist=Db::connect(config('db_trade'))->table('yp_batch_trade')->where('tradedate',$day)->select();
			oplog('成交记录--yp_batch_trade--count($yblist)--==0->'.count($yblist));
			oplog('成交记录--trader_close_log-count($tclist)--!=0->'.count($tclist));
			if(count($yblist) == 0 && count($tclist) != 0){
				$data['tra'] = 0;
				$msg .= '成交记录没有<br />';
				$i++;
			}else{
				$data['tra'] = 1;
			}
			if($i != 0){
				$data['errmsg'] = $msg;
				$data['err'] = 1;
			}else{
				$data['errmsg'] = '当日记录完整';
				$data['err'] = 0;
			}
			return json($data);
			die;
		}
		return $this->fetch();
	}

	public function wanshan(){
		oplog('完善--->111');
		$tra = input('tra');
		$clo = input('clo');
		$dal = input('dal');
		$det = input('det');
		$acc = input('acc');
		$day = input('day');
		$day = str_replace('-','',$day);
		$i = 0;
		$msg = '';
oplog('完善--->'.$acc);
		//yp_account_info_log
		if($acc == 0){
			$sql = "INSERT INTO yp_account_info_log SELECT * FROM trad_account_info_log WHERE tradedate = '".$day."';";
			$ra = Db::connect(config('db_trade'))->execute($sql);
			oplog('资金状态完善sql--->'.Db::connect(config('db_trade'))->getlastsql());
			if($ra === false){
				$i++;
				$msg .= '资金状态完善失败，请重试<br />';
			}
		}

		//yp_close_position
		if($clo == 0){
			oplog('完善平仓记录');
			$sql = "INSERT INTO yp_close_position(zaccount,direction,offset,commission,instrumentid,closeprofit,tradedate,tradeid,tradeprice,openprice,tradetime,tradevolume,create_time)
   SELECT AccountID,Direction,'平',Charge,InstrumentID,Profit,TradingDay, OrderRef,ClosePrice,OpenPrice,InsertTime,CloseVolume,now() FROM trad_trader_close_log WHERE  TradingDay = '".$day."';";
   oplog('INSERT INTO yp_close_position--------->'.$sql);
			$ra = Db::connect(config('db_trade'))->execute($sql);
			if($ra === false){
				$i++;
				$msg .= '平仓记录完善失败，请重试<br />';
			}
		}

		//yp_batch_trade
		//yp_trade_static
		if($tra == 0){
			oplog('完善成交记录');
			$sql = "INSERT INTO yp_batch_trade(zaccount,direction,offset,commission,instrumentid,tradedate,tradeid,tradeprice,tradetime,tradevolume,create_time)
   SELECT AccountID,Direction,'平',Charge,InstrumentID,TradingDay, OrderRef,ClosePrice,InsertTime,CloseVolume,now() FROM trad_trader_close_log WHERE  TradingDay = '".$day."'";
			$sql1 = "INSERT INTO yp_batch_trade(zaccount,direction,offset,commission,instrumentid,tradedate,tradeid,tradeprice,tradetime,tradevolume,create_time)
   SELECT AccountID,Direction,'开',Charge, InstrumentID,TradingDay,OrderRef,OpenPrice,InsertTime, VolumeTotalOriginal,now() FROM trad_trader WHERE TradingDay = '".$day."' and status in ('3','4') ;";
			Db::connect(config('db_trade'))->execute($sql);
			Db::connect(config('db_trade'))->execute($sql1);

			$sql2 = "INSERT INTO yp_trade_static(zaccount,instrumentid,commission,tradevolume,tradedate)
   SELECT  zaccount,instrumentid,SUM(commission) as  commission,SUM(tradevolume) as tradevolume, tradedate FROM yp_batch_trade WHERE tradedate = '".$day."'  GROUP BY zaccount,instrumentid;";
			$ra = Db::connect(config('db_trade'))->execute($sql2);
			if($ra === false){
				$i++;
				$msg .= '成交记录完善失败，请重试<br />';
			}
		}

		//yp_trade_position
		if($dal == 0){
			oplog('完善持仓汇总');
			$sql = "INSERT INTO yp_trade_position(zaccount,direction,offset,bzj,instrumentid,tradeprice,tradevolume,tradedate)
   SELECT AccountID,Direction,0,sum(Charge), InstrumentID,sum(OpenPrice*OpenVolume)/sum(OpenVolume) as tradeprice,sum(OpenVolume) as tradevolum,'".$day."' FROM trad_trader
   WHERE TradingDay = '".$day."' and status = 3 GROUP BY AccountID,InstrumentID,Direction; ";
			$ra = Db::connect(config('db_trade'))->execute($sql);
			if($ra === false){
				$i++;
				$msg .= '持仓汇总完善失败，请重试<br />';
			}
		}

		//yp_trade_position_detail
		if($det == 0){
			oplog('完善持仓明细');
			$sql = "INSERT INTO yp_trade_position_detail(zaccount,direction,offset,bzj,instrumentid,tradedate,tradeprice,tradevolume)
   SELECT AccountID,Direction,CombOffsetFlag,Charge, InstrumentID,TradingDay,OpenPrice, OpenVolume FROM trad_trader
   WHERE TradingDay ='".$day."' and status = 3 ; ";
			$ra = Db::connect(config('db_trade'))->execute($sql);
			if($ra === false){
				$i++;
				$msg .= '持仓明细完善失败，请重试<br />';
			}
		}

		if($i == 0){
			$data['errmsg'] = '当日记录完善成功！';
			$data['err'] = 0;
		}else{
			$data['errmsg'] = $msg;
			$data['err'] = 1;
		}
		return json($data);
		die;
	}

}
