<?php
namespace app\agent\model;
use think\Model;
class Agentor extends Model
{
	//管理员登录
	public function login($data)
	{
		$user=db('agentor')->where('user_name',$data['user_name'])->find();
		if($user){
			if($user['status']==0){
				if($user['user_pwd'] == md5($data['user_pwd'])){
					session('user_name',$user['user_name']);
					session('aid',$user['id']);
					return 1; //信息正确
				}else{
					return 0; //密码错误
				}
			}else{
				return -1; //账户被禁止，不能登录
			}
		}else{
			return -2; //用户不存在
		}
	}
	//修改管理员密码
	public function alterPwd($data)
	{
		$user=db('agentor')->where('user_name',$data['user_name'])->find();
		if($user['user_pwd']==md5($data['oldpwd'])){
			$newpwd=md5($data['newpwd']);
			db('agentor')->where('user_name',$user['user_name'])->update(['user_pwd'=>$newpwd]);
			return 1; //密码更新成功
		}else{
			return 0; //原始密码不正确
		}
	}

}
