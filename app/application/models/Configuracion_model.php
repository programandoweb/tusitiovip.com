<?php
/* 
	DESARROLLO Y PROGRAMACIÓN
	PROGRAMANDOWEB.NET
	LCDO. JORGE MENDEZ
	info@programandoweb.net
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Configuracion_model extends CI_Model {
	
	function SetGrupo_de_Usuarios($var){
		$row	=	$this->db->select('tipo_id,tipo,estatus')
								->from(DB_PREFIJO."tipo_usuarios")
								->where('tipo_id',$var["tipo_id"])
								->get()
								->row();
		$var["privilegios"]		=	menu_encode($var);
		unset($var["ver"]);
		if(empty($row)){
			unset($var['tipo_id']);	
			if($this->db->insert(DB_PREFIJO."tipo_usuarios",$var)){
				return true;	
			}else{
				return $this->db->_error_message();	
			}
		}else{
			$this->db->where('tipo_id',$var["tipo_id"]);
			unset($var['tipo_id']);	
			if($this->db->update(DB_PREFIJO."tipo_usuarios",$var)){
				return true;
			}else{
				return $this->db->_error_message();	
			}
		}
	}
	
	function GetGrupo_de_Usuarios(){
		$tabla	=	DB_PREFIJO."tipo_usuarios";
		$this->db->select('tipo_id as id ,tipo,estatus,"prueba" as edit')->from($tabla);
		$query	=	$this->db->get();
		return foreach_edit($query->result_array());	
	}
	
	function GetGrupo_de_Usuario($id){
		$tabla	=	DB_PREFIJO."tipo_usuarios";
		$this->db->select('tipo_id as id ,tipo,estatus,"prueba" as edit,privilegios')->from($tabla);
		$this->db->where('tipo_id',$id);
		$query	=	$this->db->get();
		return $query->row();
	}
		
	function GetMateria($id){
		$tabla	=	DB_PREFIJO."materias";
		$this->db->select('materia_id as id ,materia,estatus,"prueba" as edit')->from($tabla);
		$this->db->where('materia_id',$id);
		$query	=	$this->db->get();
		return $query->row();	
	}
	
	function GetMaterias($id=false){
		$tabla	=	DB_PREFIJO."materias";
		$this->db->select('materia_id as id ,materia,estatus,"prueba" as edit')->from($tabla);
		if($id){
			$this->db->where('materia_id',$id);
		}
		$query	=	$this->db->get();
		if($id){
			return $query->row_array();	
		}else{
			return foreach_edit($query->result_array());	
		}
	}

	function SetMaterias($var){
		$row	=	$this->db->select('materia_id,materia,estatus')
								->from(DB_PREFIJO."materias")
								->where('materia_id',$var["materia_id"])
								->get()
								->row();
		if(empty($row)){
			unset($var['materia_id']);	
			if($this->db->insert(DB_PREFIJO."materias",$var)){
				return true;	
			}else{
				return $this->db->_error_message();	
			}
		}else{
			$this->db->where('materia_id',$var["materia_id"]);
			unset($var['materia_id']);	
			if($this->db->update(DB_PREFIJO."materias",$var)){
				return true;
			}else{
				return $this->db->_error_message();	
			}
		}
	}
	
	function GetMaestro_Grados($id=false,$seccion=false){
		$tabla	=	DB_PREFIJO."cursos";
		$this->db->select('curso_id as id, curso_id ,curso,estatus,"prueba" as edit')->from($tabla);
		if($id){
			$this->db->where('curso_id',$id);
		}
		$query	=	$this->db->get();
		if($id){
			return $query->row();	
		}else{
			return foreach_edit($query->result_array());	
		}
	}
	
	function SetMaestro_Grados($var){
		$row	=	$this->db->select('curso_id as id, curso_id ,curso,estatus')
								->from(DB_PREFIJO."cursos")
								->where('curso_id',$var["curso_id"])
								->get()
								->row();
		if(empty($row)){
			unset($var['curso_id']);	
			if($this->db->insert(DB_PREFIJO."cursos",$var)){
				return true;	
			}else{
				return $this->db->_error_message();	
			}
		}else{
			$this->db->where('curso_id',$var["curso_id"]);
			unset($var['curso_id']);	
			if($this->db->update(DB_PREFIJO."cursos",$var)){
				return true;
			}else{
				return $this->db->_error_message();	
			}
		}
	}
}
?>