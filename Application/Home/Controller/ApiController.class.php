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
    public function uploadPaper(){
    	$upload = new Upload();// 实例化上传类
        $upload->maxSize   =     3145728;// 设置附件上传大小
        $upload->exts      =     array('pdf');// 设置附件上传类型
        $upload->rootPath  =     './Papers_DIR/unpacked/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        $upload->saveName = '';
        $upload->autoSub = false;
        // 上传文件 
        $info   =   $upload->upload();
        $check=true;
        foreach($info as $file){
            if(!preg_match("/^\d{4}.*[_].*[a-zA-Z]{2,}.*[.][a-zA-Z]{3}$/", $file['name'])){
                $result = @unlink ('./Papers_DIR/unpacked/'.$file['savename']);
                $check=false;
            }
        }
        if(!$check){$this->error('无法识别类型,请手动输入类型',U('home/upload/uncatpapers'));}
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
            $this->success('上传成功,即将返回主页！',U('home/index/index'));
        }
    }
}