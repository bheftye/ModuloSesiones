<?php
include_once ('conexion.php');
require_once ('archivo.php');
include_once ('imgtip.php');
	class Tip extends archivo{
		var $idTip;
		var $titulo;
		var $subtitulo;
		var $descripcion;
		var $imgPrincipal;
		var $imgSecundarias;
		var $directorio = '../tips/principales/';
		var $status;
		
		function Tip($idTip = 0, $titulo ="", $subtitulo = "", $descripcion ="", $imgPrincipal = "", $imgSecundarias = array(), $status = 1){
			$this -> idTip = $idTip;
			$this -> titulo = $titulo;
			$this -> subtitulo = $subtitulo;
			$this -> descripcion = $descripcion;
			$this -> imgPrincipal = $imgPrincipal;
			$this -> imgSecundarias = $imgSecundarias;
			$this -> status = $status;
		}

		function insertarTip() {
			$fechaCreacion = date("Y-m-d");
			$sql = "INSERT INTO tips (titulo, subtitulo, fecha, fecha_modificacion, descripcion, imagenp, status) VALUES('".$this -> titulo."', '".$this -> subtitulo."', '".$fechaCreacion."','".$fechaCreacion."', '".$this -> descripcion."','".$this -> imgPrincipal."', ".$this -> status.")";
			$con = new conexion();
			$this -> idTip = $con -> ejecutar_sentencia($sql);
			$this -> subir_archivo();
		}

		function modificarTip() {
			if ($this -> imgPrincipal != '') {
				$tip = new Tip($this -> idTip);
				$tip -> obtenerTip();
				$tip -> ruta_final = $tip -> directorio. $tip -> imgPrincipal;
				$tip -> borrar_archivo();

				$this -> ruta_final = $this -> directorio . $this -> imgPrincipal;
				$sql = ' imagenp=\'' . $this -> imgPrincipal . '\',';
			} else {
				$sql = '';
			}
			
			$fechaModificacion = date("Y-m-d");
			$sql = "UPDATE `tips` SET ".$sql." `titulo`='".$this -> titulo."',`subtitulo`='".$this -> subtitulo."',`fecha_modificacion`= '".$fechaModificacion."',`descripcion`='".$this -> descripcion."' WHERE id_tip = ".$this -> idTip;
			$con = new conexion();
			$con -> ejecutar_sentencia($sql);
			$this -> subir_archivo();	
		}

		function eliminarTip() {
			$this -> recuperarTip();
			$this -> borrar_archivo();
			$sql = "DELETE FROM `tips` WHERE id_tip =" . $this -> idTip . ";";
			$con = new conexion();
			$con -> ejecutar_sentencia($sql);
		}

		function desactivaTip() {
			$con = new conexion();
			$sql = "UPDATE tips SET status = 0 WHERE id_tip =" . $this -> idTip;
			$con -> ejecutar_sentencia($sql);
		}

		function activaTip() {
			$con = new conexion();
			$sql = "UPDATE tips SET status = 1 WHERE id_tip =" . $this -> idTip;
			$con -> ejecutar_sentencia($sql);
		}

		function llenarTipConSusDatos($filaSQL){
			$this ->  idTip = $filaSQL["id_tip"];
			$this ->  titulo = $filaSQL["titulo"];
			$this -> subtitulo = $filaSQL["subtitulo"];
			$this ->  descripcion = htmlspecialchars_decode($filaSQL["descripcion"]);
			$this ->  imgPrincipal = $filaSQL['imagenp'];
			$this -> ruta_final = $this -> directorio . $filaSQL['imagenp'];
			$this -> status = $filaSQL["status"];
		}

		function listarTipsActivos() {
			$resultados = array();
			$sql = "SELECT * FROM tips WHERE status = 1 ORDER BY titulo ASC";
			$con = new conexion();
			$temporal = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($temporal)) {
				$tip = new Tip();
				$tip -> llenarTipConSusDatos($fila);
				$tip -> listaImgTip();
				array_push($resultados, $tip);
			}
			mysql_free_result($temporal);
			return $resultados;
		}

		function listarTipsDesactivados() {
			$resultados = array();
			$sql = "SELECT * FROM tips WHERE status = 0 ORDER BY titulo ASC";
			$con = new conexion();
			$temporal = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($temporal)) {
				$tip = new Tip();
				$tip -> llenarTipConSusDatos($fila);
				$tip -> listaImgTip();
				array_push($resultados, $tip);
			}
			mysql_free_result($temporal);
			return $resultados;
		}


		function obtenerTip() {
			$sql = "SELECT * FROM tips WHERE id_tip =".$this -> idTip.";";
			$con = new conexion();
			$resultados = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($resultados)) {
				$this -> llenarTipConSusDatos($fila);
				$this -> listaImgTip();
			}
			mysql_free_result($resultados);
			return;
		}

		function recuperarTip() {
			$sql = "SELECT * FROM tips WHERE id_tip =" . $this -> idTip . ";";
			$con = new conexion();
			$resultados = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($resultados)) {
				$this -> llenarTipConSusDatos($fila);
				$this -> listaImgTip();
			}
			mysql_free_result($resultados);
			return ;
		}

		function listarTips() {
			$resultados = array();
			$sql = "SELECT * FROM tips ORDER BY titulo ASC";
			$con = new conexion();
			$temporal = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($temporal)) {
				$tip = new Tip();
				$tip -> llenarTipConSusDatos($fila);
				$tip -> listaImgTip();
				array_push($resultados, $tip);
			}
			mysql_free_result($temporal);
			return $resultados;
		}

		function buscarTip($pedazo) {
			$resultados = array();
			$sql = "SELECT * FROM tips WHERE (titulo like '%" . $pedazo . "%') or (subtitulo like '%" . $pedazo . "%') group by titulo";
			$con = new conexion();
			$temporal = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($temporal)) {
				$registro = array();
				$registro["idtip"] = $fila["id_tip"];
				$registro["titulo"] = $fila["titulo"];
				$registro["subtitulo"] = $fila["subtitulo"];
				$registro["descripcion"] = htmlspecialchars_decode($fila["descripcion"]);
				$registro["status"] = $fila["status"];
				array_push($resultados, $registro);
			}
			echo json_encode($resultados);
		}

		function limitTip() {
			$resultados = array();
			$sql = "SELECT * FROM tips";
			$con = new conexion();
			$temporal = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($temporal)) {
				$registro = array();
				$registro["idtip"] = $fila["id_tip"];
				$registro["titulo"] = $fila["titulo"];
				$registro["subtitulo"] = $fila["subtitulo"];
				$registro["descripcion"] = htmlspecialchars_decode($fila["descripcion"]);
				$registro["status"] = $fila["status"];
				array_push($resultados, $registro);
			}
			echo json_encode($resultados);
		}

		//=============MAESTRO DETALLE DE LAS IMAGENES===============
		function listaImgTip() {
			$imgtiptemp = new ImgSecundariaTip(0, $this -> idTip, '', '');
			$this -> imgSecundarias = $imgtiptemp -> listarImgTip();
		}	/*function listaImgRevistaPanel($idrevista)
		 {
		 $imgrevistatemp= new imgrevista(0,$idrevista,'','','');
		 $this->imgrevista=$imgrevistatemp->listarImgRevista();
		 }*/
		
		//insertar_imagen($_REQUEST['titulo'],$_FILES['archivo']['name'],$_FILES['archivo']['tmp_name']);
		function insertarImgTip($rut, $temporal) {
			$imgtiptemp = new ImgSecundariaTip(0, $this -> idTip, $rut, $temporal);
			$imgtiptemp -> insertaImgTip();
		}	//$producto_temporal->modificar_imagen($_REQUEST['id_imagen'],$_REQUEST['titulo'],$_FILES['archivo']['name'],$_FILES['archivo']['tmp_name']);
		
		function modificarImgTip($id, $rut, $temporal) {
			$imgtiptemp = new ImgSecundariaTip($id, $this -> idTip, $rut, $temporal);
			$imgtiptemp -> modificaImgTip();
		}	
		function eliminarImgTip($id) {
			$imgtiptemp = new ImgSecundariaTip($id, $this -> idTip, '', '');
			$imgtiptemp -> eliminaImgTip();
		}	
		function obtenerImgTip($id) {
			$imgtiptemp = new ImgSecundariaTip(0, $id, '', '');
			$imgtiptemp -> obtenerImgTipfinal();
			return $imgtiptemp -> ruta;
		}
		
	}
	
?>