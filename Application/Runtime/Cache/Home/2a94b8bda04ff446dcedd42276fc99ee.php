<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
  <title>MyPapers</title>
  <link href="Public/css/font.css" rel="stylesheet">
  <link href="Public/css/materialize.min.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  
  <link href="Public/css/custom/index/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>

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
      <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>
  </nav>


  <div id="index-banner" class="parallax-container">
    <div class="section no-pad-bot">
      <div class="container">
        <br><br>
        <h1 class="header center teal-text text-lighten-2"> MyPapers</h1>
        <div class="row center">
          <h5 class="header col s12 black-text">Artificial Intelegence enhanced past-paper centre.</h5>
        </div>
        <div class="row center">
          <a class="waves-effect waves-light btn-large">Get Started</a>
        </div>
        <br><br>

      </div>
    </div>
    <div class="parallax"><img src="Public/res/index/background1.jpg" alt="Unsplashed background img 1"></div>
  </div>
  <div class="container">
    <div class="section">
      <div class="row">
        <div class="col s12 m6 l3">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="material-icons">flash_on</i></h2>
            <h5 class="center">Speeds up your revision</h5>
            <p class="light">All the papers were well sorted and tagged by USERS and AI. Everyone's little <strong>contributions</strong> may result in huge difference. Advanced <strong>machine learning algorithms</strong> enables computers to learn from your efforts and download or analize the unsorted papers by themselves.</p>
          </div>
        </div>
        <div class="col s12 m6 l3">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="material-icons">group</i></h2>
            <h5 class="center">User's Power</h5>

            <p class="light">Our cloud sorting system encourages users to help tag the papers they viewed. The more contributions, the better the papers are tagged, and ,of course, the more convinient it will be. Your tiny contribution may result in a big difference!</p>
          </div>
        </div>
        <div class="col s12 m6 l3">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="material-icons">swap_vert</i></h2>
            <h5 class="center">Always up to date</h5>

            <p class="light">Our webspiders will check for newly issued papers <strong>tirelessly</strong>. And if you are kind enough to help, please don't hesitate to <strong>share</strong> your latest papers with all the users who have sorted papers for you. <a href="#">click here to upload</a></p>
          </div>
        </div>
        <div class="col s12 m6 l3">
          <div class="icon-block">
            <h2 class="center brown-text"><i class="material-icons">my_location</i></h2>
            <h5 class="center">Intelligent searching/viewing</h5>

            <p class="light">Our data mining algorithm and cloud sorting system can provide you with ulitmate convinience in finding what you want. Only one click is needed to search for labeled key-points through hundreds of papers or to look through the most delicate collection of questions in specific chapter!</p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="parallax-container valign-wrapper">
    <div class="section no-pad-bot">
      <div class="container">
        <div class="row center">
          <h5 class="header col s12 brown-text light">Material Design by SCIE IT Club.</h5>
        </div>
      </div>
    </div>
    <div class="parallax"><img src="Public/res/index/background2.jpg" alt="Unsplashed background img 2"></div>
  </div>

  <div class="container">
    <div class="section">
      <div class="row">
        <div class="col s12 center">
          <h3> <i class="large material-icons">redeem</i></h3>
          <h4>It is also <strong>your</strong> website!</h4>
          <p class="left-align light">Everything on this website can be <strong>downloaded in batches(compressed ZIP)</strong>. We will make no effort to reserve our resources and try try to provide the best download service. We also ask for your contributions to the <strong>sorting of the papers and the key points</strong>.</p>
        </div>
      </div>

    </div>
  </div>


  <div class="parallax-container valign-wrapper">
    <div class="section no-pad-bot">
      <div class="container">
        <div class="row center">
          <h5 class="header col s12 light">Experience machine learning and experience the <strong>future</strong>!</h5>
          <h5>Currently Catagorized: <?php echo ((isset($papernum) && ($papernum !== ""))?($papernum):"0"); ?> questions!</h5>
        </div>
      </div>
    </div>
    <div class="parallax"><img src="Public/res/index/background3.jpg" alt="Unsplashed background img 3"></div>
  </div>

<footer class="page-footer teal">
  
  <div class="container">
    <div class="row">
      <div class="col l6 s12">
        <h5 class="white-text">SCIE IT Club</h5>
        <p class="grey-text text-lighten-4">We are a team of highschool students working to improve the life of our classmates and to benefit the school.</p>
      </div>
      <div class="col l3 s12">
        <h5 class="white-text">What is text mining?</h5>
        <p class="white-text">Text mining, also referred to as text data mining, roughly equivalent to text analytics, refers to the process of deriving high-quality information from text.</p>
        <p class="white-text">We are using this thechnology to analze the papers in order to catagorize them.</p>
      </div>
      <div class="col l3 s12">
        <h5 class="white-text">Connect</h5>
        <ul>
          <li><a class="white-text" href="http://www.scieit.tk">Homepage</a></li>
          <li><a class="white-text" href="http://cms.scie.cf">MyCMS</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="footer-copyright">
    <div class="container">
    By <a class="brown-text text-lighten-3" href="http://www.scieit.tk">IT Club</a>
    </div>
  </div>

  <!--  Scripts-->
<script src="Public/js/jquery-2.1.1.min.js"></script>
<script src="Public/js/materialize.min.js"></script>

<script src="Public/js/custom/index/init.js"></script>

</body>
</html>
</block>