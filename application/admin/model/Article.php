<?php
namespace app\admin\model;

class Article extends Base{
	
	//列表
	public function artlist(){
		$data['list'] = $this->order('id desc')->paginate(config('PAGE_COUNT') , false , ['query'=>request()->param()]);
        //halt($this->getLastSql());
        //$data['page'] = $data['list']->render();
        //return $data;
        $data['page'] = [
            'render'    =>  $data['list']->render(),
            'lastPage'  =>  $data['list']->lastPage(),
            'total'     =>  $data['list']->total(),
        ];
		return $data;
	}
	
	//获取单条数据
    public function getOne($id){
        return Article::get($id);
    }
	//添加
	public function add($data){
		return Article::create($data);
	}
	// 修改
    public function edit($id , $data){
        return Article::where('id' , $id)->update($data);
    }

    //删除
    public function del($id){
        return Article::where(['id' => ['in' , $id]])->delete();
   
    }

}