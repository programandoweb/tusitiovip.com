<?php
  $perfil_id      = $this->profile->usuario_id;
  $image_portada  = get_portada($perfil_id);
  $image_avatar   = get_avatar($perfil_id);
  $json           = json_decode($this->profile->json);
  $json_inmueble  = json_decode($inmueble->json);
?>
<nav class="navbar navbar-expand-md bg-light text-black">
  <div class="container">
    <button class="navbar-toggler collapsed text-secondary" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fas fa-ellipsis-v"></i>
    </button>
    <div class="navbar-collapse collapse" id="navbarsExampleDefault" style="">
      <ul class="navbar-nav mr-auto">
				<li class="nav-item active">
          <a class="nav-link h2" href="<?php echo base_url(isset($this->profile->login)?"p/".$this->profile->login:'');?>"><?php echo (isset($this->profile->nombres) && isset($this->profile->apellidos))?$this->profile->nombres. ' '. $this->profile->apellidos :"Carlos";?></a>
        </li>
      </ul>
			<ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <img id="avatar" src="<?php echo $image_avatar?>" class="rounded-circle" alt="..." style="width:50px;">
				</li>
			</ul>
    </div>
  </div>
</nav>
<!--section class="slider mb-5 pb-0 shadow">
  <div class="jumbotron top shadow relative bg_portada" style="background-image:url(<?php echo $image_portada?>);">
    <?php
      if(!empty($this->user) && strtolower($this->user->login)==strtolower($this->uri->segment(2))){
    ?>
        <div id="cropContainerMinimal" data-bg=".bg_portada"></div>
        <div id="custom-btn" class="btn-edit btn-tooltip" title="Editar Imagen de Portada"  data-toggle="tooltip" data-placement="right">
          <i class="fas fa-edit fa-2x text-white"></i>
        </div>
    <?php
      }
    ?>
    <div class="container relative">
      <?php if(!empty($this->user) && strtolower($this->user->login)==strtolower($this->uri->segment(2))){ echo form_open(base_url("ApiRest/Push/Profile"),array('ajax' => 'true',"class"=>"form-signin"),array("token"=>$this->user->token));}	?>
        <div class="row p-5">
          <div class="col-12 col-sm-8 text-white bg-titles p-3" >
          <?php
            if(!empty($this->user) && strtolower($this->user->login)==strtolower($this->uri->segment(2))){
          ?>
            <div class="btn-edit btn-tooltip toggle" data-form="true" data-toggle="tooltip" data-placement="right"   title="Editar Información Personal">
              <i class="fas fa-edit fa-2x text-white toggle"></i>
            </div>
            <?php
              }
            ?>
            <h3>Promotor</h3>
            <h2 class="display-4 font-secundary">
              <span class="toggle string_nombres"><?php echo (isset($this->profile->nombres))?$this->profile->nombres:"Ej: Carlos";?></span>
              <span class="toggle hide">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Nombres</span>
                  </div>
                  <?php echo set_input("nombres",@$this->profile->nombres,'Nombres',true,null,array("id"=>"basic-addon2"));?>
                </div>
              </span>
              <span class="toggle string_apellidos"><?php echo (isset($this->profile->apellidos))?$this->profile->apellidos:"Castillo";?></span>
              <span class="toggle hide">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon2">Apellidos</span>
                  </div>
                  <?php echo set_input("apellidos",@$this->profile->apellidos,'Apellidos',true,null,array("id"=>"basic-addon2"));?>
                </div>
              </span>
            </h2>
            <span class="toggle hide">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text string_telefono" id="basic-addon2">Teléfono</span>
                </div>
                <?php echo set_input("telefono",@$this->profile->telefono,'Teléfono',true);?>
              </div>
            </span>
            <span class="toggle hide">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text " id="basic-addon2">Correo electrónico</span>
                </div>
                <?php echo set_input("json[email]",@$json->email,'email@suwebsite.com',true);?>
              </div>
            </span>
            <span class="toggle hide">
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text string_website" id="basic-addon2">Website</span>
                </div>
                <?php echo set_input("json[website]",@$json->website,'suwebsite.com',true);?>
              </div>
            </span>
            <span class="toggle hide">
              <div class="row">
                <div class="col-4">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text string_website" id="basic-addon2"><i class="fab fa-facebook fa-1x"></i></span>
                    </div>
                    <?php echo set_input("json[facebook]",@$json->facebook,'Facebook',true);?>
                  </div>
                </div>
                <div class="col-4">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text string_website" id="basic-addon2"><i class="fab fa-twitter fa-1x"></i></span>
                    </div>
                    <?php echo set_input("json[twitter]",@$json->twitter,'Twitter',true);?>
                  </div>
                </div>
                <div class="col-4">
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text string_website" id="basic-addon2"><i class="fab fa-instagram fa-1x"></i></span>
                    </div>
                    <?php echo set_input("json[instagram]",@$json->instagram,'Instagram',true);?>
                  </div>
                </div>
              </div>
            </span>
            <ul class="list toggle">
              <li>
                <span class="toggle p-3"><?php echo (isset($this->profile->telefono))?$this->profile->telefono:"0414-0000000";?></span>
              </li>
              <li>
                <span class="toggle p-3"><?php echo (isset($json->email))?$json->email:"email@suwebsite.com";?></span>
              </li>
              <li>
                <span class="toggle p-3"><?php echo (isset($json->website))?$json->website:"suwebsite.com";?></span>
              </li>
            </ul>
            <div class="toggle hide">
              <div class="btn-group " role="group" aria-label="Basic example">
                <button type="submit" class="btn btn-secondary">Guardar</button>
                <button type="button" class="btn btn-secondary close-toggle">Cancelar</button>
              </div>
            </div>
          </div>
        </div>
      <?php if(!empty($this->user) && strtolower($this->user->login)==strtolower($this->uri->segment(2))){ echo form_close();}?>
      <div class="row text-center">
        <div class="col">
          <div class="image-profile">
            <div class="row justify-content-md-center" >
              <div class="col-3" id="btnavatar" data-bg=".bg_portada">
                <?php
                  if(!empty($this->user) && strtolower($this->user->login)==strtolower($this->uri->segment(2))){
                ?>
                    <div id="cropContainerMinimal2"></div>
                    <div class="btn-edit btn-tooltip" id="custom-btn2"  data-toggle="tooltip" data-placement="right"  title="Editar Avatar">
                      <i class="fas fa-edit fa-2x text-white"></i>
                    </div>
                <?php
                  }
                ?>
                <div >
                  <img id="avatar" src="<?php echo $image_avatar?>" class="rounded-circle" alt="..." style="width:200px;">
                </div>
              </div>
            </div>

            <div class="row justify-content-md-center mt-3">
                <div class="col-1">
                  <i class="fab fa-facebook fa-3x"></i>
                </div>
                <div class="col-1">
                  <i class="fab fa-twitter fa-3x"></i>
                </div>
                <div class="col-1">
                  <i class="fab fa-instagram fa-3x"></i>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section-->
<!--div class="super-separador"></div>
<div class="super-separador"></div-->
<section class="bg-white pb-5">
  <div class="container">
    <div class="text-left p-3 relative">
      <?php #pre($inmueble);?>
    </div>
    <div class="row text-left">
      <div class="col-12 col-sm-7">
        <h2 class="font-secundary">
          <?php echo $inmueble->titulo;?>
        </h2>
        <h5><?php echo GetTipoAccion($inmueble->accion_id);echo ' '; echo GetTipoInmueble($inmueble->tipo_inmueble);?></h5>
        <p><?php echo $inmueble->descripcion;?></p>
        <div class="row justify-content-md-center p-2">
          <div class="col-12 col-sm-2 text-center" title="Espacio">
            <i class="fas fa-home fa-3x"></i><br>
            <h5><b><?php print($json_inmueble->metros)?>m²</b></h5>
          </div>
          <div class="col-12 col-sm-3 text-center" title="Precio">
            <i class="fas fa-coins fa-3x"></i><br>
            <h5><b><?php print(format($inmueble->precio,true))?></b></h5>
          </div>
          <div class="col-12 col-sm-2 text-center" title="Habitaciones">
            <i class="fas fa-bed fa-3x"></i><br>
            <h5><b><?php print($json_inmueble->cuartos)?></b></h5>
          </div>
          <div class="col-12 col-sm-2 text-center" title="Baños">
            <i class="fas fa-bath fa-3x"></i><br>
            <h5><b><?php print($json_inmueble->banos)?></b></h5>
          </div>
          <div class="col-12 col-sm-2 text-center" title="Baños">
            <i class="fas fa-car fa-3x"></i><br>
            <h5><b><?php print($json_inmueble->estacionamiento)?></b></h5>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-5">
        <div class="row mt-3" id="contenedor_imagenes">
          <?php
            if($inmueble->id){
            $folder	= 	'uploads/inmuebles/'.$inmueble->id;
            $map 		= 	directory($folder);
              if(!empty($map["html"])){
                foreach ($map["html"]  as $key => $value) {
          ?>
                  <div class="col-12 col-sm-6">
                    <img src="<?php echo $value?>" class="img-thumbnail" alt=""/>
                  </div>
          <?php
                }
              }
            }
          ?>
        </div>
      </div>
    </div>
    <div class="row">
      <?php
        //pre($caracteristicas_db);
        $caracteristicas		=		GetCaracteristicas();
      ?>
      <div class="col-12">
        <h3>Características</h3>
        <?php if(count($caracteristicas["On-Site"])>0){?>
          <h5>En el sitio</h5>
        <?php }?>
      </div>
    </div>
    <div class="row pb-3">
      <?php
        foreach($caracteristicas["On-Site"] as $key => $value) {
          if(isset($caracteristicas_db[$value->id])){
      ?>
            <div class="col-3 text-secondary m-1">
              <div class="input-group-text p-2 text-white">
                <i class="fas fa-check ml-2 mr-1"></i> <?php print($value->caracteristica);?>
              </div>
            </div>
      <?php
          }
        }
      ?>
    </div>
    <div class="row">
      <div class="col-12">
        <?php if(count($caracteristicas["Nearby"])>0){?>
          <h5>Alrededor</h5>
        <?php }?>
      </div>
    </div>
    <div class="row pb-3">
      <?php
        foreach($caracteristicas["Nearby"] as $key => $value) {
          if(isset($caracteristicas_db[$value->id])){
      ?>
            <div class="col text-secondary">
              <div class="input-group-text p-2 text-white">
                <i class="fas fa-check ml-2 mr-1"></i> <?php print($value->caracteristica);?>
              </div>
            </div>
      <?php
          }
        }
      ?>
    </div>
  </div>
</section>
