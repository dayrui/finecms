<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo lang('a-msg-0')?> - Finecms v<?php echo CMS_VERSION?></title>
<style type="text/css">
<!--
body{margin:0px; text-align:center; padding:0px; background-color:#F8F8F8; font-family:Arial,Helvetica,sans-serif; font-size:12px; line-height:20px; color:#000}
.main{padding:30px; width:540px; margin-top:70px; margin-right:auto; margin-bottom:0px; margin-left:auto; text-align:left; background-color:#FFF; border:1px solid #CCC}
.main .box{margin:0px; padding:0px; width:540px; border-top-style:none; border-right-style:none; border-bottom-style:none; border-left-style:none}
.main .box ul{margin:0px; padding:0px; border-top-style:none; border-right-style:none; border-bottom-style:none; border-left-style:none; list-style-type:none}
.main .box ul li{margin:0px; padding:0px; border-top-style:none; border-right-style:none; border-bottom-style:none; border-left-style:none}
.main .box ul .menu{height:25px; width:525px; border-top-style:none; border-right-style:none; border-bottom-style:none; border-left-style:none; margin-top:0px; margin-right:0px; margin-bottom:10px; margin-left:0px; font-size:14px; line-height:25px; color:#FFF; background-color:#999; padding-top:5px; padding-right:5px; padding-bottom:5px; padding-left:10px}
.main .box ul .content{font-size:14px;min-height:30px; width:500px; border-top-style:none; border-right-style:none; border-bottom-style:none; border-left-style:none; background-color:#F5F5F5; margin:0px; padding:20px; color:#C00;text-align: center;}
.main .box ul .line{padding:0px; height:5px; width:540px; margin-top:10px; margin-right:0px; margin-bottom:0px; margin-left:0px; border-top-style:none; border-right-style:none; border-bottom-style:none; border-left-style:none; background-color:#666}
.main .box ul .bottom{height:25px; width:530px; background-color:#999; color:#666; font-size:12px; line-height:25px; padding-top:0px; padding-right:10px; padding-bottom:0px; padding-left:0px; text-align:right; margin-top:5px; margin-right:0px; margin-bottom:0px; margin-left:0px}
.main .box ul .content a{font-size:12px;text-decoration:none; color:#666}
.main .box ul .content a:hover{text-decoration:underline; color:#36C}
.main .box ul .bottom a{color:#FFF; text-decoration:none}
.main .box ul .bottom a:hover{text-decoration:underline}
.content p {margin:0px;padding-top:5px;}
.content pre {height: auto;overflow: auto;}
-->
</style></head>

<body>
<div class="main">
<div class="box">
<ul>
<li class="menu"><?php echo lang('a-msg-0')?></li>
<li class="content">
<?php echo str_replace(APP_ROOT, '', $message); ?>
<?php if ($back) {?><p><a href="javascript:history.back();"><?php echo lang('a-msg-2')?></a></p><?php } ?>
</li>
<li class="line"></li>
</ul>
</div>
</div>
</body>
</html>