<?php
  $perfil_id      = $this->profile->usuario_id;
  $image_portada  = get_portada($perfil_id);
  $image_avatar   = get_avatar($perfil_id);
  $json           = json_decode($this->profile->json);
?>
<?php
  if(!empty($this->user) && strtolower(@$this->user->login)==strtolower($this->uri->segment(2))){
?>
    <div class="btn-fixed">
      <a class="btn btn-secondary" href="<?php echo base_url("apanel");?>">Panel Administrativo</a>
    </div>
<?php
  }
?>
<section class="slider mb-5 pb-0 shadow">
  <div class="jumbotron top shadow relative bg_portada" style="background-image:url(<?php echo $image_portada?>);">
    <?php
      if(!empty($this->user) && strtolower(@$this->user->login)==strtolower($this->uri->segment(2))){
    ?>
        <div id="cropContainerMinimal" data-bg=".bg_portada"></div>
        <div id="custom-btn" class="btn-edit btn-tooltip" title="Editar Imagen de Portada"  data-toggle="tooltip" data-placement="right">
          <i class="fas fa-edit fa-2x text-white"></i>
        </div>
    <?php
      }
    ?>
    <div class="container relative">
      <?php if(!empty($this->user) && strtolower(@$this->user->login)==strtolower($this->uri->segment(2))){ echo form_open(base_url("ApiRest/Push/Profile"),array('ajax' => 'true',"class"=>"form-signin"),array("token"=>@$this->user->token));}	?>
        <div class="row p-5">
          <div class="col-12 col-sm-8 text-white bg-titles p-3" >
          <?php
            if(!empty($this->user) && strtolower(@$this->user->login)==strtolower($this->uri->segment(2))){
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
                  <span class="input-group-text" id="basic-addon2">Teléfono</span>
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
                <span class="toggle p-3 string_telefono"><?php echo (isset($this->profile->telefono))?$this->profile->telefono:"0414-0000000";?></span>
              </li>
              <li>
                <span class="toggle p-3 string_email"><?php echo (isset($json->email))?$json->email:"email@suwebsite.com";?></span>
              </li>
              <li>
                <span class="toggle p-3 string_website"><?php echo (isset($json->website))?$json->website:"suwebsite.com";?></span>
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
      <?php if(!empty($this->user) && strtolower(@$this->user->login)==strtolower($this->uri->segment(2))){ echo form_close();}?>
      <div class="row text-center">
        <div class="col">
          <div class="image-profile">
            <div class="row justify-content-md-center" >
              <div class="col-3" id="btnavatar" data-bg=".bg_portada">
                <?php
                  if(!empty($this->user) && strtolower(@$this->user->login)==strtolower($this->uri->segment(2))){
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
                  <a target="_blank" <?php if(isset($json->facebook)){?> href="<?php echo 'https://facebook.com/'.$json->facebook;?>" <?php }?> class="url_facebook">
                    <i class="fab fa-facebook fa-3x"></i>
                  </a>
                </div>
                <div class="col-1">
                  <a target="_blank" <?php if(isset($json->twitter)){?> href="<?php echo 'https://twitter.com/'.$json->twitter;?>" <?php }?> class="url_twitter">
                    <i class="fab fa-twitter fa-3x"></i>
                  </a>
                </div>
                <div class="col-1">
                  <a target="_blank" <?php if(isset($json->instagram)){?> href="<?php echo 'https://instagram.com/'.$json->instagram;?>" <?php }?> class="url_instagram">
                    <i class="fab fa-instagram fa-3x"></i>
                  </a>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="super-separador"></div>
<div class="super-separador"></div>
<section class="bg-white ">
  <div class="container shadow" style="background:#ddd;">
    <div class="text-left p-5 relative">
      <h1 class="font-secundary">
        Inmuebles
      </h1>
      <h2>Destacados</h2>
      <?php
        //pre($this->inmuebles);
        if(!empty(@$this->user) && strtolower(@$this->user->login)==strtolower($this->uri->segment(2))){
      ?>
          <a href="<?php echo base_url("Gestion/Inmuebles/Add/0/Iframe")?>" class="btn-edit btn-tooltip" data-toggle="tooltip" data-placement="right"  title="Agregar nuevo inmueble">
            <i class="fas fa-plus fa-2x text-secondary"></i>
          </a>
      <?php
        }
      ?>
    </div>
    <div class="row text-center">
      <?php
        if(!empty($this->inmuebles) && count($this->inmuebles)>0){
          switch(count($this->inmuebles)){
            case 1:
            case 2:
              $num  = 6;
            break;
            case 3:
              $num  = 4;
            break;
            case 4:
              $num  = 3;
            break;
            default:
              $num  = 3;
            break;
          }
          foreach ($this->inmuebles as $key => $value) {
            $ruta       = 'uploads/inmuebles/'.$value->id.'/';
            $directorio = directory($ruta);
            $image      =  IMG.'design/1000.jpg';
            foreach ($directorio["data"] as $key2 => $value2) {
              if($value2==$value->img_destacada){
                $image  =  IMG.$ruta.$value->img_destacada;
                break;
              }
            };

      ?>
            <div class="col-12 col-sm-<?php echo $num;?> p-0 m-0 position-relative hover-link-effect">
              <a class="text-white" href="<?php echo base_url(GetTipoAccion($value->accion_id)."/".GetTipoInmueble($value->tipo_inmueble)."/PGRW-".$value->id."-".url_title($value->direccion))?>" >
                <div class="position-absolute hover-link p-5">
                  <h2 class=""><?php print(GetTipoInmueble($value->tipo_inmueble));?></h2>
                  <h3><?php print($value->direccion);?></h3>
                </div>
              </a>
              <img class=" img-fluid" src="<?php echo $image;?>" alt="Art Fit Center">
            </div>
      <?php
          }
        }
      ?>
    </div>
  </div>
</section>

<!--section class="bg-white">
  <div class="container-fluid">
    <div class="text-center p-5">
      <h1 class="font-secundary">
        Otros
      </h1>
      <h2>Inmuebles</h2>
    </div>
    <div class="row text-center">
      <div class="col-12 col-sm-2 p-0 m-0 position-relative hover-link-effect">
        <a class="text-white" href="#" >
          <div class="position-absolute hover-link p-5">
              <h6>La Pastora</h6>
          </div>
        </a>
        <img class=" img-fluid" src="<?php echo IMG?>design/01.jpg" alt="Art Fit Center">
      </div>
      <div class="col-12 col-sm-2 p-0 m-0 position-relative hover-link-effect">
        <a class="text-white" href="#" >
          <div class="position-absolute hover-link p-5">
              <h6>CCCT</h6>
          </div>
        </a>
        <img class=" img-fluid" src="<?php echo IMG?>design/06.jpg" alt="B2U Jeans">
      </div>
      <div class="col-12 col-sm-2 p-0 m-0 position-relative hover-link-effect">
        <a class="text-white" href="#" >
          <div class="position-absolute hover-link p-5">
              <h6>Las Mercedes</h6>
          </div>
        </a>
        <img class=" img-fluid" src="<?php echo IMG?>design/02.jpg" alt="Eventos Nueva Estación">
      </div>
      <div class="col-12 col-sm-2 p-0 m-0 position-relative hover-link-effect">
        <a class="text-white" href="#" >
          <div class="position-absolute hover-link p-5">
              <h6>El Marqués</h6>
          </div>
        </a>
        <img class=" img-fluid" src="<?php echo IMG?>design/03.jpg" alt="Dina diesel">
      </div>
      <div class="col-12 col-sm-2 p-0 m-0 position-relative hover-link-effect">
        <a class="text-white" href="#" >
          <div class="position-absolute hover-link p-5">
              <h6>Av Panteón</h6>
          </div>
        </a>
        <img class=" img-fluid" src="<?php echo IMG?>design/04.jpg" alt="Art Fit Center">
      </div>
      <div class="col-12 col-sm-2 p-0 m-0 position-relative hover-link-effect">
        <a class="text-white" href="#" >
          <div class="position-absolute hover-link p-5">
              <h6>CCCT</h6>
          </div>
        </a>
        <img class=" img-fluid" src="<?php echo IMG?>design/05.jpg" alt="Eventos Nueva Estación">
      </div>
    </div>
  </div>
</section>
<section class="bg-success text-center p-5 text-white">
  <h1 class="font-secundary">
    Ubicación fácil de encontrar
  </h1>
  <h2>¡fíjate del mapa!</h2>
  <p>Radal 189, Santiago, Estación Central, Región Metropolitana, Chile</p>
</section-->

<section class="bg-green mt-5 shadow">
  <div class="container ">
    <h1 class="font-secundary p-5">
      Redes Sociales
    </h1>
    <div class="row pb-5">
      <div class="col-12 col-sm-4 ">
        <div class="redes-timeline">
          <div id="fb-root"></div>
          <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v3.2&appId=1731187280515813&autoLogAppEvents=1"></script>
          <div class="fb-page"
                data-href="https://www.facebook.com/<?php echo (isset($json->facebook)?$json->facebook:"skygroupsolutions");?>/"
                data-tabs="timeline"
                data-width="450"
                data-height="350"
                data-small-header="false"
                data-adapt-container-width="true"
                data-hide-cover="false"
                data-show-facepile="true">
                <blockquote cite="https://www.facebook.com/<?php echo (isset($json->facebook)?$json->facebook:"skygroupsolutions");?>/" class="fb-xfbml-parse-ignore">
                  <a href="https://www.facebook.com/<?php echo (isset($json->facebook)?$json->facebook:"skygroupsolutions");?>/"><?php echo (isset($json->facebook)?$json->facebook:"Skygroupsolutions");?></a>
                </blockquote>
          </div>
        </div>
      </div>
      <!--div class="col-12 col-sm-4 ">
        <div class="redes-timeline">
          <i class="fab fa-twitter fa-5x"></i>
          <p>twitter</p>
        </div>
      </div-->
      <div class="col-12 col-sm-8">
        <div class="redes-timeline">
          <link href="<?php echo TEMPLATE;?>/assets/instalink/instalink-2.1.10.min.css" rel="stylesheet">
          <script src="<?php echo TEMPLATE;?>/assets/instalink/instalink-2.1.10.min.js"></script>
          <div data-il
               data-il-api="/instalink/api/"
               data-il-username="<?php echo (isset($json->instagram)?$json->instagram:"skygroupsolutions");?>"
               data-il-hashtag=""
               data-il-lang="en"
               data-il-show-heading="true"
               data-il-scroll="true"
               data-il-width="100%"
               data-il-height="350px"
               data-il-image-size="medium"
               data-il-bg-color="#285989"
               data-il-content-bg-color="#F8F8F8"
               data-il-font-color="#FFFFFF"
               data-il-ban="">
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
var croppicContaineroutputMinimal = {
    imgBG:".bg_portada",
    customUploadButtonId:'custom-btn',
    uploadUrl:'<?php echo base_url("ApiRest/Upload/ImagesUp?folder=".@$this->user->usuario_id."&name=portada")?>',
    cropUrl:'<?php echo base_url("ApiRest/Upload/ImagesCrop?folder=".@$this->user->usuario_id."&name=portada")?>',
    modal:false,
    doubleZoomControls:false,
    rotateControls: false,
    loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
    onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
    onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
    onImgDrag: function(){ console.log('onImgDrag') },
    onImgZoom: function(){ console.log('onImgZoom') },
    onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
    onAfterImgCrop:function(){ console.log('onAfterImgCrop') },
    onReset:function(){ console.log('onReset') },
    onError:function(errormessage){ console.log('onError:'+errormessage) }
}
var cropContaineroutput = new Croppic('cropContainerMinimal', croppicContaineroutputMinimal);


var croppicContaineroutputMinimal2 = {
    imgSrcChange:"#avatar",
    customUploadButtonId:'custom-btn2',
    uploadUrl:'<?php echo base_url("ApiRest/Upload/ImagesUp?folder=".@$this->user->usuario_id."&name=avatar&cuadrar=avatar")?>',
    cropUrl:'<?php echo base_url("ApiRest/Upload/ImagesCrop?folder=".@$this->user->usuario_id."&name=avatar&cuadrar=avatar")?>',
    modal:false,
    doubleZoomControls:false,
    rotateControls: false,
    loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
    onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
    onAfterImgUpload: function(){ console.log('onAfterImgUpload') },
    onImgDrag: function(){ console.log('onImgDrag') },
    onImgZoom: function(){ console.log('onImgZoom') },
    onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
    onAfterImgCrop:function(){ console.log('onAfterImgCrop') },
    onReset:function(){ console.log('onReset') },
    onError:function(errormessage){ console.log('onError:'+errormessage) }
}
var cropContaineroutput2 = new Croppic('cropContainerMinimal2', croppicContaineroutputMinimal2);

function toggle(data){
  variable =  $.parseJSON(JSON.stringify(data));
  $.each(variable,function(k,v){
    if(k=="json"){
      $.each($.parseJSON(v),function(k2,v2){
        $(".string_"+k2).html(v2);
        if(k2=="facebook"){
          $(".url_facebook").attr("href","https://facebook.com/"+v2);
        }
        if(k2=="twitter"){
          $(".url_twitter").attr("href","https://twitter.com/"+v2);
        }
        if(k2=="instagram"){
          $(".url_instagram").attr("href","https://instagram.com/"+v2);
        }
      })
    }else{
      $(".string_"+k).html(v);
    }
  })
  $(".active").find(".toggle").toggle();
}

</script>
