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


	&nbsp;
	<div class="col s10">
		<h2 class="center-align">Upload Infor. Collection</h2>
	</div>
	<hr style="border-color:#efebe9;box-shadow: 1px 1px 10px;" align="center" width="45%">
	&nbsp;
	<div class="row">
    <form class="col s11" style="border-color:#8d6e63;">

    	<div class="row">
    		<div class="col s6 offset-s2">
	    		 <label style="font-size:25px;">Grade</label>
	    		 <p>
			      <input name="grade" type="radio" id="G" />
			      <label for="G">G-Level&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
			      <input name="grade" type="radio" id="A" />
			      <label for="A">A-Level</label>
			    </p>
		   </div>
    	</div>
    	<div class="row">
      	<div class="col s6 offset-s2">
          <label style="font-size:25px;">Subject Name</label>
		    <select class="browser-default" >
		      <option value="" selected disabled>Choose the subject</option>
		      <option value="1">Option 1</option>
		      <option value="2">Option 2</option>
		      <option value="3">Option 3</option>
		    </select>
		   </div>
      </div>


      <div class="row">
      	<div class="col s3 offset-s2">
          <label style="font-size:25px;">Year</label>
		    <select class="browser-default">
		      <option value="" disabled selected>Year</option>
		      <option value="1">Option 1</option>
		      <option value="2">Option 2</option>
		      <option value="3">Option 3</option>
		    </select>
		   </div>
      </div>

      <div class="row">
      	<div class="col s3 offset-s2">
          <label style="font-size:25px;">Component</label>
		    <select class="browser-default">
		      <option value="" disabled selected>Choose the component</option>
		      <option value="1">Option 1</option>
		      <option value="2">Option 2</option>
		      <option value="3">Option 3</option>
		    </select>
		   </div>
      </div>

      <div class="row">
      	<div class="col s5 offset-s2">
          <label style="font-size:25px;">Type</label>
		    <select class="browser-default">
		      <option value="" disabled selected>Chose the file type</option>
		      <option value="ms">ms (Mark Scheme)</option>
		      <option value="qp">qp (Question Paper)</option>
		    </select>
		   </div>
      </div>

      <div class="row">
      	<div class="col s8 offset-s2 file-field input-field">
		      <input class="file-path validate" type="text"/>
		      <div class="btn">
		        <span>ADD FILE</span>
		        <input type="file" />
		      </div>
		   </div>
      </div>
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
</block>