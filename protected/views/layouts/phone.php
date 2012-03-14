<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=<?php echo app()->charset;?>" />
<title><?php echo $title;?></title>
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta content="black" name="apple-mobile-web-app-status-bar-style" />
<meta content="telephone=no" name="format-detection" />
<style type="text/css">
body {font-size:14px; line-height:24px; color:#333; background:#EFEFEF; margin:0; padding:0;}
.phone-container {background:white; margin:10px;}
.post-title {text-align:center; font-size:18px; padding:10px 0 20px 0; border-bottom:1px solid #DFDFDF;}
.phone-container img {max-width:300px;}
.content {font-size:14px;}
</style>
</head>
<body>
<div class="phone-container">
<?php echo $content;?>
</div>
</body>
</html>