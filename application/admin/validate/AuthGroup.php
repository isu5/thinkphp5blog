<?php
/******************************************************************
 *  角色验证器
 * +-----------------------------------------------------------------
 * | [tp5auth] tp5auth权限管理
 * | @Copyright (C) 2018  http://www.aliphp.cn   All rights reserved.
 * | @Team  ylnmp.com
 * | @Author: 竹永乐 QQ:396691677
 * | @Licence http://www.aliphp.cn/license.txt
 * | @Last Modified time: 2018/7/30 17:52
 *+------------------------------------------------------------------
 */
namespace app\admin\validate;
use think\Validate;

class AuthGroup extends Validate{
    // 规则
    protected $rule = [
        'title'	=>	['require'],
    ];

    // 提示
    protected $message = [
        'title.require'	=> '角色名称必须填写',
    ];
}
?>