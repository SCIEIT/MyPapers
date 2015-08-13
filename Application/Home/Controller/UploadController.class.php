<?php
namespace Home\Controller;
use Think\Controller;
class UploadController extends BaseController {
    public function papers(){
    	$this->initialize('Upload');
    	$this->display();
    }
    public function uncatpapers(){
    	$this->initialize('Uncatagorized Paper Upload');
    	$this->display();
    }
}