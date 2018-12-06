<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Input;
use think\Loader;
use app\admin\model;
class Money extends Common
{
  public function _initialize(){
    parent::_initialize();
  }
  public function index()
  {
    return $this->fetch();
  }
  //客户流水
  public function cusFlow()
  {
    if(Request()->isPost()){
      $page=input('page');
	  $limit=input('limit');
	  if($page==1){
			$pre=$page;
	  }else{
		  $pre=($page-1)*$limit;
	  }
	  $count=Db('flow_log')->where('uid','NEQ','')->count();
	  if($count>$limit){
		$list=Db('flow_log')->where('uid','NEQ','')->order('add_time DESC')->limit($pre,$limit)->select();
	  }else{
		  $list=Db('flow_log')->where('uid','NEQ','')->order('add_time DESC')->select();
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
		return $result = ['code'=>-1,'msg'=>'暂无今日客户流水数据...'];
	  }
    }
    return $this->fetch();
  }

	//客户流水
	public function daifu_list(){
		if(Request()->isPost()){
			$page=input('page');
			$limit=input('limit');
			$true_name=input('true_name');
			$end_time=input('end_time');
			$ins_name=input('ins_name');
			$status=input('status');
			$start_time=input('start_time');
			$where=array('id'=>array('neq',''));
			if(!empty($end_time)&&!empty($start_time)){
				$where['addtime']=array(array('elt',strtotime($end_time." 23:59:59")),array('egt',strtotime($start_time)));
			}else if(!empty($end_time)&&empty($start_time)){
				$where['addtime']=array('elt',strtotime($end_time." 23:59:59"));
			}else if(empty($end_time)&&!empty($start_time)){
				$where['addtime']=array('egt',strtotime($start_time));
			}
			if($status!=-1&&$status!=''){
				$where['status']=$status;
			}
			if(!empty($true_name)){
				$where['true_name']=array('like','%'.$true_name.'%');
			}
			if($ins_name!=''){
				$new_ins_name=explode(',',$ins_name);
				$agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
				$aid=[];
				foreach ($agent as $key => $value) {
					array_push($aid, $agent[$key]['id']);
				}
				$user=Db('customer')->where('pid','IN',$aid)->select();
				$uid=[];
				foreach($user as $key=>$value){
					array_push($uid,$user[$key]['id']);
				}
				$where['userid'] = ['IN',$uid];
			}
			if($page==1){
				$pre=$page;
			}else{
				$pre=($page-1)*$limit;
			}
			$count=Db('daifu')->where($where)->count();
			$list=Db('daifu')->where($where)->order('addtime DESC')->limit($pre,$limit)->select();
			if($list){
				foreach ($list as $key => $value) {
					if($list[$key]['addtime']!=NULL){
						$list[$key]['addtime']=date('Y-m-d H:i:s',$value['addtime']);
					}else{
						$list[$key]['addtime']='';
					}
					switch($list[$key]['status']){
						case "0";
						$list[$key]['status_title']='未处理';
						break;
						case "1";
						$list[$key]['status_title']='成功';
						break;
						case "2";
						$list[$key]['status_title']='已取消';
						break;
					}
				}
				return $result = ['code'=>0,'msg'=>'获取成功!','count'=>$count,'data'=>$list];
			}else{
				return $result = ['code'=>-1,'msg'=>'暂无数据...'];
			}
		}
		return $this->fetch();
	}
  //搜索流水记录
  public function search_flow()
  {
	if(Request()->isPost()|| !empty(input('export'))){
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
		$type=input('type');
		$where = [];
		if($type!=-1){
			$where['type'] = $type;
		}

		if($keywords!=''){
			$user=Db('customer')->field('id')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->select();
			$uid=[];
			foreach($user as $key=>$value){
				array_push($uid,$user[$key]['id']);
			}
			$where['uid'] = ['IN',$uid];
		}

		if($start_time!=''){
			$where['add_time'] = ['between time',[$start_time,$e_time]];
		}

		if($start_time!=''&&$end_time!=''){
			$where['add_time'] = ['between time',[$start_time,$end_time]];
		}

		if($ins_name!=''){
			$new_ins_name=explode(',',$ins_name);
			$agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
			$aid=[];
			foreach ($agent as $key => $value) {
				array_push($aid, $agent[$key]['id']);
			}
			$user=Db('customer')->where('pid','IN',$aid)->select();
			$uid=[];
			foreach($user as $key=>$value){
				array_push($uid,$user[$key]['id']);
			}
			$where['uid'] = ['IN',$uid];
		}

		if(!empty(input('sear'))) {
			$all = 0;
			$flist=Db('flow_log')->where($where)->order('add_time DESC')->field('money')->select();
			foreach($flist as $v){
				$all += $v['money'];
			}
			return $result = ['code'=>0,'data'=>$all];
			die;
		}

		if(empty(input('export'))) {
			$count = Db('flow_log')->where($where)->count();
//			print_r($where);
			if ($count > $limit) {
				$list = Db('flow_log')->where($where)->limit($pre, $limit)->order('add_time DESC')->select();
			} else {
				$list = Db('flow_log')->where($where)->order('add_time DESC')->select();
			}
//			print_r($where);die;
		}else{
			$list = Db('flow_log')->where($where)->order('add_time DESC')->select();
//			print_r($where);die;
		}
oplog('search_flow-->'.Db('flow_log')->getlastsql());
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
//			print_r($list);die;
			if(!empty(input('export'))){
				//姓名  账号   手机号    所属机构   账户余额  注册时间
				$xlsName  = "客户流水查询";
				$xlsCell  = array(
					array('user_name','账号'),
					array('true_name','姓名'),
					array('p_name','上级代理'),
					array('type','类型'),
					array('money','金额'),
//					array('total_money','账户余额'),
					array('add_time','申请时间'),
					array('check_time','处理时间'),
					array('memo','备注')
				);
				$xlsData  = $list;
				$this->exportExcel($xlsName,$xlsCell,$xlsData);
				return $result=['code'=>-1,'msg'=>'未搜索到相关数据...'];
			}else {
				return $result = ['code' => 0, 'msg' => '获取成功!', 'count' => $count, 'data' => $list];
			}
		  }else{
			return $result = ['code'=>-1,'msg'=>'暂无搜索结果数据...',];
		}
    }
  }
  
  //导出Excel
    public function export(){
		//姓名    代理姓名    类型   金额  时间
		$xlsName  = "客户流水查询";
		$xlsCell  = array(
			array('id','序号'),
			array('a1','姓名'),
			array('a2','代理姓名'),
			array('a3','类型'),
			array('a4','金额'),
			array('a5','时间')
		);
		$xlsData  = Db::name('export_data')->Field('id,a1,a2,a3,a4,a5')->select();
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

  //机构流水
  public function insFlow()
  {
    if(Request()->isPost()){
	  $page=input('page');
	  $limit=input('limit');
	  if($page==1){
			$pre=$page;
	  }else{
		  $pre=($page-1)*$limit;
	  }
	  $count=Db('flow_log')->where('aid','NEQ','')->count();
	  if($count>$limit){
		  $list=Db('flow_log')->where('aid','NEQ','')->order('add_time DESC')->limit($pre,$limit)->select();
	  }else{
		  $list=Db('flow_log')->where('aid','NEQ','')->order('add_time DESC')->select();
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
    if(Request()->isPost()){
        $uid=input('uid');
        $money=input('money');
        $type=input('type');
        $memo=input('memo');
        $user=Db('customer')->where('id',$uid)->find();
        if($type==1){
            //事物日志控制
            Db::startTrans();
            try{
                $total_money=$money+$user['total_money'];
                $result=Db('flow_log')->insert([
                        'uid'=>$uid,
                        'money'=>$money,
                        'total_money'=>$total_money,
                        'type'=>$type,
                        'add_time'=>time(),
                        'memo'=>$memo
                    ]);
                if($result){
                    $zg=Db('zg_sys')->where('id',$user['zg_id'])->find();
                    $data['UserID']=$zg['account'];
                    $data['Action']='ReqTransfer';
                    $data['ChdAccountID']=$user['zid'];//用户zid
                    $data['BadAmount']=$money;
                    //$url=$zg['server_ip'];
					$nbeApi=new model\NbeApi();
					$dataInfo['childid']= $user['zid'];
					$dataInfo['cash']= $money;
					$dataInfo['from']= 'admin input cash';
					$rec= $nbeApi->inOutCash($dataInfo);
					oplog('后台充值审核---->'.json_encode($rec));
                    //$rec= ReqTransfer($data,$url);
                    if($rec['code']==1){
                        Db('customer')->where('id',$uid)->setInc('available_money',$money);
                        Db('customer')->where('id',$uid)->setInc('local_money',$money);
                        Db('customer')->where('id',$uid)->setInc('total_money',$money);
                        Db::commit();
                        return json(['code'=>1,'msg'=>'入金成功'.$rec['code']]);
                    }else{
                        Db::rollback();
                        return json(['code'=>-1,'msg'=>'入金失败，非资管入金时间']);
                    }
                }else{
                    Db::rollback();
                    return json(['code'=>0,'msg'=>'入金失败']);
                }
            }catch (\Exception $e){
                Db::rollback();
                return json(['code'=>0,'msg'=>'入金失败']);
            }
        }else if($type==0){
            Db::startTrans();
            try{
                $total_money=$user['total_money']-$money;
                $result=Db('flow_log')->insert([
                        'uid'=>$uid,
                        'money'=>-$money,
                        'total_money'=>$total_money,
                        'type'=>$type,
                        'add_time'=>time(),
                        'memo'=>$memo
                    ]);
                if($result){
                    //$zg=Db('zg_sys')->where('id',$user['zg_id'])->find();
					$nbeApi=new model\NbeApi();
					$dataInfo['childid']= $user['zid'];
					$dataInfo['cash']= -$money;
					$dataInfo['from']= 'admin input cash';
					$rec= $nbeApi->inOutCash($dataInfo);
                    if($rec['code']==1){
						oplog('出金--->11'.json_encode($rec));
                        Db('customer')->where('id',$uid)->setDec('available_money',$money);
                        Db('customer')->where('id',$uid)->setDec('local_money',$money);
                        Db('customer')->where('id',$uid)->setDec('total_money',$money);
                        Db::commit();
                        return json(['code'=>1,'msg'=>'出金成功'.$rec['code']]);
                    }else{
                        Db::rollback();
                        return json(['code'=>-1,'msg'=>'出金失败，资管出金失败'.$rec['msg']]);
                    }
                }else{
                    Db::rollback();
                    return json(['code'=>0,'msg'=>'出金失败，请重试']);
                }
            }catch (\Exception $e){
                Db::rollback();
                return json(['code'=>0,'msg'=>'出金失败，稍后重试']);
            }
        }

    }
    $list=Db('customer')->where('status',0)->select();
    $this->assign('list',$list);
    return $this->fetch();
  }

	public function daifu(){
		if(Request()->isPost()){
			$userid=input('userid');
			$parram['mchid']='181209678';
			$parram['out_trade_no']='DF'.date("YmdHis").rand(1000,9999);
			$parram['bankname']=input('bankname');
			$parram['subbranch']=input('subbranch');
			$parram['accountname']=input('accountname');
			$parram['cardnumber']=input('cardnumber');
			$parram['money']=input('money');
			$parram['province']=input('province');
			$parram['city']=input('city');
			if(empty($parram['city'])||empty($parram['province'])||empty($parram['money'])||empty($parram['cardnumber'])||empty($parram['accountname'])||empty($parram['subbranch'])||empty($parram['bankname'])){
				return json(['code'=>0,'msg'=>'参数不能为空']);
			}
			ksort($parram);
			$md5str = "";
			$Md5key='9lpt6tlnsi3u7cfeq0ulsxzou0ukys9d';
			foreach ($parram as $key => $val) {
				$md5str = $md5str . $key . "=" . $val . "&";
			}
			$parram['extends']='';
			$parram['pay_md5sign'] = strtoupper(md5($md5str . "key=" . $Md5key));
			$tjurl='https://api.dudupay.net/Payment_Dfpay_add.html';
			$daifu_result=Db('daifu')->insert([
				'out_trade_no'=>$parram['out_trade_no'],
				'bankname'=>$parram['bankname'],
				'subbranch'=>$parram['subbranch'],
				'accountname'=>$parram['accountname'],
				'cardnumber'=>$parram['cardnumber'],
				'money'=>$parram['money'],
				'province'=>$parram['province'],
				'city'=>$parram['city'],
				'userid'=>$userid,
				'addtime'=>time()
			]);
			if($daifu_result){
				$re=json_decode(http_post_json($tjurl ,$parram),true);
				if($re['status']=='success'){
					Db::startTrans();
					try{
						oplog('代付出金--1');
							$money=$parram['money'];
							oplog('代付出金--2');
							$user=Db('customer')->where('id',$userid)->find();
							$total_money=$user['total_money']-$parram['money'];
							$result=Db('flow_log')->insert([
								'uid'=>$userid,
								'money'=>-$money,
								'total_money'=>$total_money,
								'type'=>0,
								'add_time'=>time(),
								'memo'=>'代付出金'
							]);
							oplog('代付出金--3');
							if($result){
								$nbeApi=new model\NbeApi();
								$dataInfo['childid']= $user['zid'];
								$dataInfo['cash']= -$money;
								$dataInfo['from']= 'admin input cash';
								$rec= $nbeApi->inOutCash($dataInfo);
								oplog('代付出金--4');
								oplog('代付出金--->411'.json_encode($rec));
								if($rec['code']==1){
									Db('customer')->where('id',$userid)->setDec('available_money',$money);
									Db('customer')->where('id',$userid)->setDec('local_money',$money);
									Db('customer')->where('id',$userid)->setDec('total_money',$money);
									oplog('代付出金--5');
									Db::commit();
									return json(['code'=>1,'msg'=>'申请代付成功，请及时查看状态']);
								}else{
									oplog('代付出金--6');
									Db::rollback();
									return json(['code'=>0,'msg'=>'申请代付成功，资管出金失败'.$rec['msg']]);
								}
							}else{
								oplog('代付出金--7');
								Db::rollback();
								return json(['code'=>0,'msg'=>'申请代付成功，流水记录生成失败']);
							}
						}catch (\Exception $e){
							Db::rollback();
							return json(['code'=>0,'msg'=>'系统错误，请重试']);
						}
				}else{
					Db('daifu')->where('id',$daifu_result)->update(['remark'=>$re['msg']]);
					return json(['code'=>0,'msg'=>$re['msg']]);
				}
			}else{
				return json(['code'=>0,'msg'=>'数据插入失败，请重试']);
			}
		}else{
			$list=Db('customer')->where('status',0)->select();
			$this->assign('list',$list);
			return $this->fetch();
		}
	}
  
  
 //充值记录Recharge record
  public function chongZhi()
  {
    if(Request()->isPost()){
	  $page=input('page');
	  $limit=input('limit');
	  if($page==1){
			$pre=$page;
	  }else{
		  $pre=($page-1)*$limit;
	  }
	  $count=Db('apply_log')->where(['type'=>1,'status'=>0])->where('uid','NEQ','')->count();
	  if($count>$limit){
		$list=Db('apply_log')->where(['type'=>1,'status'=>0])->where('uid','NEQ','')->limit($pre,$limit)->order('add_time DESC')->select();
	  }else{
		  $list=Db('apply_log')->where(['type'=>1,'status'=>0])->where('uid','NEQ','')->order('add_time DESC')->select();
	  }
      if($list){
        foreach ($list as $key => $value) {
          $res=Db('customer')->where('id',$list[$key]['uid'])->find();
          if($res){
            $list[$key]['user_name']=$res['user_name'];
            $list[$key]['true_name']=$res['true_name'];
          }
          $list[$key]['add_time']=date('Y-m-d H:i:s',$value['add_time']);
          if($list[$key]['check_time']!=NULL){
            $list[$key]['check_time']=date('Y-m-d H:i:s',$value['check_time']);
          }else{
            $list[$key]['check_time']='';
          }
        }
        return $result = ['code'=>0,'msg'=>'获取成功!','count'=>$count,'data'=>$list];
      }else{
		return $result = ['code'=>-1,'msg'=>'暂无充值记录数据...'];
	  }
    }
  }


  //搜索充值记录
  public function search_chongzhi()
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
		$type=input('type');
		$where = [];
		if($type!=-1){
			$where['status'] = $type;
		}
		$where['type'] = 1;
		if($keywords!=''){
			$user=Db('customer')->field('id')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->select();
			$uid=[];
			foreach($user as $key=>$value){
				array_push($uid,$user[$key]['id']);
			}
			$where['uid'] = ['IN',$uid];
		}

		if($start_time!=''){
			$where['add_time'] = ['between time',[$start_time,$e_time]];
		}

		if($start_time!=''&&$end_time!=''){
			$where['add_time'] = ['between time',[$start_time,$end_time]];
		}

		if($ins_name!=''){
			$new_ins_name=explode(',',$ins_name);
			$agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
			$aid=[];
			foreach ($agent as $key => $value) {
				array_push($aid, $agent[$key]['id']);
			}
			$user=Db('customer')->where('pid','IN',$aid)->select();
			$uid=[];
			foreach($user as $key=>$value){
				array_push($uid,$user[$key]['id']);
			}
			$where['uid'] = ['IN',$uid];
		}

		$count=Db('apply_log')->where($where)->count();
//			print_r($where);
		if($count>$limit){
			$list=Db('apply_log')->where($where)->limit($pre,$limit)->order('add_time DESC')->select();
		}else{
			$list=Db('apply_log')->where($where)->order('add_time DESC')->select();
		}

		if($list){
			foreach ($list as $key => $value) {
			  $res=Db('customer')->where('id',$list[$key]['uid'])->find();
			  if($res){
				$list[$key]['user_name']=$res['user_name'];
				$list[$key]['true_name']=$res['true_name'];
			  }
			  $list[$key]['add_time']=date('Y-m-d H:i:s',$value['add_time']);
			  if($list[$key]['check_time']!=NULL){
				$list[$key]['check_time']=date('Y-m-d H:i:s',$value['check_time']);
			  }else{
				$list[$key]['check_time']='';
			  }
			}
			return $result = ['code'=>0,'msg'=>'获取成功!','count'=>$count,'data'=>$list];
		  }else{
			return $result = ['code'=>-1,'msg'=>'暂无搜索结果数据...'];
		}
    }
  }
 //提现申请记录
  public function tiXian()
  {
    if(Request()->isPost()){
	  $page=input('page');
	  $limit=input('limit');
	  $pre=($page-1)*$limit;
	  $count=Db('apply_log')->where(['type'=>0,'status'=>0])->count();
	  if($count>$limit){
		$list=Db('apply_log')->where(['type'=>0,'status'=>0])->limit($pre,$limit)->order('add_time DESC')->select();
	  }else{
		  $list=Db('apply_log')->where(['type'=>0,'status'=>0])->order('add_time DESC')->select();
	  }
      if($list){
        foreach ($list as $key => $value) {
			if($list[$key]['uid']!=null){
				$res=Db('customer')->where('id',$list[$key]['uid'])->find();
				if($res){
					$list[$key]['user_name']=$res['user_name'];
					$list[$key]['true_name']=$res['true_name'];
					$list[$key]['p_name']=$res['p_name'];
					$list[$key]['bank_name']=$res['bank_name'];
					$list[$key]['bank_card']=$res['bank_card'];
                    $list[$key]['bank_addr']=$res['bank_addr'];
					$list[$key]['id_card']=$res['id_card'];

				}
			}else if($list[$key]['aid']!=null){
				$res=Db('agentor')->where('id',$list[$key]['aid'])->find();
				if($res){
					$list[$key]['user_name']=$res['user_name'];
					$list[$key]['true_name']=$res['true_name'];
					$list[$key]['p_name']=$res['p_name'];
					$list[$key]['bank_name']=$res['bank_name'];
					$list[$key]['bank_card']=$res['bank_card'];
                    $list[$key]['bank_addr']=$res['bank_addr'];
					$list[$key]['id_card']=$res['id_card'];
				}
			}
          
          $list[$key]['sxf']=0;
          $list[$key]['add_time']=date('Y-m-d H:i:s',$value['add_time']);
          if($list[$key]['check_time']!=NULL){
            $list[$key]['check_time']=date('Y-m-d H:i:s',$value['check_time']);
          }else{
            $list[$key]['check_time']='';
          }
        }
        return $result = ['code'=>0,'msg'=>'获取成功!','count'=>$count,'data'=>$list];
      }else{
		return $result = ['code'=>-1,'msg'=>'暂无提现申请数据...'];
	  }
    }
  }

	public function view_daifu_status(){
		$parram_df['mchid']='181209678';
		$parram_df['out_trade_no']=input('out_trade_no');
		ksort($parram_df);
		$md5str = "";
		$Md5key='9lpt6tlnsi3u7cfeq0ulsxzou0ukys9d';
		foreach ($parram_df as $key => $val) {
			$md5str = $md5str . $key . "=" . $val . "&";
		}
		$parram_df['pay_md5sign'] = strtoupper(md5($md5str . "key=" . $Md5key));
		$tjurl='https://api.dudupay.net/Payment_Dfpay_query.html';
		$re=json_decode(http_post_json($tjurl ,$parram_df),true);
		if($re['refCode']==1){
			$result=Db('daifu')->where('out_trade_no',$parram_df['out_trade_no'])->update(['status'=>1,'remark'=>$re['success_time'].$re['success_time']]);
			return json(['code'=>1,'msg'=>$re['success_time'].$re['refMsg']]);
		}else{
			return json(['code'=>0,'msg'=>$re['refMsg']]);
		}
	}

	public function refused_daifu(){
		$parram_df['out_trade_no']=input('out_trade_no');
		$result=Db('daifu')->where('out_trade_no',$parram_df['out_trade_no'])->update(['status'=>2,'remark'=>date("Y-m-d H:i:s").'取消']);
		$daifu_refsult=Db('daifu')->where('out_trade_no',$parram_df['out_trade_no'])->find();
		$user=Db('customer')->where(array('id'=>$daifu_refsult['userid']))->find();
		$uid=$daifu_refsult['userid'];
		if($result){
            //事物日志控制
            Db::startTrans();
            try{
				$money=$daifu_refsult['money'];
                $total_money=$money+$user['total_money'];
                $flow_log_result=Db('flow_log')->insert([
                        'uid'=>$uid,
                        'money'=>$money,
                        'total_money'=>$total_money,
                        'type'=>'1',
                        'add_time'=>time(),
                        'memo'=>'取消代付'
                    ]);
                if($flow_log_result){
                    $zg=Db('zg_sys')->where('id',$user['zg_id'])->find();
                    $data['UserID']=$zg['account'];
                    $data['Action']='ReqTransfer';
                    $data['ChdAccountID']=$user['zid'];//用户zid
                    $data['BadAmount']=$money;
                    //$url=$zg['server_ip'];
					$nbeApi=new model\NbeApi();
					$dataInfo['childid']= $user['zid'];
					$dataInfo['cash']= $money;
					$dataInfo['from']= 'admin input cash';
					$rec= $nbeApi->inOutCash($dataInfo);
					oplog('后台充值审核---->'.json_encode($rec));
                    //$rec= ReqTransfer($data,$url);
                    if($rec['code']==1){
                        Db('customer')->where('id',$uid)->setInc('available_money',$money);
                        Db('customer')->where('id',$uid)->setInc('local_money',$money);
                        Db('customer')->where('id',$uid)->setInc('total_money',$money);
                        Db::commit();
                        return json(['code'=>1,'msg'=>'已取消']);
                    }else{
                        Db::rollback();
                        return json(['code'=>-1,'msg'=>'取消代付入金失败，非资管入金时间']);
                    }
                }else{
                    Db::rollback();
                    return json(['code'=>0,'msg'=>'取消代付入金失败']);
                }
            }catch (\Exception $e){
                Db::rollback();
                return json(['code'=>0,'msg'=>'取消代付入金失败']);
            }
		}else{
			return json(['code'=>0,'msg'=>'取消失败，请重试']);
		}
	}
  //搜索提现记录
  public function search_tixian()
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
		$type=input('type');
		$where = [];
		if($type!=-2){
			$where['status'] = $type;
		}
		$where['type'] = 0;
		if($keywords!=''){
			$user=Db('customer')->field('id')->where('user_name|true_name|mobile|p_name|ins_name','like','%'.$keywords.'%')->select();
			$uid=[];
			foreach($user as $key=>$value){
				array_push($uid,$user[$key]['id']);
			}
			$where['uid'] = ['IN',$uid];
		}

		if($start_time!=''){
			$where['add_time'] = ['between time',[$start_time,$e_time]];
		}

		if($start_time!=''&&$end_time!=''){
			$where['add_time'] = ['between time',[$start_time,$end_time]];
		}

		if($ins_name!=''){
			$new_ins_name=explode(',',$ins_name);
			$agent=Db('agentor')->field('id')->where('user_name','IN',$new_ins_name)->select();
			$aid=[];
			foreach ($agent as $key => $value) {
				array_push($aid, $agent[$key]['id']);
			}
			$user=Db('customer')->where('pid','IN',$aid)->select();
			$uid=[];
			foreach($user as $key=>$value){
				array_push($uid,$user[$key]['id']);
			}
			$where['uid'] = ['IN',$uid];
		}

		$count=Db('apply_log')->where($where)->count();
//			print_r($where);
		if($count>$limit){
			$list=Db('apply_log')->where($where)->limit($pre,$limit)->order('add_time DESC')->select();
		}else{
			$list=Db('apply_log')->where($where)->order('add_time DESC')->select();
		}
		if($list){
			foreach ($list as $key => $value) {
			  $res=Db('customer')->where('id',$list[$key]['uid'])->find();
			  if($res){
				$list[$key]['user_name']=$res['user_name'];
				$list[$key]['true_name']=$res['true_name'];
				$list[$key]['p_name']=$res['p_name'];
				$list[$key]['bank_name']=$res['bank_name'];
				$list[$key]['bank_card']=$res['bank_card'];
				  $list[$key]['bank_addr']=$res['bank_addr'];
				  $list[$key]['id_card']=$res['id_card'];
			  }
			  $list[$key]['sxf']=0;
			  $list[$key]['add_time']=date('Y-m-d H:i:s',$value['add_time']);
			  if($list[$key]['check_time']!=NULL){
				$list[$key]['check_time']=date('Y-m-d H:i:s',$value['check_time']);
			  }else{
				$list[$key]['check_time']='';
			  }
			}
			return $result = ['code'=>0,'msg'=>'获取成功!','count'=>$count,'data'=>$list];
		  }else{
			return $result = ['code'=>-1,'msg'=>'暂无搜索结果数据...'];
		}
    }
  }
  //审核线下打款
  public function checked()
  {
    if(Request()->isPost()){
      $id=input('id');
      $res=Db('apply_log')->where('id',$id)->find();
      if($res){
		  $uid=$res['uid'];
		  $user=Db('customer')->where('id',$uid)->find();
		  $money=$res['money'];
		  $total_money=$res['total_money']+$money;

		  $nbeApi=new model\NbeApi();
		  $dataInfo['childid']= $user['zid'];
		  $dataInfo['cash']= $money;
		  $dataInfo['from']= 'admin input cash';
		  $rec= $nbeApi->inOutCash($dataInfo);
		  oplog('线下充值审核---->'.json_encode($rec));
		  if($rec['code']==1){
			Db('customer')->where('id',$uid)->setInc('available_money',$money);
			Db('customer')->where('id',$uid)->setInc('local_money',$money);
			Db('customer')->where('id',$uid)->setInc('total_money',$money);
			$result=Db('apply_log')->where('id',$id)->update(['status'=>1,'total_money'=>$total_money,'check_time'=>time()]);
			if($result){
				$new=Db('apply_log')->where('id',$id)->find();
				$record=Db('flow_log')->insert([
						'uid'=>$new['uid'],
						'money'=>$money,
						'total_money'=>$total_money,
						'type'=>$new['type'],
						'add_time'=>$new['add_time'],
						'check_time'=>$new['check_time'],
						'remark'=>$new['remark'],
						'charge_img'=>$new['charge_img'],
						'memo'=>$new['memo']
					]);
				if($record){
					return json(['code'=>1,'msg'=>'审核通过!']);
				}
			}
			
		}else{
			return json(['code'=>0,'msg'=>'同步资管系统数据失败!']);
		}
      }else{
        return json(['code'=>-1,'msg'=>'充值记录不存在!']);
      }
    }
  }

  //拒绝线下打款
  public function refused()
  {
    if(Request()->isPost()){
      $id=input('id');
      $memo=input('memo');
      $res=Db('apply_log')->where('id',$id)->find();
      if($res){
        $result=Db('apply_log')->where('id',$id)->update(['status'=>-1,'memo'=>$memo,'check_time'=>time()]);
        if($result){
          $new=Db('apply_log')->where('id',$id)->find();
          Db('flow_log')->insert([
              'uid'=>$new['uid'],
              'money'=>$new['money'],
              'total_money'=>$new['total_money'],
              'type'=>$new['type'],
              'add_time'=>$new['add_time'],
              'check_time'=>$new['check_time'],
              'remark'=>$new['remark'],
              'charge_img'=>$new['charge_img'],
              'memo'=>$new['memo']
          ]);
          return json(['code'=>1,'msg'=>'审核不通过!']);
        }else{
          return json(['code'=>0,'msg'=>'数据异常，操作失败!']);
        }
      }else{
        return json(['code'=>-1,'msg'=>'充值记录不存在!']);
      }
    }
  }

  //提现审核
  public function agreeApply()
  {
    if(Request()->isPost()){
      $id=input('id');
      $res=Db('apply_log')->where('id',$id)->find();
      if($res){
		$uid=$res['uid'];
		$aid=$res['aid'];
		if($uid!=''||$uid!=null){
			$user=Db('customer')->where('id',$uid)->find();
			$money=$res['money'];
			$total_money=$res['total_money']-$money;
			$nbeApi=new model\NbeApi();
			$dataInfo['childid']= $user['zid'];
			$dataInfo['cash']= -$money;
			$dataInfo['from']= 'admin input cash';
			$rec= $nbeApi->inOutCash($dataInfo);
			if($rec['code']==1){
				Db('customer')->where('id',$uid)->setDec('available_money',$money);
				Db('customer')->where('id',$uid)->setDec('local_money',$money);
				Db('customer')->where('id',$uid)->setDec('total_money',$money);
				$result=Db('apply_log')->where('id',$id)->update(['status'=>1,'total_money'=>$total_money,'check_time'=>time(),'memo'=>'审核通过','remark'=>'审核通过']);
				if($result){
					$new=Db('apply_log')->where('id',$id)->find();
					Db('flow_log')->insert([
					  'uid'=>$new['uid'],
					  'money'=>$new['money'],
					  'total_money'=>$new['total_money'],
					  'type'=>$new['type'],
					  'add_time'=>$new['add_time'],
					  'check_time'=>$new['check_time'],
					  'remark'=>$new['remark'],
					  'charge_img'=>$new['charge_img'],
					  'memo'=>empty($new['memo'])?'审核通过':$new['memo']
					]);
					return json(['code'=>1,'msg'=>'同意申请,审核成功!']);
				}else{
					return json(['code'=>0,'msg'=>'提现申请审核失败!']);
				}

			}else{
				return json(['code'=>-1,'msg'=>'同步资管系统数据失败!']);
			}
		}else if($aid!=''||$aid!=null){
			$money=$res['money'];
			$total_money=$res['total_money1']-$money;
			Db('agentor')->where('id',$aid)->setDec('available_money',$money);
			Db('agentor')->where('id',$aid)->setDec('local_money',$money);
			Db('agentor')->where('id',$aid)->setDec('total_money',$money);
			$result=Db('apply_log')->where('id',$id)->update(['status'=>1,'total_money'=>$total_money,'check_time'=>time()]);
			if($result){
				$new=Db('apply_log')->where('id',$id)->find();
				Db('flow_log')->insert([
				  'aid'=>$new['aid'],
				  'money'=>$new['money'],
				  'total_money'=>$new['total_money'],
				  'type'=>$new['type'],
				  'add_time'=>$new['add_time'],
				  'check_time'=>$new['check_time'],
				  'remark'=>$new['remark'],
				  'charge_img'=>$new['charge_img'],
				  'memo'=>$new['memo']
				]);
				return json(['code'=>1,'msg'=>'同意申请,审核成功!']);
			}else{
				return json(['code'=>0,'msg'=>'提现申请审核失败!']);
			}
		}
        
      }else{
        return json(['code'=>-2,'msg'=>'提现记录不存在!']);
      }
    }
  }

  //拒绝提现申请
  public function refuseApply()
  {
    if(Request()->isPost()){
      $id=input('id');
      $memo=empty(input('memo'))?'拒绝提现申请':input('memo');
      $res=Db('apply_log')->where('id',$id)->find();
      if($res){
        $result=Db('apply_log')->where('id',$id)->update(['status'=>-1,'memo'=>$memo,'remark'=>$memo,'check_time'=>time()]);
        if($result){
          $new=Db('apply_log')->where('id',$id)->find();
          Db('flow_log')->insert([
              'uid'=>$new['uid'],
			  'aid'=>$new['aid'],
              'money'=>$new['money'],
              'total_money'=>$new['total_money'],
              'type'=>$new['type'],
              'add_time'=>$new['add_time'],
              'check_time'=>$new['check_time'],
              'remark'=>$new['remark'],
              'charge_img'=>$new['charge_img'],
              'memo'=>empty($new['memo'])?'拒绝提现申请':$new['memo']
          ]);
          return json(['code'=>1,'msg'=>'拒绝申请!']);
        }else{
          return json(['code'=>0,'msg'=>'数据异常，操作失败!']);
        }
      }else{
        return json(['code'=>-1,'msg'=>'充值记录不存在!']);
      }
    }
  }

  //查看凭证
  public function viewImg()
  {
	if(Request()->isPost()){
		$id=input('id');
		$res=Db('apply_log')->where('id',$id)->find();
		return json($res);
	}
  }
    
}
