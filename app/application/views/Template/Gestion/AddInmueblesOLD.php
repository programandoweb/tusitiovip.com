<?php
/*
	DESARROLLO Y PROGRAMACIÓN
	PROGRAMANDOWEB.NET
	LCDO. JORGE MENDEZ
	info@programandoweb.net
*/
$row=$data;
?>
<?php echo form_open_multipart(current_url(),array('ajax' => 'true',"class"=>"form-signin"),array("id"=>$this->uri->segment(4)));	?>
<div class="container" id="tab1">
	<div class="row justify-content-md-center">
		<div class="col">
			<div class="row mb-3">
				<div class="col-6">
	        <div class="md-form mt-0 mb-0">
						<input type="hidden" name="callback" value="tab" />
	          <?php echo set_input("titulo",@$row->titulo,$placeholder='Título del Inmueble',true,'',array());?>
	        </div>
				</div>
				<div class="col-2">
					<div class="md-form mt-0 mb-0">
						<?php
							echo MakeTipoAccion("accion_id",@$row->accion_id,'class="custom-select"');
						?>
					</div>
				</div>
				<div class="col-2">
					<div class="md-form mt-0 mb-0">
						<?php
							echo MakeTipoInmueble("tipo_inmueble",@$row->tipo_inmueble,'class="custom-select"');
						?>
					</div>
				</div>
				<div class="col-2">
					<div class="md-form mt-0 mb-0">
						<?php echo set_input("precio",@$row->precio,$placeholder='Precio',true,'',array());?>
					</div>
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-12">
	        <div class="md-form mt-0 mb-0">
	          <?php echo set_input("direccion",@$row->direccion,$placeholder='Dirección',true,'',array());?>
	        </div>
				</div>
      </div>
			<div class="row mb-3 ">
				<div class="col-12">
	        <div class="md-form mt-0 mb-0">
						<textarea class="form-control" rows="6" cols="100" name="descripcion" placeholder="Descripcion"><?php echo (isset($row->descripcion)?$row->descripcion:''); ?></textarea>
	        </div>
				</div>
      </div>
			<!--div class="row mb-3">
				<div class="col-12">
	        <div class="md-form mt-0 mb-0">
						<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAjazpmebK2Cz3__1Uzxy3ssRZ9nRUxC6s"></script>
			      <script type="text/javascript" src="<?php echo base_url('Templates/default/assets/js/map.js') ?>"></script>

			      <div id="map" class="mb-3" style="width:100%; height:300px;"></div>
			      <div class="form-group input-group">
			        <input id="lat" class="form-control" name="ubicacion" readonly="false" value="<?php echo (isset($anuncio->ubicacion)?$anuncio->ubicacion:''); ?>" type="text"/>
			      </div>
	        </div>
				</div>
      </div-->
			<div class="row mb-3">
				<div class="col-6">
					<button class="btn btn-primary" type="submit"><i class="fas fa-camera"></i> Subir fotos del inmueble</button>
				</div>
			</div>
    </div>
	</div>
</div>
<?php echo form_close();?>
<div class="container" id="tab2" style="display:none;">
	<div class="row mb-3">
		<div class="col-6">
			<div class="md-form mt-0 mb-0">
				<?php echo UploadAjaxImage();?>
			</div>
		</div>
	</div>
</div-->
<script>
	$(document).ready(function(){
		submit_via_ajax();
	})
	function tab(id){
		$("[name='id']").val(id)
		$("#tab1").fadeOut();
		$("#tab2").fadeIn();
		$("#Upload").attr("action","<?php echo base_url("ApiRest/Upload/Images/")?>"+id);
	}
</script>
