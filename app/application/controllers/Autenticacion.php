<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autenticacion extends CI_Controller {

	var $util,$user,$Autenticacion,$ModuloActivo,$Response;

	public function __construct(){
    parent::__construct();
		$this->util 			= 	new Util_model();
		$this->Autenticacion 	= 	new Autenticacion_model();
		$this->user				=	$this->session->userdata('User');
		$this->Response			=	array();
}

	public function Index(){
		$this->util->set_title(SEO_TITLE);
		$this->load->view('Template/Header',array("nav"=>false));
		$this->load->view('Template/Flash');
		if(!empty($this->user)){
			if(MODULO_X_DEFAULT){

			}else{
				$this->load->view('Template/Welcome');
			}
		}else{
			$this->login();
		}
		$this->load->view('Template/Footer',array("footer"=>false));
	}

	public function Login(){
		$this->load->view('Template/Autenticacion/Login');
	}

	public function Recover(){
		$this->util->set_title("Recover - ".SEO_TITLE);
		$this->load->view('Template/Header');
		$this->load->view('Template/Flash');
		$this->load->view('Template/Autenticacion/Recover');
		$this->load->view('Template/Footer');
	}

	public function Register(){
		$this->util->set_title("Register - ".SEO_TITLE);
		$this->load->view('Template/Header',array("nav"=>false));
		$this->load->view('Template/Flash');
		if(!empty($this->user)){
			if(MODULO_X_DEFAULT){
			}else{
				$this->load->view('Template/Welcome');
			}
		}else{
			$this->load->view('Template/Autenticacion/Register');
		}
		$this->load->view('Template/Footer',array("footer"=>false));

	}

	public function Register_UserBasic(){
		$this->util->set_title("Register - ".SEO_TITLE);
		$this->load->view('Template/Header',array("nav"=>false));
		$this->load->view('Template/Flash');
		if(!empty($this->user)){
			if(MODULO_X_DEFAULT){
			}else{
				$this->load->view('Template/Welcome');
			}
		}else{
			$this->load->view('Template/Autenticacion/Register_User');
		}
		$this->load->view('Template/Footer',array("footer"=>false));

	}

	public function Register_University(){
		$this->util->set_title("Register - ".SEO_TITLE);
		$this->load->view('Template/Header',array("nav"=>false));
		$this->load->view('Template/Flash');
		if(!empty($this->user)){
			if(MODULO_X_DEFAULT){
			}else{
				$this->load->view('Template/Welcome');
			}
		}else{
			$this->load->view('Template/Autenticacion/Register_University');
		}
		$this->load->view('Template/Footer',array("footer"=>false));
	}

	public function Confirm_User(){
		$user=usuarios_x_token($this->uri->segment(2));
		$this->util->set_title("Register - ".SEO_TITLE);
		$this->load->view('Template/Header',array("nav"=>false));
		$this->load->view('Template/Flash');
		if(!empty($user)){
			if($user->estatus>0){
				redirect(base_url());
				return;
			}
			$this->db->where("token",$this->uri->segment(2));
			$this->db->update(DB_PREFIJO."usuarios",array("estatus"=>1));
			if($user->tipo_id==1){
				$this->load->view('Template/Autenticacion/Register_University2');
			}else if($user->tipo_id==2){

			}
		}else{
				redirect(base_url());
		}
		$this->load->view('Template/Footer',array("footer"=>false));
	}

	public function Finish_register(){
		$this->util->set_title("Register - ".SEO_TITLE);
		$this->load->view('Template/Header',array("nav"=>false));
		$this->load->view('Template/Flash');
		$this->load->view('Template/Autenticacion/Finish_register');
		$this->load->view('Template/Footer',array("footer"=>false));
	}

	public function Registertoken(){
		if(method_exists($this->Autenticacion,"set_user_by_token") && $this->uri->segment(3)){
			$this->Autenticacion->set_user_by_token($this->uri->segment(3));
			redirect(base_url("autenticacion/registertoken"));
			return;
		}
		//print_r($this->session);
		$this->util->set_title("Register - ".SEO_TITLE);
		$this->load->view('Template/Header');
		$this->load->view('Template/Flash');
		$this->load->view('Template/Autenticacion/ActiveUser');
		$this->load->view('Template/Footer');
	}

	public function Register_user(){
		if($this->Autenticacion){
			if(method_exists($this->Autenticacion,"get_user_by_email")){
				$user		=	$this->Autenticacion->get_user_by_email(post());
				if(!empty($user) && post("from_registro")){
					$this->Inicio_sesion(true);
					return;
				}
				if(!empty($user)){
					$this->Response 		=			array(	"message"	=>	"Lo siento, el correo electrónico ya existe en nuestra base de datos.<br/>Intenta restablecer contraseña si la haz olvidado",
																"code"		=>	"203");
				}else{
					$process_user			=	$this->Autenticacion->set_user(post());

					if($process_user){
						if(AUTENTICACION_REGISTER_REQUIERE_ACTIVACION){
							//echo answers_json($this->Autenticacion->user);return;
							$var		=	array(
													"view"		=>	"register",
													"data"		=>	array(	"userName"	=>	$this->Autenticacion->user["login"],
																			"href"		=>	base_url("autenticacion/registertoken/".$this->Autenticacion->user["token"])
												));
							$mensaje	=	set_template_mail($var);

							if($mensaje){
								$var		=	array(
													"recipient"		=>	$this->Autenticacion->user["email"],
													"subject"		=>	"Activar su cuenta en ".SEO_NAME,
													"body"			=>	$mensaje
												);
								$sendmail	=	send_mail($var);
								if(!$sendmail['error']){
									$this->Response 		=			array(	"message"	=>	"El registro ha sido exitoso, revise su correo electrónico y active su cuenta.",
																				"code"		=>	"200");
								}else{
									$this->Response 		=			array(	"message"	=>	"Error, no se puedo enviar correo de activación, sin embargo, su cuenta está activa.",
																				"code"		=>	"203");
								}

							}

						}else{
							$this->Response 	=			array(	"message"	=>	"El registro ha sido exitoso, su cuenta está activa",
																	"code"		=>	"200");
						}
					}
				}
			}
		}
		echo answers_json($this->Response);
	}

	public function Recovertoken(){
		if(post()){
			$set	=	$this->Autenticacion->setrecovertoken(post());
			if ($this->input->is_ajax_request()) {
				if($set){
					$this->Response 		=			array(	"message"	=>	"Los datos han sido guardados correctamente",
																				"code"		=>	"200");
				}else{
					$this->Response 		=			array(	"message"	=>	"Lo siento, presentamos un problema y no pudimos guardar los datos",
																"code"		=>	"203");
				}
				echo answers_json($this->Response);
			}
			return;
		}
		$data	=	user_x_token($this->uri->segment(3));
		if(empty($data)){

		}else{

			$this->util->set_title("Restablecer Contraseña - ".SEO_TITLE);
			$this->load->view('Template/Header');
			$this->load->view('Template/Autenticacion/RestablecerContrasena',array("row",$data));
			$this->load->view('Template/Footer');
		}
	}

	public function Recoverpass(){
		if ($this->input->is_ajax_request()) {
			if($this->Autenticacion){
				if(method_exists($this->Autenticacion,"get_user_by_email")){
					$user					=	$this->Autenticacion->get_user_by_email(post());
					pre($user);return;
					$user->token	=	md5(date("Y-m-d H:i:s"));
					$this->db->where('usuario_id', $user->usuario_id)->update(DB_PREFIJO."usuarios", array("token"=>$user->token));
					$var		=	array(
										"view"		=>	"recover",
										"data"		=>	array(	"userName"	=>	$user->login,
																"href"		=>	base_url("autenticacion/recovertoken/".$user->token)
									));
					$mensaje	=	set_template_mail($var);
					if($mensaje){
						$var		=	array(
											"recipient"		=>	$user->email,
											"subject"		=>	"Recuperación de contraseña en ".SEO_NAME,
											"body"			=>	$mensaje
										);
						$sendmail	=	send_mail($var);
						if(!$sendmail['error']){
							$this->Response 		=			array(	"message"	=>	"Envío de reinicio de clave exitoso, revise su correo electrónico",
																"code"		=>	"200");
						}else{
							$this->Response 		=			array(	"message"	=>	"Error, no se puedo reiniciar la clave, reintente más tarde",
																"code"		=>	"203");
						}

					}else{
						$this->Response 		=			array(		"message"	=>	"Error, no se puedo reiniciar la clave, reintente más tarde",
																		"code"		=>	"203");
					}
				}else{
					$this->Response 		=			array(	"message"	=>	"Error, método no encontrado",
																"code"		=>	"203");
				}
			}else{
				$this->Response 		=			array(	"message"	=>	"Error, Clase no encontrado",
															"code"		=>	"203");
			}
			echo answers_json($this->Response);
		}
	}

	public function Inicio_sesion($social_network=false){
		if ($this->input->is_ajax_request()) {
			if($respuesta	=	$this->Autenticacion->login(post(),$social_network)){
				if(isset($respuesta['error'])){
					$this->Response 		=			array(	"message"	=>	$respuesta['error'],
																"code"		=>	"203");
				}else{
					$this->Response 		=			array(	"message"	=>	"Inicio Satisfactorio, será redirigido",
																"code"		=>	"200");
				}
			}else{
				$this->Response 		=			array(	"message"	=>	"Error, El usuario no existe o su clave es incorrecta",
															"code"		=>	"203");
			}
			echo answers_json($this->Response);
		}
	}
	public function Salir(){
		destruye_session($this->user);
		$this->session->unset_userdata('User');
		$this->session->sess_destroy();
		if ($this->input->is_ajax_request()) {
			$this->Response 		=			array(	"message"	=>	"Cierre de sesión satisfactorio, será redirigido",
												"code"		=>	"200");
			echo answers_json($this->Response);
		}else{
			redirect(base_url());
		}
	}

	public function Destroy(){
		Destroy($this->uri->segment(3));
		$this->session->unset_userdata('User');
		$this->session->sess_destroy();
		if ($this->input->is_ajax_request()) {
			$this->Response 		=			array(	"message"	=>	"Cierre de sesión satisfactorio, será redirigido",
												"code"		=>	"200");
			echo answers_json($this->Response);
		}else{
			redirect(base_url());
		}
	}
}
?>
