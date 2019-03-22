<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gestion extends CI_Controller {

  var $util,$user,$ModuloActivo,$path,$listar,$Breadcrumb,$Uri_Last,$Listado,$Menu,$campos;

	public function __construct(){
    parent::__construct();

		$this->load->library('ControllerList');
		$this->Menu					=	$this->controllerlist->getControllers();
		$this->util 				= new Util_model();
		$this->Breadcrumb 	=	$this->uri->segment_array();
		$this->Uri_Last			=	$this->uri->segment($this->uri->total_rsegments());
		$this->user					=	$this->session->userdata('User');
		$this->ModuloActivo	=	'Gestion';
		$this->Path					=	PATH_VIEW.'/Template/'.$this->ModuloActivo;
		$this->listar				=	new stdClass();

		if(empty($this->user)){
			redirect(base_url("Main"));	return;
		}
    $this->load->model("Gestion_model");
    $this->Gestion	= 	new Gestion_model();
		chequea_session($this->user);
  }

  public function Inmuebles(){
    $this->Breadcrumb =	'Gestión de Inmuebles';
		$this->util->set_title($this->Breadcrumb ." - ".SEO_TITLE);

    switch($this->user->tipo_id){
      case 0:
        $this->campos     = array(	"id"=>"ID",
                                    "titulo"=>"Título",
                                    "precio"=>"Precio",
                                    "edit"=>"Acción");
        $this->exec();
  		  //$this->view("Gestion/Index",array( "usuarios"=>usuarios($this->user->usuario_id),"campos"=>$campos));
      break;
      case 1:
      $this->campos     = array(	"id"=>"ID",
                                  "titulo"=>"Título",
                                  "precio"=>"Precio",
                                  "edit"=>"Acción");
      $this->exec();
      // $this->view("Apanel/University_datos_personales",array( "usuarios"=>usuarios($this->user->usuario_id),
      //                                                   "estudios"=>estudios($this->user->usuario_id),
      //                                                   "empleos"=>empleos($this->user->usuario_id),
      //                                                 ));
      break;
      case 2:
        // $this->view("Apanel/User_datos_personales",array( "usuarios"=>usuarios($this->user->usuario_id),
        //                                                   "estudios"=>estudios($this->user->usuario_id),
        //                                                   "empleos"=>empleos($this->user->usuario_id),
        //                                                 ));
      break;
      default:
        $this->view("Apanel/User_datos_personales",array( ));
      break;
    }
	}

	private function view($view,$data){
    $this->load->view('Template/Header_Apanel');
    //$this->load->view('Template/Apanel/Menu');
		$this->load->view('Template/Flash');
    $this->load->view('Template/Apanel/Menu');
    $this->load->view('Template/'.$view,array("data"=>$data));
    $this->load->view('Template/Footer_Apanel');
  }

	private function exec(){
    if ($this->input->is_ajax_request() && $this->uri->segment(3)!='Add') {
      /*PARA LLENAR LISTADO*/
      $metodo2=$this->uri->segment(2);
      echo json_encode($this->Gestion->$metodo2(get()));
      return;
		}else if(!$this->input->is_ajax_request() &&  $this->uri->segment(3)=='Add' &&  !post()){
      /*PARA CARGAR FORMULARIO*/
      $metodo2="Get".$this->uri->segment(2);
      $data   = $this->Gestion->$metodo2($this->uri->segment(4));
      if(empty($data) &&  $this->uri->segment(4)>0){
        //pre($metodo2);
        /*ALTER TABLE `pgrw_anuncio` ADD `promocion` DECIMAL(10,2) NULL AFTER `precio`; */
        redirect($this->uri->segment(1)."/".$this->uri->segment(2));
        return;
      }
      View2($this->ModuloActivo."/Add".$this->uri->segment(2),array("data"=>$data));
      //FormNoHeader($this->ModuloActivo."/Add".$this->uri->segment(2),array("data"=>$this->Gestion->$metodo2($this->uri->segment(4))));
			return;
		}else if($this->input->is_ajax_request() &&  $this->uri->segment(3)=='Add' &&  post()){
      /*PARA GUARDAR EN BASE DE DATOS*/
      $metodo2  =   "Set".$this->uri->segment(2);
			$set	=	$this->Gestion->$metodo2(post());
			if($set){
        $extra_callBack   = "";
        if(post("callback")){
          $extra_callBack = post("callback")."('". $this->Gestion->return->id ."')";
        }
				echo answers_json(array(	 "message"	=>	"El registro ha sido exitoso.",
											             "code"		=>	"200",
											             "callback"	=>	"parent.table.ajax.reload();".$extra_callBack.";"));
			}else{
				echo answers_json(array(	"message"	=>	"Error, no se puedo guardar el registro.",
											"code"		=>	"203"));
			}
			return;
		}else if(!$this->input->is_ajax_request() &&  $this->uri->segment(3)=='Add' &&  post()){
      /*PARA GUARDAR EN BASE DE DATOS*/
      $metodo2  =   "Set".$this->uri->segment(2);
			$set	=	$this->Gestion->$metodo2(post());
      if($set){
        $extra_callBack   = "";
        if(post("callback")){
          $extra_callBack = post("callback")."('". $this->Gestion->return->id ."')";
        }
        //pre($this->Gestion->return->id);       return;
        $this->session->set_flashdata('success', 'Datos Guardados');
        redirect("Gestion/Inmuebles/Add/".$this->Gestion->return->id);
			}else{
        $this->session->set_flashdata('danger', 'No pudo guardar los datos.');
        redirect("Gestion/Inmuebles/Add/".$this->Gestion->return->id);
        return true;
      }
			return;
		}
    View2($this->ModuloActivo.'/Lista',array("campo"=>$this->campos));
	}

}
?>
