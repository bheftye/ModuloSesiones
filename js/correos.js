/* ========================================================================
 * LOCKER: correo.js v1.0.0
 * ========================================================================
 * Copyright 2014 Locker Agencia Creativa, S.A de C.V.
 *
 * Author:  Luis Caamal.
 * Description:
 * Scripts esclusivos para el modulo de correos.
 * Features:
 * Visualizacion de imágenes.
 * Editor de texto Plugin Summernote.
 * Botstrap V3.
 * Validaciones.
 * ======================================================================== */

/* ==========================================================================
 * PLANTILLA 1:
 * Visualizaciones.
 * Editor de texto
 * Multiselect.
 * Validaciones.
 * ========================================================================= */

 
 jQuery(document).ready(function() {
 	jQuery('#summernote').summernote({
  		height: 100
  	});
  	$('#form-validation').on('submit', function (e) {
    	var content = $('textarea[name="desc1"]').html($('#summernote').code());
    });
 });
 jQuery(document).ready(function() {
 	jQuery('#summernote2').summernote({
 		height: 100
 	});
 	$('#form-validation').on('submit', function (e) {
 		var content = $('textarea[name="desc2"]').html($('#summernote2').code());
    });
 });
 jQuery(document).ready(function() {
 	jQuery('#summernote3').summernote({
 		height: 100
  	});
 	$('#form-validation').on('submit', function (e) {
 	 	var content = $('textarea[name="desc3"]').html($('#summernote3').code());
 	});
 });
 
	 function handleFileSelect(evt) {
	 	var files = evt.target.files; // FileList object
		// Loop through the FileList and render image files as thumbnails.
		for (var i = 0, f; f = files[i]; i++) {
		 // Only process image files.
		 if (!f.type.match('image.*')) {
		 	continue;
		 }
		var reader = new FileReader();
		// Closure to capture the file information.
		reader.onload = (function(theFile) {
			return function(e) {
		// Render thumbnail.
				var span = document.createElement('span');
					span.innerHTML = ['<img width="100%" height="221" src="', e.target.result,
									'" title="', escape(theFile.name), '"/>'].join('');
					$("#list").empty();
					document.getElementById('list').insertBefore(span, null);
			};
		})(f);
		// Read in the image file as a data URL.
	    reader.readAsDataURL(f);
		}
	 }
	 document.getElementById('files').addEventListener('change', handleFileSelect, false);	 
 
	function handleFileSelect2(evt) {
		var files2 = evt.target.files; // FileList object
		$("#list2").empty();
		// Loop through the FileList and render image files as thumbnails.
		for (var i = 0, f; f = files2[i]; i++) {
	
		  // Only process image files.
		  if (!f.type.match('image.*')) {
			continue;
		  }
	
		  var reader = new FileReader();
	
		  // Closure to capture the file information.
		  reader.onload = (function(theFile) {
			return function(e) {
			  // Render thumbnail.
			  var span = document.createElement('div');
			  span.className = "col-lg-6 col-md-6 col-sm-6 col-xs-6";
			  span.innerHTML = ['<img style="margin: 0 0 20px 0" class="img-responsive" src="', e.target.result,
								'" title="', escape(theFile.name), '"/>'].join('');
			  document.getElementById('list2').insertBefore(span, null);
			};
		  })(f);
	
		  // Read in the image file as a data URL.
		  reader.readAsDataURL(f);
		}
	  }

	  function deleteCorreo1Img(idcorreoimg1,idcorreo1){
	  	console.log(idcorreoimg1+", "+idcorreo1)
	  	$.ajaxSetup({ cache: false });
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"operaciones.php",
			data:"idcorreoimg1="+idcorreoimg1+"&idcorreo1="+idcorreo1+"&operaciones=eliminarImagenSecundariaCorreo1",
			success:function(data){
				console.log(data);
				if(data == "true")
					$("#correo1img"+idcorreoimg1).fadeOut();
				else
					alert("Hubo un problema y no se eliminó la imagen.");
			},
			cache:false
		});		

	  }
	
	  document.getElementById('files2').addEventListener('change', handleFileSelect2, false);
	  
	  function handleFileSelect3(evt) {
		var files = evt.target.files; // FileList object
	
		// Loop through the FileList and render image files as thumbnails.
		for (var i = 0, f; f = files[i]; i++) {
	
		  // Only process image files.
		  if (!f.type.match('image.*')) {
			continue;
		  }
	
		  var reader = new FileReader();
	
		  // Closure to capture the file information.
		  reader.onload = (function(theFile) {
			return function(e) {
			  // Render thumbnail.
			  var span = document.createElement('span');
			  span.innerHTML = ['<img width="100%" height="221" src="', e.target.result,
								'" title="', escape(theFile.name), '"/>'].join('');
			  $("#list3").html("");
			  document.getElementById('list3').insertBefore(span, null);
			};
		  })(f);
	
		  // Read in the image file as a data URL.
		  reader.readAsDataURL(f);
		}
	  }
	
	  document.getElementById('files3').addEventListener('change', handleFileSelect3, false);
	  
	function validar_campos(){
		var val = $("#files").val();
		var val2 = $("#files2").val();
		var val3 = $("#files3").val();
		
		if (form1.titulo.value == ''){
			form1.titulo.focus();
			$('#titulo').removeClass("form-group").addClass("form-group has-error");
			$('.top-right').notify({
    			message: { text: 'El Campo del titulo esta vacío, para poder continuar asigne un titulo a este correo' },
    			type:'blackgloss',
    			delay: 80000,
  			}).show();
			return false;
			}
		else{
			$('#titulo').removeClass("form-group has-error").addClass("form-group has-success");
		}	
		if (!val.match(/(?:gif|jpg|png)$/) && $("#list").html() == "") {
    		$("#imgprin").removeClass("btn-default").addClass("btn-danger"); 
			$(".top-right").notify({
    			message: { text: "Agregue la imagen superior para poder continuar y solo se aceptan imágenes con formato .jpg .png .gif" },
    			type:"blackgloss",
    			delay: 1000,
  			}).show(); 
			return false; 
		}
		else{
			$("#imgprin").removeClass("btn-danger").addClass("btn-success"); 
		}
		if (form1.subtitulo.value == ''){
			form1.subtitulo.focus();
			$('#subtitulo').removeClass("form-group").addClass("form-group has-error");
			$('.top-right').notify({
    			message: { text: 'El Campo del subtitulo esta vacío, para poder continuar asigne un subtitulo a este correo' },
    			type:'blackgloss',
  			}).show();
			return false;
			}
		else{
			$('#subtitulo').removeClass("form-group has-error").addClass("form-group has-success");
		}
		if (!val2.match(/(?:gif|jpg|png)$/) && $("#list2_2").html() == "") {
    		$("#imgsecu").removeClass("btn-default").addClass("btn-danger"); 
			$(".top-right").notify({
    			message: { text: "Agregue las imágenes secundarioas para poder continuar y solo se aceptan imágenes con formato .jpg .png .gif" },
    			type:"blackgloss",
    			delay: 10000,
  			}).show(); 
			return false; 
		}
		else{
			$("#imgsecu").removeClass("btn-danger").addClass("btn-success"); 
		}
		if (!val3.match(/(?:gif|jpg|png)$/) && $("#list3").html() == "") {
    		$("#imgter").removeClass("btn-default").addClass("btn-danger");
			$(".top-right").notify({
    			message: { text: "Agregue la imagen inferior para poder continuar y solo se aceptan imágenes con formato .jpg .png .gif" },
    			type:"blackgloss",
    			delay: 10000,
  			}).show(); 
			return false; 
		}
		else{
			$("#imgter").removeClass("btn-danger").addClass("btn-success");
		}
		/*if($('#my-select').val() == 0){
			alert($('#my-select').val());
			$(".top-right").notify({
    			message: { text: "Es muy importante que seleccione a quien le desea enviar este correo" },
    			type:"blackgloss",
    			delay: 10000,
  			}).show(); 
			return false; 
		}*/
	}
	
	$(function() {
	    $('#titulo').tooltip(
		{
			placement: "top",
	        title: "Ingrese el titulo del correo aquí. (CAMPO REQUERIDO)"
		});
		$('#subtitulo').tooltip(
		{
			placement: "top",
	        title: "Ingrese el subtitulo del correo aquí. (CAMPO REQUERIDO)"
		});
		$('.note-editable').tooltip(
		{
			placement: "top",
	        title: "Ingrese una descripcion del correo aquí.(CAMPO REQUERIDO)"
		});
		$('#imgprin').tooltip(
		{
			placement: "top",
	        title: "Seleccione una imagen, esta imagen es la que se mostrará en la parte superior del correo, solo se aceptan imagenes con formatos .jpg, .png y  .gif. (CAMPO REQUERIDO)"
		});
		$('#imgsecu').tooltip(
		{
			placement: "top",
	        title: "Seleccione el numero de imágenes que desee, solo se aceptan imágenes con formato .jpg, .png y .gif. (CAMPO REQUERIDO)"
		});
		$('#imgter').tooltip(
		{
			placement: "top",
	        title: "Seleccione una imagen, esta imagen es la que se mostrará en la parte inferiro del correo, solo se aceptan imagenes con formatos .jpg, .png y  .gif. (CAMPO REQUERIDO)"
		});
		$('.ms-selection').tooltip(
		{
			placement: "top",
	        title: "Aquí se muestran todos los destinatarios que ha seleccionado, si desea retirar alguno solo le debe dar click"
		});
		$('.ms-selectable').tooltip(
		{
			placement: "top",
	        title: "En la siguiente lista se muestra a quienes les puede enviar un correo, usted puede seleccionar a los usuarios segun su estado de procedencia, a los usuarios boletines o a los usuarios registrados activos, si lo desea tambien puede selecionar todos.Para que se seleccionen debe hacer click sobre el."
		});
		$('#plant1').tooltip(
		{
			placement: "top",
	        title: "Aquí puede seleccionar el tipo de plantilla que desea utilizar para su correo. Plantilla 1"
		});
		$('#plant2').tooltip(
		{
			placement: "top",
	        title: "Aquí puede seleccionar el tipo de plantilla que desea utilizar para su correo. Plantilla 2"
		});
		$('#plant3').tooltip(
		{
			placement: "top",
	        title: "Aquí puede seleccionar el tipo de plantilla que desea utilizar para su correo. Plantilla 3"
		});
	});
	$(function() {
	    $('#plant1').popover(
		{
			placement: 'right',
			trigger: 'hover',
			html: 'true',
			title: 'Previsualizar',
			content: '<img src="img/plantillas-01.png" width="200" height="200" />',
			container: 'body'
		});
	});
	$(function() {
	    $('#plant2').popover(
		{
			placement: 'right',
			trigger: 'hover',
			html: 'true',
			title: 'Previsualizar',
			content: '<img src="img/plantillas-02.png" width="200" height="200" />',
			container: 'body'
		});
	});
	$(function() {
	    $('#plant3').popover(
		{
			placement: 'right',
			trigger: 'hover',
			html: 'true',
			title: 'Previsualizar',
			content: '<img src="img/plantillas-03.png" width="200" height="200" />',
			container: 'body'
		});
	});
	/* ==========================================================================
 * PLANTILLA 2:
 * Visualizaciones.
 * Editor de texto
 * Multiselect.
 * Validaciones.
 * ========================================================================= */

 //$('#my-select2').multiSelect();
 
 		jQuery(document).ready(function() {
  			jQuery('#summernotep2').summernote({
  				height: 100
  			});
  			$('#form-validation2').on('submit', function (e) {
       			 var content = $('textarea[name="descp2"]').html($('#summernotep2').code());
     		 });
		});
		jQuery(document).ready(function() {
  			jQuery('#summernote2p2').summernote({
  				height: 100
  			});
  			$('#form-validation2').on('submit', function (e) {
       			 var content = $('textarea[name="desc2p2"]').html($('#summernote2p2').code());
     		 });
		});
		jQuery(document).ready(function() {
  			jQuery('#summernote3p2').summernote({
  				height: 100
  			});
  			$('#form-validation2').on('submit', function (e) {
       			 var content = $('textarea[name="desc3p2"]').html($('#summernote3p2').code());
     		 });
		});
		jQuery(document).ready(function() {
  			jQuery('#summernote4p2').summernote({
  				height: 100
  			});
  			$('#form-validation2').on('submit', function (e) {
       			 var content = $('textarea[name="desc4p2"]').html($('#summernote4p2').code());
     		 });
		});
 
	 function handleFileSelectp2(evt) {
		var files = evt.target.files; // FileList object
	
		// Loop through the FileList and render image files as thumbnails.
		for (var i = 0, f; f = files[i]; i++) {
	
		  // Only process image files.
		  if (!f.type.match('image.*')) {
			continue;
		  }
	
		  var reader = new FileReader();
	
		  // Closure to capture the file information.
		  reader.onload = (function(theFile) {
			return function(e) {
			  // Render thumbnail.
			  var span = document.createElement('span');
			  span.innerHTML = ['<img width="200" height="200" src="', e.target.result,
								'" title="', escape(theFile.name), '"/>'].join('');
			  $("#listp2").empty();
			  document.getElementById('listp2').insertBefore(span, null);
			};
		  })(f);
	
		  // Read in the image file as a data URL.
		  reader.readAsDataURL(f);
		}
	  }
	
	  document.getElementById('filesp2').addEventListener('change', handleFileSelectp2, false);
 
	 function handleFileSelect2p2(evt) {
		var files2 = evt.target.files; // FileList object
		$("#list2p2").empty();
		// Loop through the FileList and render image files as thumbnails.
		for (var i = 0, f; f = files2[i]; i++) {
	
		  // Only process image files.
		  if (!f.type.match('image.*')) {
			continue;
		  }
	
		  var reader = new FileReader();
	
		  // Closure to capture the file information.
		  reader.onload = (function(theFile) {
			return function(e) {
			  // Render thumbnail.
			  var span = document.createElement('div');
			  span.className = "col-lg-6 col-md-6 col-sm-6 col-xs-6";
			  span.innerHTML = ['<img style="margin: 0 0 20px 0" class="img-responsive" src="', e.target.result,
								'" title="', escape(theFile.name), '"/>'].join('');
			  document.getElementById('list2p2').insertBefore(span, null);
			};
		  })(f);
	
		  // Read in the image file as a data URL.
		  reader.readAsDataURL(f);
		}
	  }

	  function deleteCorreo2Img(idcorreoimg2,idcorreo2){
	  	console.log(idcorreoimg2+", "+idcorreo2)
	  	$.ajaxSetup({ cache: false });
		$.ajax({
			async:true,
			type: "POST",
			dataType: "html",
			contentType: "application/x-www-form-urlencoded",
			url:"operaciones.php",
			data:"idcorreoimg2="+idcorreoimg2+"&idcorreo2="+idcorreo2+"&operaciones=eliminarImagenSecundariaCorreo2",
			success:function(data){
				console.log(data);
				if(data == "true")
					$("#correo2img"+idcorreoimg2).fadeOut();
				else
					alert("Hubo un problema y no se eliminó la imagen.");
			},
			cache:false
		});		

	  }
	
	  document.getElementById('files2p2').addEventListener('change', handleFileSelect2p2, false);
	  
	  function handleFileSelect3p2(evt) {
		var files = evt.target.files; // FileList object
	
		// Loop through the FileList and render image files as thumbnails.
		for (var i = 0, f; f = files[i]; i++) {
	
		  // Only process image files.
		  if (!f.type.match('image.*')) {
			continue;
		  }
	
		  var reader = new FileReader();
	
		  // Closure to capture the file information.
		  reader.onload = (function(theFile) {
			return function(e) {
			  // Render thumbnail.
			  var span = document.createElement('span');
			  span.innerHTML = ['<img width="100%" height="221" src="', e.target.result,
								'" title="', escape(theFile.name), '"/>'].join('');
			  $("#list3p2").empty();
			  document.getElementById('list3p2').insertBefore(span, null);
			};
		  })(f);
	
		  // Read in the image file as a data URL.
		  reader.readAsDataURL(f);
		}
	  }
	
	  document.getElementById('files3p2').addEventListener('change', handleFileSelect3p2, false);


	 function validar_campo_prueba1(){
		var correoLleno = false;
		if($($('[name="correo_prueba[]"]')[0]).val() != "" || $($('[name="correo_prueba[]"]')[1]).val() != ""){
			$("#form-validation").find(":submit").click();
		}
		else{
			$($('[name="correo_prueba[]"]')[0]).focus();
			alert("Introduce un correo.");
		}
	}
	  
	function validar_campo_prueba2(){
		var correoLleno = false;
		if($($('[name="correo_prueba[]"]')[2]).val() != "" || $($('[name="correo_prueba[]"]')[3]).val() != ""){
			$("#form-validation2").find(":submit").click();
		}
		else{
			$($('[name="correo_prueba[]"]')[2]).focus();
			alert("Introduce un correo.");
		}
	}

	function validar_campo_prueba3(){
		var correoLleno = false;
		if($($('[name="correo_prueba[]"]')[4]).val() != "" || $($('[name="correo_prueba[]"]')[5]).val() != ""){
			$("#form-validation3").find(":submit").click();
		}
		else{
			$($('[name="correo_prueba[]"]')[4]).focus();
			alert("Introduce un correo.");
		}
	}
	  
	function validar_campos2(){
		var val = $("#filesp2").val();
		var val2 = $("#files2p2").val();
		var val3 = $("#files3p2").val();
		
		if (form2.titulop2.value == ''){
			form2.titulop2.focus();
			$('#titulop2').removeClass("form-group").addClass("form-group has-error");
			$('.top-right').notify({
    			message: { text: 'El Campo del titulo esta vacío, para poder continuar asigne un titulo a este correo' },
    			type:'blackgloss',
    			delay: 80000,
  			}).show();
			return false;
			}
		else{
			$('#titulop2').removeClass("form-group has-error").addClass("form-group has-success");
		}
		if (form2.subtitulop2.value == ''){
			form2.subtitulop2.focus();
			$('#subtitulop2').removeClass("form-group").addClass("form-group has-error");
			$('.top-right').notify({
    			message: { text: 'El Campo del subtitulo esta vacío, para poder continuar asigne un subtitulo a este correo' },
    			type:'blackgloss',
  			}).show();
			return false;
			}
		else{
			$('#subtitulop2').removeClass("form-group has-error").addClass("form-group has-success");
		}	
		if (!val2.match(/(?:gif|jpg|png)$/) && $("#list2p2_2").html() == "") {
    		$("#imgsecup2").removeClass("btn-default").addClass("btn-danger"); 
			$(".top-right").notify({
    			message: { text: "Agregue las imágenes secundarioas para poder continuar y solo se aceptan imágenes con formato .jpg .png .gif" },
    			type:"blackgloss",
    			delay: 10000,
  			}).show(); 
			return false; 
		}
		else{
			$("#imgsecup2").removeClass("btn-danger").addClass("btn-success");
		}
		if (!val.match(/(?:gif|jpg|png)$/) && $("#listp2").html() == "") {
    		$("#imgprinp2").removeClass("btn-default").addClass("btn-danger"); 
			$(".top-right").notify({
    			message: { text: "Agregue la imagen superior para poder continuar y solo se aceptan imágenes con formato .jpg .png .gif" },
    			type:"blackgloss",
    			delay: 1000,
  			}).show(); 
			return false; 
		}
		else{
			$("#imgprinp2").removeClass("btn-danger").addClass("btn-success"); 
		}
		if (!val3.match(/(?:gif|jpg|png)$/) && $("#list3p2").html() == "") {
    		$("#imgterp2").removeClass("btn-default").addClass("btn-danger"); 
			$(".top-right").notify({
    			message: { text: "Agregue la imagen inferior para poder continuar y solo se aceptan imágenes con formato .jpg .png .gif" },
    			type:"blackgloss",
    			delay: 10000,
  			}).show(); 
			return false; 
		}
		else{
			$("#imgterp2").removeClass("btn-danger").addClass("btn-success"); 
		}
		if($('#my-select2').val() == 0){
			$(".top-right").notify({
    			message: { text: "Es muy importante que seleccione a quien le desea enviar este correo" },
    			type:"blackgloss",
    			delay: 10000,
  			}).show(); 
			return false; 
		}	
	}
	
	$(function() {
	    $('#titulop2').tooltip(
		{
			placement: "top",
	        title: "Ingrese el titulo del correo aquí. (CAMPO REQUERIDO)"
		});
		$('#subtitulop2').tooltip(
		{
			placement: "top",
	        title: "Ingrese el subtitulo del correo aquí. (CAMPO REQUERIDO)"
		});
		$('#imgprinp2').tooltip(
		{
			placement: "top",
	        title: "Seleccione una imagen, esta imagen es la que se mostrará en la parte superior del correo, solo se aceptan imagenes con formatos .jpg, .png y  .gif. (CAMPO REQUERIDO)"
		});
		$('#imgsecup2').tooltip(
		{
			placement: "top",
	        title: "Seleccione el numero de imágenes que desee, solo se aceptan imágenes con formato .jpg, .png y .gif. (CAMPO REQUERIDO)"
		});
		$('#imgterp2').tooltip(
		{
			placement: "top",
	        title: "Seleccione una imagen, esta imagen es la que se mostrará en la parte inferiro del correo, solo se aceptan imagenes con formatos .jpg, .png y  .gif. (CAMPO REQUERIDO)"
		});
	});
/* ==========================================================================
 * PLANTILLA 3:
 * Visualizaciones.
 * Editor de texto
 * Multiselect.
 * Validaciones.
 * ========================================================================= */
 	(function($){
  		$(function(){
	$('.searchable').multiSelect({
     selectableHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='Buscar Paquete'>",
     selectionHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='Buscar Paquete'>",
     afterInit: function() {
          var that = this,
               $selectableSearch = that.$selectableUl.prev(),
               $selectionSearch = that.$selectionUl.prev(),
               selectableSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selectable:not(.ms-selected)',
               selectionSearchString = '#' + that.$container.attr('id') + ' .ms-elem-selection.ms-selected';

               that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
               .on('keydown', function(e) {
                    if (e.which === 40){
                         that.$selectableUl.focus();
                         return false;
                    }

                    return true;
               });

               that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
               .on('keydown', function(e) {
                    if (e.which == 40){
                         that.$selectionUl.focus();
                         return false;
                    }

                    return true;
               });
     },
     afterSelect: function(value){
          this.qs1.cache();
          this.qs2.cache();

          selectedMissingValues.push(value);
     },
     afterDeselect: function(value){
          this.qs1.cache();
          this.qs2.cache();

          selectedMissingValues.pop(value);
     }
});
 });
})(jQuery);

	
	jQuery(document).ready(function() {
  			jQuery('#summernotep3').summernote({
  				height: 100
  			});
  			$('#form-validation3').on('submit', function (e) {
       			 var content = $('textarea[name="descp3"]').html($('#summernotep3').code());
     		 });
	});
	
	function handleFileSelectp3(evt) {
		var files = evt.target.files; // FileList object
	
		// Loop through the FileList and render image files as thumbnails.
		for (var i = 0, f; f = files[i]; i++) {
	
		  // Only process image files.
		  if (!f.type.match('image.*')) {
			continue;
		  }
	
		  var reader = new FileReader();
	
		  // Closure to capture the file information.
		  reader.onload = (function(theFile) {
			return function(e) {
			  // Render thumbnail.
			  var span = document.createElement('span');
			  span.innerHTML = ['<img width="200" height="200" src="', e.target.result,
								'" title="', escape(theFile.name), '"/>'].join('');
			  $("#listp3").empty();
			  document.getElementById('listp3').insertBefore(span, null);
			};
		  })(f);
	
		  // Read in the image file as a data URL.
		  reader.readAsDataURL(f);
		}
	  }
	
	  document.getElementById('filesp3').addEventListener('change', handleFileSelectp3, false);
	  
	function handleFileSelect2p3(evt) {
		var files2 = evt.target.files; // FileList object
		$("#list2p3").empty();
		// Loop through the FileList and render image files as thumbnails.
		for (var i = 0, f; f = files2[i]; i++) {
	
		  // Only process image files.
		  if (!f.type.match('image.*')) {
			continue;
		  }
	
		  var reader = new FileReader();
	
		  // Closure to capture the file information.
		  reader.onload = (function(theFile) {
			return function(e) {
			  // Render thumbnail.
			  var span = document.createElement('div');
			  span.className = "col-lg-6 col-md-6 col-sm-6 col-xs-6";
			  span.innerHTML = ['<img style="margin: 0 0 20px 0" class="img-responsive" src="', e.target.result,
								'" title="', escape(theFile.name), '"/>'].join('');
			  document.getElementById('list2p3').insertBefore(span, null);
			};
		  })(f);
	
		  // Read in the image file as a data URL.
		  reader.readAsDataURL(f);
		}
	  }
	
	  //document.getElementById('files2p3').addEventListener('change', handleFileSelect2p3, false);
	  
 	function handleFileSelect3p3(evt) {
		var files = evt.target.files; // FileList object
	
		// Loop through the FileList and render image files as thumbnails.
		for (var i = 0, f; f = files[i]; i++) {
	
		  // Only process image files.
		  if (!f.type.match('image.*')) {
			continue;
		  }
	
		  var reader = new FileReader();
	
		  // Closure to capture the file information.
		  reader.onload = (function(theFile) {
			return function(e) {
			  // Render thumbnail.
			  var span = document.createElement('span');
			  span.innerHTML = ['<img width="100%" height="221" src="', e.target.result,
								'" title="', escape(theFile.name), '"/>'].join('');
			  $("#list3p3").empty();
			  document.getElementById('list3p3').insertBefore(span, null);
			};
		  })(f);
	
		  // Read in the image file as a data URL.
		  reader.readAsDataURL(f);
		}
	  }
	
	  document.getElementById('files3p3').addEventListener('change', handleFileSelect3p3, false);
	  
	function validar_campos3(){
		var val = $("#filesp3").val();
		//var val2 = $("#files2p3").val();
		var val3 = $("#files3p3").val();
		
		if (form3.titulop3.value == ''){
			form3.titulop3.focus();
			$('#titulop3').removeClass("form-group").addClass("form-group has-error");
			$('.top-right').notify({
    			message: { text: 'El Campo del titulo esta vacío, para poder continuar asigne un titulo a este correo' },
    			type:'blackgloss',
    			delay: 80000,
  			}).show();
			return false;
			}
		else{
			$('#titulop3').removeClass("form-group has-error").addClass("form-group has-success");
		}
		if (form3.subtitulop3.value == ''){
			form3.subtitulop3.focus();
			$('#subtitulop3').removeClass("form-group").addClass("form-group has-error");
			$('.top-right').notify({
    			message: { text: 'El Campo del subtitulo esta vacío, para poder continuar asigne un subtitulo a este correo' },
    			type:'blackgloss',
  			}).show();
			return false;
			}
		else{
			$('#subtitulop3').removeClass("form-group has-error").addClass("form-group has-success");
		}
		if (!val.match(/(?:gif|jpg|png)$/) && $("#listp3").html == "") {
    		$("#imgprinp3").removeClass("btn-default").addClass("btn-danger"); 
			$(".top-right").notify({
    			message: { text: "Agregue la imagen superior para poder continuar y solo se aceptan imágenes con formato .jpg .png .gif" },
    			type:"blackgloss",
    			delay: 1000,
  			}).show(); 
			return false; 
		}
		else{
			$("#imgprinp3").removeClass("btn-danger").addClass("btn-success"); 
		}	
		/*if (!val2.match(/(?:gif|jpg|png)$/)) {
    		$("#imgsecup3").removeClass("btn-default").addClass("btn-danger"); 
			$(".top-right").notify({
    			message: { text: "Agregue las imágenes secundarioas para poder continuar y solo se aceptan imágenes con formato .jpg .png .gif" },
    			type:"blackgloss",
    			delay: 10000,
  			}).show(); 
			return false; 
		}
		else{
			$("#imgsecup3").removeClass("btn-danger").addClass("btn-success");
		}
		*/
		if (!val3.match(/(?:gif|jpg|png)$/) && $("#list3p3").html == "") {
    		$("#imgterp3").removeClass("btn-default").addClass("btn-danger"); 
			$(".top-right").notify({
    			message: { text: "Agregue la imagen inferior para poder continuar y solo se aceptan imágenes con formato .jpg .png .gif" },
    			type:"blackgloss",
    			delay: 10000,
  			}).show(); 
			return false; 
		}
		else{
			$("#imgterp3").removeClass("btn-danger").addClass("btn-success"); 
		}
		if($('#my-select3').val() == 0){
			$(".top-right").notify({
    			message: { text: "Es muy importante que seleccione a quien le desea enviar este correo" },
    			type:"blackgloss",
    			delay: 10000,
  			}).show(); 
			return false; 
		}	
		if($('#paquetes-select').val() == 0){
			$(".top-right").notify({
    			message: { text: "Es muy importante que seleccione los paquetes que irán en el correo." },
    			type:"blackgloss",
    			delay: 10000,
  			}).show(); 
			return false; 
		}	


		if($("#paquetes-select :selected").length > 9 || $("#paquetes-select :selected").length == 1){
			$(".top-right").notify({
    			message: { text: "Verifica que hayas seleccionado algún paquete. Recuerda que máximo puedes seleccionar 8." },
    			type:"blackgloss",
    			delay: 10000,
  			}).show(); 
			return false; 
		}	


	}
	
	$(function() {
	    $('#titulop3').tooltip(
		{
			placement: "top",
	        title: "Ingrese el titulo del correo aquí. (CAMPO REQUERIDO)"
		});
		$('#subtitulop3').tooltip(
		{
			placement: "top",
	        title: "Ingrese el subtitulo del correo aquí. (CAMPO REQUERIDO)"
		});
		$('#imgprinp3').tooltip(
		{
			placement: "top",
	        title: "Seleccione una imagen, esta imagen es la que se mostrará en la parte superior del correo, solo se aceptan imagenes con formatos .jpg, .png y  .gif. Las dimensiones ideales son 900px x 300px (CAMPO REQUERIDO)"
		});
		$('#imgsecup3').tooltip(
		{
			placement: "top",
	        title: "Seleccione el numero de imágenes que desee, solo se aceptan imágenes con formato .jpg, .png y .gif. (CAMPO REQUERIDO)"
		});
		$('#imgterp3').tooltip(
		{
			placement: "top",
	        title: "Seleccione una imagen, esta imagen es la que se mostrará en la parte inferiro del correo, solo se aceptan imagenes con formatos .jpg, .png y  .gif. (CAMPO REQUERIDO)"
		});
	});