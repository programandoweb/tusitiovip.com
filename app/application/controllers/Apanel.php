<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apanel extends CI_Controller {

  var $util,$user,$ModuloActivo,$path,$listar,$Profesiones,$Breadcrumb,$Uri_Last,$Listado,$Menu;

	public function __construct(){
    parent::__construct();
		$this->load->library('ControllerList');
		$this->Menu			=	$this->controllerlist->getControllers();
		$this->util 		= 	new Util_model();
		$this->Breadcrumb 	=	$this->uri->segment_array();
		$this->Uri_Last		=	$this->uri->segment($this->uri->total_rsegments());
		$this->user			=	$this->session->userdata('User');
		$this->ModuloActivo	=	'Apanel';
		$this->Path			=	PATH_VIEW.'/Template/'.$this->ModuloActivo;
		$this->listar		=	new stdClass();

		if(empty($this->user)){
			redirect(base_url("Main"));	return;
		}

		chequea_session($this->user);
    }

	public function index(){
		$this->util->set_title("Apanel - ".SEO_TITLE);
		$this->load->view('Template/Header_Apanel');
		$this->load->view('Template/Flash');
		if(file_exists($this->Path.'/Menu.php')){
			$this->load->view('Template/Apanel/Menu');
			switch($this->user->tipo_id){
				case 0:
					$this->load->view('Template/Apanel/Home');
				break;
				case 1:
          $this->load->model("Gestion_model");
          $this->Gestion	= 	new Gestion_model();
          $this->Listado          =   $this->Gestion->Inmuebles();
          $this->cant_inmuebles   =   $this->Gestion->CantInmuebles();
					$this->load->view('Template/Apanel/HomeUsuarios');
				break;
				case 2:
          if(empty($this->user->cedula) || empty($this->user->telefono)){
            redirect("Gestion/Personal_Info");
          }else{
            $this->load->view('Template/Apanel/User');
          }
				break;
				default:
					$this->load->view('Template/Apanel/Anywhere');
				break;
			}
			//$this->load->view('Template/Apanel/Home');
		}
		$this->load->view('Template/Footer_Apanel');
	}

	public function Statistics(){
		$this->util->set_title("Apanel - ".SEO_TITLE);
		$this->load->view('Template/Header');
		$this->load->view('Template/Flash');
		if(file_exists($this->Path.'/Menu.php')){
			$this->load->view('Template/Apanel/Menu');
			if($this->uri->segment(2)){
				$this->load->view('Template/Apanel/Home_'.$this->uri->segment(3));
			}else{
				$this->load->view('Template/Apanel/Home');
			}
		}
		$this->load->view('Template/Footer');
	}

}
?>
