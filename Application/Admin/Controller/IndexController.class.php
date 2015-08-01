<?php
namespace Admin\Controller;
use Think\Controller;
use Common\Extensions\PHPExcel;
use Common\Extensions\Hello;
class IndexController extends BaseController {
    public function _initialize(){
    	header("Content-type: text/html;charset=utf-8");
    }
    public function index(){
    	$hello=new Hello();
    	$hello->sayHello();
    }
    public function initpapers(){
   		$PapersArr=$this->readDir('./Papers_DIR/unpacked');
   		if(!empty($PapersArr)){
   			$this->initializePapers($PapersArr);
   		}else{
   			echo "Empty Dir";
   		}
    }
    public function proceedpapers(){

    }
    private function initializePapers($PapersArr){
    	$subjects=D('subjects')->select();
    	$count=0;
    	$except=[];
    	foreach($PapersArr as $name=>$value){
    		if(D('papers')->where(["paper_name"=>$name])->count()==0){
    			$paper['paper_name']=$name;
	    		preg_match("/\d{4}/", $name ,$code);
                $paper['subject_code']=$code[0];
                $tmp=false;
	    		foreach($subjects as $subject){
    				if($subject['subject_code']==$code[0]){
    					$tmp=true;
    				}
	    		}
                if(!$tmp&&!in_array($code[0], $except)){
                    $except[]=$code[0];
                }
	    		preg_match("/[SsWw]\d{2}/", $name ,$date);
	    		$paper['paper_year']=substr($date[0], 1);
	    		$paper['paper_month']=strtolower(substr($date[0], 0,1));
	    		if(preg_match("/[a-zA-Z]{2}_[\d+]+/", $name ,$type)){
    	    		$paper['paper_type']=split('_', $type[0])[0];
    	    		$paper['paper_num']=split('_', $type[0])[1];
                }else{
                    preg_match("/[a-zA-Z]{2}/", $name ,$type);
                    $paper['paper_type']=$type[0];
                }
	    		D('papers')->add($paper);
	    		echo '添加数据：'.$name.';<br/>';
	    	}else{
	    		$count++;
	    	}
    	}
    	echo '<br/><br/><hr/><br/><br/>跳过了：'.$count.'个已记录项目<br/><br/><br/><hr/><br/><br/>';
    	echo '无法识别的科目：';
    	var_dump($except);
    }
    private function readPaper(){
    	$phpExcel=new PHPExcel();
    }
}