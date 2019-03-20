<div class="page-header header-filter clear-filter purple-filter" data-parallax="true" style="background-image: url('<?php echo IMG;?>uploads/home/studient.jpg');">
	<div class="container">
		<div class="row justify-content-md-center">
			<div class="col-6 pl-5 pr-5 section">
				<div class="bg-black"></div>
				<h3 class="text-center">Key recovery system.</h3>
				<div class="row justify-content-md-center">
			    <div class="col">
				  	<img src="<?php echo DOMINIO?>/images/logo-sm.png" class="rounded mx-auto d-block col-5" alt="..." />
			  	</div>
				</div>
				<div class="row justify-content-md-center">
					<div class="col">
						<?php echo form_open(base_url("Autenticacion/Recoverpass"),array('ajax' => 'true'));	?>
						<div class="form-group row">
							<div class="col-sm-10 offset-sm-1">
									<input type="text" id="email" name="email" class="form-control text-white" placeholder="your@email.com" require>
							</div>
						</div>
						<div class="form-group row justify-content-md-center text-center">
							<div class="col-10">
								<?php echo form_hidden('redirect',($this->agent->is_referral())?$this->agent->referrer():base_url());?>
								<button type="submit" class="btn btn-primary btn-sm" >
									Recoverpass
								</button>
								<a class="btn btn-purple btn-sm" href="<?php echo base_url("autenticacion")?>">
									Cancel
								</a>
							</div>
						</div>
						<?php echo form_close();?>
					 </div>
				</div>
			</div>
		</div>
	</div>
</div>
