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

	public function Post(){
		$metodo	=	$this->uri->segment(3);
		$this->$metodo();
	}

	public function Upload(){
		$metodo	=	$this->uri->segment(3);
		$this->$metodo();
	}

	private function Images(){
		$imagen	=	upload('userfile',$path='images/uploads/'.$this->uri->segment(4).'/',$config=array("allowed_types"=>'gif|jpg|png',"renombrar"=>"PGRW_".rand(5000,600000),"max_size"=>2000,"max_width"=>2000,"max_height"=>2000));
		echo json_encode(array(
			'name'  => @$imagen["upload_data"]["imagen_nueva"],
			'error' => @$imagen["upload_data"]["error"],
		));
	}

	private function ImagesUp(){
		$imagen	=	upload('img','images/uploads/'.get("folder").'/',$config=array("allowed_types"=>'gif|jpg|png',"renombrar"=>get("name"),"max_size"=>4000,"max_width"=>4000,"max_height"=>4000));
		echo json_encode(array(
			'status'  => 	"success",
			'url'  		=>  @$imagen["upload_data"]["imagen_nueva"].'?rand='.rand(1000,50000),
		));
	}

	private function Profile(){
		$this->load->model('Autenticacion_model');
		$this->Autenticacion 	= 	new Autenticacion_model();
		$this->Autenticacion->set_user(post(),TRUE);
		$this->session->set_userdata(array('User'=>$this->Autenticacion->user));
		$this->Response 		=			array(	"code"		=>	"200","callback"=>"toggle(".json_encode($this->Autenticacion->user).")" );
		echo answers_json($this->Response);
	}

}
?>
