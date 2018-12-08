<?php
namespace app\index\controller;

use think\Controller;
use third\Log;
use think\Log as Logs;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

class Index extends Controller
{
    public function index()
    {
		/*
		// Create the logger
			$logger = new Logger('my_logger');
		// Now add some handlers
			$logger->pushHandler(new StreamHandler($_SERVER['DOCUMENT_ROOT'].'/data/log/my_app.log', Logger::DEBUG));
		   // $logger->pushHandler(new FirePHPHandler());

		// You can now use your logger
			$logger->info($this->test());
			dump($logger);
		*/
	}

    #日志测试
    public function query($sql){
        $logger = new Logger('my_logger');
        $logger->pushHandler(new StreamHandler($_SERVER['DOCUMENT_ROOT'].'/data/log/my_app.log', Logger::DEBUG));
        $logger->pushHandler(new FirePHPHandler());
        $logger->info(json_encode($sql,JSON_UNESCAPED_UNICODE));

        $log = new Logger('SQL');
        $date = date('Y-m-d');

//'app/logs/sql_'.$date.'.log'  路径以及日志文件名

//Logger::WARNING 日志级别
        $log->pushHandler(new StreamHandler($_SERVER['DOCUMENT_ROOT'].'/data/log/sql_'.$date.'.log', Logger::WARNING));

        $error_str = '['.date('Y-m-d H:i:s').']';
        $error_str .= 'this is error';

// add records to the log
        $log->addWarning('Foo');
        $log->addError($error_str);
    }

    public function test(){
        for($i=0;$i<10000;$i++){
            $sql = db('AuthGroup')->select();
            $this->querysend($sql);

        }

        echo "执行完毕";
    }

    public function querysend($text,$level = 'log'){
        Logs::init([
            'type'  =>  'File',
            'path'  =>  APP_PATH.'logs/'
        ]);

        Logs::write($text , $level);
    }



}
