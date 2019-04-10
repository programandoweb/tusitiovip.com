
<?php
	/*
		AQUI EL ARRAY DEBE SER ESTRUCTURADO ASÍ EN EL CASO DE JS
		$js		=		["jquery-3.3.1.slim.min.js","jquery.min.js",...];
		$css	=		["bootstrap.min.css","all.min.css",...];
		$unir	=		array("js"=>$js,"css"=>$css);
	*/
	echo template_header($this->util->get_header());
?>
<header class="bg-primary m-0">
	<div class="container">
		<div class="row">
			<div class="col-12 col-sm-7 text-center text-md-left ">
				<div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
					<a target="_blank" href="<?php echo SN_FACEBOOK;?>" class="btn btn-none">
						<i class="fab fa-facebook"></i>
					</a>
					<a target="_blank" href="<?php echo SN_TWITTER;?>" class="btn btn-none">
						<i class="fab fa-twitter"></i>
					</a>
					<a target="_blank" href="<?php echo SN_INSTAGRAM;?>" class="btn btn-none">
						<i class="fab fa-instagram"></i>
					</a>
				</div>
			</div>
			<div class="col-12 col-sm-5 text-center text-md-right p-1 header-nav-right">
				<a class="border-right-1 border-right-grey mr-2 pr-2" href="<?php echo base_url("apanel")?>">
					<i class="fas fa-user"></i> Mi Cuenta
				</a>
				<a class="border-right-1 border-right-grey mr-2 pr-2">
					 +58(241)826-0000
				</a>
				<a class="" href="https://wa.me/584144373051?text=Me%20gustaría%20saber%20sobre%20los%20servicios%20de%20TSV">
					 <i class="fab fa-whatsapp"></i> Escribe al Whatsapp
				</a>
			</div>
		</div>
	</div>
	<nav class="navbar navbar-expand-lg navbar-light">
	  <div class="container pt-3 pb-3 pr-0 pl-0">
	    <a class="navbar-brand" href="#">
				<img src="<?php echo IMG?>logo-xs.png" alt="TusitioVIP®">
			</a>
	    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
	      <span class="navbar-toggler-icon"></span>
	    </button>
			<div class="navbar-collapse collapse" id="navbarsExample07" style="">
	    	<ul class="navbar-nav ml-auto">
	        <li class="nav-item active">
	          <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
	        </li>
	        <li class="nav-item">
	          <a class="nav-link" href="<?php echo base_url("search/venta-de-inmuebles?accion_id=1")?>">Ventas</a>
	        </li>
					<li class="nav-item">
	          <a class="nav-link" href="<?php echo base_url("search/alquiler-de-inmuebles?accion_id=3")?>">Alquiler</a>
	        </li>
					<li class="nav-item">
	          <a class="nav-link btn btn-sm btn-grey text-white pl-4 pr-4" href="<?php echo base_url("publicar")?>">Publicar</a>
	        </li>
					<li class="nav-item">
	          <a class="nav-link" href="<?php echo base_url("contacto")?>">Contacto</a>
	        </li>
	      </ul>
	    </div>
	  </div>
	</nav>
</header>
