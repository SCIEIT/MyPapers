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


	<div class="col s10">
		<h2 class="center-align">Upload Infor. Collection</h2>
	</div>
	<br/>
	<h5 class="center-align">Our uploading system can't tolerate your attacks!</h5>
	<h6 class="center-align">Please be nice to it and don't upload trash files.</h6>
    <div class="row">
    <form class="col s12" action="<?=U('home/api/uploadPaper')?>" enctype="multipart/form-data" method="post" >
	    <!-- <input type="text" name="name" />
	    <input type="file" multiple name="paper[]" />
	    <input type="submit" value="提交" > -->
	        <div class="file-field input-field col s12">
		        <input type="text" name="name" class="file-path validate col s10"/>
		          <div class="btn col s2">
		            <span>File</span>
		            <input type="file" multiple name="paper[]" />
		          </div>
	        </div>
	        <h6>We are sorry but we are currently testing the stability of our server. For safty of the server, your uploads will take some time to be listed in our database.</h6>
	        <hr/>
	        <button class="btn waves-effect waves-light" type="submit" name="action">Submit
  </button>
    </form>
    </div>

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