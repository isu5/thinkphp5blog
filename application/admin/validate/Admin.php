<?php
/******************************************************************
 *  管理员验证器
 * +-----------------------------------------------------------------
 * | [tp5auth] tp5auth权限管理
 * | @Copyright (C) 2018  http://www.aliphp.cn   All rights reserved.
 * | @Team  ylnmp.com
 * | @Author: 竹永乐 QQ:396691677
 * | @Licence http://www.aliphp.cn/license.txt
 * | @Last Modified time: 2018/7/23 16:31
 *+------------------------------------------------------------------
 */
namespace app\admin\validate;
use think\validate;

class Admin extends Validate{
    // 验证规则
    protected $rule = [
        'group_id'		=>	'gt:0',
        'username'		=>	'require|unique:Admin',
        'password'		=>	'require',
    ];

    // 提示文字
    protected $message = [
        'group_id.gt'		=>	'会员角色必须选择',
        'username.require'	=>	'用户名必须填写',
        'username.unique'	=>	'填写的用户名已存在',
        'password.require'	=>	'密码必须填写',
    ];
}