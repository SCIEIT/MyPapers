<?php if (!defined('THINK_PATH')) exit();?>

<body style="display:none">

  <nav class="white" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="<?=U('home/index/index')?>" class="brand-logo">MyPapers</a>
      <ul id="nav-mobile" class="side-nav">
        <li><a class="waves-effect" href="<?=U('home/list/catebase')?>">Paper List</a></li>
        <li><a class="waves-effect" href="<?=U('home/upload/papers')?>">Paper Upload</a></li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="fa fa-navicon"></i><!-- <i class="material-icons">menu</i> --></a>
      <ul class="right hide-on-med-and-down">
        <li><a class="waves-effect" href="<?=U('home/list/catebase')?>">Paper List</a></li>
        <li><a class="waves-effect" href="<?=U('home/upload/papers')?>">Paper Upload</a></li>
      </ul>
    </div>
  </nav>


<!-- 	<a>*只需至少选择一项信息即可开始搜索,不确定的信息处可以留白，eg.只想搜所有科目2014的试卷只要在Year处选择2014即可</a> -->
	<div class="row">
		
		    <div class="input-field col l2 m4 s6">
          <input id="subject" type="text" class="validate">
          <label for="subject">Subject Code</label>
        </div>
        <div class="col l2 m4 s6">
        <label>YEAR</label>
    		<select class="browser-default" id="year">
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
    		<select class="browser-default" id="paper">
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
      			<input type="checkbox" id="s" />
      			<label for="s">May/June</label>
    		</p>
    		<p>
      			<input type="checkbox" id="w" />
      			<label for="w">October/November</label>
    		</p>
    	 </div>
    	 <div class="input_field col l2 m4 s6">
    	 	<p>
      			<input type="checkbox" id="qp" />
      			<label for="qp">Question Paper</label>
    		</p>
    		<p>
      			<input type="checkbox" id="ms" />
      			<label for="ms">Answer Paper</label>
    		</p>
    	 </div>
    	 <div class="input-field col l2 m12 s12">
           <a  class="waves-effect waves-light btn" onclick="Search()">Search  <i class="fa fa-search"></i></a>
    	</div>
    </div>
    <?php  if (empty($papers)) {?>
    	<big>Sorry! No matching paper found.</big>
    <?php } else { ?>
	<ul class="collapsible popout" data-collapsible="accordion">
	    <?php foreach($papers as $code => $subject){?>
	    	<li>
	    	  <div class="collapsible-header">
		    	  <i class="fa  fa-bookmark-o"></i><?=$subject['subject_name']?> <?=$subject['subject_code']?>
		    	   <a class="right" href="http://<?=$_SERVER['HTTP_HOST']?>/Papers_DIR/packed/<?=$subject['subject_code']?>.zip"><i class="fa fa-cloud-download"></i></a>
	    	  </div>
	    	  <div class="collapsible-body">
	    	  <?php if(!empty($subject['years'])){ ?>
	    	  	&nbsp &nbsp &nbsp please click the years to view
	    	        <ul class="collapsible" data-collapsible="accordion">
	    	        <?php foreach ($subject['years'] as $year=>$papers){?>
	    	        	    <li>
	    	        	      <div class="collapsible-header">Year <?=empty($year)?'?':$year;?></div>
	    	        	      <div class="collapsible-body">
	    	        	 	<div class="container">
	    	        	      	<table>
	    	        	      	      <thead>
	    	        	      	        <tr>
	    	        	      	            <th>month</th>
	    	        	      	            <th>type</th>
	    	        	      	            <th>views</th>
	    	        	      	            <th></th>
	    	        	      	            <th></th>
	    	        	      	        </tr>
	    	        	      	      </thead>
	    	        	      	      <tbody>
	    	        	      	      <?php foreach ($papers as $paper) { ?>
	    	        	      	      	<tr>
	    	        	      	      	  <td><?=$paper['paper_month']?></td>
	    	        	      	      	  <td><?=$paper['paper_type']?> <?=$paper['paper_num']?></td>
	    	        	      	      	  <td><?=$paper['paper_view']?></td>
	    	        	      	      	  <td><a class="right" href="/Papers_DIR/unpacked/<?=$paper['paper_name']?>"><i class="fa fa-eye"></i></a></td>
	    	        	      	      	  <td><a class="right" href="<?=U('home/api/downloadPaper?filename='.$paper['paper_name']);?>"><i class="fa fa-download"></i></a></td>
	    	        	      	      	</tr>
	    	        	      	      <?php }?>
	      	      	    	        </tbody>
	      	      	    	      </table>
	      	      	    	     </div>
	    	        	      </div>
	    	        	    </li>
	    	        <?php }?>

	    	      </ul>
	    	      <?php } ?>
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

  <script src="/Public/js/custom/catebase/search.js"></script>


<script>
  $(document).ready(function(){
    $("#preloader").remove();
    $("body").show();
    $('.button-collapse').sideNav();
  });
</script>
</body>
</html>
</block>