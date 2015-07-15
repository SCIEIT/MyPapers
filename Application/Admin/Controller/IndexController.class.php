<?php
namespace Admin\Controller;
use Think\Controller;
use Common\Extensions\PHPExcel;
use Common\Extensions\Hello;
class IndexController extends BaseController {
    public function index(){
        var_dump($this->readDir('./Papers_DIR/unpacked'));
    }
}