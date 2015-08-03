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
        <div class="input-field col s12">
          <input id="search" type="search" class="validate col s10">
          <label for="search">Search</label>
           <button class="btn waves-effect waves-light col s1 offset-s1" type="submit" id="submit" name="action">Submit
          </button>
        </div>
    </div>
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
	    	        	      	        </tr>
	    	        	      	      </thead>
	    	        	      	      <tbody>
	    	        	      	      <?php foreach ($papers as $paper) { ?>
	    	        	      	      	<tr>
	    	        	      	      	  <td><?=$paper['paper_month']?></td>
	    	        	      	      	  <td><?=$paper['paper_type']?> <?=$paper['paper_num']?></td>
	    	        	      	      	  <td><?=$paper['paper_view']?></td>
	    	        	      	      	  <td><a class="right" href="http://<?=$_SERVER['HTTP_HOST']?>/Papers_DIR/unpacked/<?=$paper['paper_name']?>"><i class="fa fa-download"></i></a></td>
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