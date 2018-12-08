<?php

namespace app\admin\validate;
use think\validate;

class Category extends Validate{
    // 验证规则
    protected $rule = [
        'catename'  =>  'require',
       
    ];

    // 提示文字
    protected $message = [
        'catename.require'  =>  '栏目必须填写',
        
    ];

}