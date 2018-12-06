<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Input;
use think\Request;
use think\Session;
use think\File;
use app\admin\model;
class Api extends controller
{
  public function _initialize(){
    parent::_initialize();
  }
  public function index()
  {
    return $this->fetch();
  }
  //用户注册
  public function reg(){
    if(Request()->isAjax()){
      $account=trim(input('account'));
      $password=md5(trim(input('password')));
      $smsCode=trim(input('sms_code'));
      $extCode=trim(input('ext_code'));
      $sendCode=Db('sms')->where('mobile',$account)->order('id DESC')->find();
      $agent=Db('agentor')->where('code',$extCode)->find();
      if(!$agent){
        return json(['code'=>-4,'msg'=>'邀请码不对，请检查是否输入有误？']);
      }
      $remain=time()-$sendCode['add_time'];
      if($smsCode==$sendCode['code']&&$remain<=1800){
        $user=Db('customer')->where('user_name',$account)->find();
        if(!$user){
          $str=(string)time();
          $auth=$this->authcode($str,'auto');
          //注册诺贝账号
          $dataInfo['account']= $account;
          $dataInfo['password']= trim(input('password'));
          $mzh=Db::name('mzh_config')->where('id',$agent['mzh_id'])->value('account');
          $dataInfo['motheraccount']= $mzh;
            $sxf=Db('sxf_mb')->where('id', $agent['sxf_id'])->value('bh');
            $con=Db('fk_config')->where('id', $agent['fk_id'])->value('account');
            $dataInfo['chargemouldid'] =$sxf;
            $dataInfo['control'] =$con;
			$apiurl = getcofig('WINDOWS_URL');
          $nbeApi=new model\NbeApi();
          $res= $nbeApi->createAccount($dataInfo);
		  if(is_array($res)){
			  if(isset($res['msg'])){
				$re=preg_match('/\{.*\}/',$res['msg'],$arr);
				if($re){
					$re_decode=json_decode(gbkToUtf8($arr['0']),true);
					oplog('注册同步诺贝信息1111--'.$re_decode['account']);
				}else{
					oplog('注册同步诺贝信息2222--'.$res['msg']);
				}
			  }else{
				oplog('注册同步诺贝信息--'.serialize($res));
			  }
		  }else{
			oplog('注册同步诺贝信息--'.$res);
		  }
		  oplog('注册同步诺贝信息--'.json_encode($dataInfo));
		  oplog('注册同步诺贝信息--'.json_encode($res));
          if(empty($res)||$res['code']!=1){
			if(is_array($res)){
				if(isset($res['msg'])){
					$re=preg_match('/\{.*\}/',$res['msg'],$arr);
					if($re){
						return json(['code'=>0,'msg'=>'用户注册失败,资管系统同步失败！'.$re_decode['account']]);
					}else{
						return json(['code'=>0,'msg'=>'用户注册失败,资管系统同步失败！']);
					}
				}
			}
          }
          $res=Db('customer')->insert(['user_name'=>$account,'user_pwd'=>$password,'mobile'=>$account,'aid'=>$agent['id'],'tid'=>$agent['tid'],'pid'=>$agent['id'],
              'p_name'=>$agent['true_name'],'ins_name'=>$agent['ins_name'],'auth'=>$auth,'code'=>mt_rand(1000,9999),'add_time'=>time(),
              'zid'=>$res['childid'],'sxf_id'=>$agent['sxf_id'],'mzh_id'=>$agent['mzh_id'],'zg_id'=>$agent['zg_id'],'fk_id'=>$agent['fk_id']]);
          if($res){
            return json(['code'=>1,'msg'=>'用户注册成功！']);
          }else{
            return json(['code'=>0,'msg'=>'用户注册失败！']);
          }
        }else{
          return json(['code'=>-1,'msg'=>'该手机号已注册，请更换手机号！']);
        }
      }else if($smsCode!=$sendCode['code']){
        return json(['code'=>-2,'msg'=>'短信验证码输入有误，请重新填写！']);
      }else if($remain['min']>30){
        return json(['code'=>-3,'msg'=>'短信验证码已超时，请重新发送！']);
      }else{
          return json(['code'=>-4,'msg'=>'参数错误1！']);
      }
    }
  }
  //用户登录
  public function login(){
    if(Request()->isAjax()){
      $account=trim(input('account'));
      $password=md5(trim(input('password')));
      $type=input('type');
      if($type==0){
        $res=Db('customer')->where('user_name',$account)->find();
      }else if($type==1){
        $res=Db('agentor')->where('user_name',$account)->find();
      }
      $data=[];
      if($res){
        if($res['user_name']==$account&&$res['user_pwd']===$password){
          $str=(string)time();
          $auth=$this->authcode($str,'auto');
          if($type==0){
            Db('customer')->where('user_name',$account)->update(['auth'=>$auth]);
            $user=Db('customer')->where('user_name',$account)->find();
          }else if($type==1){
             Db('agentor')->where('user_name',$account)->update(['auth'=>$auth]);
             $user=Db('agentor')->where('user_name',$account)->find();
          }
          $result=[1,'登录成功'];
          $data=array_merge($data,$user);
        }else{
          $result=[0,'用户密码不正确,请检查是否输入有误？'];
        }
      }else{
        $result=[-1,'用户账号不存在,请检查是否输入有误？'];
      }
      return json(['code'=>$result[0],'msg'=>$result[1],'data'=>$data]);
    }
  }
  //修改用户资料
  public function editUserInfo()
  {
	if(Request()->isAjax()){
      $uid=trim(input('uid'));
      $auth=trim(input('auth'));
	  $nick_name=trim(input('nick_name'));
      $type=input('type');
	  if($type==0){
        $res=Db('customer')->where('id',$uid)->update(['nick_name'=>$nick_name]);
		if($res){
			return json(['code'=>1,'msg'=>'资料更新成功']);
		}else{
			return json(['code'=>0,'msg'=>'资料更新失败']);
		}
      }else if($type==1){
        $res=Db('agentor')->where('id',$uid)->update(['nick_name'=>$nick_name]);
		if($res){
			return json(['code'=>1,'msg'=>'资料更新成功']);
		}else{
			return json(['code'=>0,'msg'=>'资料更新失败']);
		}
      }
    }
  }
  //上传头像
  public function upload_logo()
  {
	if(Request()->isAjax()){
      $uid=trim(input('uid'));
      $auth=trim(input('auth'));
      $type=input('type');
	  $user_logo=$this->upload_img("user_logo");
      if($type==0){
        $res=Db('customer')->where('id',$uid)->update(['user_logo'=>$user_logo]);
		if($res){
			return json(['code'=>1,'msg'=>'头像更新成功']);
		}else{
			return json(['code'=>0,'msg'=>'头像更新失败']);
		}
      }else if($type==1){
        $res=Db('agentor')->where('id',$uid)->update(['user_logo'=>$user_logo]);
		if($res){
			return json(['code'=>1,'msg'=>'头像更新成功']);
		}else{
			return json(['code'=>0,'msg'=>'头像更新失败']);
		}
      }
    }
  }
  //重新登录
  public function isLogin()
  {
      $account=trim(input('account'));
      $auth=trim(input('auth'));
      $type=input('type','0');
      if(empty($account)){
          return json(['code'=>0,'msg'=>'可以正常登录']);
      }

      if($type==0){
        $user=Db('customer')->where('user_name',$account)->find();
      }else if($type==1){
        $user=Db('agentor')->where('user_name',$account)->find();
      }
        if(empty($user)){
            $user=Db('agentor')->where('user_name',$account)->find();
        }
      if($user['auth']!==$auth){
        return json(['code'=>1,'msg'=>'身份过期,需重新登录']);
      }else{
        return json(['code'=>0,'msg'=>'可以正常登录']);
      }

  }
  //修改密码
  public function alertPwd()
  {
	if(Request()->isAjax()){
      $uid=input('uid');
      $auth=input('auth');
	  $oldpwd=md5(trim(input('oldpwd')));
	  $newpwd=md5(trim(input('newpwd')));
      $type=input('type');
      if($type==0){
         $res=Db('customer')->where(['id'=>$uid,'auth'=>$auth])->find();
         if($res){
			if($oldpwd==$res['user_pwd']){
			 $user=Db('customer')->where(['id'=>$uid])->update(['user_pwd'=>$newpwd]);
			 if($user){
                 $dataInfo['childid']= $res['zid'];
                 $dataInfo['password']= trim(input('newpwd'));
                 $nbeApi=new model\NbeApi();
                 $res= $nbeApi->UpdateAccount($dataInfo);
                 if(empty($res)||$res['code']!=1){
                     return json(['code'=>0,'msg'=>'用户修改密码失败,资管系统同步失败！'.$res['msg']]);
                 }
				return json(['code'=>1,'msg'=>'密码修改成功']);
			  }else{
				return json(['code'=>0,'msg'=>'密码修改失败']);
			  }
			}else{
				return json(['code'=>-1,'msg'=>'原始密码输入不正确']);
			}
          }else{
              return json(['code'=>-2,'msg'=>'身份过期,需重新登录']);
          }
      }else if($type==1){
          $res=Db('agentor')->where(['id'=>$uid,'auth'=>$auth])->find();
          if($res){
			if($oldpwd==$res['user_pwd']){
			 $user=Db('agentor')->where(['id'=>$uid])->update(['user_pwd'=>$newpwd]);
			 if($user){
				return json(['code'=>1,'msg'=>'密码修改成功']);
			  }else{
				return json(['code'=>0,'msg'=>'密码修改失败']);
			  }
			}else{
				return json(['code'=>-1,'msg'=>'原始密码输入不正确']);
			}
          }else{
              return json(['code'=>-2,'msg'=>'身份过期,需重新登录']);
          }
      }else{
          return json(['code'=>-3,'msg'=>'数据提交失败，请检查接口参数']);
      }
    }
  }
  //找回密码
  public function forgetPwd()
  {
	if(Request()->isAjax()){
		$account=trim(input('account'));
		$smsCode=trim(input('sms_code'));
		$password=md5(trim(input('newpwd')));
		$sendCode=Db('sms')->where('mobile',$account)->order('id DESC')->find();
		$type=input('type');
		if($type==0){
			$user=Db('customer')->where('user_name',$account)->find();
			if($user){
				if($smsCode==$sendCode['code']){
					$res=Db('customer')->where('user_name',$account)->update(['user_pwd'=>$password]);
					if($res){
						return json(['code'=>1,'msg'=>'新密码设置成功']);
					}
				}else{
					return json(['code'=>0,'msg'=>'短信验证码不正确']);
				}
			}else{
				return json(['code'=>-1,'msg'=>'用户账号不存在']);
			}
		}else if($type==1){
			$user=Db('agentor')->where('user_name',$account)->find();
			if($user){
				if($smsCode==$sendCode['code']){
					$res=Db('agentor')->where('user_name',$account)->update(['user_pwd'=>$password]);
					if($res){
						return json(['code'=>1,'msg'=>'新密码设置成功']);
					}
				}else{
					return json(['code'=>0,'msg'=>'短信验证码不正确']);
				}
			}else{
				return json(['code'=>-1,'msg'=>'用户账号不存在']);
			}
		}
	}
  }
  //查看实名认证状态
  public function viewCertState()
  {
	if(Request()->isAjax()){
      $uid=input('uid');
      $auth=input('auth');
      $type=input('type');
      if($type==0){
         $res=Db('customer')->where(['id'=>$uid,'auth'=>$auth])->find();
         if($res){
			 $cert=Db('user_cert')->where(['uid'=>$uid])->find();
			 if($cert){
			 	 if($cert['status']==1){
                     return json(['code'=>2,'status'=>1,'msg'=>'审核通过','data'=>$cert]);
                 }elseif($cert['status']==-1){
                     return json(['code'=>1,'status'=>-1,'msg'=>'审核拒绝，'.$cert['memo'],'data'=>$cert]);
                 }elseif($cert['status']==0){
                     return json(['code'=>1,'status'=>0,'msg'=>'审核中','data'=>$cert]);
                 }else{
                     return json(['code'=>-1010,'msg'=>'异常','data'=>$cert]);
                 }
				//return json(['code'=>1,'msg'=>'获取成功','data'=>$cert]);
			  }else{
				return json(['code'=>0,'status'=>0,'msg'=>'未提交实名申请']);
			  }
          }else{
              return json(['code'=>-1,'msg'=>'身份过期,需重新登录']);
          }
      }else if($type==1){
         $res=Db('agentor')->where(['id'=>$uid,'auth'=>$auth])->find();
          if($res){
              $cert=Db('user_cert')->where(['uid'=>$uid])->find();
			   if($cert){
			 	 if($cert['status']==1){
                     return json(['code'=>0,'msg'=>'获取成功','data'=>$cert]);
                 }elseif($cert['status']==-1){
                     return json(['code'=>1,'msg'=>'审核拒绝，'.$cert['memo'],'data'=>$cert]);
                 }elseif($cert['status']==0){
                     return json(['code'=>3,'msg'=>'获取成功','data'=>$cert]);
                 }else{
                     return json(['code'=>-1010,'msg'=>'获取成功','data'=>$cert]);
                 }
				//return json(['code'=>1,'msg'=>'获取成功','data'=>$cert]);
			  }else{
				return json(['code'=>2,'msg'=>'未提交实名申请']);
			  }
          }else{
              return json(['code'=>-1,'msg'=>'身份过期,需重新登录']);
          }
      }else{
          return json(['code'=>-2,'msg'=>'数据提交失败，请检查接口参数']);
      }
    }
  }
  //查看用户资金流水
  public function viewFlowLog()
  {
	if(Request()->isAjax()){
      $uid=input('uid');
      $auth=input('auth');
      $type=input('type');
	  if($type==0){
         $res=Db('customer')->where(['id'=>$uid,'auth'=>$auth])->find();
         if($res){
			 $log=Db('flow_log')->where(['uid'=>$uid])->select();
			 if($log){
				return json(['code'=>1,'msg'=>'获取成功','data'=>$log]);
			  }else{
				return json(['code'=>0,'msg'=>'暂无流水']);
			  }
          }else{
              return json(['code'=>-1,'msg'=>'身份过期,需重新登录']);
          }
      }else if($type==1){
         $res=Db('agentor')->where(['id'=>$uid,'auth'=>$auth])->find();
          if($res){
              $log=Db('flow_log')->where(['uid'=>$uid])->select();
			  if($log){
				return json(['code'=>1,'msg'=>'获取成功','data'=>$log]);
			  }else{
				return json(['code'=>0,'msg'=>'暂无流水']);
			  }
          }else{
              return json(['code'=>-1,'msg'=>'身份过期,需重新登录']);
          }
      }else{
          return json(['code'=>-2,'msg'=>'数据提交失败，请检查接口参数']);
      }
	}
  }
  //用户实名认证
  public function setUserInfo()
  {
    if(Request()->isAjax()){
      $uid=input('uid');
      $auth=input('auth');
      $type=input('type');
	  $imgUrl1=$this->upload_img("card_id_img_top");
	  $imgUrl2=$this->upload_img("card_id_img_bot");
	  $imgUrl3=$this->upload_img("bank_card_img_top");
      $data=[
        'true_name'=>trim(input('true_name')),
        'id_card'=>trim(input('id_card')),
        'bank_name'=>trim(input('bank_name')),
        'bank_card'=>trim(input('bank_card')),
        'bank_addr'=>trim(input('bank_addr')),
        'province'=>trim(input('province')),
        'city'=>trim(input('city')),
        'subbranch'=>trim(input('subbranch')),
        'card_id_img_top'=>$imgUrl1,
        'card_id_img_bot'=>$imgUrl2
      ];
      if($data['true_name']==''||$data['id_card']==''||$data['bank_name']==''||$data['bank_card']==''||$data['bank_addr']==''||$data['card_id_img_top']==''||$data['card_id_img_bot']==''){
        return json(['code'=>0,'msg'=>'认证信息提交不完整']);
      }else{
		  $user_re=Db('customer')->where(['id'=>$uid,'auth'=>$auth])->find();
		  $to_verify_arr['customerCode']='VG648591114043441591';
		  $to_verify_arr['userName']=$data['true_name'];
		  $to_verify_arr['userCard']=$data['id_card'];
		  $to_verify_arr['userPhone']=$user_re['mobile'];
		  $to_verify_arr['userBank']=$data['bank_card'];
		  $to_verify_arr['signature']  = hc_gdy_getSignature($to_verify_arr);
		  $api_host='http://blacklist.sdshopping.cn/user-api/blacklist';
//			$message = http_post_json($api_host,$to_verify_arr);
//			oplog('防客诉验证结果---'.$message);
//			$message = json_decode($message,true);
			$message['success']=true;
			$message['result']['code']='10009';
			if($message['success']&&$message['result']['code']=='10009'){
				if($type==0){
					$res=Db('customer')->where(['id'=>$uid,'auth'=>$auth])->update($data);
				  }else if($type==1){
					$res=Db('agentor')->where(['id'=>$uid,'auth'=>$auth])->update($data);
				  }
				if($res){
					$cert=Db('user_cert')->where(['uid'=>$uid,'type'=>0])->find();
					if(!$cert){
						Db('user_cert')->insert(['uid'=>$uid,'type'=>0,'up_time'=>time(),'status'=>0]);
					}else{
						Db('user_cert')->where(array('uid'=>$uid,'type'=>0))->update(array('up_time'=>time(),'status'=>0));
					}
					//插入信息提示信息
					$insertData['content']=$data['true_name'].'实名认证提交申请，请管理员及时审核';
					$insertData['url']="{:url('cert/index')}";
					$insertData['domain']='';
					$insertData['type']=1;
					$insertData['status']=1;
					\think\Db::name('system_msg')->insert($insertData);
				  return json(['code'=>1,'msg'=>'实名认证提交成功，等待管理员进行审核！']);
				}else{
				  return json(['code'=>0,'msg'=>'数据提交失败，请检查接口参数']);
				}
			}else{
				return json(['code'=>0,'msg'=>$message['result']['msg']]);
			}
          
      }
    }
  }
  
  //上传接口
    public function upload(){
        // 获取上传文件表单字段名
        $fileKey = array_keys(request()->file());
        // 获取表单上传文件
        $file = request()->file($fileKey['0']);
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DIRECTORY_SEPARATOR . 'uploads');
        if($info){
            $result['code'] = 1;
            $result['info'] = '图片上传成功!';
            $path=str_replace('\\','/',$info->getSaveName());
            $result['url'] = '/uploads/'. $path;
            return $result;
        }else{
            // 上传失败获取错误信息
            $result['code'] =0;
            $result['info'] = '图片上传失败!';
            $result['url'] = '';
            return $result;
        }
    }
	//上传图片
	private function upload_img($name){
        $file = Request::instance()->file($name);
        if (!$file instanceof File) {
            return '111';
        }
        if (!$file->validate(['ext'=>'jpg,jpeg,png,gif'])->check() ) {
            return '222';
        }
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){
            return '/uploads/'.$info->getSaveName();
        }else{
            return '333';
        }
    }
  //获取用户绑定实名认证接口状态
  public function getUserInfo()
  {


      $uid=input('uid');
      $auth=input('auth');
      $type=input('type');
      if(empty($uid)){
          return json(['code'=>1,'msg'=>'获取失败']);
      }
      if($type==0){
         $res=Db('customer')->where(['id'=>$uid,'auth'=>$auth])->find();
         if($res){
              return json(['code'=>1,'msg'=>'获取成功','data'=>$res]);
          }else{
              return json(['code'=>1,'msg'=>'获取失败']);
          }
      }else if($type==1){
         $res=Db('agentor')->where(['id'=>$uid,'auth'=>$auth])->find();
          if($res){
              return json(['code'=>1,'msg'=>'获取成功','data'=>$res]);
          }else{
              return json(['code'=>1,'msg'=>'获取失败']);
          }
      }else{
          return json(['code'=>1,'msg'=>'数据提交失败，请检查接口参数']);
      }

  }
  //短信发送接口
  public function sms_send(){
    if(Request()->isAjax()){
      $mobile=trim(input('account'));
      $type=input('type');//0-注册用户,1-找回密码
      $content='短信发送通知';
	  $content='您的验证码是';
      $code=mt_rand(1000,9999);
      $sms=Db('sms')->where('mobile',$mobile)->order('id DESC')->find();
       $user=Db('customer')->where('user_name',$mobile)->find();
      if(!$sms){
       
        if($type==0){
         if(!empty($user)){
              return json(['code'=>-1,'msg'=>'该用手机号已注册，请前往登陆']);
            }
          $res=send_sms_new($mobile,$content.$code,$skin='');
          Db('sms')->insert(['mobile'=>$mobile,'code'=>$code,'type'=>'注册用户','add_time'=>time(),'result'=>$res['msg']]);
        }else if($type==1){
          if(empty($user)){
            return json(['code'=>-1,'msg'=>'该用手机号未注册，请先注册']);
          }
          $res=send_sms_new($mobile,$content.$code,$skin='');
          Db('sms')->insert(['mobile'=>$mobile,'code'=>$code,'type'=>'找回密码','add_time'=>time(),'result'=>$res['msg']]);
        }else{
            return json(['code'=>-1,'msg'=>'参数错误，无法发送！']);
        }
        if($res['code']==0){
          return json(['code'=>0,'msg'=>'发送成功！']);
        }else{
          return json(['code'=>-1,'msg'=>'发送失败，请检查手机号是否正确！']);
        }
       }else{
        $remain=(time()-$sms['add_time']);
        if($remain<=120){
          return json(['code'=>-2,'msg'=>'2分钟内请勿重复发送','smsCode'=>$sms['code']]);
        }else{
          if($type==0){
             if(!empty($user)){
              return json(['code'=>-1,'msg'=>'该用手机号已注册，请前往登陆']);
            }
            $res=send_sms_new($mobile,$content.$code,$skin='');
            Db('sms')->insert(['mobile'=>$mobile,'code'=>$code,'type'=>'注册用户','add_time'=>time(),'result'=>$res['msg']]);
          }else if($type==1){

            if(empty($user)){
            return json(['code'=>-1,'msg'=>'该用手机号未注册，请先注册']);
           }
            $res=send_sms_new($mobile,$content.$code,$skin='');
            Db('sms')->insert(['mobile'=>$mobile,'code'=>$code,'type'=>'找回密码','add_time'=>time(),'result'=>$res['msg']]);
          }
          if($res['code']==0){
            return json(['code'=>0,'msg'=>'发送成功！']);
          }else{
            return json(['code'=>-1,'msg'=>'发送失败，请检查手机号是否正确！']);
          }
        }
      }
    }
  }
  //期货公司接口
  public function getCompany()
  {
    if(Request()->isAjax()){
      $uid=input('uid');
      $auth=input('auth');
      $type=input('type');
      if($type==0){
        $res=Db('customer')->where(['id'=>$uid,'auth'=>$auth])->find();
        if($res){
          $list=Db('company')->field('c_bh,c_name')->select();
          if($list){
            return json(['code'=>1,'msg'=>'获取成功','data'=>$list]);
          }else{
            return json(['code'=>0,'msg'=>'获取失败']);
          }
        }else{
           return json(['code'=>-1,'msg'=>'身份过期,需重新登录']);
        }
      }else{
        return json(['code'=>-2,'msg'=>'非客户身份,不能绑定交易账号']);
      }
    }
  }
  //用户交易账号绑定
  public function userBind()
  {
    if(Request()->isAjax()){
      $uid=input('uid');
      $auth=input('auth');
      $type=input('type');
      $bid=trim(input('c_bh'));
      $zid=trim(input('zid'));
      $zpwd=trim(input('zpwd'));
      if($type==0){
        $res=Db('customer')->where(['id'=>$uid,'auth'=>$auth])->find();
        if($res){
          $data=Db('customer')->where(['id'=>$uid,'auth'=>$auth])->update(['bid'=>$bid,'zid'=>$zid,'zpwd'=>$zpwd]);
          if($data){
            return json(['code'=>1,'msg'=>'绑定成功']);
          }else{
            return json(['code'=>0,'msg'=>'获取失败,请检查接口参数']);
          }
        }else{
           return json(['code'=>-1,'msg'=>'身份过期,需重新登录']);
        }
      }else{
        return json(['code'=>-2,'msg'=>'非客户身份,不能绑定交易账号']);
      }
    }
  }
  //合约接口数据
  public function contract()
  {
      if(empty(input('uid'))){
          return json(['code'=>1,'msg'=>'']);
      }

      $uid=input('uid');
      $auth=input('auth');
      $type=input('type',0);
        if($type==0){
            $res=Db('customer')->where(['id'=>$uid,'auth'=>$auth])->find();
        }else if($type==1){
            $res=Db('agentor')->where(['id'=>$uid,'auth'=>$auth])->find();
        }
        if(empty($res)){
            $res=Db('agentor')->where(['id'=>$uid,'auth'=>$auth])->find();
        }
      if($res){
          //获取对应合约信息
          $nb= new model\NbeApi();
          $data['instrument']='';
         $data= $nb->getContact($data);
          $returnArr=array();
          if($data['code']==1){
              $dataArr=$data['data'];
              $i=1;
              foreach($dataArr as $key=>$val){
                  //"id":28,"ex_name":"SHFE","p_name":"原油","c_name":"原油1809","c_code":"sc1809","copy_code":"100",
                  //"min_rate":100,"c_multiplier":100,"open_hops":100,"flat_hopping":100,
                  //"ptglf":200,"sxf":100,"jsfwf":100,"delivery_date":"","status":0
                  //"Instrument":"cu1810","Name":"��ͭ1810","OpenBond":"2500.0000","Charge":"100.0000","PipValue":"5.0000"
                  $tmpArr['id']=$i;
                  $tmpArr['ex_name']=$val['Instrument'];
                  $tmpArr['p_name']=$val['Name'];
                  $tmpArr['c_name']=$val['Name'];
                  $tmpArr['c_code']=$val['Instrument'];
                  $tmpArr['copy_code']=100;
                  $tmpArr['min_rate']=100;
                  $tmpArr['c_multiplier']=$val['PipValue'];
                  $tmpArr['open_hops']=$val['OpenBond'];
                  $tmpArr['flat_hopping']=100;
                  $tmpArr['ptglf']=0;
                  $tmpArr['sxf']=$val['Charge'];
                  $tmpArr['jsfwf']=0;
                  $tmpArr['delivery_date']='';
                  $returnArr[]=$tmpArr;
                  $i++;
              }
          }
        // $data=Db('contract_manage')->where('status',0)->order('id')->select();
        if(!empty($returnArr)){
          return json(['code'=>1,'msg'=>'获取成功','data'=>$returnArr]);
        }else{
          return json(['code'=>0,'msg'=>'获取失败,请检查接口参数']);
        }
      }else{
         return json(['code'=>-1,'msg'=>'身份过期,需重新登录']);
      }

  }
  //合约档位接口数据
  public function contract_gear(){
    if(Request()->isAjax()){
      $cid=input('cid');
      $uid=input('uid');
      $auth=input('auth');
      $type=input('type');
      if($type==0){
        $res=Db('customer')->where(['id'=>$uid,'auth'=>$auth])->find();
      }else if($type==1){
        $res=Db('agentor')->where(['id'=>$uid,'auth'=>$auth])->find();
      }
      if($res){
        $data=Db('gear_setting')->where('cid',$cid)->order('id')->select();
        if($data){
          return json(['code'=>1,'msg'=>'获取成功','data'=>$data]);
        }else{
          return json(['code'=>0,'msg'=>'获取失败,请检查接口参数']);
        }
      }else{
         return json(['code'=>-1,'msg'=>'身份过期,需重新登录']);
      }
    }
  }
  //品种接口数据
  public function product()
  {
    if(Request()->isAjax()){
      $uid=input('uid');
      $auth=input('auth');
      $type=input('type');
      if($type==0){
        $res=Db('customer')->where(['id'=>$uid,'auth'=>$auth])->find();
      }else if($type==1){
        $res=Db('agentor')->where(['id'=>$uid,'auth'=>$auth])->find();
      }
      if($res){
        $data=Db('product_manage')->where('status',0)->order('id')->select();
        if($data){
          return json(['code'=>1,'msg'=>'获取成功','data'=>$data]);
        }else{
          return json(['code'=>0,'msg'=>'获取失败,请检查接口参数']);
        }
      }else{
         return json(['code'=>-1,'msg'=>'身份过期,需重新登录']);
      }
    }
  }
  //交易接口
  public function trade()
  {
    if(Request()->isAjax()){
      $uid=input('uid');
      $auth=input('auth');
      $res=Db('customer')->where(['id'=>$uid,'auth'=>$auth])->find();
      if($res){
        return json(['code'=>1,'msg'=>'获取成功','data'=>$data]);
      }else{
        return json(['code'=>0,'msg'=>'获取失败']);
      }
    }
  }
  //历史出入金等资金
  public function getTraceLog()
  {

  }
  //提现申请
  public function enchasApply()
  {
    if(Request()->isAjax()){
      $uid=input('uid');
      $auth=input('auth');
      $type=input('type');
      $remark=empty(trim(input('remark')))? '提现申请中' : trim(input('remark'));
      $apply_money=(int)trim(input('apply_money'));
      if($type==0){
        $res=Db('customer')->where(['id'=>$uid,'auth'=>$auth])->find();
        if($res){
          $isExist= Db('apply_log')->where('uid',$uid)->where('status',0)->where('type',0)->find();
          if(!empty($isExist)){
              return json(['code'=>0,'msg'=>'您当前有未审核通过的提现申请，请勿重复提交！']);
          }
          $result=Db('apply_log')->insert(['uid'=>$uid,'money'=>$apply_money,'type'=>0,'total_money'=>$res['total_money'],'remark'=>$remark,'add_time'=>time()]);
          if($result){
              //插入信息提示信息
              $insertData['content']=$res['user_name'].'提现申请申请，请及时审核';
              $insertData['url']="{:url('money/payCheck')}";
              $insertData['domain']='';
              $insertData['type']=1;
              $insertData['status']=1;
              \think\Db::name('system_msg')->insert($insertData);
            return json(['code'=>1,'msg'=>'提现申请成功，请等待管理员核实']);
          }else{
            return json(['code'=>0,'msg'=>'提现失败，请检查接口参数']);
          }
        }else{
          return json(['code'=>-1,'msg'=>'身份已过期,请重新登录']);
        }
      }else if($type==1){
        $res=Db('agentor')->where(['id'=>$uid,'auth'=>$auth])->find();
        if($res){
          $result=Db('apply_log')->insert(['aid'=>$uid,'money'=>$apply_money,'type'=>0,'total_money'=>$res['total_money'],'remark'=>$remark,'add_time'=>time()]);
          if($result){
              //插入信息提示信息
              $insertData['content']=$res['user_name'].'提现申请申请，请及时审核';
              $insertData['url']="{:url('money/payCheck')}";
              $insertData['domain']='';
              $insertData['type']=1;
              $insertData['status']=1;
              \think\Db::name('system_msg')->insert($insertData);
            return json(['code'=>1,'msg'=>'提现申请成功，请等待管理员核实']);
          }else{
            return json(['code'=>0,'msg'=>'提现失败，请检查接口参数']);
          }
        }else{
          return json(['code'=>-1,'msg'=>'身份已过期,请重新登录']);
        }
      }
      
    }
  }
  //查询用户资金
  public function personMoney()
  {
    if(Request()->isAjax()){
      $uid=input('uid');
      $auth=input('auth');
      $res=Db('customer')->where(['id'=>$uid,'auth'=>$auth])->find();
      if($res){
        return json(['code'=>1,'msg'=>'查询成功','data'=>$res['total_money']]);
      }else{
        return json(['code'=>0,'msg'=>'查询失败']);
      }
    }
  }
  //修改银行卡接口
  public function changeBankInfo()
  {
    if(Request()->isAjax()){
      $uid=input('uid');
      $auth=input('auth');
      $type=input('type');
      if($type==0){
        $res=Db('customer')->where(['id'=>$uid,'auth'=>$auth])->find();
      }else if($type==1){
        $res=Db('agentor')->where(['id'=>$uid,'auth'=>$auth])->find();
      }
      if($res){
		//$filePath=$this->upload_img("bank_id_img_top");
        $data=[
          'bank_name'=>trim(input('bank_name')),
          'bank_card'=>trim(input('bank_card')),
          'bank_addr'=>trim(input('bank_addr'))
        ];
        if($type==0){
          $result=Db('customer')->where(['id'=>$uid,'auth'=>$auth])->update($data);
        }else if($type==1){
          $result=Db('agentor')->where(['id'=>$uid,'auth'=>$auth])->update($data);
        }
         if($result){
              return json(['code'=>1,'msg'=>'银行卡信息修改成功！']);
          }else{
              return json(['code'=>0,'msg'=>'数据提交失败，请检查接口参数']);
          }
      }else{
        return json(['code'=>-1,'msg'=>'身份已过期，请重新登录']);
      }
    }
  }
  //线下充值
  public function offlineCharge()
  {
    if(Request()->isAjax()){
      $uid=$_POST['uid'];
      $auth=$_POST['auth'];
      $type=$_POST['type'];
      $money=trim($_POST['money']);
      $remark=trim($_POST['remark']);
	  $filePath=$this->upload_img("charge_img");
      if($type==0){
        $res=Db('customer')->where(['id'=>$uid,'auth'=>$auth])->find();
		if($res){
			$result=Db('apply_log')->insert(['uid'=>$uid,'money'=>$money,'total_money'=>$res['total_money'],'type'=>1,'remark'=>$remark,'charge_img'=>$filePath,'add_time'=>time()]);
			if($result){
			  return json(['code'=>1,'msg'=>'充值成功，请等待管理员进行审核！']);
			}else{
			  return json(['code'=>0,'msg'=>'充值失败，请检查接口参数']);
			}
		  }else{
			return json(['code'=>-1,'msg'=>'身份已过期，请重新登录']);
		  }
      }else if($type==1){
        $res=Db('agentor')->where(['id'=>$uid,'auth'=>$auth])->find();
      }else{
		$res=Db('customer')->where(['id'=>$uid,'auth'=>$auth])->find();
		if($res){
			$result=Db('apply_log')->insert(['uid'=>$uid,'money'=>$money,'total_money'=>$res['total_money'],'type'=>2,'remark'=>'支付宝充值，'.$remark,'charge_img'=>$filePath,'add_time'=>time()]);
			if($result){
			  return json(['code'=>1,'msg'=>'充值成功，请等待管理员进行审核！']);
			}else{
			  return json(['code'=>0,'msg'=>'充值失败，请检查接口参数']);
			}
		  }else{
			return json(['code'=>-1,'msg'=>'身份已过期，请重新登录']);
		  }
      }
    }
  }

	public function sf_onpinecharge(){
//		if(input('uid')!='243'&&input('uid')!='35'&&input('uid')!='415'){
//			return json(array('code' => 0, 'msg' => '参数错误！'));
//		}
		if(Request()->isGet()){
			$params = array();
			$params["trxamt"] = round(input('money'), 2);
			$params["reqsn"] = 'P100' . date('YmdHis') . rand(100, 999);//订单号;//订单号,自行生成
			$params["paytype"] = empty(input('paytype')) ? "W01" : input('paytype');
			$params["randomstr"] = date('YmdHis') . rand(1000, 9999);//
			$params["remark"] = "充值订单 ";
			if (empty(intval(input('uid')))) {
				return json(array('code' => 0, 'msg' => '参数错误！'));
			}
//			if ($params["trxamt"]<100) {
//				return json(array('code' => 0, 'msg' => '最低充值100'));
//			}
			//记录日志
			oplog('接受创建支付请求：' . json_encode($params) . ',请求返回：');
			$data['userid'] = input('uid');//用户ID
			$data['order_number'] = $params['reqsn'];//订单号
			$data['platform_order_number'] = '';//平台订单号
			$system=db('system_set')->where('id',1)->find();
			$data['money'] = $params["trxamt"];//金额
			$data['create_time'] = time();
			$data['update_time'] = time();
			$data['create_ip'] = get_client_ip();
			$data['status'] = 0;//0: 订单创建成功, 1:充值成功,
			$data['remark'] = $params["remark"];//备注
			if (Db::table('pay_order')->insert($data, true)) {
				oplog('创建订单成功：' . json_encode($data));
				$pay_memberid = "181209678";   //商户ID
				$pay_orderid = $params['reqsn'];    //商户订单号
				$pay_amount = $data['money']+($params["trxamt"]*$system['charge_fee']/100);    //交易金额
				$pay_applydate = date("Y-m-d H:i:s");  //订单时间
				$pay_notifyurl = "http://www.jinqicelue.cn/index/Ips/sf_notify";   //商户接收服务端返回地址
				$pay_callbackurl = "http://www.jinqicelue.cn/index/Ips/sf_return";  //商户页面跳转返回地址
				$Md5key = "9lpt6tlnsi3u7cfeq0ulsxzou0ukys9d";   //密钥，后台可查看
				$tjurl = "https://api.dudupay.net/Pay_Index.html";   //提交网关地址，在后台查看
				$pay_bankcode = "911";   //银行编码
				//扫码
				$native = array(
					"pay_memberid" => $pay_memberid,
					"pay_orderid" => $pay_orderid,
					"pay_amount" => $pay_amount,
					"pay_applydate" => $pay_applydate,
					"pay_bankcode" => $pay_bankcode,
					"pay_notifyurl" => $pay_notifyurl,
					"pay_callbackurl" => $pay_callbackurl,
					"pay_username" => input('pay_username'),
					"pay_useridcard" => input('pay_useridcard'),
					"pay_usercardno" => input('pay_usercardno'),
					"pay_usercardphone" => input('pay_usercardphone')
				);
				ksort($native);
				$md5str = "";
				foreach ($native as $key => $val) {
					$md5str = $md5str . $key . "=" . $val . "&";
				}
				$sign = strtoupper(md5($md5str . "key=" . $Md5key));
				$native["pay_md5sign"] = $sign;
				$native["pay_signall"] = 1; 
				$native["pay_cardtype"] = 20;
				$native["pay_ip"] =get_client_ip();
				$native['pay_productname'] ='商品购买';
				$re=http_post_json($tjurl ,$native);
				$decode_re=json_decode($re,true);
				if($decode_re['status']==='error'){
					return $this->fetch('sf_onpinecharge',array('msg'=>$decode_re['msg']));
				}else{
					echo $re;die;
				}
			} else {
				oplog('创建订单失败：' . json_encode($data));
				echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
			}
		}
		
	}



  
  //计算时间
  private function timediff($begin_time,$end_time)
  {
    //$begin_time 开始时间戳
    //$end_time 结束时间戳
    if($begin_time < $end_time){
        $starttime = $begin_time;
        $endtime = $end_time;
    }else{
        $starttime = $end_time;
        $endtime = $begin_time;
    }
    //计算天数
    $timediff = $endtime-$starttime;
    $days = intval($timediff/86400);
    //计算小时数
    $remain = $timediff%86400;
    $hours = intval($remain/3600);
    //计算分钟数
    $remain = $remain%3600;
    $mins = intval($remain/60);
    //计算秒数
    $secs = $remain%60;
    $res = array("day" => $days,"hour" => $hours,"min" => $mins,"sec" => $secs);
    return $res;
  }
  //加密解密
  private function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
  {
    if($operation == 'DECODE') {
     $string = str_replace('[a]','+',$string);
     $string = str_replace('[b]','&',$string);
     $string = str_replace('[c]','/',$string);
    }
     $ckey_length = 4;
     $key = md5($key ? $key : 'ypkj_encryption');
     $keya = md5(substr($key, 0, 16));
     $keyb = md5(substr($key, 16, 16));
     $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
     $cryptkey = $keya.md5($keya.$keyc);
     $key_length = strlen($cryptkey);
     $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
     $string_length = strlen($string);
     $result = '';
     $box = range(0, 255);
     $rndkey = array();
     for($i = 0; $i <= 255; $i++) {
         $rndkey[$i] = ord($cryptkey[$i % $key_length]);
     }
     for($j = $i = 0; $i < 256; $i++) {
         $j = ($j + $box[$i] + $rndkey[$i]) % 256;
         $tmp = $box[$i];
         $box[$i] = $box[$j];
         $box[$j] = $tmp;
     }
     for($a = $j = $i = 0; $i < $string_length; $i++) {
         $a = ($a + 1) % 256;
         $j = ($j + $box[$a]) % 256;
         $tmp = $box[$a];
         $box[$a] = $box[$j];
         $box[$j] = $tmp;
         $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
     }
     if($operation == 'DECODE') {
         if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
             return substr($result, 26);
         } else {
             return '';
         }
     } else {
       $ustr = $keyc.str_replace('=', '', base64_encode($result));
       $ustr = str_replace('+','[a]',$ustr);
       $ustr = str_replace('&','[b]',$ustr);
       $ustr = str_replace('/','[c]',$ustr);
       return $ustr;
    }
  }




    /**
     * @brief:获取跟单账号列表
     * @url:http://gbb.1nbj.com/index/Api/getFollowAccount?order=deficit&week=1&direaction=asc&account=1201;
     * @params_remark:order:按哪个参数排序，week：1最近一周，2最近俩周，4最近一个月（也就4周）
     * @return: code为1表示成功，其他表示失败，{"code":1,"msg":"成功返回","data":[{"account":"张三丰","deficit":"84%","loss_rate":"0.15%","trade_fp":"1.55","deficit_yz":"1.44","deficit_profit_rate":"15%","position_avg":14},
     * {"account":"李一男","deficit":"14%","loss_rate":"0.10%","trade_fp":"1.85","deficit_yz":"1.24","deficit_profit_rate":"75%","position_avg":16}]}
     * account：账号，deficit：亏损效率，loss_rate ：失败率，trade_fp：交易频率，deficit_yz：亏损因子，deficit_profit_rate：盈/亏比，position_avg:平均持仓
     */
    public function getFollowAccount(){
        $week=input('week');
        $ord=input('order');
        $direaction=strtoupper(input('direaction'));// asc 或者desc
        $map=array('deficit'=>'deficitrate','loss_rate'=>'lossrate','trade_fp'=>'tradefrequently','deficit_yz'=>'lossreason'
        ,'deficit_profit_rate'=>'winlossrate','position_avg'=>'avgpositiontime');
        $order=!isset($map[$ord]) ? $ord : $map[$ord];
        $day=$week*7;
        $lastDate= date("Ymd",strtotime("-$day day"));

        $gbbApi=new model\GbbApi();
        $accArr= $gbbApi->getFollowAccount(array());
        $account=input('account');
        $noneFoundInfo=array('account'=>'0','deficit'=>'-','loss_rate'=>'-','trade_fp'=>'-','deficit_yz'=>'-','deficit_profit_rate'=>'-','position_avg'=>'-');
        //判断这个主账号和账户是否有跟随
        if(!empty($account)){
            $hostAccArr=$gbbApi->queryFollowRelation(array('account'=>$account));
        }else{
            $hostAccArr=array('18888888888');
        }
        //var_dump($accArr);exit;
        $dataAccInfoArr=Db::name('static_info')->where('zaccount','in',$accArr)
            ->where('last_time','>=',$lastDate)
            ->field(['zaccount','deficitrate','lossrate','tradefrequently','lossreason','winlossrate','avgpositiontime'])
            ->order($order,$direaction)
            ->select();
        $i=1;
        foreach($dataAccInfoArr as $key=>&$val){
            $val['account']=$val['zaccount'];
            $val['deficit']=round($val['deficitrate'],2);
            $val['loss_rate']=round($val['lossrate'],2);
            $val['trade_fp']=round($val['tradefrequently'],2);
            $val['deficit_yz']=round($val['lossreason'],2);
            $val['deficit_profit_rate']=round($val['winlossrate'],2);
            $val['position_avg']=round($val['avgpositiontime'],2);
            unset($val['zaccount']);
            unset($val['deficitrate']);
            unset($val['lossrate']);
            unset($val['tradefrequently']);
            unset($val['lossreason']);
            unset($val['winlossrate']);
            unset($val['avgpositiontime']);
            if(empty($hostAccArr) && in_array($val['account'],$hostAccArr)) {
                $val['status']=1;
            }else{
                $val['status']=0;
            }
            if(in_array($val['account'],$accArr)) {
                unset($accArr[$val['account']]);
                $accArr=array_diff($accArr, [$val['account']]);
            }
            $val['img'] = '/static/assets/images/sw'.$i.'.jpg';
            $i++;
            if($i==6){
                $i=1;
            }
        }

        /*     foreach($accArr as $k=>$v){
                 $noneFoundInfo['account']=$v;
                 if(in_array($v,$hostAccArr)) {
                     $noneFoundInfo['status']=1;
                 }else{
                     $noneFoundInfo['status']=0;
                 }
                 $dataAccInfoArr[]=$noneFoundInfo;
             }*/

        $res=array('code'=>1,'msg'=>'成功返回','data'=>$dataAccInfoArr);
        return json($res);
    }


    /**
     * @brief:获取我的跟随管理账户列表
     * @url:http://gbb.1nbj.com/index/Api/getMyFollowAccount?account=1201;
     * @params_remark:account:当前用户账户
     * @return: code为1表示成功，其他表示失败，{"code":1,"msg":"成功返回","data":[{"account":"李一男","deficitrate":"14%","lossrate":"0.10%","tradefrequently":"1.85","lossreason":"1.24","winlossrate":"75%","avgpositiontime":16}]}
     * account：账号，deficitrate：亏损效率，lossrate ：失败率，tradefrequently：交易频率，lossreason：亏损因子，winlossrate：盈/亏比，avgpositiontime:平均持仓
     */
    public function getMyFollowAccount(){

        $gbbApi=new model\GbbApi();
        $account=input('account');
        //判断这个主账号和账户是否有跟随
        if(!empty($account)){
            $hostAccArr=$gbbApi->queryFollowRelation(array('account'=>$account));
        }else{
            $hostAccArr=array();
        }

        $dataAccInfoArr=Db::name('static_info')->where('zaccount','in',$hostAccArr)->field(['zaccount','deficitrate','lossrate','tradefrequently','lossreason','winlossrate','avgpositiontime'])->select();

        if(!empty($dataAccInfoArr)) foreach($dataAccInfoArr as $k=>&$v){
            $v['winlossrate']=empty($v['winlossrate'])?0:round($v['winlossrate'],2);
            $v['lossreason']=empty($v['lossreason'])?0:round($v['lossreason'],2);
        }
        $res=array('code'=>1,'msg'=>'成功返回','data'=>$dataAccInfoArr);
        return json($res);
    }

    /**
     * @brief:获取追随者账号列表
     * @url:http://gbb.1nbj.com/index/Api/getFollowedAcc?order=deficit&week=1&direaction=asc
     * @params_remark:order:按哪个参数排序，week：1最近一周，2最近俩周，4最近一个月（也就4周）
     * @return: code为1表示成功，其他表示失败，{"code":1,"msg":"成功返回","data":[{"account":"张三丰","deficit":"84%","loss_rate":"0.15%","trade_fp":"1.55","deficit_yz":"1.44","deficit_profit_rate":"15%","position_avg":14},
     * {"account":"李一男","deficit":"14%","loss_rate":"0.10%","trade_fp":"1.85","deficit_yz":"1.24","deficit_profit_rate":"75%","position_avg":16}]}
     * account：账号，deficit：亏损效率，loss_rate ：失败率，trade_fp：交易频率，deficit_yz：亏损因子，deficit_profit_rate：盈/亏比，position_avg:平均持仓
     */
    public function getFollowedAcc(){
        $week=input('week');
        $ord=input('order');
        $direaction=strtoupper(input('direaction'));// asc 或者desc
        $map=array('deficit'=>'deficitrate','loss_rate'=>'lossrate','trade_fp'=>'tradefrequently','deficit_yz'=>'lossreason'
        ,'deficit_profit_rate'=>'winlossrate','position_avg'=>'avgpositiontime');
        $order=!isset($map[$ord]) ? $ord : $map[$ord];
        $day=$week*7;
        $lastDate= date("Ymd",strtotime("-$day day"));
        $gbbApi=new model\GbbApi();
        $accArr= $gbbApi->getFollowAccount(array('type'=>1));
        $noneFoundInfo=array('account'=>'0','deficit'=>'-','loss_rate'=>'-','trade_fp'=>'-','deficit_yz'=>'-','deficit_profit_rate'=>'-','position_avg'=>'-');

        $dataAccInfoArr=Db::name('static_info')->where('zaccount','in',$accArr)
            ->where('last_time','>=',$lastDate)
            ->field(['zaccount','deficitrate','lossrate','tradefrequently','lossreason','winlossrate','avgpositiontime'])
            ->order($order,$direaction)
            ->select();
        $i=3;
        foreach($dataAccInfoArr as $key=>&$val){
            $val['account']=$val['zaccount'];
            $val['deficit']=round($val['deficitrate'],2);
            $val['loss_rate']=round($val['lossrate'],2);
            $val['trade_fp']=round($val['tradefrequently'],2);
            $val['deficit_yz']=round($val['lossreason'],2);
            $val['deficit_profit_rate']=round($val['winlossrate'],2);
            $val['position_avg']=round($val['avgpositiontime'],2);
            unset($val['zaccount']);
            unset($val['deficitrate']);
            unset($val['lossrate']);
            unset($val['tradefrequently']);
            unset($val['lossreason']);
            unset($val['winlossrate']);
            unset($val['avgpositiontime']);
            if(in_array($val['account'],$accArr)) {
                unset($accArr[$val['account']]);
                $accArr=array_diff($accArr, [$val['account']]);
            }
            $val['img'] = '/static/assets/images/sw'.$i.'.jpg';
            $i++;
            if($i==6){
                $i=1;
            }
        }

        /*    foreach($accArr as $k=>$v){
                $noneFoundInfo['account']=$v;
                $dataAccInfoArr[]=$noneFoundInfo;
            }*/

        $res=array('code'=>1,'msg'=>'成功返回','data'=>$dataAccInfoArr);
        return json($res);
    }
    /**
     * @brief:跟单设置接口
     * @url:/index/Api/setFollow?hostaccount=1201&followaccount=1211&direction=0&status=0&type=2&ratio=1&celue=2&p1=111&P2=11;
     * @params_remark:1: hostaccount:主账号，followaccount：跟随账号，即当前登陆账号，direction [0:正跟; 1:反跟]
    status[0:启用; 1:禁用;]，type:类型，1 固定数量下单需要带上数量 number 参数，2.比例跟单  需要带上 ratio[正整数,跟单倍率]
     * celue:1经典模式，2：倍倍模式，3：万金油模式；4动态数据模式；p1:策略参数1，P2:策略备用参数2
     * max_position:最大持仓手数，max_position_order:最大持仓单数，stop_time:停止交易时间（精确到分秒）
     * @returnRes:code为1表示成功，其他表示失败，{"code":1,"msg":"成功返回"}
     */
    public function setFollow(){
        $dataInfo['hostaccount']=input('hostaccount');
        $dataInfo['followaccount']=input('followaccount');
        //$dataInfo['followaccount']='1201';
        $dataInfo['direction']=input('direction');
        $dataInfo['status']=input('status');
        $dataInfo['ratio']=input('ratio');
        $dataInfo['status']=input('status');
        // return json($dataInfo);
        $gbbApi=new model\GbbApi();
        $res= $gbbApi->setFollowRelation($dataInfo);
        return json($res);
    }

    /**
     * @brief:随者账号详细战绩
     * @url:/index/Api/getFollowAccInfo?hostaccount=12
     * @params_remark:hostaccount:主账号即需要查询战绩的账号;
     * pure_profit_yz:净值利润因子，profit_rate：收益率，follow_people跟随人数
     * @returnRes:code为1表示成功，其他表示失败,{"code":1,"msg":"成功返回","data":{"account":"王稍等","pure_profit_yz":1.65,"profit_rate":145.255,"follow_people":745,"trade_date":"2018-06-25 14:50:00",
     * "gg_rate":"1:200","trade_amount":"55","trade_week":"44","follow_total_money":"150000.70","profit_trade":"177(59.3%)","duo_profit":"133(50.38%)","avg_profit":"1400.70",
     * "max_profit_point":"800.70","avg_profit_point":"70.70","loss_profit_point":"70.70","follow_profit_point":"72.70","bzc":"2170.70","xp_rate":"0.72","trade_times":"378","loss_times":"37{40.88%}",
     * "kong_profit":"38{47.88%}","avg_loss_profit":"38{47.88%}","max_loss_profit":"38{47.88%}","avg_loss_profit_point":"38{47.88%}",
     * "avg_profit_time":"38000","pre_profit":"229","active_rate":"0.88","max_back":"-38.885}"}}
     */
    public  function getFollowAccInfo(){
        $dataArr=array('account'=>'王稍等','pure_profit_yz'=>1.65,'profit_rate'=>145.255,'follow_people'=>745,'trade_date'=>'2018-06-25 14:50:00','gg_rate'=>'1:200','trade_amount'=>'55',
            'trade_week'=>'44','follow_total_money'=>'150000.70','profit_trade'=>'177(59.3%)',
            'duo_profit'=>'133(50.38%)','avg_profit'=>'1400.70','max_profit_point'=>'800.70','avg_profit_point'=>'70.70'
        ,'loss_profit_point'=>'70.70','follow_profit_point'=>'72.70','bzc'=>'2170.70','xp_rate'=>'0.72','trade_times'=>'378'
        ,'loss_times'=>'37{40.88%}','kong_profit'=>'38{47.88%}','avg_loss_profit'=>'38{47.88%}','max_loss_profit'=>'38{47.88%}'
        ,'avg_loss_profit_point'=>'38{47.88%}','avg_profit_time'=>'38000','pre_profit'=>'229','active_rate'=>'0.88','max_back'=>'-38.885}'
        );
        $hostaccount=input('hostaccount');
        if(empty($hostaccount)){
            return array('code'=>-1,'msg'=>'账户不能为空','data'=>array());
        }
        $dataAccInfoArr=Db::name('static_info')->where('zaccount',$hostaccount)
            ->field(['last_time','tradetimes','winrate','lossrate','balance','profittimes','deficittimes'
                ,'avgproift','avgdeficit','winlossrate','available','maxretracementrate','profit','totalreturnrate'])
            ->find();
        if(!empty($dataAccInfoArr)){

            $dataAccInfoArr['totalreturnrate']=round($dataAccInfoArr['totalreturnrate'],2);
            $dataAccInfoArr['last_time']= date('Y-m-d H:i:s',strtotime($dataAccInfoArr['last_time']));
            $dataAccInfoArr['winlossrate']=empty($dataAccInfoArr['winlossrate'])?0:round($dataAccInfoArr['winlossrate'],2);

        }
        $res=array('code'=>1,'msg'=>'成功返回','data'=>$dataAccInfoArr);
        return json($res);
    }

    public function depthmarket(){
        $url = getcofig('WINDOWS_URL');
//        $url = 'http://120.76.54.211:8888';
        $data['action'] = 'DepthMarket';
        $html=http($url,$data);
        $html=gbkToUtf8($html);
        $arr = json_decode($html,true);
        $dat['code'] = 0;
        $dat['data'] = $arr['DepthMarketData'];
        return json($dat);
    }
}
