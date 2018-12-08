<?php
/******************************************************************
 *  权限验证器
 * +-----------------------------------------------------------------
 * | [tp5auth] tp5auth权限管理
 * | @Copyright (C) 2018  http://www.aliphp.cn   All rights reserved.
 * | @Team  ylnmp.com
 * | @Author: 竹永乐 QQ:396691677
 * | @Licence http://www.aliphp.cn/license.txt
 * | @Last Modified time: 2018/7/30 17:54
 *+------------------------------------------------------------------
 */
namespace app\admin\validate;
use think\Validate;

class Node extends Validate{
    // 规则
    protected $rule = [
        'title' =>  'require|chsDash',
        'name'  =>  'require|unique:AuthRule',
        'sort'  =>  'number',
    ];
    
    // 提示
    protected $message = [
        'title.require' =>  '节点名称必须填写', 
        'title.chsDash' =>  '节点名称必须是汉字、字母、数字和下划线_及破折号-',
        'name.require'  =>  '节点路径必须填写', 
        'name.unique'  =>  '节点路径已存在',
        'sort.number'   =>  '排序必须是数字',
    ];
}
?>