<?php
/*
	AQUI EL ARRAY DEBE SER ESTRUCTURADO ASÍ EN EL CASO DE JS
	$js		=		["jquery-3.3.1.slim.min.js","jquery.min.js",...];
	$css	=		["bootstrap.min.css","all.min.css",...];
	$unir	=		array("js"=>$js,"css"=>$css);
*/
	$ready=		[	"table = DataTable()",];
	$js		=		[	"js/plugins/DataTables-1.10.16/js/jquery.dataTables.js",
							"js/plugins/DataTables-1.10.16/js/dataTables.bootstrap4.min.js",
							"js/plugins/bootstrap-datetimepicker.js",
							"js/plugins/jquery.pgrw.js",
							"croppic/assets/js/jquery.mousewheel.min.js",
							"croppic/croppic.js",
						];
	$css	=		[	"css/fonts.css",
							"js/plugins/DataTables-1.10.16/css/jquery.dataTables.min.css",
							"js/plugins/DataTables-1.10.16/css/dataTables.bootstrap4.min.css",
						];
	$unir	=		array("js"=>$js,"css"=>$css,"ready"=>$ready);
	echo template_header($this->util->get_header(),$unir);
?>
