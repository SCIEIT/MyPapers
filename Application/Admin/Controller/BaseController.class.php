<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller {
	public function readDir($path){
		$handle=opendir($path);
		while(($item=readdir($handle))!==false){
			if($item!='.'&&$item!='..'){
				if(is_file($path.'/'.$item)){
					$arr[$item]=true;
				}
				if(is_dir($path.'/'.$item)){
					$arr[$item]=$this->readDir($path.'/'.$item);
				}
			}
		}
		closedir($handle);
		return $arr;
	}
}