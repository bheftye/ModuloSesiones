<?php
include_once('conexion.php');
require_once('archivo.php');
require_once('paquete.php');

class ImgSecundariaPaquete extends Archivo
{
	var $idImgS;
	var $ruta;
	var $idPaquete;
	var $directorio = '../paquetes/secundarias/';
	
	function ImgSecundariaPaquete ($idImgS = 0, $idPqt = 0, $rut = "", $temporal = '')
	{
		$this -> idImgS = $idImgS;
		$this -> idPaquete = $idPqt;
		$this -> ruta = $rut;
		
		$this -> ruta_final = $this -> directorio.$rut;
		$this -> ruta_temporal = $temporal;
	}
	
	
	
	function insertaImgPaquete()
	{
		$sql="insert into paquetes_imagenes(id_paquete, imagen) values (".$this -> idPaquete.", '".$this -> ruta."');";
		$con = new conexion();
		$con -> ejecutar_sentencia($sql);
		$this -> subir_archivo();
	}
	
	
	function modificaImgPaquete()
	{
	
		if ($this -> ruta != '')
		{
		
			$ruta_temporal = $this -> ruta;
			
			$this -> recuperaImgPaquete();
			$this -> borrar_archivo();
			
			$this -> ruta = $ruta_temporal;
			
			$this -> ruta_final = $this -> directorio.$ruta_temporal;
			$sql = ' ,imagen=\''.$this -> ruta.'\'';
		}
		else
		{
			$sql = '';
		}
			
		$sql = "update paquetes_imagenes set id_paquete = ".$this -> idPaquete." ".$sql."  where id_img = ".$this -> idImgS.";";
		$con = new conexion();
		$con -> ejecutar_sentencia($sql);
		$this -> subir_archivo();
	}
	
	
	function eliminaImgPaquete()
	{
	
		$this -> recuperaImgPaquete();
		$this -> borrar_archivo();
		
		$sql = "delete from paquetes_imagenes where id_img =".$this -> idImgS.";";
		$con = new conexion();
		$con -> ejecutar_sentencia($sql);
	}
	
	function obtenerImgPaquete()
	{
		$sql = "select id_img, id_paquete, imagen from paquetes_imagenes where id_img =".$this -> idImgS;
		$con = new conexion();
		$resultados = $con -> ejecutar_sentencia($sql);
		
		while ($fila = mysql_fetch_array($resultados))
		{
			$this -> idImgS = $fila['id_img'];
			$this -> idPaquete = $fila['id_paquete'];
			$this -> ruta = $fila['imagen'];
			$this -> ruta_final = $this -> directorio.$fila['imagen'];
		}
	}
	
	function obtenerImgPaquetefinal()
	{
		$sql = "select imagen from paquetes_imagenes where id_paquete =".$this -> idPaquete;
		$con = new conexion();
		$resultados = $con -> ejecutar_sentencia($sql);
		
		while ($fila = mysql_fetch_array($resultados))
		{
			$this -> ruta = $fila['imagen'];
			$this -> ruta_final = $this -> directorio.$fila['imagen'];
		}
	}
	
	function recuperaImgPaquete()
	{
		$sql = "select * from paquetes_imagenes where id_img=".$this->idImgS;
		$con = new conexion();
		$resultados = $con -> ejecutar_sentencia($sql);
		
		while ($fila = mysql_fetch_array($resultados))
		{
			$this -> idImgS = $fila['id_img'];
			$this -> idPaquete = $fila['id_paquete'];
			$this -> ruta = $fila['imagen'];
			$this -> ruta_final = $this -> directorio.$fila['imagen'];
		
		}
	}
	
	function listarImgPaquete()
	{
		$resultados = array();
		$sql = "select * from paquetes_imagenes where id_paquete =".$this -> idPaquete;
		$con = new conexion();
		$temporal = $con -> ejecutar_sentencia($sql);
		while ($fila = mysql_fetch_array($temporal))
		{
			$registro = new ImgSecundariaPaquete();
			$registro -> idImgS = $fila['id_img'];
			$registro -> idPaquete = $fila['id_paquete'];
			$registro -> ruta = $fila['imagen'];
			array_push($resultados, $registro);
		}
		mysql_free_result($temporal);
		return $resultados;
	}
}
?>