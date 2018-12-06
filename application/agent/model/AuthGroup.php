<?php
namespace app\agent\model;
use think\Model;
class AuthGroup extends Model
{
    protected $type       = [
        // 设置addtime为时间戳类型（整型）
        'create_time' => 'timestamp:Y-m-d H:i:s',
    ];
}