<section class="slider" id="buscador">
  <div class="jumbotron top shadow" style="background-image:url(<?php echo IMG?>design/top_programandoweb.jpg); ">
    <div class="container">
      <div class="row">
        <div class="col-12 col-sm-5 text-white form-white">
          <h4>Busca <b>tú</b> inmueble por ubicación</h4>
          <?php echo form_open(base_url("buscador/de-inmuebles"),array('ajax1' => 'true',"class"=>"form-signin","method"=>"get"));	?>
            <div class="input-group mb-3">
              <div class="input-group-prepend">
                <div class="dropdown">
                  <button data-default="¿Qué Buscas?" class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    ¿Qué Buscas?
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <button data-value=""  class="dropdown-item accion_id" href="#">Todos</button >
                    <button data-value="1" class="dropdown-item accion_id" href="#">Venta</button >
                    <button data-value="3" class="dropdown-item accion_id" href="#">Alquiler</button >
                  </div>
                </div>
              </div>
              <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyASilt304sHIqv3IYyo_Chr04MVK5HrjsM&libraries=places&callback=initialize"  async defer></script>
              <script type="text/javascript">
    	          var geocoder;
    	          var marker;
    	          var latLng;
    	          var latLng2;
    	          var map;
    	          function initialize(_xloa, _yloa) {
    	            geocoder = new google.maps.Geocoder();
    	            if(true){
    	              latLng = new google.maps.LatLng("10.1579312", "-67.99721039999997");
    	            } else{
    	              latLng = new google.maps.LatLng(_xloa, _yloa);
    	            }
    	            var input = document.getElementById('buscar_dir');
    	            var autocomplete = new google.maps.places.Autocomplete(input);
                  autocomplete.setComponentRestrictions({'country': ['ve']});
    							autocomplete.addListener('place_changed', function() {
    								var place = autocomplete.getPlace();
    			          if (!place.geometry) {
    			            window.alert("No details available for input: '" + place.name + "'");
    			            return;
    			          }
    								if (place.geometry.viewport) {
    									codeAddress(place);
    								}
    							})

    	          }
    	          function codeAddress(place) {
    	            $("#buscar_dir").attr("readonly","readonly");
    	            var address = $("#buscar_dir").val();
    	              geocoder.geocode( { 'address': address}, function(results, status) {
    	              if (status == google.maps.GeocoderStatus.OK) {
    										$("#lat").val(place.geometry.location.lat());
    										$("#lng").val(place.geometry.location.lng());
    	              }
    	              $("#buscar_dir").removeAttr("readonly");
    	            });
    	          }
                $(document).ready(function(){
                  $(".accion_id").click(function(){
                    $("#accion_id").val($(this).data("value"))
                  })
                })
    	        </script>
              <input name="accion_id" id="accion_id" type="hidden"  value="<?php echo @$row->accion_id;?>"/>
              <input name="lat" id="lat" type="hidden"  value="<?php echo @$row->lat;?>"/>
              <input name="lng" id="lng" type="hidden"  value="<?php echo @$row->lng;?>"/>
              <?php echo set_input("direccion",NULL,"Dónde lo quieres?",true,' text-secondary ',array("id"=>"buscar_dir"));?>
              <div class="input-group-append">
                <button class="input-group-text" type="submit"><i class="fas fa-search"></i></button>
              </div>
  					</div>
          <?php echo form_close();?>
        </div>
      </div>
    </div>
  </div>
</section>
<section id="destacados">
  <div class="container mb-5">
    <div class="row">
      <div class="col mb-3">
        <h3 class="text-center"><i class="fas fa-building"></i> Destacados</h3>
      </div>
    </div>
    <div class="row">
      <div class="col-12 col-sm-3">
        <div class="card">
          <img src="<?php echo IMG?>design/01.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Venta</h5>
            <p class="card-text">Urbanización El Trigal Norte</p>
            <a href="#" class="btn btn-primary">Quiero verlo</a>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-3">
        <div class="card">
          <img src="<?php echo IMG?>design/02.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Alquiler</h5>
            <p class="card-text">Urbanización El Trigal Norte</p>
            <a href="#" class="btn btn-primary">Quiero verlo</a>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-3">
        <div class="card" >
          <img src="<?php echo IMG?>design/03.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Venta</h5>
            <p class="card-text">Urbanización El Trigal Norte</p>
            <a href="#" class="btn btn-primary">Quiero verlo</a>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-3">
        <div class="card">
          <img src="<?php echo IMG?>design/04.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Alquiler</h5>
            <p class="card-text">Urbanización El Trigal Norte</p>
            <a href="#" class="btn btn-primary">Quiero verlo</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<section id="banenr-central" class="parallax parallax-one shadow">
  <div class="container">
    <div class="row justify-content-md-center">
      <div class="col-2">
        <svg  class="svg-grey"
                xmlns="http://www.w3.org/2000/svg"
                version="1.1"
                width="100%"
                height="40"
                viewBox="0 0 100 102"
                preserveAspectRatio="none">
                <path  d="M0 0 L50 100 L100 0 Z"></path>
          </svg>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row pt-4 pb-4  text-whites">
      <div class="col">
        <h1 class="text-center">Vende o Alquila <b>tú</b> inmueble</h1>
        <h2 class="text-center">Nosotros nos encargamos de todo lo demás</h2>
      </div>
    </div>
  </div>
</section>
<section id="banner-1" class="shadow bg-one">
  <div class="container-fluid">
    <div class="row overflow-hide">
      <div class="col-12 col-sm-2 mt-negativo">
        <img src="<?php echo IMG?>design/ventas-vendedor.png" />
      </div>
    </div>
  </div>
</section>
<section id="bloque-button" class="shadow bg-white">
  <div class="container text-center p-5">
    <div class="row">
      <div class="col-12 col-sm-4">
        <h3>Atención personalizada</h3>
        <p>Asignamos un promotor que lo acompañe durante todo el proceso</p>
      </div>
      <div class="col-12 col-sm-4">
        <div class="text-center">
          <i class="fas fa-headset fa-5x"></i>
        </div>
        <h3>Atención telefónica</h3>
        <p>+58(241)8260000</p>
      </div>
      <div class="col-12 col-sm-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">No te pierdas de nada</h5>
            <p class="card-text">Suscríbete a nuestros boletine</p>
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Su Correo electrónico" aria-label="Recipient's username" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <span class="input-group-text" id="basic-addon2">Suscribirme</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
