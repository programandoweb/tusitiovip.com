
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
<?php echo (isset($menu))?$menu:"";?>
