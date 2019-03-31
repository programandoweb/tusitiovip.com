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
        <div id="demo" class="carousel slide" data-ride="carousel">

          <!-- Indicators -->
          <ul class="carousel-indicators">
            <?php
              if($inmueble->id){
              $folder	= 	'uploads/inmuebles/'.$inmueble->id;
              $map 		= 	directory($folder);
                if(!empty($map["html"])){
                  foreach ($map["html"]  as $key => $value) {
            ?>
                    <li data-target="#demo" data-slide-to="<?php echo $key;?>" class="<?php echo ($key==0)?"active":'';?>"></li>
            <?php
                  }
                }
              }
            ?>
          </ul>
          <div class="carousel-inner">
            <?php
              if($inmueble->id){
              $folder	= 	'uploads/inmuebles/'.$inmueble->id;
              $map 		= 	directory($folder);
                if(!empty($map["html"])){
                  foreach ($map["html"]  as $key => $value) {
            ?>
                    <div class="carousel-item <?php echo ($key==0)?"active":'';?>">
                      <img src="<?php echo $value;?>" alt="">
                    </div>
            <?php
                  }
                }
              }
            ?>
          </div>

          <!-- Left and right controls -->
          <a class="carousel-control-prev" href="#demo" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </a>
          <a class="carousel-control-next" href="#demo" data-slide="next">
            <span class="carousel-control-next-icon"></span>
          </a>

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
