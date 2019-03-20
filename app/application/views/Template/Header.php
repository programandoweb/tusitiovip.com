
<?php
	echo template_header($this->util->get_header());
?>
<section class="header border-bottom">
  <div class="container">
    <div class="row">
      <div class="p-3 col-12 col-sm-4 mr-auto">
				<a href="<?php echo base_url()?>">
					<img src="<?php echo IMG?>logo-xs.png" alt="<?php echo SEO_TITLE?>" />
				</a>
			</div>
			<div class="col-md-4 offset-md-4 p-3 col-12 d-none d-sm-none d-md-block">
				<div class="row">
		      <div class="col-12 col-md-5 d-none d-sm-none d-md-block">
						<div class="border-right pr-3">
			        <i class="fas fa-phone"></i>
			        <b>+582410000000</b>
						</div>
		      </div>
		      <div class="col-12 col-md-4 d-none d-sm-none d-md-block">
		        <i class="fas fa-life-ring"></i>
		        <a href="#">Privacidad</a>
		      </div>
		      <div class="col-12 col-md-3 d-none d-sm-none d-md-block">
		        <i class="fas fa-blog"></i>
		        <a href="#">Blog</a>
		      </div>
				</div>
			</div>
    </div>
  </div>
</section>
<nav class="navbar navbar-expand-md bg-light text-black">
  <div class="container">
    <button class="navbar-toggler collapsed text-secondary" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-ellipsis-v"></i>
    </button>
    <div class="navbar-collapse collapse" id="navbarsExampleDefault" style="">
      <ul class="navbar-nav mr-auto">
				<li class="nav-item active">
          <a class="nav-link" href="<?php echo base_url()?>">Home</a>
        </li>
        <li class="nav-item active">
          <a class="nav-link" href="<?php echo base_url("Apartamentos")?>">Apartamentos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url("Casas")?>">Casas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="<?php echo base_url("Locales")?>">Locales</a>
        </li>
				<li class="nav-item">
          <a class="nav-link" href="<?php echo base_url("Fincas")?>">Fincas</a>
        </li>
      </ul>
			<ul class="navbar-nav ml-auto">
        <li class="nav-item active">
					Promociones
				</li>
			</ul>
    </div>
  </div>
</nav>
