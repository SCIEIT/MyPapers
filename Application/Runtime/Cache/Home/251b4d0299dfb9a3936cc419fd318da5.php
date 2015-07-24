<?php if (!defined('THINK_PATH')) exit();?>

<body style="display:none">

  <nav class="white" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="<?=U('index/index')?>" class="brand-logo">MyPapers</a>
      <ul id="nav-mobile" class="side-nav">
        <li><a class="waves-effect" href="#">Get Started</a></li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="fa fa-navicon"></i><!-- <i class="material-icons">menu</i> --></a>
      <ul class="right hide-on-med-and-down">
        <li><a class="waves-effect" href="#">Get Started</a></li>
      </ul>
    </div>
  </nav>


	<div class="row">
		<div class="input-field col s2">
          <input id="last_name" type="text" class="validate">
          <label for="last_name">Subject Code</label>
        </div>
        <div class="input-field col s2">
    		<select class="browser-default">
      			<option value="" disabled selected>YEAR</option>
      			<option value="2013">2013</option>
      			<option value="2014">2014</option>
      			<option value="2015">2015</option>
    		</select>
    	 </div>
    	 <div class="input-field col s2">
    		<select class="browser-default">
      			<option value="" disabled selected>PAPER</option>
      			<option value="">01</option>
      			<option value="2014">02</option>
      			<option value="2015">03</option>
      			<option value="2013">04</option>
      			<option value="2014">05</option>
      			<option value="2015">06</option>
    		</select>
    		 
    	 </div>
    	 <div class="input_field col s2">
    	 	<p>
      			<input type="checkbox" id="s" />
      			<label for="s">May/June</label>
    		</p>
    		<p>
      			<input type="checkbox" id="w" />
      			<label for="w">October/November</label>
    		</p>
    	 </div>
    	 <div class="input_field col s2">
    	 	<p>
      			<input type="checkbox" id="qp" />
      			<label for="qp">Question</label>
    		</p>
    		<p>
      			<input type="checkbox" id="ms" />
      			<label for="ms">Answer</label>
    		</p>
    	 </div>
    	 <div class="input-field col s2">
           <a href="<?=U('home/list/search');?>" class="waves-effect waves-light btn" onclick="Search()">Search</a>
    	</div>
    </div>
	<ul class="collapsible popout" data-collapsible="accordion">
	    <?php foreach($subjects as $subject){?>
	    	<li>
	    	  <div class="collapsible-header">
		    	  <i class="fa  fa-bookmark-o"></i><?=$subject['subject_name']?> <?=$subject['subject_code']?>
		    	   <a class="right" href="http://<?=$_SERVER['HTTP_HOST']?>/Papers_DIR/packed/<?=$subject['subject_code']?>.zip"><i class="fa fa-cloud-download"></i></a>
	    	  </div>
	    	  <div class="collapsible-body"><p><?=$subject['subject_description']?></p>
	    	  <?php if(!empty($papers[$subject['subject_code']])){ ?>
	    	  <div class="container">
	    	  <table>
	    	        <thead>
	    	          <tr>
	    	              <th>Year</th>
	    	              <th>month</th>
	    	              <th>type</th>
	    	              <th>views</th>
	    	              <th></th>
	    	          </tr>
	    	        </thead>
	    	        <tbody>
	    	        <?php foreach ($papers[$subject['subject_code']] as $paper){?>
	    	          <tr>
	    	            <td><?=$paper['paper_year']?></td>
	    	            <td><?=$paper['paper_month']?></td>
	    	            <td><?=$paper['paper_type']?> <?=$paper['paper_num']?></td>
	    	            <td><?=$paper['paper_view']?></td>
	    	            <td><a class="right" href="http://<?=$_SERVER['HTTP_HOST']?>/Papers_DIR/unpacked/<?=$paper['paper_name']?>"><i class="fa fa-download"></i></a></td>
	    	          </tr>
	    	        <?php }?>
	    	        </tbody>
	    	      </table>
	    	      </div>
	    	      <?php } ?>
	    	  </div>
	    	</li>
	    <?php } ?>
	</ul>

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
<script src="/Public/js/custom/index/init.js"></script>


<script>
  $(document).ready(function(){
    $("#preloader").remove();
    $("body").show();
  });
</script>
</body>
</html>
</block>