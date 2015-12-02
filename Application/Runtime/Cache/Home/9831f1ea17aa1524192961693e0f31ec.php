<?php if (!defined('THINK_PATH')) exit();?>

<body style="display:none">

  <nav class="white" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="<?=U('home/index/index')?>" class="brand-logo">MyPapers</a>
      <ul id="nav-mobile" class="side-nav">
        <li><a class="waves-effect" href="<?=U('home/list/catebase')?>">Paper List</a></li>
        <li><a class="waves-effect" href="<?=U('home/upload/papers')?>">Paper Upload</a></li>
        <li><a class="waves-effect" href="<?=U('home/advancedsearch/search')?>">Advanced Search(BETA)</a></li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="fa fa-navicon"></i><!-- <i class="material-icons">menu</i> --></a>
      <ul class="right hide-on-med-and-down">
        <li><a class="waves-effect" href="<?=U('home/list/catebase')?>">Paper List</a></li>
        <li><a class="waves-effect" href="<?=U('home/upload/papers')?>">Paper Upload</a></li>
        <li><a class="waves-effect" href="<?=U('home/advancedsearch/search')?>">Advanced Search(BETA)</a></li>
      </ul>
    </div>
  </nav>


<!-- 	<a>*只需至少选择一项信息即可开始搜索,不确定的信息处可以留白，eg.只想搜所有科目2014的试卷只要在Year处选择2014即可</a> -->
  <div class="blue-grey darken-2">
    <br/>
    <h1 class="center-align white-text"><i class="fa fa-search"></i></h1>
    <h4 class="center-align white-text">Paper Search BETA</h4>
    <p class="center-align white-text">In the advanced paper search function, you may search for anything in any question paper and/or markscheme of a specific subject. The advanced search module is the basis of our intelligence.</p>
    <br/>
  </div>
  <blockquote class="hoverable">
    <br/>
    <h5 class="blue-text text-lighten-1"><strong>Knowledge</strong> is having <strong>ALL the Answers</strong>.<br/></h5>
    <h4 class="blue-text text-darken-2"><strong>Intelligence</strong> is having <strong>THE Right Answer</strong>.</h4>
    <br/>
  </blockquote>
  <div class="row">

  </div>
	<div class="row">
		  <form action="<?=U('home/advancedsearch/search')?>" enctype="multipart/form-data" method="post">
		    <div class="input-field col l2 m4 s6">
          <input id="subject" type="text" class="validate" name="subject">
          <label for="subject">Subject Code</label>
        </div>
        <div class="col l2 m4 s6">
        <label>YEAR</label>
    		<select class="browser-default" id="year" name='year'>
<!--       			<option value="" disabled selected>YEAR</option> -->
            <option value="" selected>Unspecified</option>
      			<option value="15">2015</option>
      			<option value="14">2014</option>
      			<option value="13">2013</option>
      			<option value="12">2012</option>
      			<option value="11">2011</option>
      			<option value="10">2010</option>
      			<option value="09">2009</option>
      			<option value="08">2008</option>
      			<option value="07">2007</option>
      			<option value="06">2006</option>
      			<option value="05">2005</option>
      			<option value="04">2004</option>
      			<option value="03">2003</option>
    		</select>
    	 </div>
    	 <div class="col l2 m4 s6">
       <label>PAPER</label>
    		<select class="browser-default" id="paper" name='paper'>
            <option value="" selected>Unspecified</option>
      			<option value="1">01</option>
      			<option value="2">02</option>
      			<option value="3">03</option>
      			<option value="4">04</option>
      			<option value="5">05</option>
      			<option value="6">06</option>
    		</select>
    	 </div>
    	 <div class="input_field col l2 m4 s6">
    	 	<p>
      			<input type="checkbox" id="summer" name='summer'/>
      			<label for="summer">May/June</label>
    		</p>
    		<p>
      			<input type="checkbox" id="winter" name='winter'/>
      			<label for="winter">October/November</label>
    		</p>
    	 </div>
    	 <div class="input_field col l2 m4 s6">
    	 	<p>
      			<input type="checkbox" id="qp" name='qp'/>
      			<label for="qp">Question Paper</label>
    		</p>
    		<p>
      			<input type="checkbox" id="ms" name='ms'/>
      			<label for="ms">Answer Paper</label>
    		</p>
    	 </div>
        <div class="row">
          <div class="input-field col s12">
            <textarea id="txtwords" name='keywords' class="materialize-textarea"></textarea>
            <label for="textarea1">Keywords( Please separate by semicolon--';' )</label>
          </div>
          </div>
       </div>
    	 <div class="input-field col l2 m12 s12">
           <!-- <a  class="waves-effect waves-light btn" onclick="Search()">Search  <i class="fa fa-search"></i></a> -->
           <button class="btn waves-effect waves-light" type="submit" name="action">Search  <i class="fa fa-search"></i>
        </button>
    	</div>
      </form>
    </div>
    <?php if(!isset($result)){?>
      <big>Now, let's rock.</big>
    <?php }else if (empty($result)) {?>
    	<big>Sorry! No matching paper found.</big>
    <?php } else { ?>
	<ul class="collapsible popout" data-collapsible="accordion">
	    <?php foreach($result as $paper){?>
	    	<li>
	    	  <div class="collapsible-header"> <?=$paper['paper_name']?> <?=$subject['subject_code']?>
		    	   <td><a class="right" href="/Papers_DIR/unpacked/<?=$paper['paper_name']?>"><i class="fa fa-eye"></i></a></td>
             <td><a class="right" href="<?=U('home/api/downloadPaper?filename='.$paper['paper_name']);?>"><i class="fa fa-download"></i></a></td>
	    	  </div>
	    	  <div class="collapsible-body">
            <?php if($con){ foreach ($paper['modified_content'] as $substring) {?>
              <blockquote><?=$substring?></blockquote>
            <?php } }else{ echo '<big>Too many results, we can\'t show the content matched</big>'; }?>
	    	  </div>
	    	</li>
	    <?php } ?>
	</ul>
	<?php } ?>

<footer class="page-footer teal">
  
  
  <div class="footer-copyright">
    <div class="container">
    By <a class="brown-text text-lighten-3" href="http://www.scieit.tk">IT Club</a>
    </div>
  </div>
</footer>
  <!--  Scripts-->
<script src="/Public/js/jquery-2.1.1.min.js"></script>
<script src="/Public/js/materialize.min.js"></script>



<script>
  $(document).ready(function(){
    $('.button-collapse').sideNav();
  });
  window.onload=function(){
    $("#preloader").remove();
    $("body").show();
  }
</script>
</body>
</html>