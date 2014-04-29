<?php
include_once ('conexion.php');
require_once ('archivo.php');
	class Slide extends archivo{
		var $idSlide;
		var $titulo;
		var $imgPrincipal;
		var $directorio = '../slide/principales/';
		var $status;
		
		function Slide($idSlide = 0, $titulo ="", $imgPrincipal = "", $status = 1){
			$this -> idSlide = $idSlide;
			$this -> titulo = $titulo;
			$this -> imgPrincipal = $imgPrincipal;
			$this -> status = $status;
		}

		function insertarSlide() {
			$sql = "INSERT INTO slide (titulo, imagen, status) VALUES('".$this -> titulo."', '".$this -> imgPrincipal."', ".$this -> status.")";
			$con = new conexion();
			$this -> idSlide = $con -> ejecutar_sentencia($sql);
			$this -> subir_archivo();
		}

		function modificarSlide() {
			if ($this -> imgPrincipal != '') {
				$slide = new Slide($this -> idSlide);
				$slide -> obtenerSlide();
				$slide -> ruta_final = $slide -> directorio. $slide -> imgPrincipal;
				$slide -> borrar_archivo();

				$this -> ruta_final = $this -> directorio . $this -> imgPrincipal;
				$sql = ' imagen=\'' . $this -> imgPrincipal . '\',';
			} else {
				$sql = '';
			}
			
			$sql = "UPDATE `slide` SET ".$sql." `titulo`='".$this -> titulo."'  WHERE id = ".$this -> idSlide;
			$con = new conexion();
			$con -> ejecutar_sentencia($sql);
			$this -> subir_archivo();	
		}

		function eliminarSlide() {
			$this -> recuperarSlide();
			$this -> borrar_archivo();
			$sql = "DELETE FROM `slide` WHERE id =" . $this -> idSlide . ";";
			$con = new conexion();
			$con -> ejecutar_sentencia($sql);
		}

		function desactivaSlide() {
			$con = new conexion();
			$sql = "UPDATE slide SET status = 0 WHERE id =" . $this -> idSlide;
			$con -> ejecutar_sentencia($sql);
		}

		function activaSlide() {
			$con = new conexion();
			$sql = "UPDATE slide SET status = 1 WHERE id =" . $this -> idSlide;
			$con -> ejecutar_sentencia($sql);
		}

		function llenarSlideConSusDatos($filaSQL){
			$this ->  idSlide = $filaSQL["id"];
			$this ->  titulo = $filaSQL["titulo"];
			$this ->  imgPrincipal = $filaSQL['imagen'];
			$this -> ruta_final = $this -> directorio . $filaSQL['imagen'];
			$this -> status = $filaSQL["status"];
		}

		function listarSlideActivos() {
			$resultados = array();
			$sql = "SELECT * FROM slide WHERE status = 1 ORDER BY titulo ASC";
			$con = new conexion();
			$temporal = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($temporal)) {
				$slide = new Slide();
				$slide -> llenarSlideConSusDatos($fila);
				array_push($resultados, $slide);
			}
			mysql_free_result($temporal);
			return $resultados;
		}

		function listarSlideDesactivados() {
			$resultados = array();
			$sql = "SELECT * FROM slide WHERE status = 0 ORDER BY titulo ASC";
			$con = new conexion();
			$temporal = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($temporal)) {
				$slide = new Slide();
				$slide -> llenarSlideConSusDatos($fila);
				array_push($resultados, $slide);
			}
			mysql_free_result($temporal);
			return $resultados;
		}


		function obtenerSlide() {
			$sql = "SELECT * FROM slide WHERE id =".$this -> idSlide.";";
			$con = new conexion();
			$resultados = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($resultados)) {
				$this -> llenarSlideConSusDatos($fila);
			}
			mysql_free_result($resultados);
			return;
		}

		function recuperarSlide() {
			$sql = "SELECT * FROM slide WHERE id =" . $this -> idSlide . ";";
			$con = new conexion();
			$resultados = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($resultados)) {
				$this -> llenarSlideConSusDatos($fila);
			}
			mysql_free_result($resultados);
			return ;
		}

		function listarSlide() {
			$resultados = array();
			$sql = "SELECT * FROM slide ORDER BY titulo ASC";
			$con = new conexion();
			$temporal = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($temporal)) {
				$slide = new Slide();
				$slide -> llenarSlideConSusDatos($fila);
				array_push($resultados, $slide);
			}
			mysql_free_result($temporal);
			return $resultados;
		}

		function buscarSlide($pedazo) {
			$resultados = array();
			$sql = "SELECT * FROM slide WHERE (titulo like '%" . $pedazo . "%') group by titulo";
			$con = new conexion();
			$temporal = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($temporal)) {
				$registro = array();
				$registro["idslide"] = $fila["id"];
				$registro["titulo"] = $fila["titulo"];
				$registro["status"] = $fila["status"];
				array_push($resultados, $registro);
			}
			echo json_encode($resultados);
		}

		function limitSlide() {
			$resultados = array();
			$sql = "SELECT * FROM slide";
			$con = new conexion();
			$temporal = $con -> ejecutar_sentencia($sql);
			while ($fila = mysql_fetch_array($temporal)) {
				$registro = array();
				$registro["idslide"] = $fila["id"];
				$registro["titulo"] = $fila["titulo"];
				$registro["status"] = $fila["status"];
				array_push($resultados, $registro);
			}
			echo json_encode($resultados);
		}

		function obtenerSlidesUrl(){
			
		}
		
	}
	
?>