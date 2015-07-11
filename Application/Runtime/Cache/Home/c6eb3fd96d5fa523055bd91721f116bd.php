<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  
  <link href="/Public/css/font.css" rel="stylesheet">
  <link href="/Public/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="/Public/css/custom/index/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
  
  
</head>
<body>

  <nav class="white" role="navigation">
    <div class="nav-wrapper container">
      <a id="logo-container" href="#" class="brand-logo">MyPapers</a>
      <ul class="right hide-on-med-and-down">
        <li><a class="waves-effect" href="#">Get Started</a></li>
      </ul>
      <ul id="nav-mobile" class="side-nav">
        <li><a class="waves-effect" href="#">Get Started</a></li>
      </ul>
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="fa fa-navicon"></i><!-- <i class="material-icons">menu</i> --></a>

    </div>
  </nav>


	<?php foreach($subjects as $subject){?>
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
<script src="/Public/js/custom/index/init.js"></script>


<script>
  $(document).ready(function(){
    $("#preloader").remove();
  });
</script>
</body>
</html>
</block>