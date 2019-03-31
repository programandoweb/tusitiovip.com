<section class="mb-1">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 col-sm-6 p-0 m-0">
        <img class="card-img-top" src="<?php echo IMG?>design/leyendo-un-libro-programandoweb.jpg" alt="Leyendo un libro">
      </div>
      <div class="col-12 col-sm-6 bg-primary">
        <div class="p-5 text-white">
          <h2>Lee un libro</h2>
          <h1 class="font-secundary pt-3 pb-3">Vendemos por ti!</h1>
					<?php echo form_open(base_url($this->uri->segment(1)."/inicio_sesion"),array('ajax' => 'true',"class"=>"form-signin"));	?>
            <div class="row mb-2">
              <div class="col">
                <input type="text" id="email" name="email" class="form-control text-white" placeholder="correo@electronico.com" require>
              </div>
            </div>
            <div class="row mb-2">
              <div class="col">
						    <input type="password" id="password" name="password" class="form-control text-white" placeholder="Contraseña" require>
              </div>
            </div>
						<?php echo form_hidden('redirect',($this->agent->is_referral())?$this->agent->referrer():base_url("Apanel"));?>
						<button type="submit" id="submit" class="btn btn-primary" >
							Entrar
						</button>
					<?php echo form_close();?>
        </div>
      </div>
    </div>
  </div>
</section>
