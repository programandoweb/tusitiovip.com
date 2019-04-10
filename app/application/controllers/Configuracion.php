<?php
/*
	DESARROLLO Y PROGRAMACIÓN
	PROGRAMANDOWEB.NET
	LCDO. JORGE MENDEZ
	info@programandoweb.net
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracion extends CI_Controller {

	var $util,$user,$ModuloActivo,$path,$listar,$Operavita,$Breadcrumb,$Uri_Last,$View,$Menu,$Configuracion;

	public function __construct(){
    parent::__construct();
		$this->load->library('ControllerList');
		$this->Menu			=	$this->controllerlist->getControllers();
		$this->util 		= 	new Util_model();
		$this->Breadcrumb 	=	NULL;
		$this->user			=	$this->session->userdata('User');
		$this->ModuloActivo	=	$this->router->fetch_class();;
		$this->listar		=	new stdClass();
		$this->View			=	$this->uri->segment(2).(1)?"":"";
		if(empty($this->user)){
			redirect(base_url("Main"));	return;
		}
		// $this->load->library('CI_Minifier');
		// $this->ci_minifier->init('html,css,js');

		$this->load->model("Configuracion_model");
		$this->Configuracion	= 	new Configuracion_model();

		chequea_session($this->user);
    }

	public function Index(){
		if ($this->input->is_ajax_request()) {
			echo json_encode(array("data"=>$this->Configuracion->GetAlumnos()));return;
		}
		$this->util->set_title($this->ModuloActivo." - ".SEO_TITLE);
		$campos=array("Id","Nombre de Usuario","Email","Teléfono","Acción");
		View("Welcome",array("campo"=>$campos),"_Apanel");
	}


	public function Grupo_de_Usuarios(){
		if($this->input->is_ajax_request() && !$this->uri->segment(3)) {
			echo json_encode(array("data"=>$this->Configuracion->GetGrupo_de_Usuarios()));return;
		}else if($this->input->is_ajax_request() &&  $this->uri->segment(3)=='Add' &&  !$this->uri->segment(5) &&  !post()){
			$this->AddGrupo_de_Usuarios();
			return;
		}else if(!$this->input->is_ajax_request() &&  $this->uri->segment(3)=='Add' &&  !post()){
			$this->AddGrupo_de_Usuarios();
			return;
		}else if($this->input->is_ajax_request() &&  $this->uri->segment(3)=='Add' &&  post()){
			$set	=	$this->Configuracion->SetGrupo_de_Usuarios(post());
			if($set){
				echo answers_json(array(	"message"	=>	"El registro ha sido exitoso.",
											"code"		=>	"200",
											"callback"	=>	"reloader_iframe()"));
			}else{
				echo answers_json(array(	"message"	=>	"Error, no se puedo guardar el registro.",
											"code"		=>	"203"));
			}
			return;
		}

		$this->Breadcrumb =	'Grupo de Usuarios';
		$this->util->set_title($this->ModuloActivo." / ".$this->Breadcrumb." / ".SEO_TITLE);
		$campos=array(	"id"=>"ID",
						"tipo"=>"Tipo de Usuario",
						"estatus"=>"Estatus",
						"edit"=>"Acción");
		View($this->ModuloActivo."/Grupo_de_Usuarios",array("campo"=>$campos),"_Apanel");
	}

	public function AddGrupo_de_Usuarios(){
		$this->Breadcrumb =	'Agregar Usuario';
		$this->util->set_title($this->ModuloActivo." / ".$this->Breadcrumb." / ".SEO_TITLE);
		$view	=	$this->ModuloActivo."/AddGrupo_de_Usuarios";
		$this->Configuracion->Row	=	$this->Configuracion->GetGrupo_de_Usuario($this->uri->segment(4));
		if ($this->input->is_ajax_request()) {
			Ajax($view,array("modulos"=>$this->Menu));return;
		}else{
			FormNoHeader($view,array("modulos"=>$this->Menu));
		}
	}



}

?>
