<?php
namespace Home\Controller;
use Think\Controller;
class BaseController extends Controller {
	protected function initialize($title){
	    $this->assign('title',$title);
	    $this->display('./head');
	    ob_flush();
	    flush();
	}
}