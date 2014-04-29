<?php
include_once('conexion.php');
require_once('archivo.php');
require_once('correo1.php');

class correo1img2 extends Archivo
	{
	var $idcorreo1img2;
	var $titulo;
	var $ruta;
	var $idcorreo1;
	var $directorio='/home1/locker07/public_html/clientes/patadeperro/panel/correos/correo1/correo2img/';
	
	function correo1img2 ($idcoimg1,$idc1,$rut,$tit,$temporal='')
	{
		$this->idcorreo1img2=$idcoimg1;
		$this->idcorreo1=$idc1;
		$this->ruta=$rut;
		$this->titulo=$tit;
		
		$this->ruta_final=$this->directorio.$rut;
		$this->ruta_temporal=$temporal;
	}
	
	
	
	function insertaCorreo1img2()
	{
		$sql="insert into correo1img2(idcorreo1,ruta,titulo) values (".$this->idcorreo1.",'".$this->ruta."','".$this->titulo."');";
		//echo $sql; 
		$con= new conexion();
		$con->ejecutar_sentencia($sql);
		
		$this->subir_archivo();	
	}
	
	
	function modificaCorreo1img2()
	{
		if ($this->ruta!='')
		{
			$titulo_temporal=$this->titulo;
			$ruta_temporal=$this->ruta;
			
			$this->recuperaCorreo1img2();
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

		$sql="update correo1img2 set idcorreo1=".$this->idcorreo1." ".$sql." ,titulo='".$this->titulo."' where idcorreo1img2=".$this->idcorreo1img2.";";
		//echo $sql;
		$con= new conexion();
		$con->ejecutar_sentencia($sql);
		$this->subir_archivo();
	}
	
	
	function eliminaCorreo1img2()
	{
		$this->recuperaCorreo1img2();
		$this->borrar_archivo();
		
		$sql="delete from correo1img2 where idcorreo1img2=".$this->idcorreo1img2.";";
		$con= new conexion();
		$con->ejecutar_sentencia($sql);
	}
	
	function obtenerCorreo1img2()
	{
		$sql="select idcorreo1img2,idcorreo1, ruta,titulo from correo1img2 where idcorreo1img2=".$this->idcorreo1img2;
		$con= new conexion();
		$resultados= $con->ejecutar_sentencia($sql);
		
		while ($fila=mysql_fetch_array($resultados))
		{
			$this->idcorreo1img2=$fila['idcorreo1img2'];
			$this->idcorreo1=$fila['idcorreo1'];
			$this->ruta=$fila['ruta'];
			$this->titulo=$fila['titulo'];
			$this->ruta_final=$this->directorio.$fila['ruta'];
		}
	}
	
	function obtenerCorreo1img2final()
	{
		$sql="select ruta from correo1img2 where idcorreo1=".$this->idcorreo1;
		$con= new conexion();
		$resultados= $con->ejecutar_sentencia($sql);
		while ($fila=mysql_fetch_array($resultados))
		{
			$this->ruta=$fila['ruta'];
			$this->ruta_final=$this->directorio.$fila['ruta'];
		}
	}
	
	function recuperaCorreo1img2()
	{
		$sql="select idcorreo1img2,idcorreo1, ruta,titulo from correo1img2 where idcorreo1img2=".$this->idcorreo1img2;
		$con= new conexion();
		$resultados= $con->ejecutar_sentencia($sql);
		
		while ($fila=mysql_fetch_array($resultados))
		{
			$this->idcorreo1img2=$fila['idcorreo1img2'];
			$this->idcorreo1=$fila['idcorreo1'];
			$this->ruta=$fila['ruta'];
			$this->titulo=$fila['titulo'];
			$this->ruta_final=$this->directorio.$fila['ruta'];
		}
	}
	
	function listarCorreo1img2()
	{
		$resultados=array();
		$sql="select idcorreo1img2, idcorreo1, ruta, titulo from correo1img2 where idcorreo1=".$this->idcorreo1.";";
		$con=new conexion();
		$temporal= $con->ejecutar_sentencia($sql);
		while ($fila=mysql_fetch_array($temporal))
		{
			$registro=array();
			$registro['idcorreo1img2']=$fila['idcorreo1img2'];
			$registro['idcorreo1']=$fila['idcorreo1'];
			$registro['ruta']=$fila['ruta'];
			$registro['titulo']=$fila['titulo'];
			array_push($resultados, $registro);
		}
		mysql_free_result($temporal);
		return $resultados;
	}
}
?>