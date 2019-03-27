<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
  DESARROLLADO POR JORGE MENDEZ
  programandoweb.net
  info@programandoweb.net
  Colombia - Venezuela - Chile
**/

class Home extends CI_Controller {

	var $util,$user,$ModuloActivo,$profile;

	public function __construct(){
    parent::__construct();
		$this->load->library('ControllerList');
		$this->Menu			=	$this->controllerlist->getControllers();
		$this->util 		= 	new Util_model();
		$this->Breadcrumb 	=	NULL;
		$this->user			=	$this->session->userdata('User');
		$this->ModuloActivo	=	'Home';
		$this->Breadcrumb_bool=	false;
		$this->listar		=	new stdClass();
		$this->View			=	$this->uri->segment(2).(1)?"":"";
		$this->load->model("Home_model");
		$this->Home				= 	new Home_model();
    }

	public function Index(){
		$this->Breadcrumb 		=	'Main';
		$this->Breadcrumb_bool 	=	false;
		$this->util->set_title($this->ModuloActivo." - ".$this->Breadcrumb." - ".SEO_TITLE);
		View($this->ModuloActivo."/Index");
	}

	public function Favorites(){
		$url	=	base_url("Search/Profiles/Bot?fv=true");
		redirect($url);
	}

	public function Routing(){
		if($this->profile=$profile=$this->profile()){
			$nombres		=		(!empty($profile->nombres) && !empty($profile->apellidos))?$profile->nombres.' '.$profile->apellidos .' VIP':" Nuevo VIP";
			//pre($profile);return;
			$this->Breadcrumb 		=	'Main';
			$this->Breadcrumb_bool 	=	false;
			$this->util->set_title("Promotor inmobiliario ".$nombres." - ".SEO_TITLE);
			View3($this->ModuloActivo."/Profile");
		}
	}

	public function Inmueble(){
		list($prefijo,$id,$slug) 	=	explode("-",$this->uri->segment(3));
		$inmueble								=		$this->Home->getInmueble($id,"*","home");
		$this->profile					=		usuarios_x_id($inmueble["inmueble"]->usuario_id);
		$images									=		get_imagesInmuebles($id,"*",false,false,"img-fluid");
		$set_image							=		"";
		if(!empty($images)){
				$set_image =	$images[0];
		}
		$this->Breadcrumb 			=		GetTipoInmueble($inmueble["inmueble"]->tipo_inmueble).' en '.GetTipoAccion($inmueble["inmueble"]->accion_id);
		$this->Breadcrumb_bool 	=		false;
		$this->util->set_title($this->Breadcrumb." - ".SEO_TITLE);
		$this->util->set_description($inmueble["inmueble"]->descripcion);
		$this->util->set_image($set_image);
		View($this->ModuloActivo."/Inmueble",array(	"menu"=>100,
																								"inmueble"=>$inmueble["inmueble"],
																								"caracteristicas_db"=>$inmueble["caracteristicas"],
																								"images"=>$images));
	}

	private function profile(){
		return usuarios_x_login($this->uri->segment(2));
	}

}
