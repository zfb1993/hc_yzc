<?php
namespace app\admin\model;
use think\Model;
class Admin extends Model
{
	//管理员登录
	public function login($data)
	{
		$user=db('admin')->where('username',$data['username'])->find();
		if($user){
			if($user['pwd'] == md5($data['password'])){
				session('username',$user['username']);
				session('aid',$user['admin_id']);
				return 1; //信息正确
			}else{
				return -1; //密码错误
			}
		}else{
			return -1; //用户不存在
		}
	}
	//修改管理员密码
	public function alterPwd($data)
	{
		$user=db('admin')->where('username',$data['username'])->find();
		if($user['pwd']==md5($data['oldpwd'])){
			$newpwd=md5($data['newpwd']);
			db('admin')->where('username',$user['username'])->update(['pwd'=>$newpwd]);
			return 1; //密码更新成功
		}else{
			return 0; //原始密码不正确
		}
	}

}
