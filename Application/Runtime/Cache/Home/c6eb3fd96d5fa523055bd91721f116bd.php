<?php if (!defined('THINK_PATH')) exit();?>

<body>

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
	    <?php foreach($subjects as $subject){?>
	    	<li>
	    	  <div class="collapsible-header">
		    	  <i class="fa  fa-bookmark-o"></i><?=$subject['subject_name']?> <?=$subject['subject_code']?>
		    	   <a class="right waves-effect waves-light btn" href="http://<?=$_SERVER['HTTP_HOST']?>/Papers_DIR/packed/<?=$subject['subject_code']?>.zip"><i class="fa fa-cloud-download"></i>All</a>
	    	  </div>
	    	  <div class="collapsible-body"><p><?=$subject['subject_description']?></p>
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
  });
</script>
</body>
</html>
</block>