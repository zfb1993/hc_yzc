<?php

/**
 * @name 读取子节点配置
 * @param $config_name
 * @return mixed
 */
function getConfig($config_name){
    $server=config('server'); //读取代理系统根配置
    return config($server.'.'.$config_name); //返回节点配置
}