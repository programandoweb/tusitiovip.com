window.onload = miconstructor;
$(document).ready(function(){
	remove_flash();
	_confirm();
	clonar();
	lightbox();
	sobrescribir();
	btn_up_foto();
	registro_unico();
	password();
	$('.tooltip').tooltip();
	historyback();
	cuadrado();
	//education_init();
	menu_lateral();
	content_ajax();
	fixedmenu();
	cookies();
	favourite();
	radio_select();
	tooltip();
	edit();
});

function edit(){
	var element 	=	$(".btn-edit");
	if(element.length>0){
		element.each(function(index,v){
			if($(v).data("form")){
				$(v).click(function(){
					parent	=		$(v).parent("div");
					parent.addClass("active");
					parent.find(".toggle").toggle();
					parent.find(".close-toggle").unbind( "click" );
					parent.find(".close-toggle").click(function(){
						parent.find(".toggle").toggle();
					})
				})
			}
		})
	}
}

function toggle(){
	var element 	=	$(".btn-edit");
	if(element.length>0){
		element.each(function(index,v){
			console.log(v)
		})
	}
}

function tooltip(){
	$('.btn-tooltip').tooltip();
}

function radio_select(){
	if($(".radio_select").length>0){
		$(".radio_select").each(function(k,v){
			$(this).find("input[type='radio']").hide();
		});
	}
}

function favourite(){
	if($(".favourite").length>0){
		$(".favourite").each(function(k,v){
			$(this).click(function(){
				alert(4);
			})
		});
	}
}

function cookies(){
	if(!$.cookie("accepted_cookie")){
			// var content_warning 	=	'<div class="modal fade bottom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false"> <div class="modal-dialog modal-full-height modal-bottom modal-notify modal-danger" role="document"> <div class="modal-content"> <div class="modal-header"> <p class="heading lead">COOKIES POLICY</p>  </div> <div class="modal-body"><p>We use cookies to help us improve website user experience. If you continue, we\'ll assume that you are happy for us to use cookies for this purpose.</p></div><div class="modal-footer"><a type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">I agree</a></div></div></div></div>';
			var content_warning 	=	'<div class="modal fade bottom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="false"> <div class="modal-dialog modal-full-height modal-bottom modal-notify modal-danger" role="document"> <div class="modal-content"> <div class="modal-body"><p>We use cookies to help us improve website user experience. If you continue, we\'ll assume that you are happy for us to use cookies for this purpose.</p></div><div class="modal-footer"><a type="button" class="btn btn-outline-danger waves-effect" data-dismiss="modal">I agree</a></div></div></div></div>';
			content_warning 	= $(content_warning);
			$("body").append(content_warning);
			content_warning.modal();
			content_warning.find(".btn-outline-danger").click(function(){
					$.cookie("accepted_cookie", 1);
			});
	}
	// $.cookie("test", 1); //set cookie
	// $.cookie("test"); //get cookie
	// $.cookie('test', null); //delete cookie
}

function fixedmenu(){
	var contents 	=	$( ".fixed-menu" );
	if(contents.length>0){
		contents.each(function(index,v){
			content=$(v);
			content.find(".block-menu .item").slimScroll({
        		height: '180px',
        		width:content.width()
    		});
		});
	}
}

function content_ajax(){
	var contents 	=	$( ".content_ajax" );
	if(contents.length>0){
		clone=contents.find(".base_items");
		get_post(contents);
		$(window).scroll(function (event) {
			div     =   $( ".base_items:last" );
			offset  =   div.offset();
			sc 		= 	parseInt($(window).scrollTop());
			set_now	=	offset.top -	sc;
		    if(set_now<2000 && contents.data("status")==0){
				contents.data("status",1);
		    	contents.data("start",contents.attr("data-start"))
		    	get_post(contents);
		    }
		})
	}
}

function get_post(div){
	$.post(div.data("url"),div.data(),function(data){
		if(data.response){
			$(".num_results").html(data.response.total);
			$.each(data.response.data, function(k2,v2){
				clone_items1(v2,clone.clone(),div);
			});
			start 	=	 parseInt(div.data("start"))
			div.attr("data-start", start + 10 );
			clone.hide();
		}else{
			clone.find(".loading").remove();
			clone.find(".content_listado").html('<div class="text-center"><i class="far fa-tired fa-5x"></i> <br/>No results have appeared</div>');
		}
	},"json").always(function() {
    	//alert( "finished" );
    	div.data("status",0);

  	});
}

function clone_items1(data,item,contents){
	item.find("div.loading").remove();
	item.find("div.content .logotipo").html(data.logo);
	item.find("div.content .disciplina").html('<i class="fas fa-graduation-cap mr-1"></i>'+data.title);
	item.find("div.content .universidad").html('<i class="fas fa-university mr-1"></i>'+data.nombre);
	item.find("div.content .intro").html(data.descripcion);
	item.find("div.content .hrefStudies").attr("href",data.hrefStudies);
	item.find("div.content .hrefUniversity").attr("href",data.hrefUniversity);
	item.find("div.content .price").show();
	item.find("div.content .amount").html(data.fee_amount);
	item.find("div.content .unit").html(data.fee_unit);
	item.find("div.content .currency").html(data.fee_currency);
	item.find("div.content .ico-primary .views").html(data.views);
	item.find("div.content .ico-secundary").click(function(){
		set_favourite(data.disciplina_disponible_id);
		toogleIco(item.find("div.content .ico-secundary i"),{inactivo:"far fa-heart",activo:"fas fa-heart"});
	});
	if(get_favourite(data.disciplina_disponible_id)>0){
		toogleIco(item.find("div.content .ico-secundary i"),{inactivo:"far fa-heart",activo:"fas fa-heart"});
	}
	item.find("div.content .reviews").removeClass("hide");
	contents.append(item.show());
}

function get_favourite(profile){
		var _return=0;
		if(!$.cookie("favourite")){
			_return	=	0;
		}else{
			$.each($.parseJSON($.cookie("favourite")),function(k,v){
				if(profile==v){
					_return=1;
				}
			});
		}
		return _return;
}

function set_favourite(profile){
	var favourite=$.cookie("favourite");
	var exists=0;
	if(!favourite){
		data_to_save	= new Array();
		data_to_save	=	[profile];
		$.cookie("favourite", JSON.stringify(data_to_save));
		_return  = "active";
	}else{
		data_to_save	= $.parseJSON(favourite);
		$.each($.parseJSON(favourite),function(k,v){
			if(profile==v){
				exists=1;
			}
		})
		if(exists==0){
				_return  = "active";
				data_to_save.push(profile);
		}else{
				data_to_save.splice($.inArray(profile, data_to_save),1);
				_return  = "inactive";
		}
		$.cookie("favourite", JSON.stringify(data_to_save));
		return _return;
	}
}

function toogleIco(objeto,clase_css){
	if(objeto.hasClass(clase_css.inactivo)){
		objeto.removeClass(clase_css.inactivo).addClass(clase_css.activo);
	}else if(objeto.hasClass(clase_css.activo)){
		objeto.removeClass(clase_css.activo).addClass(clase_css.inactivo);
	}
}

function menu_lateral(){
	var menu 		= 	$( ".menu_lateral");
	var active 		=	menu.data("select");
	var buscar		=	menu.find('[data-di="'+active+'"]');
	$('[data-sdi="'+active+'"]').find("a").css("color","#000").css("font-size","14px").css("font-weight","bold");
	$("#contenedo_lis").html($('[data-sdi="'+active+'"]')).append(buscar);
	if(buscar.length>1){
		items_rel	=	$('[data-di="'+active+'"]');
		items_rel.each(function(k,v){
			$(v).removeClass("hide");
		});
	}else{
		buscar		=	menu.find('[data-sdi="'+active+'"]');
		items_rel 	=	menu.find('[data-di="'+buscar.data("di")+'"]')
		items_rel.each(function(k,v){
			$(v).removeClass("hide");
		});
	}
	if(menu.data("url")){
		$.post(menu.data("url"),function(data){
			$.each(data.response.data,function(k,v){
				$("#carrera_"+v.disciplina_id).html(" ("+v.total+") ").fadeIn();
			})
		},"json");
	}
}

function cuadrado(){
	if($( ".cuadrado").length>0){
		$( ".cuadrado").each(function(k,v){
			$(this).height($(this).width());
		});
	}
}

function education_init(){
	if($( "div.content_listado").length>0){
		//getDataBG($( "div.content_listado:last" ));
		$(window).scroll(function (event) {
			div     =   $( "div.content_listado:last" );
			offset  =   div.offset();
	        sc 		= 	$(window).scrollTop();
	        var set_now	=	offset.top -	sc;
	        if(set_now<1000 && div.data("estatus")==0){
	        	div.data("estatus",1);
	        	$.post(div.data("url"),{	ci:div.data("ci"),
	        								tc:div.data("tc"),
	        								precio:div.data("precio"),
	        								duracion:div.data("duracion"),
	        								presencia:div.data("presencia"),
	        								where2:div.data("where2"),
	        								di:div.data("di"),
	        								search:div.data("search"),
	        								init:div.data("rel")
	        							},
	        		function(data){
	        		inc	=	1;
					$.each(data.response, function(index, value) {
						clon	=	div.parent(".block").clone();
						clon.find(".content").data("rel",div.data("rel")+inc);
						clon.find(".content").data("estatus",0);
						clon.find(".content").find(".logotipo").html(value.logo);
						clon.find(".content").find("b").find("a").html(value.title);
						clon.find(".content").find("b").find("a").attr("href",value.url)
						clon.find(".content").find("div.intro").html(value.descripcion);
						clon.find(".content").find(".price").find(".amount").html(value.fee_amount);
						clon.find(".content").find(".price").find(".unit").html(value.fee_unit);
						clon.find(".content").find(".price").find(".currency").html(value.fee_currency);
						$("#listados").append(clon);
						inc++;
					});
	        	},"json");
	        	//getDataBG(div);
	    	}
	    });
	}
}

function historyback(){
	$(".historyback").click(function(event){
		event.preventDefault();
		window.history.back();
	});
}

function search_in_object(rows,_search){
	/*LO QUE BUSCABA PARA EL RETURN EN JS*/
	var obj = $.grep(rows, function(obj){ return obj.id === _search;})[0];
	return obj;
}

function add_inventario(){
	var items	= 	$(".add_inventario");
	if(items.length>0){
		items.each(function(index,v){

		})
	}
}

function add_receta(){
	var items	= 	$(".recetas");
	if(items.length>0){
		items.each(function(index,v){
			var span	=	$(v).find("span");
			if(span.length<5){
				$(this).find("i").show().click(function(){
					var ico	=	$(this);
					$(".agregar_receta").unbind().click(function(){
						$.post(ico.attr("data-action"),{receta_id:$(this).attr("data-value"),receta:$(this).attr("data-receta")},function(data){

						},'json');
					})
					$(".agregar_receta").attr("data-pedido",$(this).attr("data-pedido"));
				});
			}
		})
	}
}

function delete_row(variable){
	$("#"+variable).removeClass().addClass('zoomOut animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
		//$(this).removeClass();
		$(this).remove();
	});
	/*lightSpeedOut	*/
}

$( function() {
	// $( ".datepicker" ).datepicker();
	// //$( ".datepicker" ).datepicker({ minDate: "-3M -1D", maxDate: "+3M +1D" });
	// //$( ".datepicker" ).datepicker({ changeMonth: true, changeYear: true });
	// $( ".datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
});

function miconstructor(){
  $(".progress").find(".indeterminate").hide();
}

function password(){
	$("#submit_pass").addClass("disabled");
	var inputs	= $("[password=true]");
	if(inputs.length>0){
		inputs.each(function(index,v){
			$(this).attr("type","password");
			$(this).keyup(function(){
				if($(this).val()!=''){
					disabled($(this));
				}
			});
		})
	}
}
function disabled(obj){
	if(obj.val()!=$("#"+obj.data("rel")).val()){
		$("#submit_pass").addClass("disabled");
	}else{
		$("#submit_pass").removeClass("disabled");
	}
}

function base(){
	return $("body").data("base")
}

function ApiRest(){
	return $("body").data("base")+'/ApiRest/'
}

function active(obj){
	$("#"+obj).css("background","#FF9B9B");
	$(".submit").addClass("disabled");
}

function inactive(obj){
	$("#"+obj).css("background","none");
}

function registro_unico(){
	$("[registro_unico=true]").each(function(index,v){
		var input	=	$(this);
		input.keyup(function(){
			$.post(ApiRest()+'User/Get',{"search":$(this).val(),"type":"usuarios","name":$(this).attr("name")},function(data){
			},'json').fail(function() {
				alert("Error consulte al administrador de sistemas");
			}).always(function(data) {
				if(data.message){
					alert(data.message);
				}
				if(data.code==200){
					var redirect = elem.find('[name="redirect"]');
					if( redirect.length >0){
						setInterval(function(){ document.location.href	=	redirect.val(); }, 2000);
					}
				}
				if(data.callback){
					eval(data.callback);
				}
			});
		});
	})
}

function btn_up_foto(){
	var btns		=	$(".btn_up_foto");
	var div			=	$("<div/>");
	var input_file	=	$('<div class="absolute"><div class="custom-file"><input type="file" name="userfile" class="custom-file-input" id="input_compadre" required><i class="custom-file-label-ico fas fa-camera fa-2x"></i></div></div>');
	if(btns.length>0){
		btns.each(function(index,v){
			var contenedor	=	$(this);
			contenedor.prepend(input_file);
			var form 		= 	$(this).parents('form:first');
			var formData	= 	new FormData();
			input_file.find("input").change(function(){
				formData.append("userfile", input_file.find("input").get(0).files[0]);
				formData.append("userfile", true);
				formData.append("usuario_id", form.find('input[name="usuario_id"]').val());
				formData.append("login", form.find('input[name="login"]').val());
				var ajaxRequest =	$.ajax({
												url: form.attr("action"), // Url to which the request is send
												type: "POST",             // Type of request to be send, called as method
												data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
												dataType: 'json',
												contentType: false,       // The content type used when sending data to the server.
												cache: false,             // To unable request pages to be cached
												processData:false,        // To send DOMDocument or non processed data file it is set to false
												success: function(data){
													if(data.callback){
														eval(data.callback);
													}
												}
									});
				ajaxRequest.done(function(xhr, textStatus) {

				});
			})
		});
	}
}

function sobrescribir(){
	$("input.sobrescribir").each(function(index,v){
		var span			=	$("#span_"+$(this).attr("id"));
		var text_default	=	span.text();
		if(span.length>0){
			if($(this).val()!=''){
				span.html($(this).val())
			}
			$(this).keyup(function(){
				if($(this).val()!=''){
					span.html($(this).val());
				}else{
					span.html(text_default);
				}
			});
		}
	});
	$("select.sobrescribir").each(function(index,v){
		var span			=	$($(this).data("rel"));
		var _default		=	span.attr("class");
		if(span.length>0){
			$("img#img").attr("src",$(this).children('option:selected').data("image"));
			span.removeClass().addClass($(this).children('option:selected').data("color"));
			$(this).change(function(){
				if($(this).val()!=''){
					span.removeClass().addClass($(this).children('option:selected').data("color"));
					//$("img#img").attr("src",$(this).children('option:selected').data("image"));
				}else{
					span.removeClass().addClass($(this).children('option:selected').data("color"));
					//$("img#img").attr("src",$(this).children('option:selected').data("image"));
				}
			});
		}
	})
}

function submit_via_ajax(){
	$("form[ajax]").each(function(index,v){
		var form	=	$(this);
		if(parent.$(".submit").length>0){
			parent.$(".submit").click(function(){
				form.submit();
				setTimeout(function(){ parent.$modal.modal('hide');}, 3000);
			});
		}
	})
}

function DataTable(){
	var newURL 		=	$(location).attr('href');
	var columnas	=	$('#perfiles thead th')
	var descripcion	=	[];
	columnas.each(function(index,v){
		descripcion[index]	=	{"data": $(v).data("columna")};
	})
	var order	=	$('#perfiles').data("order");
	var desc	=	$('#perfiles').data("desc");
	if(!order){order=0;}
	if(!desc){desc="asc";}else{desc="desc";}
	var table		=	$('#perfiles').DataTable({
		ajax: newURL,
		"processing": true,
		"serverSide": true,
		"language": {
			"url": $("body").data("lang")
		},
		"order": [[ order, desc ]],
		"columns": descripcion
	});

	if($('#perfiles').hasClass( "openmodal" )){
		$('#perfiles tbody').on( 'click', 'a', function () {
			make_modal_ajax($(this));
			return false;
		});
	}
	$('#perfiles tbody').on( 'click', 'input', function () {
		$(this).unbind('keyup');
		$(this).keyup(function(e){
			var elem=$(this);
			if(e.which == 13) {
				$.post($(this).attr("href"),{receta_id:$(this).attr("data-recetaid"),cantidad_entrada:$(this).val()},function(data){
					if(data.cantidad){
						elem.parent("td").parent("tr").find("td .inventario_nuevo").html(data.cantidad);
						elem.val('');
					}
				},'json')
			}
		});
		return false;
	});
	return table;
}

function formatNumber (n) {
            n = String(n).replace(/\D/g, "");
          return n === '' ? n : Number(n).toLocaleString();
        }

function CalcularDv(){
     var arreglo, x, y, z, i, nit1, dv1;
        nit1= $('#identificacion').val();
        if (isNaN(nit1))
        {
        $('#identificacion_ext').val("X");
          make_message('Importante','Número del Nit no valido, ingrese un número sin puntos, ni comas, ni guiones, ni espacios');
        }else{
        arreglo = new Array(16);
        x=0 ; y=0 ; z=nit1.length ;
        arreglo[1]=3;   arreglo[2]=7;   arreglo[3]=13;
        arreglo[4]=17;  arreglo[5]=19;  arreglo[6]=23;
        arreglo[7]=29;  arreglo[8]=37;  arreglo[9]=41;
        arreglo[10]=43; arreglo[11]=47; arreglo[12]=53;
        arreglo[13]=59; arreglo[14]=67; arreglo[15]=71;
      for(i=0 ; i<z ; i++)
        {
         y=(nit1.substr(i,1));
         x+=(y*arreglo[z-i]);
        }
      y=x%11
      if (y > 1){ dv1=11-y; } else { dv1=y; }
        $('#NumVer').val(dv1);

        }
    }

function notificaciones(){
	var num_intentos_fallidos=0;
	var url_notificaciones	=	$("body").data("notificaciones");
	if(url_notificaciones!='undefined'){
		var interval	=	setInterval(function(){ $.post(url_notificaciones,{token:$("body").data("token")},function(data){
			if(data.code==203){
				if(num_intentos_fallidos>=3){
					clearInterval(interval);
					return false;
				}else{
					num_intentos_fallidos++;
				}
			}else if(data.code==200){
				if(data.rows.length>0){
					var resumen='';
					$.each(data, function (index, value) {
						resumen += value;
					});
					make_message("Notificaciones","Tienes nuevas actividades qué realizar<br><a href='Utilidades/List_Notificaciones'> Ver </a>");
				}
			}
		},'json');}, 10000);
	}
}

function printer(){
	$(".fa-print").parent("a").click(function(event){
		printDiv();
		event.preventDefault();
	});
}
function printDiv() {
	var contenido= document.getElementById("imprimeme").innerHTML;
	var contenidoOriginal= document.body.innerHTML;
	document.body.innerHTML = contenido;
	window.print();
	document.body.innerHTML = contenidoOriginal;
}

function format_num(){
	$(".format_num").number( true, 2 );
}

function anular(){
	$(".anular").click(function(){
		make_message($(this).data("title"),$(this).data("message"));
		return false;
	})
}

function error(title,message){
	make_message(title,message);
	return false;
}

function makeCanvas(ctx){
	eval('var objeto ='+ctx.data("objeto"));

	var	andres			=	{	'Red':{"bg":"rgba(255, 99, 132, 0.2)","bd":"rgba(255,99,132,1)"},
								'Blue':{"bg":"rgba(54, 162, 235, 0.2)","bd":"rgba(54, 162, 235, 1)"},
								'Yellow':{"bg":"rgba(255, 206, 86, 0.2)","bd":"rgba(255, 206, 86, 1)"},
								'Green':{"bg":"rgba(75, 192, 192, 0.2)","bd":"rgba(75, 192, 192, 1)"},
								'Purple':{"bg":"rgba(153, 102, 255, 0.2)","bd":"rgba(153, 102, 255, 1)"},
								'Orange':{"bg":"rgba(255, 159, 64, 0.2)","bd":"rgba(255, 159, 64, 1)"},
								'Agua_Amarilla':{"bg":"rgba(152, 102, 255, 0.2)","bd":"rgba(153, 102, 255, 1)"},
								'b':{"bg":"rgba(151, 102, 255, 0.2)","bd":"rgba(153, 102, 255, 1)"},
								'c':{"bg":"rgba(150, 102, 255, 0.2)","bd":"rgba(153, 102, 255, 1)"},
								'e':{"bg":"rgba(149, 102, 255, 0.2)","bd":"rgba(153, 102, 255, 1)"}
							};


	var backgroundColor	=	[];
	var	borderColor		=	[];
	var	datos			=	[];

	$.each(objeto.colores,function(index,valor){
		backgroundColor[index]	= 	eval("andres."+valor+".bg");
		borderColor[index]		= 	eval("andres."+valor+".bd");
	})

	var myChart = new Chart(ctx, {
			type: objeto.type,
			data: {
				labels: objeto.colores,
				datasets: [{
					label: objeto.label,
					data: objeto.valores,
					backgroundColor: backgroundColor,
					borderColor: borderColor,
					borderWidth: 1
				}]
			},
			options: {
				title: {
					fontSize: 24,
					display: true,
					text: objeto.text
				},
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero:true
						}
					}]
				}
			}
		});

}

function dolar(){
	var valor_dolar	=	$("#get_datos_dolar").html();
		$("#deposita_aqui_dolar").html(valor_dolar);
		$("#get_datos_dolar").remove();
}

function clonar(){
	var objetos		= 	$("[clonar]");
	objetos.each(function(index,v){
		var	elem	=	$(this);
		var add		=	$(this).find("div.clonar");
		add.click(function(){
			var inputs		=	elem.find("input");
			var continue_	=	true;
			inputs.each(function(){
				var	input				=	$(this);
				var grand_contenedor	=	input.parent("div").parent("div.form-group");
				if(input.val()==''){
					make_message("Error","Debe Completar todos los datos");
					continue_			=	false;
					return false;
				}
			})
			if(continue_){
				var clon	=	elem.clone();
				clon.appendTo( "#"+elem.data("padre") );
				clon.find("input").removeAttr("type").attr("type","hidden");
				elem.find("input").val("");
				clon.find(".clonar").click(function(){
					clon.remove();
				});
				clon.find(".clonar").find("i").removeClass("fa-plus").addClass("fa-trash");
				clon.find(".d-none").removeClass();
			}
		});
	})

}


function validar_file_upload(){
	forms		=	$( "form" );
	forms.each(function(index,v){
		var _return = 	true;
		$(v).submit(function(){
			var inputs		=	$(v).find("input:file");
			inputs.each(function(index,v2){
				var v2	=	$(v2);
				if(v2.val()==''){
					_return	=	false;
					return false;
				}
				extensiones_permitidas 	= 	v2.data("filetype");
				eval(extensiones_permitidas);
				if(filtroExtensionPermitida(v2.val(),filestype)==false){
					_return	=	false;
					return false;
				}

				if(v2.val()!=''){
					if(window.File && window.FileReader && window.FileList && window.Blob){
						if(this.files[0].size > v2.data("sizemax")){
							make_message("Error en Formulario","El archivo supera el peso permitido");
							_return	=	false;
							return false;
						}
					}else{
						// IE
						var Fs = new ActiveXObject("Scripting.FileSystemObject");
						var ruta = document.upload.file.value;
						var archivo = Fs.getFile(ruta);
						var size = archivo.size;
						if(size > v2.data("sizemax")){
							make_message("Error en Formulario","El archivo supera el peso permitido");
							_return	=	false;
							return false;
						}
					}
				}

			});
			if(_return==false){
				return false;
			}else{
				return true;
			}
		});
	});
}

function filtroExtensionPermitida(archivo,extensiones_permitidas){
	var mierror		= 	"";
	var _return 	= 	false;
	var permitida 	= 	false;
	if(!extensiones_permitidas){
   		extensiones_permitidas 	= 	new Array(".gif", ".jpg", ".doc", ".pdf");
	}
	extension 		= 	(archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
	if(extensiones_permitidas.length<1){
		return false;
	}
	for (var i = 0; i < extensiones_permitidas.length; i++) {
		 if (extensiones_permitidas[i] == extension) {
		 	permitida 	= true;
		 	break;
		 }
	  }
	if (!permitida) {
		mierror 	= 	"Comprueba la extensión de los archivos a subir. \nSólo se pueden subir archivos con extensiones: " + extensiones_permitidas.join();
		make_message("Error en Formulario",mierror);
		return false;
	}else{
		//alert ("Todo correcto. Voy a submitir el formulario.");
		return true;
	}
}

function comprueba_extension(formulario, archivo,extensiones_permitidas) {
	if(!extensiones_permitidas){
   		extensiones_permitidas 	= 	new Array(".gif", ".jpg", ".doc", ".pdf");
	}

   	mierror = "";
	if (!archivo) {
	  //Si no tengo archivo, es que no se ha seleccionado un archivo en el formulario
	   mierror = "No has seleccionado ningún archivo";
	}else{
	  //recupero la extensión de este nombre de archivo
	  extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
	  //alert (extension);
	  //compruebo si la extensión está entre las permitidas
	  permitida = false;
	  for (var i = 0; i < extensiones_permitidas.length; i++) {
		 if (extensiones_permitidas[i] == extension) {
		 permitida = true;
		 break;
		 }
	  }
	  if (!permitida) {
		 mierror = "Comprueba la extensión de los archivos a subir. \nSólo se pueden subir archivos con extensiones: " + extensiones_permitidas.join();
	   }else{
		  //submito!
		 alert ("Todo correcto. Voy a submitir el formulario.");
		 formulario.submit();
		 return 1;
	   }
	}
	//si estoy aqui es que no se ha podido submitir
	alert (mierror);
	return 0;
}

function make_message(title,message,size,height){
	if(!size){
		size	=	'modal-sm';
	}
	if(!height){
		height	=	'450';
	}
	$modal			=	modal.clone();
	var contenido  	=	$modal.find(".modal-dialog").find(".modal-content");
		$modal.addClass("pgrw_modal_confirm_ajax").attr("aria-labelledby","modalLabel_confirm_ajax").find(".modal-dialog").addClass(size);
		contenido.find(".modal-header").html("<h5>"+title+"</h5>");
		contenido.find(".modal-footer").html('<button type="button" class="btn btn-warning cancelar" data-dismiss="modal">Cerrar</button>');
	$("body").append($modal);
	$modal.find(".modal-body").html('<div class="text-center"> '+message+'</div>');
	$modal.modal({ keyboard: false})
}

function input_dinamico(){
	inputs	=	$("[input_dinamico]");
	inputs.each(function(index,v){
		var input 		=	$(v);
		var default_	=	input.val();
		var form		=	input.parent( "form" );
		var send		=	true;
		input.dblclick(function(){
			send		=	true;
			$("[input_dinamico]").attr("readonly","readonly").unbind( "keypress" );
			$(this).removeAttr("readonly").keypress(function(e){
				if(e.which ==13){
					if(default_	!=$(this).val() && send==true){
						post_ajax(form);
						send	=	false;
					}
				}
			});
		});
		input.focusout(function(){
			$("[input_dinamico]").attr("readonly","readonly").unbind( "keypress" );
			if(default_	!=$(this).val() && send==true){
				post_ajax(form);
				send	=	false;
			}
		});
	});
}

function post_ajax(form){
	$.post(form.attr("action"),form.serialize(),function(data){
	},'json').fail(function() {
		alert("Error consulte al administrador de sistemas");
	}).always(function(data) {
		if(data.message){
			alert(data.message);
		}
		if(data.code==200){
			$("[input_dinamico]").attr("readonly","readonly").unbind( "keypress" );
			if( data.redirect ){
				setInterval(function(){ document.location.href	=	data.redirect.val(); }, 2000);
			}
		}
		if(data.callback){
			eval(data.callback);
		}
	});
}

function closeAll(){
	$(document).keyup(function (event) {
		if (event.which === 27) {

		}
	});
}

var	modal	=	$('<div class="modal fade " tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"></div><div class="modal-body"></div><div class="modal-footer"></div></div></div></div>');
/*MODAL */
function lightbox(){
	btns	=	$(".lightbox");
	btns.each(function(index,v){
		var btn =	$(v);
		btn.click(function(event){
			make_modal_ajax(btn);
			return false;
		})
	});
}

function make_modal_ajax(obj){
	var size		=	obj.data("size");
	var height		=	obj.data("height");
	var btnsuccess	=	obj.data("btnsuccess");
	if(btnsuccess){
		var btn_save	=	$('<button type="button" class="btn btn-primary submit"><i class="fas fa-save"></i> Guardar</button>')
	}else{
		var btn_save	=	$('<div/>');
	}
	if(!size){
		size	=	'modal-lg';
	}
	if(!height){
		height	=	'400';
	}

	$modal			=	modal.clone();
	var contenido  	=	$modal.find(".modal-dialog").find(".modal-content");
		$modal.addClass("pgrw_modal_confirm_ajax").attr("aria-labelledby","modalLabel_confirm_ajax").find(".modal-dialog").addClass(size);
		contenido.find(".modal-header").html("<h5>"+'<i class="fas fa-info-circle"></i> ' +obj.attr("title")+"</h5>");
		contenido.find(".modal-footer").html('<button type="button" class="btn btn-danger cancelar" data-dismiss="modal"><i class="fas fa-window-close"></i> Cerrar</button>');
		if(obj.data("form")){contenido.find(".modal-footer").prepend(btn_save);}
	$("body").append($modal);
	$modal.find(".modal-body").html('<div class="text-center"><i class="fa fa-cog fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span></div>');
	if(obj.data("type")=='iframe'){
		$iframe		=	$('<iframe src="'+obj.attr("href")+'" allowfullscreen="" frameborder="0" width="100%" height="100%" />');
		$modal.find(".modal-body").css("height",height+"px").html($iframe);
	}else if(obj.data("type")=='ajax'){
		$.post(obj.attr("href"),{},function(data){
			$modal.find(".modal-body").height(height).html(data);
			$.pgrwForms();
		})
	}
	$modal.modal({ keyboard: true}).on('hidden.bs.modal', function (e) {
   		$modal.remove();
	})
}


/*MODAL END */

function pgrw_ajax(){
	var elem	=	$("[pgrw-ajax]");
	elem.each(function(index,v){
		var element		=	$(v);
		var atributos	=	element.attr("pgrw-ajax");
		atributos 		= 	eval("("+atributos+")");
		var contenedor	=	atributos.contenedor;
		var url			=	atributos.url;
		element.change(function(){
			$.post(url,{id:$(this).val()},function(data){
				$(contenedor).empty();
				$(contenedor).html(data);
			})
		})
	});
}

function form_ajax(){
	var elem	=	$("[ajax]");
	elem.each(function(index,v){
		var form		=	$(v);
		form.submit(function( event ) {
			var feedback				=	contenedor_message.clone();
			form.find('[require]').each(function(indice,objeto){
				var	input				=	$(objeto);
				var grand_contenedor	=	input.parent("div").parent("div.form-group");
				if(input.val()==''){
					if(grand_contenedor.find(".contenedor_message").length==0){
						feedback.find(".form-control-feedback").html(message.form_require);
						grand_contenedor.addClass(hasestatus.danger).find("div").append(feedback);
						fx(feedback);
						input.focus().addClass(formcontrol.danger);
					}
					return false;
				}
			});
			return false;
		});
	});
}

function _confirm(){
	var obj			=	$("[confirm='true']");
	obj.each(function(index,v){
		var elem	=	$(v);
		elem.click(function(){
			if(confirm("Está seguro de borrar este registro?")){
			}else{
				return false;
			}
		});
	});
}

function _post(){
	$.post(elem.attr("href"),function(data){

	},'json').fail(function() {
		alert("Error consulte al administrador de sistemas");
	}).always(function(data) {
		if(data.message){
			alert(data.message);
		}
		if(data.code==200){
			var redirect = elem.find('[name="redirect"]');
			if( redirect.length >0){
				setInterval(function(){ document.location.href	=	redirect.val(); }, 2000);
			}
		}
		if(data.callback){
			eval(data.callback);
		}
	});
}

function reloader_iframe(){
	parent.location.reload();
	//window.opener.location.reload()
	//document.location.reload();

}

function remove_flash(){
	var elem		=	$("#flash");
	var contenido	=	elem.find("div");
	if(elem.find("div").length>0){

		setTimeout(function(){contenido.addClass("animated fadeOutUp");elem.html("");}, 3500);
	}
}

function fx(obj,fx){
	if(!fx){fx	=	'bounceIn';}
	obj.addClass("animated animated "+fx+" active");
	setTimeout(function(){obj.removeClass("animated animated bounceIn");}, 1000);
}

jQuery.fn.SoloNumeros =
  function() {
    return this.each(function() {
      $(this).keydown(function(e) {
        var key = e.charCode || e.keyCode || 0;
        return (
          key == 8 ||
          key == 9 ||
          key == 46 ||
          (key >= 37 && key <= 40) ||
          (key >= 48 && key <= 57) ||
          (key >= 96 && key <= 105));
      });
    });
};
