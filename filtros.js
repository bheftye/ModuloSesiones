function lista(cantidad, e) {
	e.preventDefault();

	$.ajaxSetup({
		cache : false
	});
	$.ajax({
		async : true,
		type : "POST",
		dataType : "html",
		contentType : "application/x-www-form-urlencoded",
		url : "operaciones.php",
		data : {
			"operaciones" : "listapropiedad"
		},
		success : getInformation,
		beforeSend : SendInformation,
		cache : false
	});
}
function buscarPorPalabra(cadena){
	if(cadena!=""){
		$.ajaxSetup({
			cache : false
		});
		$.ajax({
			async : true,
			type : "POST",
			dataType : "html",
			contentType : "application/x-www-form-urlencoded",
			url : "operaciones.php",
			data : {
				"cadena" : cadena,
				"operaciones" : "buscarpropiedad"
			},
			success : getInformation,
			beforeSend : SendInformation,
			cache : false
		});
	}else{
		lista("10",event);
	}
}

function buscarPaquetePorPalabra(cadena){
	if(cadena!=""){
		$.ajaxSetup({
			cache : false
		});
		$.ajax({
			async : true,
			type : "POST",
			dataType : "html",
			contentType : "application/x-www-form-urlencoded",
			url : "operaciones.php",
			data : {
				"cadena" : cadena,
				"operaciones" : "buscarpaquete"
			},
			success : despliegaResultadosDePaquetes,
			beforeSend : SendInformation,
			cache : false
		});
	}else{
		listaPaquete("10",event);
	}
}

function listaPaquete(cantidad, e){
	e.preventDefault();

	$.ajaxSetup({
		cache : false
	});
	$.ajax({
		async : true,
		type : "POST",
		dataType : "html",
		contentType : "application/x-www-form-urlencoded",
		url : "operaciones.php",
		data : {
			"operaciones" : "listapaquete"
		},
		success : despliegaResultadosDePaquetes,
		beforeSend : SendInformation,
		cache : false
	});
}

function despliegaResultadosDePaquetes(data){
	//alert(data);
	console.log(data);	
	var texto = "";
	var img ="";
	var funcion = "";
	var img2 ="";
	var funcion2 = "";
	var total=0;
	var resultado = JSON.parse(data);
	$("tbody").empty();
	var contador = 0;	
	if(data!="0"){
		for (var i in resultado){
			if(resultado[i].status!="0"){
				img='img/visible.png';
				funcion='Desactivar('+resultado[i].idpaquete+')';
			}
			else{
				img='img/invisible.png';
				funcion='Activar('+resultado[i].idpaquete+')';
			}
	   
	   
    texto += "<tr>";
    texto += "<td>";
    texto += "<input type='checkbox' id='"+resultado[i].idpaquete+"' name='idpaquete[]' value='"+resultado.idpaquete+"'>";
	texto += "<label for='"+resultado.idpaquete+"'><span></span></label>";
	texto += "</td>";
	texto += "<td>"+resultado[i].idpaquete+"</td>";
	texto += "<td><a href='formpaquete.php?idpaquete="+resultado[i].idpaquete+"'>"+resultado[i].titulo+"</a></td>";
	texto += "<td class='text-center visible-lg visible-md'>"+resultado[i].precio+"</td>";
	texto += "<td class='text-center visible-lg visible-md'>"+resultado[i].vigencia+"</td>";
	texto += "<td class='text-center visible-lg visible-md'><img onclick='"+funcion+"' id='temp"+resultado[i].idpaquete+"' src='"+img+"'></td>";
    texto += "</tr>";
			contador++;
		}
	
	}else{	
		texto="<tr>" + "<td colspan='8'>" + "<center>NO HAY RESULTADOS QUE MOSTRAR</center>" + "</td>" + "</tr>";
		contador=0;
	}
	$("#total").text(contador);
	$("tbody").empty();
	$("tbody").append(texto).fadeIn(1000);

}

function buscarTipPorPalabra(cadena){
	if(cadena!=""){
		$.ajaxSetup({
			cache : false
		});
		$.ajax({
			async : true,
			type : "POST",
			dataType : "html",
			contentType : "application/x-www-form-urlencoded",
			url : "operaciones.php",
			data : {
				"cadena" : cadena,
				"operaciones" : "buscartip"
			},
			success : despliegaResultadosDeTips,
			beforeSend : SendInformation,
			cache : false
		});
	}else{
		listaTip("10",event);
	}
}

function listaTip(cantidad, e){
	e.preventDefault();

	$.ajaxSetup({
		cache : false
	});
	$.ajax({
		async : true,
		type : "POST",
		dataType : "html",
		contentType : "application/x-www-form-urlencoded",
		url : "operaciones.php",
		data : {
			"operaciones" : "listatip"
		},
		success : despliegaResultadosDeTips,
		beforeSend : SendInformation,
		cache : false
	});
}

function despliegaResultadosDeTips(data){
	//alert(data);
	console.log(data);	
	var texto = "";
	var img ="";
	var funcion = "";
	var img2 ="";
	var funcion2 = "";
	var total=0;
	var resultado = JSON.parse(data);
	$("tbody").empty();
	var contador = 0;	
	if(data!="0"){
		for (var i in resultado){
			if(resultado[i].status!="0"){
				img='img/visible.png';
				funcion='Desactivar('+resultado[i].idtip+')';
			}
			else{
				img='img/invisible.png';
				funcion='Activar('+resultado[i].idtip+')';
			}
	   
	   
    texto += "<tr>";
    texto += "<td>";
    texto += "<input type='checkbox' id='"+resultado[i].idtip+"' name='idtip[]' value='"+resultado.idtip+"'>";
	texto += "<label for='"+resultado.idtip+"'><span></span></label>";
	texto += "</td>";
	texto += "<td>"+resultado[i].idtip+"</td>";
	texto += "<td><a href='formtip.php?idtip="+resultado[i].idtip+"'>"+resultado[i].titulo+"</a></td>";
	texto += "<td class='text-center visible-lg visible-md'><img onclick='"+funcion+"' id='temp"+resultado[i].idtip+"' src='"+img+"'></td>";
    texto += "</tr>";
			contador++;
		}
	
	}else{	
		texto="<tr>" + "<td colspan='8'>" + "<center>NO HAY RESULTADOS QUE MOSTRAR</center>" + "</td>" + "</tr>";
		contador=0;
	}
	$("#total").text(contador);
	$("tbody").empty();
	$("tbody").append(texto).fadeIn(1000);

}

function buscarPromocionPorPalabra(cadena){
	if(cadena!=""){
		$.ajaxSetup({
			cache : false
		});
		$.ajax({
			async : true,
			type : "POST",
			dataType : "html",
			contentType : "application/x-www-form-urlencoded",
			url : "operaciones.php",
			data : {
				"cadena" : cadena,
				"operaciones" : "buscarboletin"
			},
			success : despliegaResultadosDePromociones,
			beforeSend : SendInformation,
			cache : false
		});
	}else{
		listaPromocion("10",event);
	}
}

function listaPromocion(cantidad, e){
	e.preventDefault();

	$.ajaxSetup({
		cache : false
	});
	$.ajax({
		async : true,
		type : "POST",
		dataType : "html",
		contentType : "application/x-www-form-urlencoded",
		url : "operaciones.php",
		data : {
			"operaciones" : "listaboletin"
		},
		success : despliegaResultadosDePromociones,
		beforeSend : SendInformation,
		cache : false
	});
}

function despliegaResultadosDePromociones(data){
	//alert(data);
	console.log(data);	
	var texto = "";
	var img ="";
	var funcion = "";
	var img2 ="";
	var funcion2 = "";
	var total=0;
	var resultado = JSON.parse(data);
	$("tbody").empty();
	var contador = 0;	
	if(data!="0"){
		for (var i in resultado){
			if(resultado[i].status!="0"){
				img='img/visible.png';
				funcion='Desactivar('+resultado[i].idboletin+')';
			}
			else{
				img='img/invisible.png';
				funcion='Activar('+resultado[i].idboletin+')';
			}
	   
	   
    texto += "<tr>";
    texto += "<td>";
    texto += "<input type='checkbox' id='"+resultado[i].idboletin+"' name='idboletin[]' value='"+resultado.idboletin+"'>";
	texto += "<label for='"+resultado.idboletin+"'><span></span></label>";
	texto += "</td>";
	texto += "<td>"+resultado[i].idboletin+"</td>";
	texto += "<td><a href='formboletin.php?idboletin="+resultado[i].idboletin+"'>"+resultado[i].titulo+"</a></td>";
	texto += "<td class='text-center visible-lg visible-md'><img onclick='"+funcion+"' id='temp"+resultado[i].idboletin+"' src='"+img+"'></td>";
    texto += "</tr>";
			contador++;
		}
	
	}else{	
		texto="<tr>" + "<td colspan='8'>" + "<center>NO HAY RESULTADOS QUE MOSTRAR</center>" + "</td>" + "</tr>";
		contador=0;
	}
	$("#total").text(contador);
	$("tbody").empty();
	$("tbody").append(texto).fadeIn(1000);

}
/*Boletin*/
function buscarBoletinPorPalabra(cadena){
	if(cadena!=""){
		$.ajaxSetup({
			cache : false
		});
		$.ajax({
			async : true,
			type : "POST",
			dataType : "html",
			contentType : "application/x-www-form-urlencoded",
			url : "operaciones.php",
			data : {
				"cadena" : cadena,
				"operaciones" : "buscarboletin"
			},
			success : despliegaResultadosDeBoletines,
			beforeSend : SendInformation,
			cache : false
		});
	}else{
		listaBoletin("10",event);
	}
}

function listaBoletin(cantidad, e){
	e.preventDefault();

	$.ajaxSetup({
		cache : false
	});
	$.ajax({
		async : true,
		type : "POST",
		dataType : "html",
		contentType : "application/x-www-form-urlencoded",
		url : "operaciones.php",
		data : {
			"operaciones" : "listaboletin"
		},
		success : despliegaResultadosDeBoletines,
		beforeSend : SendInformation,
		cache : false
	});
}

function despliegaResultadosDeBoletines(data){
	//alert(data);
	console.log(data);	
	var texto = "";
	var img ="";
	var funcion = "";
	var img2 ="";
	var funcion2 = "";
	var total=0;
	var resultado = JSON.parse(data);
	$("tbody").empty();
	var contador = 0;	
	if(data!="0"){
		for (var i in resultado){
			if(resultado[i].status!="0"){
				img='img/visible.png';
				funcion='Desactivar('+resultado[i].idboletin+')';
			}
			else{
				img='img/invisible.png';
				funcion='Activar('+resultado[i].idboletin+')';
			}
	   
	   
    texto += "<tr>";
    texto += "<td>";
    texto += "<input type='checkbox' id='"+resultado[i].idboletin+"' name='idboletin[]' value='"+resultado.idboletin+"'>";
	texto += "<label for='"+resultado.idboletin+"'><span></span></label>";
	texto += "</td>";
	texto += "<td>"+resultado[i].idboletin+"</td>";
	texto += "<td><a href='formboletin.php?idboletin="+resultado[i].idboletin+"'>"+resultado[i].correo+"</a></td>";
	texto += "<td class='text-center visible-lg visible-md'><img onclick='"+funcion+"' id='temp"+resultado[i].idboletin+"' src='"+img+"'></td>";
    texto += "</tr>";
			contador++;
		}
	
	}else{	
		texto="<tr>" + "<td colspan='8'>" + "<center>NO HAY RESULTADOS QUE MOSTRAR</center>" + "</td>" + "</tr>";
		contador=0;
	}
	$("#total").text(contador);
	$("tbody").empty();
	$("tbody").append(texto).fadeIn(1000);

}
/*Boletin*/

/**/
function buscarSlidePorPalabra(cadena){
	if(cadena!=""){
		$.ajaxSetup({
			cache : false
		});
		$.ajax({
			async : true,
			type : "POST",
			dataType : "html",
			contentType : "application/x-www-form-urlencoded",
			url : "operaciones.php",
			data : {
				"cadena" : cadena,
				"operaciones" : "buscarslide"
			},
			success : despliegaResultadosDeSlide,
			beforeSend : SendInformation,
			cache : false
		});
	}else{
		listaSlide("10",event);
	}
}

function listaSlide(cantidad, e){
	e.preventDefault();

	$.ajaxSetup({
		cache : false
	});
	$.ajax({
		async : true,
		type : "POST",
		dataType : "html",
		contentType : "application/x-www-form-urlencoded",
		url : "operaciones.php",
		data : {
			"operaciones" : "listaslide"
		},
		success : despliegaResultadosDeSlide,
		beforeSend : SendInformation,
		cache : false
	});
}

function despliegaResultadosDeSlide(data){
	//alert(data);
	console.log(data);	
	var texto = "";
	var img ="";
	var funcion = "";
	var img2 ="";
	var funcion2 = "";
	var total=0;
	var resultado = JSON.parse(data);
	$("tbody").empty();
	var contador = 0;	
	if(data!="0"){
		for (var i in resultado){
			if(resultado[i].status!="0"){
				img='img/visible.png';
				funcion='Desactivar('+resultado[i].idslide+')';
			}
			else{
				img='img/invisible.png';
				funcion='Activar('+resultado[i].idslide+')';
			}
	   
	   
    texto += "<tr>";
    texto += "<td>";
    texto += "<input type='checkbox' id='"+resultado[i].idslide+"' name='idslide[]' value='"+resultado.idslide+"'>";
	texto += "<label for='"+resultado.idslide+"'><span></span></label>";
	texto += "</td>";
	texto += "<td>"+resultado[i].idslide+"</td>";
	texto += "<td><a href='formslide.php?idslide="+resultado[i].idslide+"'>"+resultado[i].titulo+"</a></td>";
	texto += "<td class='text-center visible-lg visible-md'><img onclick='"+funcion+"' id='temp"+resultado[i].idslide+"' src='"+img+"'></td>";
    texto += "</tr>";
			contador++;
		}
	
	}else{	
		texto="<tr>" + "<td colspan='8'>" + "<center>NO HAY RESULTADOS QUE MOSTRAR</center>" + "</td>" + "</tr>";
		contador=0;
	}
	$("#total").text(contador);
	$("tbody").empty();
	$("tbody").append(texto).fadeIn(1000);

}
/**/



function SendInformation() {
	$("tbody").html("<tr>" + "<td colspan='8'>" + "<center><img src='img/load.GIF' width='50' height='50'/><br>CARGANDO</center>" + "</td>" + "</tr>");
}

function listaUsuario(cantidad, e) {
	e.preventDefault();

	$.ajaxSetup({
		cache : false
	});
	$.ajax({
		async : true,
		type : "POST",
		dataType : "html",
		contentType : "application/x-www-form-urlencoded",
		url : "operaciones.php",
		data : {
			"operaciones" : "listausuario"
		},
		success : getInformationUsuario,
		beforeSend : SendInformationUsuario,
		cache : false
	});
}
function buscarPorPalabraUsuario(cadena){
	if(cadena!=""){
		$.ajaxSetup({
			cache : false
		});
		$.ajax({
			async : true,
			type : "POST",
			dataType : "html",
			contentType : "application/x-www-form-urlencoded",
			url : "operaciones.php",
			data : {
				"cadena" : cadena,
				"operaciones" : "buscarusuario"
			},
			success : getInformationUsuario,
			beforeSend : SendInformationUsuario,
			cache : false
		});
	}else{
		listaUsuario("10",event);
	}
}

function getInformationUsuario(data) {
	//alert(data);
	//console.log(data);	
	var texto = "";
	var img ="";
	var funcion = "";
	var total=0;
	var resultado = JSON.parse(data);
	$("tbody").empty();
	var contador = 0;	
	if(data!="0"){
		for (var i in resultado){
			if(resultado[i].status!="0"){
				img='img/visible.png';
				funcion='Desactivar('+resultado[i].idusuario+')';
			}
			else{
				img='img/invisible.png';
				funcion='Activar('+resultado[i].idusuario+')';
			}	   
	   
    texto += "<tr>";
    texto += "<td>";
    texto += "<input type='checkbox' id='"+resultado[i].idusuario+"' name='idusuario[]' value='"+resultado.idusuario+"'>";
	texto += "<label for='"+resultado.idusuario+"'><span></span></label>";
	texto += "</td>";
	texto += "<td><a href='formusuario.php?idusuario="+resultado[i].idusuario+"'>"+resultado[i].nomusuario+"</a></td>";
	texto += "<td class='text-center visible-lg visible-md'>"+resultado[i].nomtipo+"</td>";
	texto += "<td class='text-center visible-lg visible-md'><img onclick='"+funcion+"' id='temp"+resultado[i].idusuario+"' src='"+img+"'></td>";
    texto += "</tr>";
			contador++;
		}
	
	}else{	
		texto="<tr>" + "<td colspan='8'>" + "<center>NO HAY RESULTADOS QUE MOSTRAR</center>" + "</td>" + "</tr>";
		contador=0;
	}
	$("#total").text(contador);
	$("tbody").empty();
	$("tbody").append(texto).fadeIn(1000);
}

function SendInformationUsuario() {
	$("tbody").html("<tr>" + "<td colspan='8'>" + "<center><img src='img/load.GIF' width='50' height='50'/><br>CARGANDO</center>" + "</td>" + "</tr>");
}
function listaTipoUsuario(cantidad, e) {
	e.preventDefault();

	$.ajaxSetup({
		cache : false
	});
	$.ajax({
		async : true,
		type : "POST",
		dataType : "html",
		contentType : "application/x-www-form-urlencoded",
		url : "operaciones.php",
		data : {
			"operaciones" : "listatipousuario"
		},
		success : getInformationTipoUsuario,
		beforeSend : SendInformationTipoUsuario,
		cache : false
	});
}
function buscarPorPalabraTipoUsuario(cadena){
	if(cadena!=""){
		$.ajaxSetup({
			cache : false
		});
		$.ajax({
			async : true,
			type : "POST",
			dataType : "html",
			contentType : "application/x-www-form-urlencoded",
			url : "operaciones.php",
			data : {
				"cadena" : cadena,
				"operaciones" : "buscartipousuario"
			},
			success : getInformationTipoUsuario,
			beforeSend : SendInformationTipoUsuario,
			cache : false
		});
	}else{
		listaTipoUsuario("10",event);
	}
}

function getInformationTipoUsuario(data) {
	//alert(data);
	//console.log(data);	
	var texto = "";
	var img ="";
	var funcion = "";
	var total=0;
	var resultado = JSON.parse(data);
	$("tbody").empty();
	var contador = 0;	
	if(data!="0"){
		for (var i in resultado){
			if(resultado[i].status!="0"){
				img='img/visible.png';
				funcion='Desactivar('+resultado[i].idtipousuario+')';
			}
			else{
				img='img/invisible.png';
				funcion='Activar('+resultado[i].idtipousuario+')';
			}	   
	   
    texto += "<tr>";
    texto += "<td>";
    texto += "<input type='checkbox' id='"+resultado[i].idtipousuario+"' name='idtipousuario[]' value='"+resultado.idtipousuario+"'>";
	texto += "<label for='"+resultado.idtipousuario+"'><span></span></label>";
	texto += "</td>";
	texto += "<td><a href='formtipousuario.php?idtipousuario="+resultado[i].idtipousuario+"'>"+resultado[i].nomtipousuario+"</a></td>";
	texto += "<td class='text-center visible-lg visible-md'><img onclick='"+funcion+"' id='temp"+resultado[i].idtipousuario+"' src='"+img+"'></td>";
    texto += "</tr>";
			contador++;
		}
	
	}else{	
		texto="<tr>" + "<td colspan='8'>" + "<center>NO HAY RESULTADOS QUE MOSTRAR</center>" + "</td>" + "</tr>";
		contador=0;
	}
	$("#total").text(contador);
	$("tbody").empty();
	$("tbody").append(texto).fadeIn(1000);
}

function SendInformationTipoUsuario() {
	$("tbody").html("<tr>" + "<td colspan='8'>" + "<center><img src='img/load.GIF' width='50' height='50'/><br>CARGANDO</center>" + "</td>" + "</tr>");
}
