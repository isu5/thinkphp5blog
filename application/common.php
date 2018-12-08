<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function createRandom($length, $chars = '0123456789')
{
    $hash = '';
    $max = strlen($chars) - 1;
    for ($i = 0; $i < $length; $i++) {
        $hash .= $chars[mt_rand(0, $max)];
    }
    return $hash;
}

//生成字符串
function createRandomStr($lenth = 6)
{
    return createRandom($lenth, '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ');
}


//生成密码
function createPassword($password, $encrypt = '')
{
    $pwd = [];
    $pwd['encrypt'] = $encrypt ? $encrypt : createRandomStr();
    $pwd['password'] = md5(md5(trim($password)) . $pwd['encrypt']);
    return $encrypt ? $pwd['password'] : $pwd;
}
// 删除文件
function delDir($dirpath){
    $dh=opendir($dirpath);
    while (($file=readdir($dh))!==false) {
        if($file!="." && $file!="..") {
            $fullpath=$dirpath."/".$file;
            if(!is_dir($fullpath)) {
                unlink($fullpath);
            } else {
                delDir($fullpath);
                @rmdir($fullpath);
            }
        }
    }
    closedir($dh);
    $isEmpty = true;
    $dh=opendir($dirpath);
    while (($file=readdir($dh))!== false) {
        if($file!="." && $file!="..") {
            $isEmpty = false;
            break;
        }
    }
    return $isEmpty;
}

//生成日志文件
function LogWirte($field , $Astring){
	$path = $_SERVER['DOCUMENT_ROOT'];
	$path = $path."/data/log/".$field.'/';
	$file = $path."log".date('Ymd',time()).".txt";
	if(!is_dir($path)){	mkdir($path,0777,true); }
	$LogTime = date('Y-m-d H:i:s',time());
	if(!file_exists($file))
	{
		$logfile = fopen($file, "w") or die("Unable to open file!");
        fprintf($logfile, "[$LogTime]:".json_encode($Astring,JSON_UNESCAPED_UNICODE)."\r\n");
		fclose($logfile);
	}else{		
		$logfile = fopen($file, "a") or die("Unable to open file!");
        @fprintf($logfile, "[$LogTime]:".json_encode($Astring,JSON_UNESCAPED_UNICODE)."\r\n");
		fclose($logfile);
	}			
}
