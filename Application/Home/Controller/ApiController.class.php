<?php
namespace Home\Controller;
use Think\Controller;
use Think\Upload as Upload;
class ApiController extends BaseController {
    public function downloadPaper($filename){
    	header('content-disposition:attachment;filename='.$filename);
    	$filename='./Papers_DIR/unpacked/'.$filename;
    	header('content-length:'.filesize($filename));
    	readfile($filename);
    }
    public function uploadPaper($filename){
    	upload();
    }
    private function upload(){
        $upload = new Upload();// 实例化上传类
        $upload->maxSize   =     0;// 设置附件上传大小
        $upload->exts      =     array('pdf', 'txt');// 设置附件上传类型
        $upload->rootPath  =     './Papers_DIR/unpacked'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件 
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
            $this->success('上传成功！');
        }
    }
}