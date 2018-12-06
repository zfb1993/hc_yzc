<?php
namespace app\admin\controller;
use think\Request;
use think\Db;
use think\Controller;
use think\Session;
class Common extends Controller
{
  protected $mod,$role,$system,$nav,$menudata,$cache_model,$categorys,$module,$moduleid,$adminRules,$HrefId;
  public function _initialize()
  {
      //判断管理员是否登录
      if (!session('aid')) {
          $this->redirect('login/index');
      }
	  define('MODULE_NAME',strtolower(request()->controller()));
        define('ACTION_NAME',strtolower(request()->action()));
        //权限管理
        //当前操作权限ID
        if(session('aid')!=1){
            $this->HrefId = db('auth_rule')->where('href',MODULE_NAME.'/'.ACTION_NAME)->value('id');
            //当前管理员权限
            $map['a.admin_id'] = session('aid');
            $rules=Db::table(config('database.prefix').'admin')->alias('a')
                ->join(config('database.prefix').'auth_group ag','a.group_id = ag.group_id','left')
                ->where($map)
                ->value('ag.rules');
            $this->adminRules = explode(',',$rules);
            if($this->HrefId){
                if(!in_array($this->HrefId,$this->adminRules)){
                    $this->error('您无此操作权限','index');
                }
            }
        }
  }
  //空操作
  public function _empty(){
      return $this->error('空操作，返回上次访问页面中...');
  }

  //加密解密
  /*
  * $string： 明文 或 密文
  * $operation：DECODE表示解密,其它表示加密
  * $key： 密匙
  * $expiry：密文有效期
  * */
  public function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0)
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
}
