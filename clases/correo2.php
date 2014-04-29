<?php
include_once('conexion.php');
require_once('archivo.php');
include_once('correo2img.php');
include_once('correo2img2.php');

class correo2 extends Archivo
{
	var $idcorreo2;
	var $ruta;
	var $titulo;
	var $subtitulo;
	var $desc1;
	var $desc2;
	var $desc3;
	var $desc4;
	var $correo1img;
	var $correo2img;
	var $directorio='/home1/locker07/public_html/clientes/patadeperro/panel/correos/correo2/';
	
	function correo2 ($idc2= 0,$rut = '',$tit = '',$subt = '',$desc1 = '',$desc2 = '',$desc3 = '', $desc4 = '', $temporal='')
	{
		$this -> idcorreo2 = $idc2;
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
		$this -> desc4 = $desc4;
		$this -> correo1img = array();
		$this -> correo2img = array();
		$this -> ruta_final = $this -> directorio.$this->ruta;
		$this -> ruta_temporal = $temporal;
	}
	
	
	
	function insertaCorreo2()
	{
		$sql="insert into correo2 (ruta, titulo, subtitulo, desc1, desc2, desc3, desc4) values 
		('".$this -> ruta."',
		'".$this -> titulo."',
		'".$this -> subtitulo."',
		'".$this -> desc1."',
		'".$this -> desc2."',
		'".$this -> desc3."',
		'".$this -> desc4."'
		);"; 
		$con= new conexion();
		$this->idcorreo2=$con->ejecutar_sentencia($sql);
		$this->subir_archivo();
	}
	
	
	function modificaCorreo2()
	{
		if ($this->ruta!='')
		{
			$titulo_temporal=$this->titulo;
			$ruta_temporal=$this->ruta;
			
			$this->recuperaCorreo2();
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
		$sql="update correo2 set 
		".$sql."
		titulo='".$this->titulo."', 
		subtitulo='".$this->subtitulo."', 
		desc1='".$this->desc1."',
		desc2='".$this->desc2."',
		desc3='".$this->desc3."',
		desc4='".$this->desc4."'
		where idcorreo2=".$this->idcorreo2.";";
		$con= new conexion();
		
		$con->ejecutar_sentencia($sql);
		$this->subir_archivo();
	}
	
	function eliminaCorreo2()
	{
		$this->obtenerCorreo2();
		$this->borrar_archivo();
		
		$sql="delete from correo2 where idcorreo2=".$this->idcorreo2.";";
		$con= new conexion();
		$con->ejecutar_sentencia($sql);
	}
	
	function obtenerCorreo2()
	{
		$sql="select * from correo2 where idcorreo2=".$this->idcorreo2.";";
		$con= new conexion();
		$resultados= $con->ejecutar_sentencia($sql);
		
		while ($fila=mysql_fetch_array($resultados))
		{
			$this->idcorreo2=$fila['idcorreo2'];
			$this->ruta=$fila['ruta'];
			$this->titulo=$fila['titulo'];
			$this->subtitulo=$fila['subtitulo'];
			$this->desc1=$fila['desc1'];
			$this->desc2=$fila['desc2'];
			$this->desc3=$fila['desc3'];
			$this->desc4=$fila['desc4'];
			$this->ruta_final=$this->directorio.$fila['ruta'];
		}
	}
	
	function recuperaCorreo2()
	{
		$sql="select idcorreo2, ruta,titulo from correo2 where idcorreo2=".$this->idcorreo2.";";
		echo $sql;
		$con= new conexion();
		$resultados= $con->ejecutar_sentencia($sql);
		
		while ($fila=mysql_fetch_array($resultados))
		{
			$this->idcorreo2=$fila['idcorreo2'];
			$this->ruta=$fila['ruta'];
			$this->titulo=$fila['titulo'];
			//$this->urlvideo=$fila['urlvideo'];
			$this->ruta_final=$this->directorio.$fila['ruta'];
		}
	}
	
	function listarCorreo2()
	{
		$resultados=array();
		$sql="select idcorreo2, ruta, titulo, subtitulo, descripcion from correo2";
		$con=new conexion();
		$temporal= $con->ejecutar_sentencia($sql);
		while ($fila=mysql_fetch_array($temporal))
		{
			$registro=array();
			$registro['idcorreo2']=$fila['idcorreo2'];
			$registro['ruta']=$fila['ruta'];
			$registro['titulo']=$fila['titulo'];
			$registro['subtitulo']=$fila['subtitulo'];
			$registro['desc1']=$fila['desc1'];
			array_push($resultados, $registro);
		}
		mysql_free_result($temporal);
		return $resultados;
	}
	
	//---------->COMIENZA MAESTRO DETALLE DE IMAGEN2<---------------
		
		function listarCorreo2img()
		{
			$imagencorreo1=new correo2img(0,$this->idcorreo2,'','','');
			$this->correo1img=$imagencorreo1->listarCorreo2img();
		}
	
		//insertar_imagen($_REQUEST['titulo'],$_FILES['archivo']['name'],$_FILES['archivo']['tmp_name']);	
		function insertarCorreo2img($tit,$rut,$temporal)
		{
			$imagencorreo1=new correo2img(0,$this->idcorreo2,$rut,$tit,$temporal);
			$imagencorreo1->insertaCorreo2img();
		}
		//$producto_temporal->modificar_imagen($_REQUEST['id_imagen'],$_REQUEST['titulo'],$_FILES['archivo']['name'],$_FILES['archivo']['tmp_name']);
		function modificarCorreo2img($id,$tit,$rut,$temporal)
		{
			$imagencorreo1=new correo2img($id,$this->idcorreo2,$rut,$tit,$temporal);
			$imagencorreo1->modificaCorreo2img();
		}
		
		function eliminarCorreo2img($id)
		{
			$imagencorreo1=new correo2img($id,$this->idcorreo1,'','','');
			$imagencorreo1->eliminaCorreo2img();
		}
		
		function obtenerCorreo2img($id)
		{
			$imagencorreo1=new correo2img($id,$this->idcorreo1,'','','');
			$imagencorreo1->obtenerCorreo2img();
			return $imagencorreo1;
		}
		
		//---------->COMIENZA MAESTRO DETALLE DE IMAGEN3<---------------
		
		function listarCorreo2img2()
		{
			$imagencorreo2=new correo2img2(0,$this->idcorreo2,'','','');
			$this->correo2img=$imagencorreo2->listarCorreo2img2();
		}
	
		//insertar_imagen($_REQUEST['titulo'],$_FILES['archivo']['name'],$_FILES['archivo']['tmp_name']);	
		function insertarCorreo2img2($tit,$rut,$temporal)
		{
			$imagencorreo2=new correo2img2(0,$this->idcorreo2,$rut,$tit,$temporal);
			$imagencorreo2->insertaCorreo2img2();
		}
		//$producto_temporal->modificar_imagen($_REQUEST['id_imagen'],$_REQUEST['titulo'],$_FILES['archivo']['name'],$_FILES['archivo']['tmp_name']);
		function modificarCorreo2img2($id,$tit,$rut,$temporal)
		{
			$imagencorreo2=new correo2img2($id,$this->idcorreo2,$rut,$tit,$temporal);
			$imagencorreo2->modificaCorreo2img2();
		}
		
		function eliminarCorreo2img2($id)
		{
			$imagencorreo2=new correo2img2($id,$this->idcorreo2,'','','');
			$imagencorreo2->eliminaCorreo2img2();
		}
	
}
?>