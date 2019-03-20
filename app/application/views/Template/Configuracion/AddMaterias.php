<?php
/* 
	DESARROLLO Y PROGRAMACIÓN
	PROGRAMANDOWEB.NET
	LCDO. JORGE MENDEZ
	info@programandoweb.net
*/
//pre($campo);
?>
<?php 
	if (!$this->input->is_ajax_request() && !$this->uri->segment(5)) {
		if(!empty($this->Breadcrumb)){
			echo btn_add(false,false,false);
		}
	}
	$hidden	=	array("materia_id"=>$this->uri->segment(4,0));
	$row	=	$this->Configuracion->Row;
?>
<?php echo form_open(current_url(),array('ajax' => 'true',"class"=>"form-signin"),$hidden);	?>
<div class="container">
	<div class="row justify-content-md-center">
    	<div class="col">
        	<div class="row filters">
            	<div class="col-md-3">
                </div>
                <div class="col-md-3">
	                <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                            	<i class="fas fa-id-card"></i>
                            </div>
                        </div>
	                	<?php echo set_input("materia",@$row,'Nombre de la Materia',true);?>
					</div>                        
                </div>
                <div class="col-md-3">
                	<div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                            	<i class="fas fa-id-card"></i>
                            </div>
                        </div>
	                	<?php echo MakeEstado("estatus",@$row->estatus,array("class"=>"form-control browser-default"));?>
					</div>                        
                </div>
                <div class="col-md-3">
                	
                </div>
			</div>
		</div>
	</div>
</div>
<?php echo form_close();?>
<script>
	$(document).ready(function(){
		submit_via_ajax();
		//if(parent.$(".submit").length>0){console.log(1);}		
	})
</script>