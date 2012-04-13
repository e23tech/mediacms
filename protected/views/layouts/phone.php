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
body {font-size:16px; line-height:24px; color:#333; background:#EFEFEF; margin:0; padding:0; width:100%; height:100%;}
.phone-container {background:white; padding:7px;margin:7px; height:100%;}
.post-title {text-align:center; font-size:20px; padding:10px 0 15px 0; margin:0; border-bottom:1px solid #DFDFDF; text-shadow:1px 1px #DFDFDF;}
.phone-container img {max-width:290px;}
</style>
</head>
<body>
<div class="phone-container">
<?php echo $content;?>
</div>
</body>
</html>