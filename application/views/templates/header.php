<!doctype html>
<html class="no-js" lang="en" dir="ltr">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?=isset($title)? $title:''?></title>
<link rel="stylesheet" href="<?php echo base_url();?>font_end/css/foundation.css">
<link rel="stylesheet" href="<?php echo base_url();?>font_end/css/app.css">
<link href="<?php echo base_url();?>font_end/css/style.css" type="text/css" rel="stylesheet" />
</head>

<body>
<div class="row" style="position: relative; padding:0; margin:0; background-color: #056839">
  <div class="large-9 medium-9 columns padding_left_none padding_right_none">
    <ul class="topnav header row" id="myTopnav">
      <li><a class="active" href="<?=base_url()?>">Home</a></li>
      <li><a href="" >Services</a></li>
      <li><a href="">Teacher's Corner</a></li>
      <li><a href="">Student's Corner</a></li>
      <li><a href="">Parents'c Corner</a></li>
      <li><a href="">News & Events</a></li>
      <li><a href="">Our Clients</a></li>
      <li class="icon"> <a href="javascript:void(0);" style="font-size:15px;" onClick="myFunction()">☰</a> </li>
    </ul>
  </div>
  <div class="large-3 medium-3 login_panel_main">
    <div class="large-12 login_panel">
      <div class="large-12 columns"  style="margin:0 auto; padding: 0 !important"> <img src="<?php echo base_url();?>font_end/images/logo_kite.png" align="" alt="Kite Classroom" style="width: 100%; object-fit: contain height:auto; clear:both" />
        <form method="post" action="<?php echo site_url('login/verifylogin');?>" enctype="multipart/form-data" class="login_form">
          <label class="clear_both">User</label>
          <input type="text" id="inputEmail" name="email" value="" class="clear_both" placeholder="Email Address/Username"/>
          <label class="clear_both">Password</label>
          <input type="password" id="inputPassword" name="password" value="" class="clear_both" placeholder="Password" />
          <button class="button btn-lg btn-primary btn-block" type="submit">Sign-in</button>
        </form>
        <p style="font-size: 24px;">New User ? <a href="" title="Sign Up"><img src="<?php echo base_url();?>font_end/images/sign_up_01.png" alt="Sign Up" class="float-right" ></a></p>
      </div>
    </div>
    <div style="clear: both"></div>
    <div class="large-12 box">
      <p><a href="http://foundation.zurb.com/docs">Foundation Documentation</a><br />
        Everything you need to know about using the framework.</p>
    </div>
  </div>
  <div style="clear: both"></div>
</div>