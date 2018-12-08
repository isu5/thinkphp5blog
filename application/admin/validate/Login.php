<?php
/******************************************************************
 *  登录验证文件
 * +-----------------------------------------------------------------
 * | [tp5auth] tp5auth权限管理
 * | @Copyright (C) 2018  http://www.aliphp.cn   All rights reserved.
 * | @Team  ylnmp.com
 * | @Author: 竹永乐 QQ:396691677
 * | @Licence http://www.aliphp.cn/license.txt
 * | @Last Modified time: 2018/7/20 13:32
 *+------------------------------------------------------------------
 */
namespace app\admin\validate;
use think\validate;

class Login extends Validate{
    // 验证规则
    protected $rule = [
        'username'	=>	'require',
        'password'	=>	'require',
        'npassword'	=>	'require|confirm:cPwd',
    ];

    // 提示文字
    protected $message = [
        'username.require'	=>	'用户名必须填写',
        'password.require'	=>	'密码必须填写',
        'npassword.require'	=>	'新密码必须填写',
        'npassword.confirm'	=>	'新密码和确认密码不一致',
    ];

    // 验证场景
    protected $scene = [
        'edit' 	=> ['npassword' , 'cpassword'], 	// 修改密码
        'login'	=> ['username' , 'password'],	// 登录
    ];
}