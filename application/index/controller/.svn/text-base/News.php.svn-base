<?php
namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Session;
use think\Db;
class News extends Controller
{
    static $news_url='http://www.xiongdd.com/api/';

    public function news(){
        return $this->fetch();
    }
    public function newdetails(){
        return $this->fetch();
    }
    /**
     * @date:2017-07-20
     * @auth:willion
     * @brief:获取最新五条新闻数据内容
     * @url:/index/News/totalList?page=1&pagesize=5
     * @params_remark:page=1&pagesize=5
     * @returnRes:"error_code":0 正常返回,"data":[{..}] 新闻数据
     */
    public function totalList()
    {
        //action=news5&page=1&pagesize=3&callback=abc
        $action='index.php?action=news5';
        $type=input('type');//默认期权，0期权，1期货
        if(!empty($type)){
            $action='index.php?action=news6';
        }
        $page=input('page');
        $pagesize=input('pagesize');
        $url=self::$news_url.$action.'&page='.$page.'&pagesize='.$pagesize;
        $content=http($url);
        $content1=explode('text/html',$content);
        if(is_array($content1) && !empty($content1[1])){
            $content= $content1[1];
        }
        echo $content;
    }



    /**
     * @date:2017-07-20
     * @auth:willion
     * @brief:获取新闻数据具体内容
     * @url:/index/News/detail?newsId=3
     * @params_remark:newsId=3
     * @returnRes:"error_code":0 正常返回,"data":[{..}] 新闻数据
     */
    public function detail(){
        //action=detail&newsId=147
        $action='newsDetail.php?action=detail';
        $newsId=input('newsId');
        $url=self::$news_url.$action.'&newsId='.$newsId;
        $content=http($url);
        $content1=explode('text/html',$content);
        if(is_array($content1) && !empty($content1[1])){
            $content= $content1[1];
        }
        echo $content;
    }

}
