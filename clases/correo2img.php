<?php
include_once('conexion.php');
require_once('archivo.php');
require_once('correo2.php');

class correo2img extends Archivo
	{
	var $idcorreoimg2;
	var $titulo;
	var $ruta;
	var $idcorreo2;
	var $directorio='/home1/locker07/public_html/clientes/patadeperro/panel/correos/correo2/correo1img/';
	
	function correo2img ($idcoimg2,$idc2,$rut,$tit,$temporal='')
	{
		$this->idcorreoimg2=$idcoimg2;
		$this->idcorreo2=$idc2;
		$this->ruta=$rut;
		$this->titulo=$tit;
		
		$this->ruta_final=$this->directorio.$rut;
		$this->ruta_temporal=$temporal;
	}
	
	
	
	function insertaCorreo2img()
	{
	$sql="insert into correo2img(idcorreo2,ruta,titulo) values (".$this->idcorreo2.",'".$this->ruta."','".$this->titulo."');"; 
	$con= new conexion();
	$con->ejecutar_sentencia($sql);
	$this->subir_archivo();
	
	}

	function modificaCorreo2img()
	{
		if ($this->ruta!='')
		{
			$titulo_temporal=$this->titulo;
			$ruta_temporal=$this->ruta;
			
			$this->recuperaCorreo2img();
			$this->borrar_archivo();
			
			$this->titulo=$titulo_temporal;
			$this->ruta=$ruta_temporal;
			
			$this->ruta_final=$this->directorio.$ruta_temporal;
			$sql=' ,ruta=\''.$this->ruta.'\'';
		}
		else
		{
			$sql='';
		}
		
		$sql="update correo2img set idcorreo2=".$this->idcorreo2." ".$sql." ,titulo='".$this->titulo."' where idcorreoimg2=".$this->idcorreoimg2.";";
		$con= new conexion();
		$con->ejecutar_sentencia($sql);
		$this->subir_archivo();
	}
	
	
	function eliminaCorreo2img()
	{
		$this->recuperaCorreo2img();
		$this->borrar_archivo();
		
		$sql="delete from correo2img where idcorreoimg2=".$this->idcorreoimg2.";";
		$con= new conexion();
		$con->ejecutar_sentencia($sql);
	}
	
	function obtenerCorreo2img()
	{
		$sql="select idcorreoimg2,idcorreo2, ruta,titulo from correo2img where idcorreoimg2=".$this->idcorreoimg2;
		$con= new conexion();
		$resultados= $con->ejecutar_sentencia($sql);
		
		while ($fila=mysql_fetch_array($resultados))
		{
			$this->idcorreoimg2=$fila['idcorreoimg2'];
			$this->idcorreo2=$fila['idcorreo2'];
			$this->ruta=$fila['ruta'];
			$this->titulo=$fila['titulo'];
			$this->ruta_final=$this->directorio.$fila['ruta'];
		}
	}
	
	function obtenerCorreo2imgfinal()
	{
		$sql="select ruta from correo2img where idcorreo2=".$this->idcorreo2;
		$con= new conexion();
		$resultados= $con->ejecutar_sentencia($sql);
		
		while ($fila=mysql_fetch_array($resultados))
		{
			$this->ruta=$fila['ruta'];
			$this->ruta_final=$this->directorio.$fila['ruta'];
		}
	}
	
	function recuperaCorreo2img()
	{
		$sql="select idcorreoimg2,idcorreo2, ruta,titulo from correo2img where idcorreoimg2=".$this->idcorreoimg2;
		$con= new conexion();
		$resultados= $con->ejecutar_sentencia($sql);
		
		while ($fila=mysql_fetch_array($resultados))
		{
			$this->idcorreoimg2=$fila['idcorreoimg2'];
			$this->idcorreo2=$fila['idcorreo2'];
			$this->ruta=$fila['ruta'];
			$this->titulo=$fila['titulo'];
			$this->ruta_final=$this->directorio.$fila['ruta'];
		}
	}
	
	function listarCorreo2img()
	{
		$resultados=array();
		$sql="select idcorreoimg2, idcorreo2, ruta, titulo from correo2img where idcorreo2=".$this->idcorreo2.";";
		$con=new conexion();
		$temporal= $con->ejecutar_sentencia($sql);
		while ($fila=mysql_fetch_array($temporal))
		{
			$registro=array();
			$registro['idcorreoimg2']=$fila['idcorreoimg2'];
			$registro['idcorreo2']=$fila['idcorreo2'];
			$registro['ruta']=$fila['ruta'];
			$registro['titulo']=$fila['titulo'];
			array_push($resultados, $registro);
		}
		mysql_free_result($temporal);
		return $resultados;
	}
}
?>