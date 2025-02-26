<?php
namespace Admin\Controller;
use Think\Controller;
use Common\Extensions\clsTbsZip;
class IndexController extends BaseController {
    public function _initialize(){
    	header("Content-type: text/html;charset=utf-8");
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
    public function packpapers(){
        $subjects=D('subjects')->select();
        $paperArr=[];
        $countArr=[];
        foreach ($subjects as $subject) {
            $code=$subject['subject_code'];
             $paperArr[$code]=D('papers')->where(['subject_code'=>$subject['subject_code']])->getField('paper_name',true);
             $countArr[$code]=D('papers')->where(['subject_code'=>$subject['subject_code']])->count();
        }
        foreach ($subjects as $subject) {
            if(!file_exists('./Papers_DIR/packed/'.$subject['subject_code'].'.zip')){
                $zip = new clsTbsZip();
                $zip->CreateNew();
            // $zip=new ZipArchive();
            //     if($zip->open('./Papers_DIR/packed/'.$subject['subject_code'].'.zip',ZipArchive::OVERWRITE)===TRUE){
                echo '正在创建:'.$subject['subject_code'].'.zip--'.$subject['subject_name'].'<br/>';
                $papers=$paperArr[$subject['subject_code']];
                $filearr=[];
                ob_flush();
                flush();
                foreach ($papers as $paper) {
                    $zip->FileAdd($paper, './Papers_DIR/unpacked/'.$paper, TBSZIP_FILE);
                    echo '添加数据：'.$paper.'<br/>';
                    ob_flush();
                    flush();
                }
                // $zip->close();
                echo '完成添加数据，正在保存。。。。<br/>';
                ob_flush();
                flush();
                $zip->Flush(TBSZIP_FILE, './Papers_DIR/packed/'.$subject['subject_code'].'tmp.zip'); // apply modifications as a new local file
                echo '保存完毕<br/>';
                rename('./Papers_DIR/packed/'.$subject['subject_code'].'tmp.zip','./Papers_DIR/packed/'.$subject['subject_code'].'.zip');
                ob_flush();
                flush();
                $zip->close();
            // }
            }else{
                echo '正在检查 '.$subject['subject_code'].'.zip 的数据完整性。<br/>';
                $zip = new clsTbsZip();
                $zip->Open('./Papers_DIR/packed/'.$subject['subject_code'].'.zip');
                ob_flush();
                flush();
                $papers=$paperArr[$subject['subject_code']];
                if($countArr[$subject['subject_code']]!=count($zip->CdFileLst)){
                    echo $countArr[$subject['subject_code']].'::'.count($zip->CdFileLst).'<br/>';
                    $zip->CreateNew();
                    foreach ($papers as $paper) {
                        $zip->FileAdd($paper, './Papers_DIR/unpacked/'.$paper, TBSZIP_FILE);
                        echo '添加数据：'.$paper.'<br/>';
                        ob_flush();
                        flush();
                    }
                    $zip->Flush(TBSZIP_FILE, './Papers_DIR/packed/'.$subject['subject_code'].'tmp.zip');
                    $zip->close();
                    @unlink ('./Papers_DIR/packed/'.$subject['subject_code'].'.zip');
                    rename('./Papers_DIR/packed/'.$subject['subject_code'].'tmp.zip','./Papers_DIR/packed/'.$subject['subject_code'].'.zip');
                }else{
                    echo '通过检验。<br/>';
                    $zip->close();
                }
                
            }
        }
    }
    private function initializePapers($PapersArr){
    	$subjects=D('subjects')->select();
    	$count=0;
        $wrong=[];
    	$except=[];
        $model=D('papers');
    	foreach($PapersArr as $name=>$value){
    		if($model->where(["paper_name"=>$name])->count()==0){
    			$paper['paper_name']=$name;
	    		preg_match_all("/(?<=\D|^)\d{4}(?=\D)/", $name ,$code);
                $check=true;
                $code=$code[0];
                foreach ($code as $value) {
                    //preg_match("/\d{4}/", $string, $value);
                    //$value=$value[0];
                    if(substr($value, 0,2)!='20'){
                        $paper['subject_code']=$value;
                        $code[0]=$value;
                        $check=false;
                    }
                }
                if(empty($code[0])||($check)){
                    echo '无法识别：'.$name.'<br/>';
                    $wrong[]=$name;
                }else{
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
                    $field=array('paper_name', 'subject_code', 'paper_year', 'paper_month', 'paper_type', 'paper_num');
    	    		$model->field($field)->add($paper);
    	    		echo '添加数据：'.$name.';<br/>';
                }
	    	}else{
	    		$count++;
	    	}
    	}
    	echo '<br/><br/><hr/><br/><br/>跳过了：'.$count.'个已记录项目<br/><br/><br/><hr/><br/><br/>';
    	echo '无法识别的科目：';
    	var_dump($except);
        echo '<br/>无法识别的试卷：';
        var_dump($wrong);
    }
}