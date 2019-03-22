<?php
/*
	DESARROLLO Y PROGRAMACIÓN
	PROGRAMANDOWEB.NET
	LCDO. JORGE MENDEZ
	info@programandoweb.net
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Gestion_model extends CI_Model {

	var $return;

	public function __construct(){
		$this->return	=	new stdClass();
	}

	function CantInmuebles(){
		$tabla	=	DB_PREFIJO."anuncio";
		$this->db->select('count(id) as total')->from($tabla);
		if($this->user->tipo_id>0){
			$this->db->where("usuario_id",$this->user->usuario_id);
		}
		$query	=	$this->db->get();
		return $query->row()->total;
	}

	function Inmuebles(){
		$tabla	=	DB_PREFIJO."anuncio";
		$this->db->select('id,titulo,precio,estatus,"prueba" as edit')->from($tabla);
		if($this->user->tipo_id>0){
			$this->db->where("usuario_id",$this->user->usuario_id);
		}
		$query	=	$this->db->get();
		return foreach_edit($query->result_array());
	}

	public function Asignaciones($var){
		return $this->Citas($var);
	}

	public function GetInmuebles($id){
		$tabla	=	DB_PREFIJO."anuncio";
		$this->db->select('*,estatus,"prueba" as edit');
		$this->db->from($tabla);
		$this->db->where("id",$id);
		if($this->user->tipo_id>0){
			$this->db->where("usuario_id",$this->user->usuario_id);
		}
		$query	=	$this->db->get();
		$caracteristicas=$this->db->select('*')->from(DB_PREFIJO."anuncio_caracteristicas")->where("anuncio_id",$id)->get()->result();
		$return	=	array();
		foreach ($caracteristicas as $key => $value) {
			$return[$value->caracteristica_id]	=	$value;
		}
		return array("inmueble"=>$query->row(),"caracteristicas"=>$return);
	}

	public function SetInmuebles($var){
		$caracteristica=$var["caracteristica"];
		unset($var["caracteristica"]);
		if(isset($var["callback"])){
			unset($var["callback"]);
		}
		if($this->user->tipo_id>0){
			$var["usuario_id"]		=		$this->user->usuario_id;
		}
		$return =	false;
		if($var["id"]==0){
			$this->return->id		=		$var["id"];
			unset($var["id"]);
			if($this->db->insert(DB_PREFIJO."anuncio",$var)){
				$return=true;
				$this->return->id	=		$insert_id = $this->db->insert_id();
			}
		}else{
			$this->db->where("id",$var["id"]);
			$insert_id = $var["id"];
			if($this->db->update(DB_PREFIJO."anuncio",$var)){
				$this->return->id		=		$var["id"];
				$return=true;
			}
		}
		$this->db->where("anuncio_id",$this->return->id)->delete(DB_PREFIJO."anuncio_caracteristicas");
		foreach ($caracteristica as $key => $value) {
			$this->db->insert(DB_PREFIJO."anuncio_caracteristicas",array("anuncio_id"=>$this->return->id,"caracteristica_id"=>$value));
		}
		$config	=	array(	"allowed_types"=>'gif|jpg|png',
											"max_size"=>12000,
											"max_width"=>12000,
											"max_height"=>12000,
											"max_size_avaible"=>350,
											"max_width_avaible"=>800,
											"max_height_avaible"=>480);

		upload_multiple(	$_FILES["userfile"],
											$path='images/uploads/inmuebles/'.$insert_id,
											$config);
		return $return;
	}

	public function GetCitas($id){
		$tabla	=	DB_PREFIJO."tareas";
		$this->db->select('prioridad,id,placa,descripcion_completa,usignado_a_usuario_id,usignado_x_usuario_id, tarea ,fecha_inicio,fecha_final,estatus,"prueba" as edit');
		$this->db->from($tabla);
		$this->db->where("id",$id);
		$query	=	$this->db->get();
		return $query->row();
	}

	public function Citas($var){
		$start	=	$var["start"];
		$length	=	$var["length"];
		$search	=	$var["search"]["value"];
		$key_order	=	@$var["order"][0]["column"];
		$tabla	=	DB_PREFIJO."tareas t1";
		$this->db->select('CONCAT(nombres," ",apellidos) AS asignado,id, tarea ,fecha_inicio,fecha_final,t1.estatus,"prueba" as edit');
		$this->db->from($tabla)->join(DB_PREFIJO."usuarios t2","t1.usignado_a_usuario_id=usuario_id","left");
		if($search){
		 		$this->db->where("tarea",$search);
		}
		$this->db->limit($length,$start);
		if(isset($var["columns"]) && isset($var["order"])){
				$this->db->order_by($var["columns"][$key_order]["data"],$var["order"][0]["dir"]);
		}
		$query	=	$this->db->get();
		return foreach_edit($query->result_array());
	}

	public function SetCotizaciones($var){
		$return =false;
		if($var["id"]==0){
			unset($var["id"]);
			if($this->db->insert(DB_PREFIJO."cotizaciones",$var)){
				$return=true;
			}
		}else{
			$this->db->where("id",$var["id"]);
			if($this->db->update(DB_PREFIJO."cotizaciones",$var)){
				$return=true;
			}
		}
		return $return;
	}

	public function GetCotizaciones($id){
		$tabla	=	DB_PREFIJO."cotizaciones";
		$this->db->select('*,id,placa,descripcion_completa, tarea ,fecha_inicio,fecha_final,estatus,"prueba" as edit');
		$this->db->from($tabla);
		$this->db->where("id",$id);
		$query	=	$this->db->get();
		return $query->row();
	}

	public function Cotizaciones($var){
		$start	=	$var["start"];
		$length	=	$var["length"];
		$search	=	$var["search"]["value"];
		$key_order	=	@$var["order"][0]["column"];
		$tabla	=	DB_PREFIJO."cotizaciones";
		$this->db->select('id, tarea ,fecha_inicio,fecha_final,estatus,"prueba" as edit');
		$this->db->from($tabla);
		if($search){
		 		$this->db->where("tarea",$search);
		}
		$this->db->limit($length,$start);
		if(isset($var["columns"]) && isset($var["order"])){
				$this->db->order_by($var["columns"][$key_order]["data"],$var["order"][0]["dir"]);
		}
		$query	=	$this->db->get();
		return foreach_edit($query->result_array());
	}

	public function SetUsuarios($var){
		$return =false;
		if($var["usuario_id"]==0){
			unset($var["usuario_id"]);
			if($this->db->insert(DB_PREFIJO."usuarios",$var)){
				$return=true;
			}
		}else{
			$this->db->where("usuario_id",$var["usuario_id"]);
			if($this->db->update(DB_PREFIJO."usuarios",$var)){
				$return=true;
			}
		}
		return $return;
	}

	public function GetUsuarios($id){
		$tabla	=	DB_PREFIJO."usuarios";
		$this->db->select('usuario_id as id,tipo_id,nombres,apellidos,telefono,estatus, email ,"prueba" as edit');
		$this->db->from($tabla);
		$this->db->where("usuario_id",$id);
		$query	=	$this->db->get();
		return $query->row();
	}

	public function Usuarios($var){
		$start	=	$var["start"];
		$length	=	$var["length"];
		$search	=	$var["search"]["value"];
		$key_order	=	@$var["order"][0]["column"];
		$tabla	=	DB_PREFIJO."usuarios";
		$this->db->select('usuario_id as id,CONCAT(nombres," " ,apellidos) as nombres,telefono, email ,"prueba" as edit');
		$this->db->from($tabla);
		if($search){
		 		$this->db->where("tarea",$search);
		}
		$this->db->where("tipo_id>",0);
		$this->db->limit($length,$start);
		if(isset($var["columns"]) && isset($var["order"])){
				$this->db->order_by($var["columns"][$key_order]["data"],$var["order"][0]["dir"]);
		}
		$query	=	$this->db->get();
		return foreach_edit($query->result_array());
	}

}
?>
