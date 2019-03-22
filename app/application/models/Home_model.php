<?php
/*
	DESARROLLO Y PROGRAMACIÓN
	PROGRAMANDOWEB.NET
	LCDO. JORGE MENDEZ
	info@programandoweb.net
*/
defined('BASEPATH') OR exit('No direct script access allowed');

class Home_model extends CI_Model {

	var $extra;

	public function get_Inmuebles(	$estado=false,
																$banos=false,
																$cuartos=false,
																$metros=false,
																$precio=false,
																$tipo_inmueble=false,
																$start=false,
																$fv=false,
																$tipo=false,
																$lat=false,
																$lng=false,
																$estacionamiento=false
																){
		$init	=	$start;
		if($lat){
			$query 	=	"	SELECT 	SQL_CALC_FOUND_ROWS t1.id as totalizar,
									t1.id,
									t1.direccion,
									t1.precio,
									t1.descripcion,
									t1.tipo_inmueble,
									t1.tipo,
									t1.coordenadas_x,
									t1.coordenadas_y,
									(6371 * ACOS( SIN(RADIANS(t1.coordenadas_x)) * SIN(RADIANS(".$lat."))
									              + COS(RADIANS(t1.coordenadas_y - ".$lng.")) * COS(RADIANS(t1.coordenadas_x))
									              * COS(RADIANS(".$lat."))
									                                )
									) AS distance
										FROM ".DB_PREFIJO."inmuebles t1
									 		WHERE  1=1 ";
		}else{
			$query 	=	"	SELECT 	SQL_CALC_FOUND_ROWS t1.id as totalizar,
										t1.id,
										t1.direccion,
										t1.precio,
										t1.descripcion,
										t1.tipo_inmueble,
										t1.tipo
											FROM ".DB_PREFIJO."inmuebles t1
										 		WHERE  1=1 ";
		}

		if($estado){
			$query 	.=	"		 			AND (estado='".$estado."')";
		}
		if($banos){
			$query 	.=	"		 			AND (banos='".$banos."')";
		}
		if($cuartos){
			$query 	.=	"		 			AND (cuartos='".$cuartos."')";
		}
		if($estacionamiento){
			$query 	.=	"		 			AND (estacionamiento='".$estacionamiento."')";
		}
		if($tipo_inmueble){
			$query 	.=	"		 			AND (tipo_inmueble='".$tipo_inmueble."')";
		}
		if($tipo){
			$query 	.=	"		 			AND (tipo='".$tipo."')";
		}
		if($metros){
			$explode=explode("|",$metros);
			$query 	.=	"		 			AND precio BETWEEN ".$explode[0]." AND ".$explode[1];
		}
		if($fv){
			$query 	.=	"		 			AND t1.id IN (".$fv.")";
		}

		if($lat){
			$query 	.=	"	HAVING distance < 10	 ORDER BY id DESC 	LIMIT ".$init.",".ELEMENTOS_X_PAGINA;
		}else{
			$query 	.=	" ORDER BY id DESC	LIMIT ".$init.",".ELEMENTOS_X_PAGINA;
		}
		$nuevo	=		$this->db->query($query);
		$rows		=		$nuevo->result();
		$nuevo	=		$this->db->query("SELECT FOUND_ROWS() as total");
		$rows2	=		$nuevo->row();

		$data 	=	array();

		foreach($rows as $k => $v){
			$data[$k]				=	$v;
			$data[$k]->hrefStudies	=	base_url("SGS/Alquiler/".$v->id."/".url_title($v->direccion));
			$data[$k]->title				=		$v->direccion;
			$data[$k]->fee_amount		=	format($v->precio,true);
			$data[$k]->descripcion	=	substr($v->descripcion,0,250).'...';
			$data[$k]->nombre				=	$v->tipo_inmueble  . ' ' .$v->tipo;
			$data[$k]->disciplina_disponible_id				=	$v->id;
			$visitas								=	CountVisitas($v->id);
			$data[$k]->views				=	(!empty($visitas))?$visitas->total:0;
			$data[$k]->logo					=	get_imagesInmuebles($v->id,$tablas="*",$main=true,$html=true,$class="img-fluid");
		}

		if(!empty($rows)){
	 		return array(	"data"=>$data,
	 						"total"=>$rows2->total,
	 						"limit"=>ELEMENTOS_X_PAGINA);
	 	}
	}

	public function getInmueble($id,$campos="*"){
		$tabla	=	DB_PREFIJO."anuncio";
		$this->db->select('*');
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


		// $this->db->select($campos)->from(DB_PREFIJO."anuncio");
		// $this->db->where("id",$id);
		// return $this->db->get()->row();
	}

	public function getCaracteristicas($id){
		$this->db->select("t2.*")
			->from(DB_PREFIJO."inmuebles_caract t1")
			->join(DB_PREFIJO."caracteristicas t2","t1.id_caracteristica=t2.id");
		$this->db->where("t1.id_inmueble",$id);
		return $this->db->get()->result();
	}

	public function get($id=false,$di){
		if(is_numeric($id) && !empty($id)){
			return get_Profile($id);
		}else{
			return get_Profiles(0,$id,$di);
		}
	}

	public function get_disciplinas_disponibles($string=false,
												$di=false,
												$ci=false,
												$where2=false,
												$oi=false,
												$bot=false,
												$start=false,
												$precio=false,
												$fv=false){

		$init	=	$start;

		$this->db->select("	t1.title,
												t1.universidad_id,
												t1.disciplina_id,
												t1.subdisciplina_id,
												t1.disciplina_disponible_id,
												t1.universidad_id,
												t1.descripcion,
												t2.fee_amount,
												t2.fee_unit,
												t2.fee_currency,
												t3.parent_profile_id,
												t3.nombre,
												t3.nombre as universidad,
												t1.json");
		$this->db->from(DB_PREFIJO."disciplinas_disponibles t1");
		$this->db->join(DB_PREFIJO."disciplinas_precio t2","t1.disciplina_disponible_id=t2.disciplina_disponible_id","left");
		$this->db->join(DB_PREFIJO."profiles t3","(t1.universidad_id=t3.profile_id OR t1.universidad_id=t3.parent_profile_id)","left");
		if($di){
			$this->db->where("disciplina_id",$di);
		}
		if($oi){
			$this->db->where("universidad_id",$oi);
		}
		if($ci){
			$this->db->where("pais_id",$ci);
		}
		if($fv){
			$this->db->where_in("t1.disciplina_disponible_id",$fv);
		}
		if($where2){
			$this->db->where_in("ciudad_id",$where2);
		}

		if($precio){
			$explode=explode("-", $precio);
			$this->db->where( "t2.fee_amount BETWEEN ".str_replace(",","",$explode[0]) ." AND ".str_replace(",","",$explode[1]) , NULL, FALSE );
		}
		//$this->db->where("title!=","");

		$this->db->limit(ELEMENTOS_X_PAGINA,$init);
		$rows	=	$this->db->get()->result();

		$this->db->select("	COUNT(t1.id) as total	");
		$this->db->from(DB_PREFIJO."disciplinas_disponibles t1");
		if($oi){
			$this->db->join(DB_PREFIJO."profiles t2","(t1.universidad_id=t2.profile_id OR t1.universidad_id=t2.parent_profile_id)","left");
		}else{
			$this->db->join(DB_PREFIJO."profiles t2","t1.universidad_id=t2.profile_id","left");
		}
		if($di){
			$this->db->where("disciplina_id",$di);
		}
		if($oi){
			$this->db->where("universidad_id",$oi);
		}
		if($ci){
			$this->db->where("pais_id",$ci);
		}
		if($fv){
			$this->db->where_in("t1.disciplina_disponible_id",$fv);
		}
		if($where2){
			$this->db->where_in("ciudad_id",$where2);
		}

		if($precio){
			$explode=explode("-", $precio);
			$this->db->where( "t2.fee_amount BETWEEN ".str_replace(",","",$explode[0]) ." AND ".str_replace(",","",$explode[1]) , NULL, FALSE );
		}

		//$this->db->where("title!=","");

		$rows2	=	$this->db->get()->row();

		$data 	=	array();
		foreach($rows as $k => $v){
			$logo 					=	logo($v->universidad_id,'img-fluid');

			if($v->parent_profile_id>0){
				$logo 					=	logo($v->parent_profile_id,'img-fluid');
			}

			$json						=	json_decode($v->json);
			$data[$k]				=	$v;

			$total=$this->db->select("COUNT(t1.id) as total")
											->from(DB_PREFIJO."contador t1")
											->where("t1.disciplina_disponible_id",$v->disciplina_disponible_id)
											->get()->row();

			$data[$k]->views		=	(!empty($total))?$total->total:0;
			$data[$k]->nombre		=	$v->universidad;
			if(empty($v->title)){
				$data[$k]->title		=	($json->name)?$json->name:$v->universidad;
			}else{
				$data[$k]->title		=	$v->title;
			}

			if($this->session->userdata('tc')){
				$trm_											=		$this->session->userdata('trm');
				$data[$k]->fee_currency		=		$trm_->current;
				$data[$k]->fee_amount			=		format($trm_->trm * $v->fee_amount,true);
			}else{
				$data[$k]->fee_amount			=		format($v->fee_amount,TRUE);
			}

			$data[$k]->hrefStudies		=	base_url("PGRW-Studies-".$v->disciplina_disponible_id."-Pre-Law-Studies");
			$data[$k]->hrefUniversity	=	base_url("PGRW-University-".$v->universidad_id."-Pre-Law-Studies");
			if(!empty($logo)){
				$data[$k]->logo = $logo;
      }else{
      	$data[$k]->logo = '<img src="'.IMG.'no-image.png" class="img-fluid">';
      }
		}
		if(!empty($rows)){
	 		return array(	"data"=>$data,
	 						"total"=>$rows2->total,
	 						"limit"=>ELEMENTOS_X_PAGINA);
	 	}else{
	 		if(EXTRACCION==0){
	 			return $rows;
	 		}
	 		return;
	 		if($bot){return array();}
	 		$url =	"Bot/Spider/SearchMain?di=".$di."&search=".$string."&ci=".$where2."&oi=".$oi."&redirect=".current_url();
	 		redirect(base_url($url));
	 	}
	}

	public function get_Courses($string=false,
												$di=false,
												$ci=false,
												$where2=false,
												$oi=false,
												$bot=false,
												$start=false,
												$precio=false,
												$fv=false){

		$init	=	$start;
		$this->db->select("t2.*,t2.json as json_courses, t1.*");
		$this->db->from(DB_PREFIJO."cursos t1");
		$this->db->join(DB_PREFIJO."cursos_perfiles t2","t1.perfil_id=t2.id","left");
		$this->db->limit(ELEMENTOS_X_PAGINA,$init);
		$rows	=	$this->db->get()->result();

		//pre($rows);		return;

		$this->db->select("	COUNT(t1.id) as total	");
		$this->db->from(DB_PREFIJO."cursos t1");
		if($oi){
			//$this->db->join(DB_PREFIJO."profiles t2","(t1.universidad_id=t2.profile_id OR t1.universidad_id=t2.parent_profile_id)","left");
		}else{
			//$this->db->join(DB_PREFIJO."profiles t2","t1.universidad_id=t2.profile_id","left");
		}
		if($di){
			//$this->db->where("disciplina_id",$di);
		}
		if($oi){
			//$this->db->where("universidad_id",$oi);
		}
		if($ci){
			//$this->db->where("pais_id",$ci);
		}
		if($fv){
			//$this->db->where_in("t1.disciplina_disponible_id",$fv);
		}
		if($where2){
			//$this->db->where_in("ciudad_id",$where2);
		}

		if($precio){
			// $explode=explode("-", $precio);
			// $this->db->where( "t2.fee_amount BETWEEN ".str_replace(",","",$explode[0]) ." AND ".str_replace(",","",$explode[1]) , NULL, FALSE );
		}

		$rows2	=	$this->db->get()->row();
		$data 	=	array();
		foreach($rows as $k => $v){
			$data[$k]				=	$v;
			if($this->session->userdata('tc')){
				$trm_											=		$this->session->userdata('trm');
				$data[$k]->fee_currency		=		$trm_->current;
				if(isset($v->fee_amount)){
					$data[$k]->fee_amount			=		format($trm_->trm * $v->fee_amount,true);
				}else{
					$data[$k]->fee_amount			=		format(0.00,true);
				}
			}else{
				if(isset($v->fee_amount)){
					$data[$k]->fee_amount			=		format($v->fee_amount,TRUE);
				}else{
					$data[$k]->fee_amount			=		format(0.00,true);
				}
			}
			$json=json_decode($v->json);
			if(is_object($json) && $json->img){
				$data[$k]->logo 					= 	'<img src="'.$json->img.'" class="img-fluid">';
			}else{
				$data[$k]->logo 					= 	'<img src="'.IMG.'no-image.png" class="img-fluid">';
			}
			$data[$k]->hrefStudies		=		base_url("PGRW-Course-".$v->id."-PGRW");
			$data[$k]->hrefUniversity	=		base_url("PGRW-Academy-".$v->perfil_id."-PGRW");
		}
		if(!empty($rows)){
			return array(	"data"=>$data,
							"total"=>$rows2->total,
							"limit"=>ELEMENTOS_X_PAGINA);
		}else{
			if(EXTRACCION==0){
				return $rows;
			}
			return;
		}
	}

	public function get_Course($id){
		$this->db->select('*,t2.json as json_perfil,t1.json as json_curso,t1.descripcion as desc_curso');
		$this->db->from(DB_PREFIJO."cursos t1");
		$this->db->join(DB_PREFIJO."cursos_perfiles t2","t1.perfil_id=t2.id","left");
		$this->db->where("t1.id",$id);
	 	$rows=$this->db->get()->row();
	 	return $rows;
	}

	public function get_disciplina_disponible($di){
		$this->db->select('*')
		         ->from(DB_PREFIJO."disciplinas_disponibles");
		$this->db->where("disciplina_id",$di);
	 	$rows=$this->db->limit(ELEMENTOS_X_PAGINA)->get()->row();
	 	return $rows;
	}

	public function get_profile($di){
		return get_Profile($di,$update=true);
	}

	public function get_Study($disciplina_disponible_id){
		return get_Study($disciplina_disponible_id,$update=true);
	}

	public function get_cities($like=false){
		if(!is_numeric($like)){
			$this->db->select('*')->from(DB_PREFIJO."paises");
	 		$this->db->like("pais",$like);
	 		$this->db->order_by('pais', 'asc')->limit(ELEMENTOS_X_PAGINA)->get()->result();
		}else{
			$this->db->select('*')->from(DB_PREFIJO."paises");
	 		return $this->db->like("pais_id",$like)->get()->row();
		}
	}
}
?>
