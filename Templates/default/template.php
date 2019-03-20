<?php 
	$config						=	array();
	$config["js"]				=	array(	"jquery"=>"assets/js/core/jquery.min.js",
											"popper"=>"assets/js/core/popper.min.js",
											"bootstrap-material-design"=>"assets/js/core/bootstrap-material-design.min.js",
											"moment"=>"assets/js/plugins/moment.min.js",
											"datetimepicker"=>"assets/js/plugins/bootstrap-datetimepicker.js",
											"nouislider"=>"assets/js/plugins/nouislider.min.js",
											"sharrre"=>"assets/js/plugins/jquery.sharrre.js",
											"kit"=>"assets/js/material-kit.js?v=2.0.4");	
	$config["script_header"]	=	array();
	$config["script_footer"]	=	array(	"ready"=>array(	"materialKit.initFormExtendedDatetimepickers();",
															" materialKit.initSliders();"));
	$config["meta"]				=	array(	"width"	=>	"<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />",);
	$config["css"]				=	array(	"");
?>