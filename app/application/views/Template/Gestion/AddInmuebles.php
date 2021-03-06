<?php
/*
	DESARROLLO Y PROGRAMACIÓN
	PROGRAMANDOWEB.NET
	LCDO. JORGE MENDEZ
	info@programandoweb.net
*/
$row									=		$data["inmueble"];
$json									=		json_decode(@$row->json);
$caracteristicas_db		=		$data["caracteristicas"];
?>

<?php
	if(empty($row) && $this->uri->segment(4)){?>
		<div class="container">
			<div class="card p-5">
				<div class="row justify-content-md-center">
					<div class="col-6 h6 text-center">
						No autorizado para ver este inmueble.
					</div>
				</div>
			</div>
		</div>
<?php
		return;
	}
?>

<?php $caracteristicas		=		GetCaracteristicas();?>
<?php echo form_open_multipart(current_url(),array('ajaxi' => 'true',"class"=>"form-signin"),array("id"=>$this->uri->segment(4),"redirect"=>"apanel"));	?>
	<div class="container">
		<div class="card p-5">
			<div class="row mb-3 justify-content-md-center">
				<div class="col-6 h6">
					<div class="btn-group btn-block" role="group" aria-label="Basic example">
						<button type="submit" class="btn btn-secondary"><i class="fas fa-upload"></i> Publicar</button>
						<a href="<?php echo base_url("apanel")?>" class="btn btn-danger"><i class="fas fa-ban mr-2"></i> Cancelar</a>
						<a target="_blank" href="<?php echo base_url(GetTipoAccion(@$row->accion_id)."/".GetTipoInmueble(@$row->tipo_inmueble)."/PGRW-".@$row->id."-".url_title(@$row->titulo))?>" class="btn btn-secondary <?php echo (!isset($row->id))?'disabled':''?>"><i class="fas fa-search mr-2"></i> Ver</a>
					</div>
				</div>
			</div>
			<div class="row justify-content-md-center">
				<div class="col-6">
					<div class="row">
						<div class="col">
							<?php echo set_input("titulo",@$row->titulo,$placeholder='Título del Inmueble',true,'text-secondary',array());?>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<?php echo set_input("codigo_manual",@$row->codigo_manual,$placeholder='Código manual',false,'text-secondary',array());?>
						</div>
					</div>
					<div class="row mt-3">
						<div class="col">
							<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <label class="input-group-text" for="inputGroupSelect01"><i class="far fa-money-bill-alt mr-2"></i> Tipo de transacción</label>
							  </div>
								<?php
										echo MakeTipoAccion('accion_id',@$row->accion_id,array("class"=>"custom-select"));
								?>
							</div>
						</div>
					</div>
					<div class="row mt-3">
						<div class="col">
							<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <label class="input-group-text" for="inputGroupSelect022"><i class="far fa-money-bill-alt mr-2"></i> Tipo de inmueble</label>
							  </div>
								<?php
										echo MakeTipoInmueble('tipo_inmueble',@$row->tipo_inmueble,array("class"=>"custom-select"));
								?>
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
			            // User entered the name of a Place that was not suggested and
			            // pressed the Enter key, or the Place Details request failed.
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
										geocodePosition(place.geometry.location);
	              }else{
	                  console.log(status)
	              }
	              $("#buscar_dir").removeAttr("readonly");
	            });
	          }
	          function geocodePosition(pos) {
						  geocoder.geocode({
						    latLng: pos
						  }, function(responses) {
								$("#responses").html(JSON.stringify(responses))
						  });
						}
						function _split(string){
							var str = string;
							var res = str.split(",");
							//console.log(res);
							return res;
						}
	        </script>
					<div class="row mb-3">
						<div class="col">
							<input name="lat" id="lat" type="hidden"  value="<?php echo @$row->lat;?>"/>
							<input name="lng" id="lng" type="hidden"  value="<?php echo @$row->lng;?>"/>
							<textarea id="responses" name="json2" style="display:none;"><?php echo @$row->json2;?></textarea>
							<?php echo set_input("direccion",@$row->direccion,$placeholder='Dirección',true,' text-secondary ',array("id"=>"buscar_dir"));?>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-6">
							<?php echo set_input("precio",@$row->precio,$placeholder='Precio Ej:15000',true,' text-secondary ');?>
						</div>
						<div class="col-6">
							<?php echo set_input("promocion",@$row->promocion,$placeholder='Promoción Ej:10000',false,' text-secondary ');?>
						</div>
					</div>
					<div class="row mb-3">
						<div class="col-3">
							<i class="fas fa-bath fa-3x"></i>
							<input type="number" name="json[banos]" value="<?php echo @$json->banos?>" id="" placeholder="Baños" class="form-control  text-secondary ">
						</div>
						<div class="col-3">
							<i class="fas fa-bed fa-3x"></i>
							<input type="number" name="json[cuartos]" value="<?php echo @$json->cuartos?>" id="" placeholder="Cuartos" class="form-control  text-secondary ">
						</div>
						<div class="col-3">
							<i class="fas fa-car fa-3x"></i>
							<input type="number" name="json[estacionamiento]" value="<?php echo @$json->estacionamiento?>" id="" placeholder="Estacionamiento" class="form-control  text-secondary ">
						</div>
						<div class="col-3">
							<i class="fas fa-home fa-3x"></i>
							<input type="number" name="json[metros]" value="<?php echo @$json->metros?>" id="" placeholder="M²" class="form-control  text-secondary ">
						</div>
					</div>
					<div class="row mt-0">
						<div class="col">
							<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <label class="input-group-text" for="inputGroupSelect02"><i class="fas fa-edit fa-3x"></i><br/> Descripción</label>
							  </div>
								<?php
									$textarea_options = array(	'class' => 'form-control h6 text-secondary',
																							'rows' => 3,
																							'cols' => 30,
																							"placeholder"=>"Ej: Excelente zona residencial, con centros comerciales y panaderías cerca");
									echo form_textarea('descripcion', @$row->descripcion,  $textarea_options);
								?>
							</div>
						</div>
					</div>
					<div class="row mt-3">
						<div class="col">
							<div class="input-group mb-3">
							  <div class="input-group-prepend">
							    <label class="input-group-text" for="inputGroupSelect03"><i class="fas fa-toggle-on mr-2"></i> Estatus</label>
							  </div>
								<?php
										$options = array(
																	'' 			=> 'Seleccione...',
																	'1'   	=> 'Activo',
																	'0'   	=> 'Inactivo',
																	'2'   	=> 'Vendido',
																	'9'   	=> 'Cancelado',

										);
										echo form_dropdown('estatus', $options, @$row->accion_id,array("class"=>"custom-select"));
								?>
							</div>
						</div>
					</div>
					<div class="row mt-0">
						<div class="col h6">
							Al publicar un aviso, admites y aceptas los Términos y Condiciones de TusitioVIP.
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="bg-grey border-grey radio_select pt-2 pb-2 pl-5 pr-5 ">
						<p class="text-secondary font-weight-light">Agregue mas fotos y venda aún más rápido (Opcional)</p>
						<div class="input-group mb-3">
							<div class="input-group mb-3">
								<div class="input-group-prepend">
									<span class="input-group-text"><i class="fas fa-camera mr-2"></i> Fotos</span>
								</div>
								<div class="custom-file">
									<input type="file" class="custom-file-input" id="inputGroupFile01">
									<label class="custom-file-label" for="inputGroupFile01">Seleccione</label>
								</div>
							</div>
						</div>
					</div>
					<div class="row mt-3" id="contenedor_imagenes">
						<div class="col-3 clone hide">
							<img src="<?php echo IMG?>no-image2.png" class="img-thumbnail" alt=""/>
						</div>
						<?php
							if($this->uri->segment(4)){
							$folder	= 	'uploads/inmuebles/'.@$row->id;
							$map 		= 	directory($folder);
								if(!empty($map["html"])){
									foreach ($map["html"]  as $key => $value) {
										$result = stripos($row->img_destacada,$map["data"][$key]);
						?>
										<div class="col-3 text-center zoom destacar <?php if($result === false ){ echo '';}else{echo 'destacar-active';}?>" data-url="<?php echo base_url("ApiRest/Push/Destacar")?>" data-id="<?php echo @$row->id;?>" data-src="<?php echo $map["data"][$key];?>">
											<img src="<?php echo $value?>" class="img-thumbnail" alt=""/>
											<a  confirm='true' data-message="¿Desea eliminar?"  href="<?php echo base_url("ApiRest/Delete/Image?redirect=".base64_encode(base_url("Gestion/Inmuebles/Add/".$this->uri->segment(4)))."&f=".base64_encode("inmuebles/".$row->id)."&fi=".base64_encode($map["data"][$key]));?>">
												<i class="fas fa-trash-alt mt-2"></i>
											</a>
										</div>
						<?php
									}
								}
							}
						?>
					</div>
					<h3>Características</h3>
					<div class="row">

						<div class="col-12  mt-2 mb-2">
							<h6 class="text-secondary input-group-text p-2 ">En el sitio</h6>
						</div>
						<?php
							foreach($caracteristicas["On-Site"] as $key => $value) {
						?>
								<div class="col-6">
									<label>
										<input
											<?php if(isset($caracteristicas_db[$value->id])){echo 'checked';};?>
											type="checkbox"
											name="caracteristica[]"
											value="<?php print($value->id) ?>"/>
										<?php print($value->caracteristica);?>
									</label>
								</div>
						<?php
							}
						?>
					</div>
					<div class="row">
						<div class="col-12 mt-2 mb-2">
							<h6 class="text-secondary input-group-text p-2">En los alrededores</h6>
						</div>
						<?php
							foreach($caracteristicas["Nearby"] as $key => $value) {
						?>
								<div class="col-6">
									<label>
										<input
											<?php if(isset($caracteristicas_db[$value->id])){echo 'checked';};?>
											type="checkbox"
											name="caracteristica[]"
											value="<?php print($value->id) ?>"/>
										<?php print($value->caracteristica);?>
									</label>
								</div>
						<?php
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php echo form_close();?>
<script>
	$(document).ready(function(){
		$(".destacar").click(function(){
			$(".destacar").removeClass("destacar-active");
			$(this).addClass("destacar-active");
			$.post($(this).data("url"),{img:$(this).data("src"),id:$(this).data("id")},function(data){

			},"json");
		});
		submit_via_ajax();
		$("#inputGroupFile01").change(function() {
			file	=		$(this).clone();
			file.removeAttr("id");
			file.addClass("custom-file-input-hide");
			file.attr("name","userfile[]");
			elem	=		$(".clone").clone();
			elem.removeClass("hide").removeClass("clone");
			img		=		elem.find("img");
			$("#contenedor_imagenes").append(elem).append(file);
			console.log(img)
			readURL(this,img);
		});
	});
	function readURL(input,img) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				img.attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	function tab(id){
		$("[name='id']").val(id)
		$("#tab1").fadeOut();
		$("#tab2").fadeIn();
		$("#Upload").attr("action","<?php echo base_url("ApiRest/Upload/Images/")?>"+id);
	}
</script>
