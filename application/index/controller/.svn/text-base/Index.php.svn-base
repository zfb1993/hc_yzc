<?php
namespace app\index\controller;
use think\Controller;
class Index extends Controller
{
public function index()
    {
        //$this->redirect('/www/member/index.html');
//        if(!$this->isMobile()){
//            $this->redirect('/www/member/index.html'); //跳转到手机端index页面
//        }else{
//            return $this->fetch();
//        }
        return view();
    }
	public function stock2()
    {
        return view();
    }
    public function stock()
    {
        return view();
    }

    public function login()
    {
        return view();
    }
    public function baobiao()
    {
        return view();
    }
    public function reg()
    {
        return view();
    }

    public function referprice()
    {
        return view();
    }
    public function hezuo()
    {
		if($_SERVER['HTTP_HOST']=='www.jinqicelue.cn'){
			$this->assign('url',"http://www.jinqicelue.cn");
			$this->assign('title',"盈众策略");
			$this->title="盈众策略";
		}else{
			$this->assign('url',"http://tycf.jinqicelue.cn");
			$this->assign('title',"天裕财富");
		}
		
        return view();
    }

    public function position()
    {
        return view();
    }
    public function trade()
    {
		if($_SERVER['HTTP_HOST']=='www.jinqicelue.cn'){
			return view();
		}else{
			return view('trade_tycf');
		}
    }
    public function userinfo()
    {
        return view();
    }
    public function newbie()
    {
        return view();
    }

    public function xieyishu()
    {
        return view();
    }

    public function record()
    {
        return view();
    }

    public function password()
    {
        return view();
    }

    public function about()
    {
        return view();
    }

    public function contact()
    {
        return view();
    }

    public function verify()
    {
        return view();
    }

    public function pay()
    {
        return view();
    }

    public function withdraw()
    {
        return view();
    }

    public function log()
    {
        return view();
    }

    public function optional()
    {
        return view();
    }
    /**
     * @name 退出登陆
     */
    public function logout()
    {
        return view();
    }
    public function help()
    {
        return view();
    }

    public function forget_password()
    {
        return view();
    }

    /**
     * @name 绑定手机号
     */
    public function bind_phone()
    {
        return $this->fetch();
    }
    /**
     * ZHANGLIN扩展的方法
     */

    public function myoperate()
    {
        return view();
    }
    public function wantoperate()
    {
        return view();
    }
    public function position_current()
    {
        return view();
    }
    public function position_history()
    {
        return view();
    }
    public function position_not()
    {
        return view();
    }
    public function safety()
    {
        return view();
    }
    public function introduction()
    {
        return view();
    }
    public function newdetail()
    {
        return view();
    }
    public function protocoltrade()
    {
        return view();
    }
    public function payips()
    {
		if($_SERVER['HTTP_HOST']=='www.jinqicelue.cn'){
			$this->assign('alipay_img','/static/images/yzcl_alipay.jpg');
		}else{
			$this->assign('alipay_img','/static/images/tycf_alipay.jpg');
		}
        return view();
    }
    public function notice()
    {
        return view();
    }
    public function mine()
    {
        return view();
    }
    public function news()
    {
        return view();
    }
    public function newdetails()
    {
        return view();
    }
    public function getstockklinedetail()
    {
        return view();
    }
    public function invitation()
    {
        return view();
    }
    public function manual()
    {
        return view();
    }
    public function inquiry_list()
    {
        return view();
    }
    public function inquiry_operate()
    {
        return view();
    }
    public function inquiry_position()
    {
        return view();
    }
    public function kaihu()
    {
        return view();
    }
    public function dredge()
    {
        return view();
    }
    public function readkh()
    {
        return view();
    }
    public function bangding()
    {
        return view();
    }
    public function user()
    {
        return view();
    }
    public function nickname()
    {
        return view();
    }
    public function downa()
    {
        return view();
    }
    public function deal()
    {
        return view();
    }
    public function dts()
    {
        return view();
    }
    public function alesd()
    {
        return view();
    }
	public function gendan()
    {
		return false;
        return view();
    }
	public function set()
    {
        return view();
    }
	public function documentary()
    {
        return view();
    }
	public function followsuit()
    {
        return view();
    }
	public function down()
    {
        return view();
    }
    /*移动端判断*/
    private function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA']))
        {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT']))
        {
            $clientkeywords = array ('nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT']))
        {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
            {
                return true;
            }
        }
        return false;
    }
}
