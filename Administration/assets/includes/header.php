<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?php echo $pagetitle; ?> &rsaquo; <?php echo $userinfo['NAMETAG']; ?> &mdash; DomCord</title>


  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/egg.js/1.0/egg.min.js"></script>
  <script src="../assets/ckeditor/ckeditor.js"></script>




  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <script>
    var egg = new Egg();
    egg
      .addCode("p,a,n,d,a", function() {
        swal("Amazing !", "Pandas are actually the cutest animals. I love them, and you too ?! 🐼", "success")
      }).listen();
  </script>

  <meta property="og:image" content="../themes/uploaded/favicon.ico">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
</head>

<body class="layout-3">
  <div id="app">
    <div class="main-wrapper container">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <a href="https://domcord.dommioss.fr/" class="navbar-brand sidebar-gone-hide"><i class="fas fa-truck-loading"></i> DomCord</a>
        <div class="navbar-nav">
          <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar"><i class="fas fa-bars"></i></a>
        </div>
        <div class="nav-collapse">
          <a class="sidebar-gone-show nav-collapse-toggle nav-link" href="#">
            <i class="fas fa-ellipsis-v"></i>
          </a>
          <ul class="navbar-nav">
            <li class="nav-item active"><a href="#" class="nav-link"><i class="fas fa-tablet"></i> Application</a></li>
            <?php if ($userrank["SUPERADMIN"] == "on") { ?>
              <li class="nav-item"><a href="?page=update" class="nav-link"><i class="fas fa-cloud-download-alt"></i> Check for update</a></li>
            <?php } ?>
            <li class="nav-item"><a href="?page=debug" class="nav-link"><i class="fas fa-cog"></i> Debug mode</a></li>
            <li class="nav-item"><a href="../" class="nav-link"><i class="fas fa-sign-out-alt"></i> Back to website</a></li>
          </ul>
        </div>
        <ul class="navbar-nav ml-auto navbar-right">

          <li class="dropdown "><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
              <?php

              $filename = "../themes/uploaded/profiles/" . $userinfo['AVATAR_PATH'] . "";
              if (file_exists($filename)) {
                echo '<img alt="image" src="' . $filename . '" class="rounded-circle mr-1">';
              } else {
                echo '<img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">';
              }
              ?>
              <div class="d-sm-none d-lg-inline-block">Hi, <?php echo $userinfo['NAMETAG']; ?></div>
            </a>
            <div class="dropdown-menu dropdown-menu-right"><?php if ($userrank['DISPLAY'] > 0) { ?>
                <div class="dropdown-title">Rank: <span class="badge <?php echo $userrank['BADGE_COLOR']; ?> text-white"><?php echo $userrank['NAME']; ?></span><br></div><?php } ?>
              <a href="../?page=account" class="dropdown-item has-icon">
                <i class="far fa-user"></i> My account
              </a>
              <div class="dropdown-divider"></div>
              <a href="../" class="dropdown-item has-icon text-danger">
                <i class="fas fa-sign-out-alt"></i> Back to website
              </a>
            </div>
          </li>
        </ul>
      </nav>

      <nav class="navbar navbar-secondary navbar-expand-lg">
        <div class="container">
          <ul class="navbar-nav">
            <li class="nav-item dropdown">
              <a href="#" data-toggle="dropdown" class="nav-link has-dropdown"><i class="fas fa-truck-loading"></i><span>DomCord</span></a>
              <ul class="dropdown-menu">
                <li class="nav-item"><a href="https://domcord.dommioss.fr/" class="nav-link">Domcord website</a></li>
                <li class="nav-item"><a href="https://dommioss.fr/discord" class="nav-link">Support discord server: 🇫🇷</a></li>
                <li class="nav-item"><a href="https://dommioss.fr/" class="nav-link">DommiossGroup website</a></li>
              </ul>
            </li>


            <li class="nav-item active">
              <a href="?page=home" class="nav-link"><i class="far fa-clone"></i><span>Admin panel</span></a>
            </li>
            <li class="nav-item dropdown">
              <a href="#" data-toggle="dropdown" class="nav-link has-dropdown"><i class="far fa-clone"></i><span>Forum Management</span></a>
              <ul class="dropdown-menu">
                <li class="nav-item dropdown"><a href="#" class="nav-link has-dropdown"><i class="fas fa-users-cog text-info"></i> Users</a>
                  <ul class="dropdown-menu">
                    <?php if ($userrank["SUPERADMIN"] == "on") { ?>
                      <li class="nav-item"><a href="?page=users" class="nav-link">Members list</a></li>
                    <?php } ?>
                    <?php if ($userrank["ADMIN_RANK_EDIT"] == "on") { ?>
                      <li class="nav-item"><a href="?page=ranks" class="nav-link">Ranks</a></li>
                    <?php } ?>
                  </ul>
                </li>

                <li class="nav-item dropdown"><a href="#" class="nav-link has-dropdown"><i class="fab fa-forumbee text-warning"></i> Forum</a>
                  <ul class="dropdown-menu">
                    <?php if ($userrank["ADMIN_MANAGE_CATEGORIES"] == "on") { ?>
                      <li class="nav-item"><a href="?page=forums" class="nav-link">Forums</a></li>
                      <li class="nav-item"><a href="?page=categories" class="nav-link">Categories</a></li>
                    <?php } ?>
                    <?php if ($userrank["ADMIN_MANAGE_FORUMS"] == "on") { ?>
                      <li class="nav-item"><a href="?page=badges" class="nav-link">Badges / Prefix</a></li>
                    <?php } ?>
                  </ul>
                </li>
                <li class="nav-item dropdown"><a href="#" class="nav-link has-dropdown"><i class="fas fa-flag text-danger"></i> Moderation</a>
                  <ul class="dropdown-menu">
                    <?php if ($userrank["ADMIN_BAN"] == "on") { ?>
                      <li class="nav-item"><a href="?page=banlist" class="nav-link">Banip list</a></li>
                    <?php } ?>
                    <?php if ($userrank["MESSAGE_DELETE"] == "on") { ?>
                      <li class="nav-item"><a href="?page=reports" class="nav-link">Reports</a></li>
                    <?php } ?>
                  </ul>
                </li>
                <li class="nav-item dropdown"><a href="#" class="nav-link has-dropdown"><i class="fas fa-feather text-primary"></i> Other</a>
                  <ul class="dropdown-menu">
                    <?php if ($userrank["MAINTENANCE_MANAGE"] == "on") { ?>
                      <li class="nav-item"><a href="?page=maintenance" class="nav-link">Maintenance mode</a></li>
                    <?php } ?>
                    <?php if ($userrank["SUPERADMIN"] == "on") { ?>
                      <li class="nav-item"><a href="?page=settings" class="nav-link">Main settings</a></li>
                      <li class="nav-item"><a href="?page=additional_settings" class="nav-link">Additional settings</a></li>
                      <li class="nav-item"><a href="?page=widgets" class="nav-link">Widgets</a></li>
                    <?php } ?>
                    <?php if ($userrank["ADMIN_THEME_EDIT"] == "on") { ?>
                      <li class="nav-item"><a href="?page=themes" class="nav-link">Themes</a></li>
                    <?php } ?>
                    <?php if ($userrank["ADMIN_MANAGE_FORUMS"] == "on") { ?>
                      <li class="nav-item dropdown"><a href="#" class="nav-link has-dropdown"><i class="fas fa-share"></i> Links</a>
                        <ul class="dropdown-menu">
                          <li class="nav-item"><a href="?page=footerlinks" class="nav-link">Footer links</a></li>
                          <li class="nav-item"><a href="?page=headerlinks" class="nav-link">Header links</a></li>
                        </ul>
                      </li>
                    <?php } ?>

                    <?php if ($userrank["ADMIN_PAGE_CREATE"] == "on") { ?>
                      <li class="nav-item"><a href="?page=custom_pages" class="nav-link">Custom Pages</a></li>
                    <?php } ?>
                  </ul>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </nav>

      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1><?php echo $pagetitle ?></h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#"><?php echo $_Config_['General']['name']; ?></a></div>
              <div class="breadcrumb-item"><a href="#">Administration
                  <a onclick='javascript:(function(){function c(){var e=document.createElement("link");e.setAttribute("type","text/css");e.setAttribute("rel","stylesheet");e.setAttribute("href",f);e.setAttribute("class",l);document.body.appendChild(e)}function h(){var e=document.getElementsByClassName(l);for(var t=0;t<e.length;t++){document.body.removeChild(e[t])}}function p(){var e=document.createElement("div");e.setAttribute("class",a);document.body.appendChild(e);setTimeout(function(){document.body.removeChild(e)},100)}function d(e){return{height:e.offsetHeight,width:e.offsetWidth}}function v(i){var s=d(i);return s.height>e&&s.height<n&&s.width>t&&s.width<r}function m(e){var t=e;var n=0;while(!!t){n+=t.offsetTop;t=t.offsetParent}return n}function g(){var e=document.documentElement;if(!!window.innerWidth){return window.innerHeight}else if(e&&!isNaN(e.clientHeight)){return e.clientHeight}return 0}function y(){if(window.pageYOffset){return window.pageYOffset}return Math.max(document.documentElement.scrollTop,document.body.scrollTop)}function E(e){var t=m(e);return t>=w&&t<=b+w}function S(){var e=document.createElement("audio");e.setAttribute("class",l);e.src=i;e.loop=false;e.addEventListener("canplay",function(){setTimeout(function(){x(k)},500);setTimeout(function(){N();p();for(var e=0;e<O.length;e++){T(O[e])}},15500)},true);e.addEventListener("ended",function(){N();h()},true);e.innerHTML=" <p>If you are reading this, it is because your browser does not support the audio element. We recommend that you get a new browser.</p> <p>";document.body.appendChild(e);e.play()}function x(e){e.className+=" "+s+" "+o}function T(e){e.className+=" "+s+" "+u[Math.floor(Math.random()*u.length)]}function N(){var e=document.getElementsByClassName(s);var t=new RegExp("\\b"+s+"\\b");for(var n=0;n<e.length;){e[n].className=e[n].className.replace(t,"")}}var e=30;var t=30;var n=350;var r=350;var i="//s3.amazonaws.com/moovweb-marketing/playground/harlem-shake.mp3";var s="mw-harlem_shake_me";var o="im_first";var u=["im_drunk","im_baked","im_trippin","im_blown"];var a="mw-strobe_light";var f="//s3.amazonaws.com/moovweb-marketing/playground/harlem-shake-style.css";var l="mw_added_css";var b=g();var w=y();var C=document.getElementsByTagName("*");var k=null;for(var L=0;L<C.length;L++){var A=C[L];if(v(A)){if(E(A)){k=A;break}}}if(A===null){console.warn("Could not find a node of the right size. Please try a different page.");return}c();S();var O=[];for(var L=0;L<C.length;L++){var A=C[L];if(v(A)){O.push(A)}}})()'>
                    .</a></a></div>
              <div class="breadcrumb-item"><?php echo $pagetitle ?></div>
            </div>
          </div>

          <?php if ($obj->status === 0) { ?>
            <?php if ($obj->type === "Development") { ?>
              <div class="alert alert-warning"><b><i class="fas fa-tools"></i></b> License for development only.</div>
            <?php } ?>
          <?php } else { ?>
            <div class="alert alert-danger"><b><i class="fas fa-exclamation-circle"></i></b> You license is no longer available. Please create a <u><a href="https://domcord.dommioss.fr/?page=licenses">new license key on DomCord's website</a></u>.</div>
            
          <?php } ?>