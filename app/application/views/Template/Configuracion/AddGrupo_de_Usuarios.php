<?php
/*
	DESARROLLO Y PROGRAMACIÓN
	PROGRAMANDOWEB.NET
	LCDO. JORGE MENDEZ
	info@programandoweb.net
*/
?>
<?php
	if (!$this->input->is_ajax_request() && !$this->uri->segment(5)) {
		if(!empty($this->Breadcrumb)){
			//echo btn_add("LB",false,false,false);
		}
	}
	$hidden=array("tipo_id"=>$this->uri->segment(4,0));
	$row			=	$this->Configuracion->Row;
	$privilegios	=	json_decode(@$row->privilegios);
?>
<?php echo form_open(current_url(),array('ajax' => 'true',"class"=>"form-signin"),$hidden);	?>

<div class="container">
	<div class="row justify-content-md-center">
    	<div class="col">
            <div class="bd-example bd-example-tabs " role="tabpanel">
                <ul class="nav nav-tabs nav-justified md-tabs indigo" id="myTab" role="tablist">
                	<?php
						$ini=0;
						foreach($modulos as $k => $v){
					?>
                        <li class="nav-item">
                            <a class="nav-link <?php if($ini==0){echo 'active';}?>" id="<?php echo $k;?>-tab" data-toggle="tab" href="#<?php echo $k;?>" role="tab" aria-controls="<?php echo $k;?>" aria-expanded="false">
                            	<?php echo $k;?>
                            </a>
                        </li>
                    <?php $ini++;
						}
					?>
                </ul>
                <div class="tab-content card pt-5" id="myTabContent">
                	<?php
						$ini=0;
						foreach($modulos as $k => $v){
					?>
                        <div role="tabpanel" class="tab-pane fade <?php if($ini==0){echo 'active show';}?>" id="<?php echo $k;?>" aria-labelledby="<?php echo $k;?>-tab" aria-expanded="false">
                        	<div class="row">
                            	<div class="col text-center">
                                	<table class="table table-striped">
                                    	<thead class="thead-light">
                                        	<tr>
                                            	<th width="100">
                                                	Privilegio
                                                </th>
												<?php
                                                    foreach($v as $k2 => $v2){

                                                ?>
                                                    <th>
                                                        <?php print($v2);?>
                                                    </th>
                                                <?php
                                                    }
                                                ?>
                                			</tr>
                                    	</thead>
                                        <tbody>
                                        	<tr>
                                            	<td width="100" title="Ver Registros">
                                                	<i class="fas fa-eye"></i>
                                                </td>
												<?php
                                                    foreach($v as $k2 => $v2){

                                                ?>
                                                    <td>
                                                        <div class="form-check">
                                                        	<?php
																if(isset($privilegios->$k->$v2)){
															?>
                                                            <?php
																	echo form_checkbox("ver[]", json_encode(array($k=>$v2)), FALSE,array("id"=>"ver".$k.$v2,"class"=>"form-check-input","checked"=>"checked"));?>
                                                            <?php
																}else{
																	echo form_checkbox("ver[]", json_encode(array($k=>$v2)), FALSE,array("id"=>"ver".$k.$v2,"class"=>"form-check-input"));?>
                                                            <?php
																}
															?>
                                                            <label class="form-check-label" for="ver<?php echo $k.$v2;?>"></label>
                                                        </div>
                                                    </td>
                                                <?php
                                                    }
                                                ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    <?php $ini++;
						}
					?>
				</div>
            </div>
		</div>
	</div>
</div>
<div class="container pt-3">
	<div class="row justify-content-md-center">
  	<div class="col">
      <div class="row filters">
        <div class="col-4">
        	<?php echo set_input("tipo",@$row,'Tipo de Usuario',true);?>
				</div>
        <div class="col-4">
        	<?php echo MakeEstado("estatus",@$row->estatus,array("class"=>"form-control browser-default"));?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo form_close();?>
<script>
	$(document).ready(function(){
		submit_via_ajax();
	})
</script>
