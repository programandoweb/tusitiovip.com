<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ApiRest extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->user			=	$this->session->userdata('User');
		if(empty($this->user) && $this->uri->segment(4)!='Upload'){
			redirect(base_url("Main"));	return;
		}
  }

	public function Get(){
		$metodo	=	$this->uri->segment(3);
		$this->$metodo();
	}

	public function Push(){
		$metodo	=	$this->uri->segment(3);
		$this->$metodo();
	}

	public function Delete(){
		$metodo	=	$this->uri->segment(3);
		$this->$metodo();
	}

	public function Post(){
		$metodo	=	$this->uri->segment(3);
		$this->$metodo();
	}

	public function Upload(){
		$metodo	=	$this->uri->segment(3);
		$this->$metodo();
	}

	private function Image(){
		$folder	=	base64_decode(get("f"));
		$file		=	base64_decode(get("fi"));
		unlink(PATH_IMG.'uploads/'.$folder.'/'.$file);
		redirect(base64_decode(get("redirect")));
	}

	private function Images(){
		$imagen	=	upload('userfile',$path='images/uploads/'.$this->uri->segment(4).'/',$config=array("allowed_types"=>'gif|jpg|png',"renombrar"=>"PGRW_".rand(5000,600000),"max_size"=>12000,"max_width"=>12000,"max_height"=>12000));
		echo json_encode(array(
			'name'  => @$imagen["upload_data"]["imagen_nueva"],
			'error' => @$imagen["upload_data"]["error"],
		));
	}

	private function ImagesUp(){
		$editar_esta_imagen=false;
		$config	=	array(	"allowed_types"=>'gif|jpg|png',
											"renombrar"=>get("name"),
											"max_size"=>12000,
											"max_width"=>12000,
											"max_height"=>12000,
											"max_size_avaible"=>350,
											"max_width_avaible"=>1350,
											"max_height_avaible"=>520,
											"filename"=>get("name"),
											);
		$imagen	=	upload('img','images/uploads/'.get("folder").'/',$config);
		if(!empty(get("cuadrar"))){
			$reset								=		get("cuadrar");
			$file_path						=		$imagen["upload_data"]["file_path"];
			$editar_esta_imagen		=		$imagen["upload_data"]["file_path"].get("cuadrar").$imagen["upload_data"]["file_ext"];
			$datos								=		getimagesize($editar_esta_imagen);
			$original_width				=		$datos[0];
			$original_height			=		$datos[1];
			$new_width						=		320;
			$new_height						=		320;
			resizeImage($file_path,$editar_esta_imagen, $original_width, $original_height, $new_width, $new_height,$reset);
		}

		$this->load->helper('directory');
		$map 	=  directory_map(PATH_IMG.'uploads/'.get("folder").'/');
		if(!empty($map)){
			foreach ($map as $key => $value) {
				$pos 		= 	strpos($value, get("name"));
				if ($pos !== false) {
					if($imagen["upload_data"]["file_path"].$value!=$imagen["upload_data"]["file_path"].$imagen["upload_data"]["nuevo_nombre"]){
						unlink($imagen["upload_data"]["file_path"].$value);
					}
				}
			}
		}

		echo json_encode(array(
			'status'  => 	"success",
			'url'  		=>  @$imagen["upload_data"]["imagen_nueva"].'?rand='.rand(1000,50000),
		));
	}

	private function Profile(){
		$this->load->model('Autenticacion_model');
		$this->Autenticacion 	= 	new Autenticacion_model();
		$User	=	$this->session->userdata("User");
		$User->nombres		=		post("nombres");
		$User->apellidos	=		post("apellidos");
		$User->telefono		=		post("telefono");
		$User->json				=		json_encode(post("json"));
		$update						=		$User;
		unset($update->session_id);
		$this->db->where('token',post("token") )->update(DB_PREFIJO."usuarios", $update);
		$this->session->set_userdata(array('User'=>$User));
		$this->Response 		=			array(	"code"		=>	"200","callback"=>"toggle(".json_encode($update).")" );
		echo answers_json($this->Response);
	}

}
?>
