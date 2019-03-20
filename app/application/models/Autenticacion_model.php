<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
  DESARROLLADO POR JORGE MENDEZ
  programandoweb.net
  info@programandoweb.net
  Colombia - Venezuela - Chile
**/

class Autenticacion_model extends CI_Model {

	var $user;

	public function setrecovertoken(){
		$data	=	user_x_token(post("token"));
		if(!empty($data)){
			$query	=	$this->db->where('usuario_id', $data->usuario_id)->update(DB_PREFIJO."usuarios", array("token"=>"NULL","password"=>md5(post("clave_nueva"))));
			if($query){
				logs($data,2,"usuarios",$data->usuario_id,"Autenticacion");
				$this->session->set_flashdata('success', 'La activación ha sido exitosa, ya puede iniciar sesión.');
				return true;
			}else{
				logs($data,2,"usuarios",$data->usuario_id,"Autenticacion","0");
				$this->session->set_flashdata('danger', 'No pudo activarse esta cuenta.');
				return false;
			}
			return true;
		}
		pre($data);
	}

	public function login($var,$social_network=false){
		$data	=	$this->db	->select('*')
											->from(DB_PREFIJO."usuarios")
											->where('email',$var["email"])
											->or_where('login',$var["email"])
											->get()->row();
		if(!empty($data)){
			if($data->password==md5(@$var['password'])){

				if($data->estatus==0){
					return array("error"=>"Esta cuenta se encuentra inactiva, consulte con el administrador");
					return;
				}
				$data->token	=	md5($data->login);
				$this->db->where('usuario_id',$data->usuario_id)->update(DB_PREFIJO."usuarios",array("token"=>$data->token));
				$session	=	$this->db->select('*')->from(DB_PREFIJO."sys_session")->where('usuario_id',$data->usuario_id)->get()->row();

				if(empty($session)){
					logs($data,4,"usuarios",$data->usuario_id,"Autenticacion");
					unset($data->password);
					if($data->tipo_id =='root'){
						$data->menu		=	menu();
					}else{
						//$data->menu		=	menu_usuarios($data->rol_id);
					}
					$session		=	ini_session($data);

					if($session){
						$this->set_session_login($session);
						return true;
					}else{
						return false;
					}
				}else{
					if($user_new	=	tiempo_session($data)){
						$this->set_session_login($user_new);
						return true;
					}else{
						return array("error"=>"Ya existe otra sesión abierta con este usuario<br><a class='btn btn-default' href='".base_url("Autenticacion/Destroy/".$session->session_id)."'>Cerrar Sesiones abiertas</a>");
					}
				}
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

	public function get_user_by_email($var){
		$ci 	=& 	get_instance();
		return $ci->db->select('*')->from(DB_PREFIJO."usuarios")->where('email',$var["email"])->get()->row();
	}

	public function set_user_by_token($token){
		$row		=	$this->db->select('*')->from(DB_PREFIJO."usuarios")->where('token',$token)->get()->row();
		if(!empty($row)){
			$query	=	$this->db->where('usuario_id', $row->usuario_id)->update(DB_PREFIJO."usuarios", array("token"=>"NULL"));
			if($query){
				logs($row,2,"usuarios",$row->usuario_id,"Autenticacion");
				$this->session->set_flashdata('success', 'La activación ha sido exitosa, ya puede iniciar sesión.');
				return true;
			}else{
				logs($row,2,"usuarios",$row->usuario_id,"Autenticacion","0");
				$this->session->set_flashdata('danger', 'No pudo activarse esta cuenta.');
				return false;
			}
			return true;
		}else{
			$this->session->set_flashdata('danger', 'Token obsoleto o inválido.');
			return false;
		}
	}

	public function set_user($var,$me=FALSE){
		if(isset($var['redirect'])){
			unset($var["redirect"]);
			unset($var["from_registro"]);
		}
		if(isset($var['json'])){
			$var['json']=json_encode($var['json']);
		}
		if(isset($var['id'])){
			$var['password']	=	md5($var['password']);
		}
		if(!isset($var['id']) && !isset($var['token'])){
			$var['password']	=	$var['token']	=	md5(date("Y-m-d H:i:s"));
			if(!isset($var['login'])){
				if(isset($var['email'])){
					$explode_login	=	explode("@",$var['email']);
					$var['login']	= 	$explode_login[0];
				}
			}
			$var['tipo_id']	= 	9;
			$query	=	$this->db->insert(DB_PREFIJO."usuarios", $var);
		}else if(isset($var['token'])) {
			$query	=	$this->db->where('token',$var["token"] )->update(DB_PREFIJO."usuarios", $var);
		}else{
			$query	=	$this->db->where('id',$var["id"] )->update(DB_PREFIJO."usuarios", $var);
		}
		if($me){
			$this->set_session_login($var);
		}
		if($query){
			$this->user		=		$this->db->select('*')->from(DB_PREFIJO."usuarios")->where('token',$var["token"])->get()->row();
			$this->session->set_flashdata('success', 'La información se guardo correctamente.');
			return true;
		}else{
			$this->session->set_flashdata('danger', 'La información no se pudo guardar.');
			return false;
		}
	}

	private function set_session_login($data){
		$this->session->set_flashdata('success', 'La información se guardo correctamente.');
		$this->session->set_userdata(array('User'=>$data));
	}

}
?>
