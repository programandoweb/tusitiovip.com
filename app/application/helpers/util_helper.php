<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
	DESARROLLADO POR JORGE MENDEZ
	programandoweb.net
	info@programandoweb.net
	Colombia - Venezuela - Chile
*/

function GetTipoAccion($id){
	$ci 			=& 	get_instance();
	return 	@$ci->db->select("nombre")
									->from(DB_PREFIJO."accion t1")
									->where("id",$id)
									->get()->row()->nombre;

}

function GetTipoInmueble($id){
	$ci 			=& 	get_instance();
	return @$ci->db->select("nombre")
												->from(DB_PREFIJO."tipo t1")
												->where("id",$id)
												->get()->row()->nombre;
}

function get_imagesInmuebles($id,$tablas="*",$main=true,$html=true,$class="img-fluid"){
	$ci 	=& 	get_instance();
	$img_url	=	IMG.'uploads/inmuebles/'.$id.'/';
	$img_path	=	PATH_IMG.'uploads/inmuebles/'.$id.'/';
	$ci->load->helper('directory');
	$map 			= 	directory_map(PATH_IMG.'uploads/inmuebles/'.$id.'/');

	if($main){
		$image_return="";
		if(file_exists($img_path.$map[0]) && !file_exists($img_path."principal.jpg")){
			//echo $img_path."principal.jpg";
			if($html){
				$image_return	= '<img src="'.$img_url.$map[0].'" class="'.$class.'"/>';
			}else {
				$image_return	= $img_url.$map[0];
			}
		}else	if(file_exists($img_path.$map[0]) && file_exists($img_path."principal.jpg")){
				if($html){
					$image_return	= '<img src="'.$img_url.'principal.jpg?rand='.rand(100,60000).'" class="'.$class.'"/>';
				}else {
					$image_return	= $img_url.$map[0];
				}
		}else{
			if($html){
				$image_return	= '<img src="'.IMG.'no-image2.png" class="'.$class.'"/>';
			}else {
				$image_return	= IMG."no-image2.png";
			}
		}
		return $image_return;
	}else{
		$images	=	array();
		foreach ($map as $key => $value) {
			if(file_exists($img_path.$value)){
				if($html){
					$images[]	= '<img src="'.$img_url.$value.'" class="'.$class.'"/>';
				}else {
					$images[]	= $img_url.$value;
				}
			}else{
				if($html){
					$images[]	= '<img src="'.IMG.'no-image2.png" class="'.$class.'"/>';
				}else {
					$images[]	= IMG."no-image2.png";
				}
			}
		}
		return $images;
	}
}

function directory($folder){
	$ci 	=& 	get_instance();
	$ci->load->helper('directory');
	$return = array();
	$map=directory_map(PATH_IMG.$folder);
	foreach ($map as $key => $value) {
		if($value!='index.html'){
			$return[$key]		=		IMG.$folder.'/'.$value;
		}
	}
	return $return;
}

function get_portada($perfil_id){
	$img_path	=	PATH_IMG.'uploads/'.$perfil_id.'/portada.jpg';
	if(file_exists($img_path)){
		return IMG.'uploads/'.$perfil_id.'/portada.jpg';
	}else{
		return IMG."design/portada.jpg";
	}
}

function get_avatar($perfil_id){
	$img_path	=	PATH_IMG.'uploads/'.$perfil_id.'/avatar.jpg';
	if(file_exists($img_path)){
		return IMG.'uploads/'.$perfil_id.'/avatar.jpg';
	}else{
		return IMG."design/avatar.jpg";
	}
}

function template_header($replace=''){
	$html 	=	file_get_contents(PATH_BASE_APP.'../'.TEMPLATE.'/header.php');
	return 	str_replace(array("{htm}","{metatags}","{template}"), array(DOMINIO,$replace,TEMPLATE),$html);
}

function template_footer(){
	$html 	=	file_get_contents(PATH_BASE_APP.'../'.TEMPLATE.'/footer.php');
	return 	str_replace(array("{htm}","{template}"), array(DOMINIO,TEMPLATE),$html);
}

function session_flash(){
	$ci 	=& 	get_instance();
	if($error = $ci->session->flashdata('error')){
		echo '<div class="alert alert-danger">';
		echo $error;
		echo '<i class="glyphicon glyphicon-alert"></i></div>';
	}elseif($info = $ci->session->flashdata('info')){
		echo '<div class="alert alert-info">';
		echo $info;
		echo '<i class="glyphicon  glyphicon-ok"></i></div>';
	}else if($success = $ci->session->flashdata('success')){
		echo '<div class="alert alert-success">';
		echo $success;
		echo '<i class="glyphicon  glyphicon-ok"></i></div>';
	}else if($success = $ci->session->flashdata('danger')){
		echo '<div class="alert alert-danger">';
		echo $success;
		echo '<i class="glyphicon  glyphicon-ok"></i></div>';
	}
}

function View($view,$data=array(),$Apanel=""){
	$ci =& 	get_instance();
	$ci->file_exists = file_exists(PATH_VIEW.'/Template/'.$view.'.php');
	$ci->load->view('Template/Header'.$Apanel);
	if($Apanel=='_Apanel'){
		$ci->load->view('Template/Apanel/Menu');
	}
	$ci->load->view('Template/Flash');
	if(isset($ci->Breadcrumb_bool) && $ci->Breadcrumb_bool){
		$ci->load->view('Template/Breadcrumb');
	}
	if($ci->file_exists){
		$ci->load->view('Template/'.$view,$data);
	}else{
		$ci->load->view('Template/Error_NoView',array("View"=>$view));
	}
	$ci->load->view('Template/Footer'.$Apanel);
}

function post($var=""){
	$ci 	=& 	get_instance();
	if($var==''){
		return $ci->input->post();
	}else{
		return $ci->input->post($var, TRUE);
	}
}

function get($var=""){
	$ci 	=& 	get_instance();
	if($var==''){
		return $ci->input->get();
	}else{
		return $ci->input->get($var, TRUE);
	}
}

function logs($user,$tipo_transaccion,$tabla_afectada,$registro_afectado_id=NULL,$modulo_donde_produjo_cambio=NULL,$accion=1,$json=array()){
	$ci 	=& 	get_instance();
	$ci->db->insert(DB_PREFIJO."sys_logs",array(
									"fecha"=>date("Y-m-d H:i:s"),
									"usuario_id"=>$user->usuario_id,
									"tipo_transaccion"=>$tipo_transaccion,
									"tabla_afectada"=>$tabla_afectada,
									"registro_afectado_id"=>$registro_afectado_id,
									"modulo_donde_produjo_cambio"=>$modulo_donde_produjo_cambio,
									"accion"=>$accion,
									"json"=>json_encode($json)));

}

function ini_session($user){
	$ci 	=& 	get_instance();
	$session_id		=	md5(date("Y-m-d H:i:s"));
	if(is_object($user)){
		$user->session_id		=	$session_id;
		$insert					=	$ci->db->insert(DB_PREFIJO."sys_session",array(	"fecha"=>date("Y-m-d H:i:s"),
																					"usuario_id"=>$user->usuario_id,
																					"session_id"=>$user->session_id));
	}else if(is_array($user)){
		$user['session_id']		=	$session_id;
		$insert					=	$ci->db->insert(DB_PREFIJO."sys_session",array(	"fecha"=>date("Y-m-d H:i:s"),
																					"usuario_id"=>$user["usuario_id"],
																					"session_id"=>$user["session_id"]));
	}
	if($insert){
		return $user;
	}else{
		return false;
	}
}

function chequea_session($user){
	$ci 					=& 	get_instance();
	$session				=	$ci->db->select('*')->from(DB_PREFIJO."sys_session")->where('session_id',$user->session_id)->get()->row();
	$fechaGuardada 			= 	@$session->fecha;
	$ahora 					= 	date("Y-m-d H:i:s");
	$tiempo_transcurrido 	= 	(strtotime($ahora)-strtotime($fechaGuardada));
	if($tiempo_transcurrido>=SESSION_TIME){
		if (!$ci->input->is_ajax_request()) {
			redirect(base_url("autenticacion/salir"));
		}else{
			echo '<script>parent.location.reload();</script>';
		}
	}else{
		$ci->db->where('session_id', $user->session_id);
		$ci->db->update(DB_PREFIJO."sys_session",array("fecha"=>$ahora));
	}
}

function tiempo_session($user){
	$ci 					=& 	get_instance();
	$session				=	$ci->db->select('*')->from(DB_PREFIJO."sys_session")->where('usuario_id',$user->usuario_id)->get()->row();
	$fechaGuardada 			= 	$session->fecha;
	$ahora 					= 	date("Y-m-d H:i:s");
	$tiempo_transcurrido 	= 	(strtotime($ahora)-strtotime($fechaGuardada));
	$user->session_id		=	$session->session_id;
	if($tiempo_transcurrido>=SESSION_TIME){
		destruye_session($user);
		return ini_session($user);
	}else{
		return false;
	}
}

function destruye_session($user){
	$ci 					=& 	get_instance();
	if(is_object($user)){
		$ci->db->where('session_id', $user->session_id);
		$ci->db->delete(DB_PREFIJO."sys_session");
		return true;
	}else{
		$ci->db->where('session_id', $user["session_id"]);
		$ci->db->delete(DB_PREFIJO."sys_session");
		return true;
	}
}

function Destroy($session_id){
	$ci 					=& 	get_instance();
	$ci->db->where('session_id', $session_id);
	$ci->db->delete(DB_PREFIJO."sys_session");
}

function answers_json($array){
	return json_encode($array);
}

function menu($tipo_id=NULL,$modulos,$no_listas=array()){
	$menu=null;
	if(!is_null($tipo_id) && $tipo_id>0){
		$ci 	=& 	get_instance();
		$tabla						=	DB_PREFIJO."tipo_usuarios";
		$ci->db->select("*")->from($tabla);
		if(!empty($tipo_id)){
			$ci->db->where("tipo_id",$tipo_id);
		}
		$roles						=	$ci->roles					=	$ci->db->get()->row();
		$menu_						=	json_decode($roles->privilegios);
		foreach($menu_ as $k =>$v){
			foreach($v as $key => $value){
				$menu[$k][]		=	$key;
			}
		}
	}else{
		foreach($modulos as $k =>$v){
			foreach($v as $k2 => $v2){
				if(!in_array($v2,$no_listas)){
					$menu[$k]	=	$v;
				}
			}

		}

	}
	return $menu;
}

function set_input($name,$row,$placeholder='',$require=false,$class='',$extra=NULL){
	$data = array(
		'type' 			=> 	(isset($extra["type"]))?$extra["type"]:'text',
		'name'  		=> 	$name,
		'id'    		=> 	@$extra["id"],
		'placeholder' 	=> 	$placeholder,
		'class' 		=> 	'form-control '.$class
	);
	if(is_array($extra)){
		foreach($extra as $k => $v){
			$data[$k]	=	$v;
		}
	}
	if($require){
		$data['require']=	$require;
	}
	if(is_object($row)){
		if(isset($row->$name)){
			$data['value']	=	set_value($name, $row->$name);
		}
	}else if(!empty($row)){
		$data['value']	=	 $row ;
	}
	echo form_input($data);
}

function btn_add($add=true,$print=true,$excel=true,$back=false){
	$ci=&get_instance();
	if($ci->input->is_ajax_request() || $ci->uri->segment(5)=='Iframe'){return;}
	$return 	=	'<div class="container">';
		$return 	.=	'<div class="section_">';
			$return 	.=	'<div class="row">';
				$return 	.=	'<div class="col-md-6">';
					$return 	.=	'<h3>';
						$return 	.=	$ci->Breadcrumb;
					$return 	.=	'</h3>';
				$return 	.=	'</div>';
				$return 	.=	'<div class="col-md-6">';
					$return 	.=	'<div class="btn-group float-right" role="group" aria-label="Basic example">';
						if($add){
							if($add=="NL"){
								$return 	.=	'<a href="'.current_url().'/Add/" title="Agregar Registro" class="btn btn-primary "><i class="fas fa-plus"></i></a>';
							}else if($add=="LG"){
								$return 	.=	'<a href="'.current_url().'/Add/0/Iframe" title="Agregar Registro" class="btn btn-primary lightbox" data-type="iframe" data-form="true" data-size="modal-lg" data-btnsuccess="true" ><i class="fas fa-plus"></i></a>';
							}else{
								$return 	.=	'<a href="'.current_url().'/Add/0/Iframe" title="Agregar Registro" class="btn btn-primary lightbox" data-type="iframe" data-form="true" data-size="modal-md" data-btnsuccess="true" ><i class="fas fa-plus"></i></a>';
							}
						}
						if($print){
							$return 	.=	'<a href="'.current_url().'/Print" title="Procesar Impresión" class="btn btn-primary"><i class="fas fa-print"></i></a>';
						}
						if($excel){
							$return 	.=	'<a href="'.current_url().'/Excel" title="Exportar a Excel" class="btn btn-primary"><i class="fas fa-file-excel"></i></a>';
						}
						if($back){
							//pre($back);
							if($back==true){
								if (isset($_SERVER['HTTP_REFERER'])){
									$url = $_SERVER['HTTP_REFERER'];
								}else{
									$url = base_url("Apanel");
								}
								$return 	.=	'<a href="'.$url.'" title="Regresar" class="btn btn-primary "><i class="fas fa-chevron-left"></i></a>';
								//$return 	.=	'<a  title="Volver atrás" class="btn btn-primary historyback" ><i class="fas fa-chevron-left"></i></a>';
							}else{
								//$return 	.=	'<a href="'.$back.'" title="Agregar Registro" class="btn btn-primary "><i class="fas fa-chevron-left"></i></a>';
							}
						}
					$return 	.=	'</div>';
				$return 	.=	'</div>';
			$return 	.=	'</div>';
		$return 	.=	'</div>';
	$return 	.=	'</div>';
	return $return;
}

function columnas($campo){
	$return		=	'';
	$lastkey 	= 	count($campo) - 1;
	$count		=	0;
	foreach($campo as $k => $v){
		if($count==$lastkey || $k=='estatus' || $k=='id'){
			$return		.=	'<th data-columna="'.$k.'" width="30" class="text-center">';
		}else{
			$return		.=	'<th data-columna="'.$k.'">';
		}
			$return		.=	$v;
		$return		.=	'</th>';
		$count++;
	}
	return $return;
}

function foreach_edit($data){
	$return	=	array();
	foreach($data as $k => $v){
		$id	=	'';
		foreach($v as $k2 => $v2){
			if($k2=='id'){
				$id	=	$v2;
			}
			if($k2=='nombre'){
				$nombre	=	$v2;
			}
			$explode	=	explode("::",$k2);
			if($k2=="edit"){
				$return[$k][$k2]	=		'<a class="edit lightbox" title="Editar" data-btnsuccess="true" data-type="iframe" data-form="true" data-size="modal-lg" href="'.current_url().'/Add/'.$id.'/Iframe"><i class="fas fa-edit"></i></a>';
			}else if($k2=="estatus"){
				$return[$k][$k2]	=		($v2==1)?'Activo':'Inactivo';
			}else if($explode[0]=="json" && isset($explode[1])){
				$json_decode				=	json_decode($v->json);
				$label							=	$explode[1];
				$return[$k][$label]	=	@$json_decode->$label;
			}else if($k2=="nombre_frontOffice"){
				$return[$k][$k2]	=		'<a target="_blank" title="Ver" href="'.base_url($v2.$id).'-BackOffice">'.$nombre.' <i class="fas fa-search"></i></a>';
			}else if($k2=="json"){
				$return[$k][$k2]			=		$v2;
				$return[$k]["nombres"]		=		@json_decode($v2)->nombres .' '.@json_decode($v2)->apellidos;
				$return[$k]["ciudad"]		=		@json_decode($v2)->ciudad;
				$return[$k]["departamento"]	=		@json_decode($v2)->departamento;
				$return[$k]["title"]					=	@json_decode($v2)->name;
			}else{
				$return[$k][$k2]	=		$v2;
			}
			if(@$return[$k]["title"]==''){
				@$return[$k]["title"]=$v->title;
			}
		}
	}
	return $return;
}

function FormNoHeader($view,$data=array(),$Apanel="_Apanel"){
	$return;
	$ci 	=& 	get_instance();
	$ci->file_exists = file_exists(PATH_VIEW.'/Template/'.$view.'.php');
	$ci->load->view('Template/Header'.$Apanel);
	if($Apanel=='_Apanel'){
		//$ci->load->view('Template/Apanel/Menu');
	}
	$ci->load->view('Template/Flash');
	if(isset($ci->Breadcrumb_bool) && $ci->Breadcrumb_bool){
		$ci->load->view('Template/Breadcrumb');
	}
	if($ci->file_exists){
		$ci->load->view('Template/'.$view,$data);
	}else{
		$ci->load->view('Template/Error_NoView',array("View"=>$view));
	}
	$ci->load->view('Template/Footer'.$Apanel,array("hide"=>true));
}

function MakeEstado($name,$estado=null,$extra=array()){
	$options = array(
		'1'         => 'Activo',
		'0'       => 'Inactivo'
	);
	return form_dropdown($name, $options, $estado,$extra);
}

function menu_encode($var){
	$items 	= 	array();
	foreach($var["ver"] as $v){
		$json		=	json_decode($v);
		foreach($json as $key => $value){
			$items[$key][$value]	=	1;
		}
	}
	return json_encode($items);
}

function View2($view,$data=array(),$Apanel="_Apanel"){
	$ci =& 	get_instance();
	$ci->file_exists = file_exists(PATH_VIEW.'/Template/'.$view.'.php');
	$ci->load->view('Template/Header'.$Apanel);
	if($Apanel=='_Apanel'){
		$ci->load->view('Template/Apanel/Menu');
	}
	$ci->load->view('Template/Flash');
	if(isset($ci->Breadcrumb_bool) && $ci->Breadcrumb_bool){
		$ci->load->view('Template/Breadcrumb');
	}
	if($ci->file_exists){
		$ci->load->view('Template/'.$view,$data);
	}else{
		$ci->load->view('Template/Error_NoView',array("View"=>$view));
	}
	$ci->load->view('Template/Footer'.$Apanel);
}

function View3($view,$data=array()){
	$ci =& 	get_instance();
	$ci->file_exists = file_exists(PATH_VIEW.'/Template/'.$view.'.php');
	$ci->load->view('Template/Header_Profile');
	$ci->load->view('Template/Flash');
	if($ci->file_exists){
		$ci->load->view('Template/'.$view,$data);
	}else{
		$ci->load->view('Template/Error_NoView',array("View"=>$view));
	}
	$ci->load->view('Template/Footer');
}

function FormNoHeader2($view,$data=array(),$Apanel="_Apanel"){
	$return;
	$ci 	=& 	get_instance();
	$ci->file_exists = file_exists(PATH_VIEW.'/Template/'.$view.'.php');
	$ci->load->view('Template/Header'.$Apanel);
	if($Apanel=='_Apanel'){
		$ci->load->view('Template/Apanel/Menu');
	}
	$ci->load->view('Template/Flash');
	if(isset($ci->Breadcrumb_bool) && $ci->Breadcrumb_bool){
		$ci->load->view('Template/Breadcrumb');
	}
	if($ci->file_exists){
		$ci->load->view('Template/'.$view,$data);
	}else{
		$ci->load->view('Template/Error_NoView',array("View"=>$view));
	}
	$ci->load->view('Template/Footer'.$Apanel);
}

function MakeTipoAccion($name,$estado=null,$extra=array()){
	$ci 			=& 	get_instance();
	$return		= 	$ci->db->select("*")
												->from(DB_PREFIJO."accion t1")
												->get()->result();
	$options 	= [];
	foreach ($return as $key => $value) {
		$options[$value->id]	=	$value->nombre;
	}
	return form_dropdown($name, $options, $estado,$extra);
}

function MakeTipoInmueble($name,$estado=null,$extra=array()){
	$ci 			=& 	get_instance();
	$return		= 	$ci->db->select("*")
												->from(DB_PREFIJO."tipo t1")
												->get()->result();
	$options 	= [];
	foreach ($return as $key => $value) {
		$options[$value->id]	=	$value->nombre;
	}
	return form_dropdown($name, $options, $estado,$extra);
}

function UploadAjaxImage($selector="#demo1"){
	$js	=	'
				<form id="Upload" method="post" action="" enctype="multipart/form-data">
					<h3>Fotos del inmueble</h3>
					<label><input class="btn btn-info" type="file" name="userfile" id="demo1" /></label>
					<div id="uploads">
					</div>
				</form>
				<script type="text/javascript">
						$(document).ready(function() {
							$("'.$selector.'").AjaxFileUpload({
								selector_action:"#Upload",
								onComplete: function(filename, response) {
									$("#uploads").append(
										$("<img />").attr("src", response.name).attr("width", 200)
									);
								}
							});
						});
				</script>';
		echo $js;
}

function pre($var){
	echo '<pre>';
		print_r($var);
	echo '</pre>';
}

function upload($file='userfile',$path='images/uploads/',$config=array("allowed_types"=>'gif|jpg|png',"max_size"=>100,"max_width"=>1024,"max_height"=>768)){
	$config['upload_path']        = 	PATH_BASE.'/'.$path;
	if(!is_dir($config['upload_path'])){
		if(!mkdir($config['upload_path'], 0755,true)){
			return false;
		}else{
			$fp		=	fopen($config['upload_path'].'/index.html',"w");
			fwrite($fp,'<a href="http://programandoweb.net">PROGRAMANDOWEB</a>');
			fclose($fp);
		}
	}
	$config['encrypt_name']       = 	TRUE;

	if(isset($config['renombrar'])){
		$nuevo_nombre	=	$config['renombrar'];
		unset($config['renombrar']);
	}

	$ci 	=& 	get_instance();
	$ci->load->library('upload', $config);
	//print_r($file);return;
	if(isset($_FILES[$file])){
		if ( ! $ci->upload->do_upload($file)){
			return array('error' => $ci->upload->display_errors());
		}
		else{
			$upload_data	=	$ci->upload->data();
			$upload_data['imagen_nueva']	=	DOMINIO.'/'.$path.$nuevo_nombre.$upload_data['file_ext'];
			rename($upload_data['full_path'],$upload_data['file_path'].$nuevo_nombre.$upload_data['file_ext']);
			$upload_data['nuevo_nombre']	=	$nuevo_nombre.$upload_data['file_ext'];
			return array('upload_data' => $upload_data);
		}
	}
}

function upload_multiple($file='userfile',$path='images/uploads/',$config=array("allowed_types"=>'gif|jpg|png',"max_size"=>100,"max_width"=>1024,"max_height"=>768)){
	$config['upload_path']        = 	PATH_BASE.'/'.$path;
	if(!is_dir($config['upload_path'])){
		if(!mkdir($config['upload_path'], 0755,true)){
			return false;
		}else{
			$fp		=	fopen($config['upload_path'].'/index.html',"w");
			fwrite($fp,'<a href="http://programandoweb.net">PROGRAMANDOWEB</a>');
			fclose($fp);
		}
	}
	$config['encrypt_name']       = 	TRUE;
	$ci 	=& 	get_instance();
	$ci->load->library('upload', $config);
	$returns=$upload_data		=		array();
	if(is_array($file)){
		foreach ($file["name"] as $key => $value) {
			$nuevo_nombre		=	"PGRW_".rand(1000,90000);
			$_FILES['userfile']['name']   	= 	$file['name'][$key];
			$_FILES['userfile']['type']  		= 	$file['type'][$key];
			$_FILES['userfile']['tmp_name'] = 	$file['tmp_name'][$key];
			$_FILES['userfile']['error'] 		= 	$file['error'][$key];
			$_FILES['userfile']['size'] 		= 	$file['size'][$key];
			if ( ! $ci->upload->do_upload("userfile")){
				$returns[] 										=		$upload_data[$key]		= 	array('error' => $ci->upload->display_errors());
			}
			else{
				$upload_data									=		$ci->upload->data();
				$upload_data['imagen_nueva']	=		DOMINIO.'/'.$path.$nuevo_nombre.$upload_data['file_ext'];
				rename($upload_data['full_path'],	$upload_data['file_path'].$nuevo_nombre.$upload_data['file_ext']);
				$upload_data['nuevo_nombre']	=		$nuevo_nombre.$upload_data['file_ext'];
				$returns[] 										= 	array('upload_data' => $upload_data);
			}

		}
	}
	return $returns;
}

function usuarios_x_id($id){
	$ci 	=& 	get_instance();
	$tabla						=	DB_PREFIJO."usuarios";
	return $ci->db->select("*")->from($tabla)->where("usuario_id",$id)->get()->row();
}

function usuarios_x_login($login){
	$ci 	=& 	get_instance();
	$tabla						=	DB_PREFIJO."usuarios";
	return $ci->db->select("*")->from($tabla)->where("email",$login)->or_where("login",$login)->get()->row();
}

function usuarios_x_token($token){
	$ci 	=& 	get_instance();
	$tabla						=	DB_PREFIJO."usuarios";
	return $ci->db->select("*")->from($tabla)->where("token",$token)->get()->row();
}

?>
