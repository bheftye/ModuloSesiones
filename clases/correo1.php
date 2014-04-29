<?php
include_once('conexion.php');
require_once('archivo.php');
include_once('correo1img.php');
include_once('correo1img2.php');

class correo1 extends Archivo
{
	var $idcorreo1;
	var $ruta;
	var $titulo;
	var $subtitulo;
	var $desc1;
	var $desc2;
	var $desc3;
	var $correo1img;
	var $correo2img;
	var $directorio='/home1/locker07/public_html/clientes/patadeperro/panel/correos/correo1/';
	
	function correo1 ($idc1= 0,$rut = '',$tit = '',$subt = '',$desc1 = '',$desc2 = '',$desc3 = '',$temporal='')
	{
		$this -> idcorreo1 = $idc1;
		if ($rut != '') {
			$this -> ruta = $this -> obtenerExtensionArchivo($rut);
		} else {
			$this -> ruta = '';
		}
		$this -> titulo = $tit;
		$this -> subtitulo = $subt;
		$this -> desc1 = $desc1;
		$this -> desc2 = $desc2;
		$this -> desc3 = $desc3;
		$this -> correo1img = array();
		$this -> correo2img = array();
		$this -> ruta_final = $this -> directorio.$this->ruta;
		$this -> ruta_temporal = $temporal;
	}
	
	
	
	function insertaCorreo1()
	{
		$sql="insert into correo1 (ruta, titulo, subtitulo, desc1, desc2, desc3) values 
		('".$this -> ruta."',
		'".$this -> titulo."',
		'".$this -> subtitulo."',
		'".$this -> desc1."',
		'".$this -> desc2."',
		'".$this -> desc3."'
		);"; 
		$con= new conexion();
		$this->idcorreo1=$con->ejecutar_sentencia($sql);
		$this->subir_archivo();
	}
	
	
	function modificaCorreo1()
	{
		if ($this->ruta!='')
		{
			$titulo_temporal=$this->titulo;
			$ruta_temporal=$this->ruta;
			
			$this->recuperaCorreo1();
			$this->borrar_archivo();
			
			$this->titulo=$titulo_temporal;
			$this->ruta=$ruta_temporal;
			
			$this->ruta_final=$this->directorio.$ruta_temporal;
			$sql=' ruta=\''.$this->ruta.'\',';
		}
		else
		{
			$sql='';
		}
		
		// ruta='".$this->ruta."'
		$sql="update correo1 set 
		".$sql."
		titulo='".$this->titulo."', 
		subtitulo='".$this->subtitulo."', 
		desc1='".$this->desc1."',
		desc2='".$this->desc2."',
		desc3='".$this->desc3."'
		 where idcorreo1=".$this->idcorreo1.";";
		$con= new conexion();
		
		$con->ejecutar_sentencia($sql);
		$this->subir_archivo();
	}
	
	function eliminaCorreo1()
	{
		$this->obtenerCorreo1();
		$this->borrar_archivo();
		
		$sql="delete from correo1 where idcorreo1=".$this->idcorreo1.";";
		$con= new conexion();
		$con->ejecutar_sentencia($sql);
	}
	
	function obtenerCorreo1()
	{
		$sql="select * from correo1 where idcorreo1=".$this->idcorreo1.";";
		$con= new conexion();
		$resultados= $con->ejecutar_sentencia($sql);
		
		while ($fila=mysql_fetch_array($resultados))
		{
			$this->idcorreo1=$fila['idcorreo1'];
			$this->ruta=$fila['ruta'];
			$this->titulo=$fila['titulo'];
			$this->subtitulo=$fila['subtitulo'];
			$this->desc1=$fila['desc1'];
			$this->desc2=$fila['desc2'];
			$this->desc3=$fila['desc3'];
			$this->ruta_final=$this->directorio.$fila['ruta'];
		}
	}
	
	function recuperaCorreo1()
	{
		$sql="select idcorreo1, ruta,titulo from correo1 where idcorreo1=".$this->idcorreo1.";";
		$con= new conexion();
		$resultados= $con->ejecutar_sentencia($sql);
		
		while ($fila=mysql_fetch_array($resultados))
		{
			$this->idcorreo1=$fila['idcorreo1'];
			$this->ruta=$fila['ruta'];
			$this->titulo=$fila['titulo'];
			//$this->urlvideo=$fila['urlvideo'];
			$this->ruta_final=$this->directorio.$fila['ruta'];
		}
	}
	
	function listarCorreo1()
	{
		$resultados=array();
		$sql="select idcorreo1, ruta, titulo, subtitulo, descripcion from correo1";
		$con=new conexion();
		$temporal= $con->ejecutar_sentencia($sql);
		while ($fila=mysql_fetch_array($temporal))
		{
			$registro=array();
			$registro['idcorreo1']=$fila['idcorreo1'];
			$registro['ruta']=$fila['ruta'];
			$registro['titulo']=$fila['titulo'];
			$registro['subtitulo']=$fila['subtitulo'];
			$registro['descripcion']=$fila['descripcion'];
			array_push($resultados, $registro);
		}
		mysql_free_result($temporal);
		return $resultados;
	}
	
	//---------->COMIENZA MAESTRO DETALLE DE IMAGEN2<---------------
		
		function listarCorreo1img()
		{
			$imagencorreo1=new correo1img(0,$this->idcorreo1,'','','');
			$this->correo1img=$imagencorreo1->listarCorreo1img();
		}
	
		//insertar_imagen($_REQUEST['titulo'],$_FILES['archivo']['name'],$_FILES['archivo']['tmp_name']);	
		function insertarCorreo1img($tit,$rut,$temporal)
		{
			$imagencorreo1=new correo1img(0,$this->idcorreo1,$rut,$tit,$temporal);
			$imagencorreo1->insertaCorreo1img();
		}
		//$producto_temporal->modificar_imagen($_REQUEST['id_imagen'],$_REQUEST['titulo'],$_FILES['archivo']['name'],$_FILES['archivo']['tmp_name']);
		function modificarCorreo1img($id,$tit,$rut,$temporal)
		{
			$imagencorreo1=new correo1img($id,$this->idcorreo1,$rut,$tit,$temporal);
			$imagencorreo1->modificaCorreo1img();
		}
		
		function eliminarCorreo1img($id)
		{
			$imagencorreo1=new correo1img($id,$this->idcorreo1,'','','');
			$imagencorreo1->eliminaCorreo1img();
		}
		
		function obtenerCorreo1img($id)
		{
			$imagencorreo1=new correo1img($id,$this->idcorreo1,'','','');
			$imagencorreo1->obtenerCorreo1img();
			return $imagencorreo1;
		}
		
		//---------->COMIENZA MAESTRO DETALLE DE IMAGEN3<---------------
		
		function listarCorreo1img2()
		{
			$imagencorreo2=new correo1img2(0,$this->idcorreo1,'','','');
			$this->correo2img=$imagencorreo2->listarCorreo1img2();
		}
	
		//insertar_imagen($_REQUEST['titulo'],$_FILES['archivo']['name'],$_FILES['archivo']['tmp_name']);	
		function insertarCorreo1img2($tit,$rut,$temporal)
		{
			$imagencorreo2=new correo1img2(0,$this->idcorreo1,$rut,$tit,$temporal);
			$imagencorreo2->insertaCorreo1img2();
		}
		//$producto_temporal->modificar_imagen($_REQUEST['id_imagen'],$_REQUEST['titulo'],$_FILES['archivo']['name'],$_FILES['archivo']['tmp_name']);
		function modificarCorreo1img2($id,$tit,$rut,$temporal)
		{
			$imagencorreo2=new correo1img2($id,$this->idcorreo1,$rut,$tit,$temporal);
			$imagencorreo2->modificaCorreo1img2();
		}
		
		function eliminarCorreo1img2($id)
		{
			$imagencorreo2=new correo1img2($id,$this->idcorreo1,'','','');
			$imagencorreo2->eliminaCorreo1img2();
		}
	
}
?>