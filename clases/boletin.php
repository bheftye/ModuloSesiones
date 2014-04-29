<?php
include_once('conexion.php');

class Boletin
{
var $idBoletin;
var $correo;
var $token;
var $status;

	function Boletin($id=0,$correo='',$stat=0)
	{
		$this->idBoletin=$id;
		$this->correo=$correo;
		$this->status=$stat;
	}
	function insertarBoletin()
	{
		$conexion= new conexion();
		$sql="insert into boletin (correo,token,status) values('".$this->correo."',MD5('".$this->correo."'),1)";
		$this->idBoletin=$conexion->ejecutar_sentencia($sql);
	}
	
	function modificarBoletin()
	{
		$conexion= new conexion();
		$sql="update boletin set correo='".$this->correo."',status=".$this->status." where idboletin=".$this->idBoletin;
		return $conexion->ejecutar_sentencia($sql);
	}
	function desactivarBoletin()
	{
		$con=new conexion();
		$sql="update boletin set status=0 where idboletin=".$this->idBoletin;
		$con->ejecutar_sentencia($sql);	
	}
	function activarBoletin()
	{
		$con=new conexion();
		$sql="update boletin set status=1 where idboletin=".$this->idBoletin;
		$con->ejecutar_sentencia($sql);	
	}
	function activarBoletinToken()
	{
		$con=new conexion();
		$sql="update boletin set status=1 where token='".$this->token."'";
		$con->ejecutar_sentencia($sql);	
	}

	function desactivarBoletinToken()
	{
		$con=new conexion();
		$sql="update boletin set status=0 where token='".$this->token."'";
		$con->ejecutar_sentencia($sql);	
	}
	function listarBoletinActivados()
	{
		$conexion=new conexion();
		$sql="select idboletin,correo,token,status from boletin where status=1";
		$result=$conexion->ejecutar_sentencia($sql);
		$resultados=array();
			while ($row=mysql_fetch_array($result))
			{
				$boletin = new Boletin();
				$boletin -> idBoletin =$row['idboletin'];
				$boletin -> correo =$row['correo'];
				$boletin -> status =$row['status'];
				array_push($resultados,$boletin);
			}
		mysql_free_result($result);
		return $resultados;
	}
	function listarBoletinDesactivados()
	{
		$conexion=new conexion();
		$sql="select idboletin,correo,status from boletin where status=0";
		$result=$conexion->ejecutar_sentencia($sql);
		$resultados=array();
			while ($row=mysql_fetch_array($result))
			{
				$boletin = new Boletin();
				$boletin -> idBoletin =$row['idboletin'];
				$boletin -> correo =$row['correo'];
				$boletin -> status =$row['status'];
				array_push($resultados,$boletin);
			}
		mysql_free_result($result);
		return $resultados;
	}
	function buscarBoletin($pedazo)
	{
		$conexion=new conexion();
		$sql="select idboletin,correo,status from boletin where correo like '%".$pedazo."%' group by idboletin";
		$result=$conexion->ejecutar_sentencia($sql);
		$resultados=array();
		while ($row=mysql_fetch_array($result))
		{
			$registro=array();
			$registro['idboletin']=$row['idboletin'];
			$registro['correo']=$row['correo'];
			$registro['status']=$row['status'];
			array_push($resultados,$registro);
		}
		echo json_encode($resultados);
		
	}
	function verificarDisponibilidad($criterio)
	{
		$conexion=new conexion();
		$sql="select idboletin,correo,status from boletin where correo='".$criterio."'";
		$result=$conexion->ejecutar_sentencia($sql);
		$resultados=array();
			while ($row=mysql_fetch_array($result))
			{
				$boletin = new Boletin();
				$boletin -> idBoletin =$row['idboletin'];
				$boletin -> correo =$row['correo'];
				$boletin -> status =$row['status'];
				array_push($resultados,$boletin);
			}
		mysql_free_result($result);
		return $resultados;
	}
	function listarBoletinAjax()
	{
			$conexion=new conexion();
			$sql="select idboletin,correo,status from boletin";
			$result=$conexion->ejecutar_sentencia($sql);
			$resultados=array();
			while ($row=mysql_fetch_array($result))
			{
				$registro=array();
				$registro['idboletin']=$row['idboletin'];
				$registro['correo']=$row['correo'];
				$registro['status']=$row['status'];
				array_push($resultados,$registro);
			}
			echo json_encode($resultados);
	}
	function  eliminarBoletin()
	{
		$conexion=new conexion();
		$sql="delete from boletin where idboletin=".$this->idBoletin;
		return $conexion->ejecutar_sentencia($sql);
	}
	function listarBoletin()
	{
		$conexion=new conexion();
		$sql="select idboletin,correo,status from boletin";
		$result=$conexion->ejecutar_sentencia($sql);
		$resultados=array();
			while ($row=mysql_fetch_array($result))
			{
				$boletin = new Boletin();
				$boletin -> idBoletin =$row['idboletin'];
				$boletin -> correo =$row['correo'];
				$boletin -> status =$row['status'];
				array_push($resultados,$boletin);
			}
		mysql_free_result($result);
		return $resultados;
	}
	
	function obtenerBoletin()
	{
		$conexion=new conexion();
		$sql="select * from boletin where idboletin=".$this->idBoletin;
		$result=$conexion->ejecutar_sentencia($sql);
			
			while($row=mysql_fetch_array($result))
			{
				$this->idBoletin=$row['idboletin'];
				$this->correo=$row['correo'];
				$this->token=$row['token'];
				$this->status=$row['status'];
			}
		mysql_free_result($result);
	}
	function obtenerBoletinToken()
	{
		$conexion=new conexion();
		$sql="select idboletin,correo,token,status from boletin where token=".$this->token;
		$result=$conexion->ejecutar_sentencia($sql);
			
			while($row=mysql_fetch_array($result))
			{
				$this->idBoletin=$row['idboletin'];
				$this->correo=$row['correo'];
				$this->token=$row['token'];
				$this->status=$row['status'];
			}
		mysql_free_result($result);
	}
}
?>