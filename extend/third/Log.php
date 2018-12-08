<?php
/**
 * Created by PhpStorm.
 * User: 21192
 * Date: 2018/10/30
 * Time: 18:05
 */
namespace third;
/*
思路：给定文件，写入读取(fopen ,fwrite……)
  如果大于1M 则重写备份

  传给一个内容，
  判断大小，如果大于1M，备份
  小于则写入
*/

define("ROOT",$_SERVER['DOCUMENT_ROOT']);
class Log{

	//定义一个常量，创建一个文件的名称
	const LOGFILE = 'curr.log';
	//写入文件
	public static function write($cont){
		//$cont .= PHP_EOL;
		$log = self::isBak(); //计算文件的地址，判断大小
		$fh = fopen($log, "ab") or die("Unable to open file!"); //追加模式打开
		$datetime = date('Y-m-d H:i:s',time());
        fprintf($fh,"[$datetime]:" . json_encode($cont,JSON_UNESCAPED_UNICODE)  .  "\r\n");
		fclose($fh);
	}

	//备份日志
	public static function bak(){
		//给出写入文件的路径,把原来的日志
		//改为年月日 .bak 的形式
		$log = ROOT .'/data/log/'. self::LOGFILE;
		$bak = ROOT .'/data/log/'.date('Ymd') . time(). '.log';

		return rename($log,$bak);

	}

	//判断日志是否大于1M
	public static function isBak(){
		//判断文件是否存在
		$log = ROOT .'/data/log/'. self::LOGFILE;
		if(!file_exists($log)){
		//如果不存在，则创建该文件
			//mkdir($log);
			touch($log); // touch在linux也有此命令,是快速的建立一个文件
			return $log;
		}

		//判断大小
		clearstatcache(true,$log); //清除缓存，则创建.log文件
		$size = filesize($log);

		if($size <= 1024*1024*2){
			//如果<=1M 则写入
			return $log;
		}
			//到这一行，说明大于1M
		if(!self::bak()){
			return $log;
		} else {
            //mkdir($log,0777,true);
			touch($log);
			return $log;
		}
   }
}

?>
