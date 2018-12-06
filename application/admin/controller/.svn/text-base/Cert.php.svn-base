<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Input;

class Cert extends Common
{
  public function _initialize(){
    parent::_initialize();
  }
  public function index()
  {
  	if(Request()->isPost()){
  		$list=Db('user_cert')->where('status',0)->select();
  		if($list){
			foreach ($list as $k => $v) {
				if($list[$k]['type']==0){
					$user=Db('customer')->where(['id'=>$list[$k]['uid']])->find();
					$list[$k]['user_name']=$user['user_name'];
					$list[$k]['true_name']=$user['true_name'];
					$list[$k]['idcard']=$user['id_card'];
                    $list[$k]['bank_name']=$user['bank_name'];
                    $list[$k]['bank_card']=$user['bank_card'];
                     $list[$k]['bank_addr']=$user['bank_addr'];
					$list[$k]['ins_name']=$user['ins_name'];
					$list[$k]['p_name']=$user['p_name'];
				}else{
					$user=Db('agentor')->where(['id'=>$list[$k]['uid']])->find();
					$list[$k]['user_name']=$user['user_name'];
					$list[$k]['true_name']=$user['true_name'];
					$list[$k]['idcard']=$user['id_card'];
                    $list[$k]['bank_name']=$user['bank_name'];
                    $list[$k]['bank_card']=$user['bank_card'];
                     $list[$k]['bank_addr']=$user['bank_addr'];
					$list[$k]['ins_name']=$user['ins_name'];
					$list[$k]['p_name']=$user['p_name'];
				}
				$list[$k]['up_time']=date('Y-m-d H:i:s',$v['up_time']);

				switch ($list[$k]['status']) {
					case 1:
						$list[$k]['status']='已审核';
						$list[$k]['check_time']=date('Y-m-d H:i:s',$v['check_time']);
						break;
					case 0:
						$list[$k]['status']='未审核';
						$list[$k]['check_time']= '--';
						break;
					case -1:
						$list[$k]['status']='审核未通过';
						$list[$k]['check_time']=date('Y-m-d H:i:s',$v['check_time']);
						break;
				}
				
			}
  			return $result=['code'=>0,'msg'=>'','count'=>count($list),'data'=>$list];
  		}else{
			return $result=['code'=>-1,'msg'=>'暂无未审核的数据...'];
		}
  	}
    return $this->fetch();
  }
  //审核
  public function checked()
  {
	if(Request()->isPost()){
		$id=input('id');
		$uid=input('uid');
		$type=input('type');
		$res=Db('user_cert')->where('id',$id)->update(['status'=>1,'check_time'=>time()]);
		if($res){
			if($type==0){
				Db('customer')->where('id',$uid)->update(['is_true'=>1]);

				if(AUTO_OPEN_USER==1){
                    $resInfo=Db('customer')->where(['id'=>$uid])->find();
                    //如果勾选了自动开户，则需要自动插入一条开户申请
                    if($resInfo['is_open']==1){
                        return json(array('code'=>-3,'msg'=>'该账号已经开户，无法重复申请！'));
                    }
                    //判断是否已经提交申请开户，或者审核已经通过
                    $num= Db::name('openaccount_apply')->where('userid',$uid)->where('status','in',array(0,1))->count();
                    if($num>0){
                        return json(array('code'=>-4,'msg'=>'无法重复申请开户！'));
                    }
                    //插入数据库记录
                    Db::startTrans();
                    try{
                        Db::commit();
                        Db::name('customer')->where('id',$uid)->update(array('is_open'=>2));
                        Db::name('openaccount_apply')->insert(array('userid'=>$uid,'nikename'=>$resInfo['true_name']));
                        //插入信息提示信息
                        $insertData['content']=$resInfo['user_name'].'自动开户申请，请及时审核';
                        $insertData['url']="{:url('customer/checkOpenUser')}";
                        $insertData['domain']='';
                        $insertData['type']=1;
                        $insertData['status']=1;
                        \think\Db::name('system_msg')->insert($insertData);
                        Db::commit();
                    }catch (\Exception $e){
                        Db::rollback();
                        return json(array('code'=>-1,'msg'=>'审核通过，自动开户申请失败！'));
                    }
                }

                return json(['code'=>1,'msg'=>'审核通过']);
			}else{
				Db('agentor')->where('id',$uid)->update(['is_true'=>1]);
				return json(['code'=>1,'msg'=>'审核通过']);
			}
		}else{
			return json(['code'=>0,'msg'=>'操作超时，请检查网络']);
		}
	}
  }
  //拒绝
  public function refused()
  {
	if(Request()->isPost()){
		$id=input('id');
		$memo=input('memo');
		$res=Db('user_cert')->where('id',$id)->update(['status'=>-1,'check_time'=>time(),'memo'=>$memo]);
		if($res){
            $uid=Db('user_cert')->where('id',$id)->value('uid');
			$userInfo= Db::name('customer')->where('id',$uid)->find();
			if(!empty($userInfo['user_name'])){
				$content=empty($memo)?'实名认证审核拒绝':$memo;
				$resSms=aliSmsNotice($userInfo['user_name'],$content,$skin=3);
				Db('sms')->insert(['mobile'=>$userInfo['user_name'],'code'=>$content,'type'=>'实名认证审核拒绝，'.$content,'add_time'=>time(),'result'=>$resSms['msg']]);
			}
			return json(['code'=>1,'msg'=>'审核不通过']);
		}else{
			return json(['code'=>0,'msg'=>'操作超时，请检查网络']);
		}
	}
  }
  //查看
  public function viewInfo()
  {
	if(Request()->isPost()){
		$uid=input('uid');
		$type=input('type');
		if($type==0){
			$res=Db('customer')->where('id',$uid)->find();
			if($res){
				return json(['card_id_img_top'=>$res['card_id_img_top'],'card_id_img_bot'=>$res['card_id_img_bot'],'bank_card_img_top'=>$res['bank_card_img_top']]);
			}
		}else{
			$res=Db('agentor')->where('id',$uid)->find();
			if($res){
				return json(['card_id_img_top'=>$res['card_id_img_top'],'card_id_img_bot'=>$res['card_id_img_bot'],'bank_card_img_top'=>$res['bank_card_img_top']]);
			}
		}
	}
  }
  //搜索
  public function search_list()
  {

		$keywords=input('keywords');
		$start_time=input('start_time');
		$e_time=date('Y-m-d',strtotime("+1 day",strtotime($start_time)));
		$end_time=input('end_time');
		if($end_time!=''){
		  $end_time=date('Y-m-d',strtotime("+1 day",strtotime($end_time)));
		}
		$status=input('type');
		if($keywords!=''&&$start_time!=''&&$end_time!=''){
			$user=Db('customer')->where('user_name|true_name|mobile','like','%'.$keywords.'%')->select();
			$uid=[];
			foreach($user as $key=>$value){
				array_push($uid,$user[$key]['id']);
			}
			$list=Db('user_cert')->where('uid','IN',$uid)->where('status',$status)->where('check_time','between time',[$start_time,$end_time])->select();
		}else if($keywords!=''&&$start_time!=''){
			$user=Db('customer')->where('user_name|true_name|mobile','like','%'.$keywords.'%')->select();
			$uid=[];
			foreach($user as $key=>$value){
				array_push($uid,$user[$key]['id']);
			}
			$list=Db('user_cert')->where('uid','IN',$uid)->where('status',$status)->where('check_time','between time',[$start_time,$e_time])->select();

		}else if($start_time!=''&&$end_time!=''){
			$list=Db('user_cert')->where('status',$status)->where('check_time','between time',[$start_time,$end_time])->select();
		}else if($start_time!=''){
			$list=Db('user_cert')->where('status',$status)->where('check_time','between time',[$start_time,$e_time])->select();
		}else if($keywords!=''){
			$user=Db('customer')->where('user_name|true_name|mobile','like','%'.$keywords.'%')->select();
			$uid=[];
			foreach($user as $key=>$value){
				array_push($uid,$user[$key]['id']);
			}
			$list=Db('user_cert')->where('uid','IN',$uid)->where('status',$status)->select();
		}else{
			$list=Db('user_cert')->where('status',$status)->select();
		}
		if($list){
			foreach ($list as $k => $v) {
				if($list[$k]['type']==0){
					$user=Db('customer')->where(['id'=>$list[$k]['uid']])->find();
					$list[$k]['user_name']=$user['user_name'];
					$list[$k]['true_name']=$user['true_name'];
					$list[$k]['idcard']=$user['id_card'];
					$list[$k]['bank_name']=$user['bank_name'];
                    $list[$k]['bank_card']=$user['bank_card'];
                    $list[$k]['bank_addr']=$user['bank_addr'];
					$list[$k]['ins_name']=$user['ins_name'];
					$list[$k]['p_name']=$user['p_name'];
				}else{
					$user=Db('agentor')->where(['id'=>$list[$k]['uid']])->find();
					$list[$k]['user_name']=$user['user_name'];
					$list[$k]['true_name']=$user['true_name'];
					$list[$k]['idcard']=$user['id_card'];
					  $list[$k]['bank_name']=$user['bank_name'];
                    $list[$k]['bank_card']=$user['bank_card'];
                    $list[$k]['bank_addr']=$user['bank_addr'];
					$list[$k]['ins_name']=$user['ins_name'];
					$list[$k]['p_name']=$user['p_name'];
				}
				$list[$k]['up_time']=date('Y-m-d H:i:s',$v['up_time']);
				$list[$k]['check_time']=date('Y-m-d H:i:s',$v['check_time']);
				switch ($list[$k]['status']) {
					case 1:
						$list[$k]['status']='已审核';
						break;
					case 0:
						$list[$k]['status']='未审核';
						break;
					case -1:
						$list[$k]['status']='审核未通过';
						break;
				}
			}
			if(!empty(input('export'))){
				//姓名  账号   手机号    所属机构   账户余额  注册时间
				$xlsName  = "客户列表查询";
				$xlsCell  = array(
					array('id','序号'),
					array('user_name','账号'),
					array('true_name','姓名'),
					array('idcard','身份证号'),
					array('ins_name','所属机构'),
					array('p_name','上级代理'),
					array('bank_name','开户银行'),
					array('bank_addr','开户支行'),
					array('bank_card','银行卡号'),
					array('up_time','提交时间'),
					array('check_time','审核时间'),
					array('status','状态'),
					array('memo','备注')
				);
				$xlsData  = $list;
				$this->exportExcel($xlsName,$xlsCell,$xlsData);
				return $result=['code'=>-1,'msg'=>'未搜索到相关数据...'];
			}else{
				return $result=['code'=>0,'msg'=>'','count'=>count($list),'data'=>$list];
			}

		}else{
			return $result=['code'=>-1,'msg'=>'未搜索到相关数据...'];
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

}
