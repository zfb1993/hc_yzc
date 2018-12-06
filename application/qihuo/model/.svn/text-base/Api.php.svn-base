<?php
namespace app\mobile\model;

use think\Db;
use think\Model;

class Api extends Model
{
    protected static $game_db;


    /**
     * @name 获取用户信息ByCharId
     * @param $charId
     * @return array|false|\PDOStatement|string|Model
     */
    public static function getInfoByCharId($charId){
        return Db::connect(getConfig('game_db'))->table('char_base')->where('chrid',$charId)->field(['account','nikename'])->find();
    }
}