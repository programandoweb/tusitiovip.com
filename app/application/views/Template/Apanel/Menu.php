<?php
	$menu	=	menu($this->user->tipo_id,$this->Menu);
?>
<header>
	<nav class="navbar navbar-expand-sm navbar-dark bg-dark yamm m-0">
    	<div class="container">
            <a class="navbar-brand" href="<?php echo base_url("apanel")?>">
                <img src="<?php echo IMG?>logo-xs.png" alt="<?php echo SEO_TITLE?>" />
            </a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse collapse" id="navbarCollapse" style="">
                <ul class="navbar-nav mr-auto mt-2 mt-md-0 balancear">
                    <!--li class="nav-item <?php if(!$this->uri->segment(1)){echo 'active';}?>">
                        <a class="nav-link" href="<?php echo base_url("apanel")?>">
                            <i class="fas fa-home fa-2x"></i>
                        </a>
                    </li-->
                    <?php foreach($menu as $k => $v){?>
                        <li class="nav-item dropdown <?php if($this->uri->segment(1)==$k){echo 'active';}?>">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php print($k)?> <i class="fas fa-tasks"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <?php
									foreach($v as $k2 => $v2){
										if (strpos($v2, 'Index') === false && strpos($v2, 'Add') === false){
								?>
                                            <a class="dropdown-item" href="<?php echo base_url($k.'/'.$v2)?>">
                                                <?php print(str_replace("_"," ",$v2));?>
                                            </a>
                    			<?php
										}
									}
								?>
                            </div>
                        </li>
                    <?php }?>
                </ul>
                <ul class="navbar-nav ml-auto hidden-sm-up hidden-md-up">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="chip chip-md blue-gradient white-text">
	                            <img style="width:30px;" src="<?php echo IMG?>image.png" alt="<?php print($this->user->login);?>"> <?php print($this->user->login);?>
                            </div>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        	<a class="dropdown-item " data-toggle="modal" data-target="#cpassword">Cambiar Contraseña</a>
							<a class="dropdown-item" href="<?php echo base_url("Autenticacion/Salir")?>">Cerrar Sesión</a>
						</div>
                    </li>
                </ul>
            </div>
		</div>
	</nav>
    <div class="progress primary-color-dark">
	    <div class="indeterminate"></div>
    </div>
</header>
<?php
	//pre($menu);
?>
<script>
	$(function() {
		window.prettyPrint && prettyPrint()
		$(document).on('click', '.yamm .dropdown-menu', function(e) {
			e.stopPropagation();
		})
	})
</script>
<?php echo form_open(base_url("ApiRest/User/Password"),array('ApiRest' => 'true','data-method'=>'PUT',"class"=>"form-pass",'autocomplete'=>"off"),array("token"=>$this->user->token));	?>
    <div class="modal fade right" id="cpassword" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-side modal-top-right" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title w-100" id="myModalLabel">Cambio de Contraseña</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row justify-content-md-center">
                        <div class="md-form col-md-12 mt-0 mb-0">
                            <?php echo set_input("password",null,$placeholder='Password',true,'form-control  password',array("id"=>"password","password"=>"true","data-rel"=>"password2"));?>
                        </div>
                        <div class="md-form col-md-12 mt-0 mb-0">
                            <?php echo set_input("",null,$placeholder='Repita el Password',true,'form-control  password ',array("id"=>"password2","password"=>"true","data-rel"=>"password"));?>
                        </div>
                        <div class="md-form col-md-12 mt-0 mb-0" id="password_error">
                        </div>
                    </div>
                </div>
                <!--Footer-->
                <div class="modal-footer">
                    <button type="submit" id="submit_pass" class="btn btn-primary disabled">Guardar Clave</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>
<?php echo form_close();?>
