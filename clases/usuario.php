<?php
include_once('conexion.php');

class usuario
{
	var $idusuario;
	var $user;
	var $password;
	var $status;
	var $preguntaSecreta;
	var $respuestaSecreta;
	var $nombre;
	var $apellido;
	
	function usuario($idusuario = 0, $user = '', $password = '', $stat = 1, $preguntaSecreta ="", $respuestaSecreta="", $nombre = "", $apellido ="")
	{
		$this->idusuario=$idusuario;
		$this->user=$user;
		$this->password=$password;
		$this->status=$stat;
		$this -> preguntaSecreta = $preguntaSecreta;
		$this -> respuestaSecreta = $respuestaSecreta;
		$this -> nombre  = $nombre;
		$this -> apellido = $apellido;
	}
	
	function inserta_usuario()
	{
		$conexion= new conexion();
		$sql="INSERT INTO usuarios (user, password, status, question, answer, name, last_name) values('".$this->user."',MD5('".$this->password."'), 1, '".$this -> preguntaSecreta."', '".$this -> respuestaSecreta."' , '".$this -> nombre."', '".$this -> apellido."')";
		return $this->idusuario=$conexion->ejecutar_sentencia($sql);
	}
	
	function modifica_usuario()
	{
		$conexion= new conexion();
		$pedazo="";
		$pedazo2='';
		if($this->user != '')
			$pedazo2="user='".$this->user."',";
		if ($this->password!='')   
			$pedazo="password=MD5('".$this->password."'),";
		$sql="update usuarios set ".$pedazo2." ".$pedazo."status='".$this->status."',idtipousuario=".$this->tiposusuario->idtipousuario.", pregunta = '".$this -> preguntaSecreta."', respuesta = '".$this -> respuestaSecreta."' where idusuario=".$this->idusuario;
		return $conexion->ejecutar_sentencia($sql);
	}
	function modifica_usuario_pass()
	{
		$conexion= new conexion();
		$sql="update usuarios set password=MD5('".$this->password."') where idusuario=".$this->idusuario;
		$conexion->ejecutar_sentencia($sql);
	}
	function elimina_usuario()
	{
		$conexion=new conexion();
		$sql="delete from usuarios where idusuario=".$this->idusuario;
		return $conexion->ejecutar_sentencia($sql);
	}
	
	function DesactivaUsuario()
	{
		$con=new conexion();
		$sql="update usuarios set status=0 where idusuario=".$this->idusuario;
		$con->ejecutar_sentencia($sql);	
	}
	
	function ActivaUsuario()
	{
		$con=new conexion();
		$sql="update usuarios set status=1 where idusuario=".$this->idusuario;
		$con->ejecutar_sentencia($sql);	
	}
	
	function obten_usuario()
	{
		$conexion=new conexion();
		$sql="select * from usuarios where id_user=".$this->idusuario;
		$result=$conexion->ejecutar_sentencia($sql);
		while($row=mysql_fetch_array($result))
		{
			$this->idusuario=$row['id_user'];
			$this->user=$row['user'];
			$this->password=$row['password'];
			$this->status=$row['status'];
			$this -> preguntaSecreta = $row["question"];
			$this -> respuestaSecreta = $row["answer"];
			$this -> nombre = $row["name"];
			$this -> apellido =$row["last_name"];
		}
		mysql_free_result($result);
	}
	
	function VerficarDisponibilidadNomUsuario($nom)
	{
		$conexion=new conexion();
		$sql="SELECT user FROM usuarios where user='".$nom."'";
		$result=$conexion->ejecutar_sentencia($sql);
		$resultados=array();
		while ($row=mysql_fetch_array($result))
		{
			$registro=array();
			$registro['user']=$row['user'];
			array_push($resultados,$registro);
		}
		mysql_free_result($result);
		return $resultados;
	}
	function VerficarPassword($idusuario)
	{
		$conexion=new conexion();
		$sql="SELECT password FROM usuarios where idusuario='".$idusuario."'";
		$result=$conexion->ejecutar_sentencia($sql);
		$resultados=array();
		while ($row=mysql_fetch_array($result))
		{
			$this->password=$row['password'];
		}
	}
	
	function login()
	{
		$conexion=new conexion();
		$sql="select * from usuarios where user='".$this->user."' and password = MD5('".$this->password."') and status=1";
		$resultado=$conexion->ejecutar_sentencia($sql);
		while($fila =mysql_fetch_array($resultado))
		{
			$this->idusuario=$fila['id_user'];
			$this->user=$fila['user'];
		}
	}
	
	function obtener_datos_usuarios($id)
	{
			 $con=new conexion();
			 $sql="SELECT usuario.idusuario,user, datosusuario.idusuario, nombre,email,telefono from usuario, datosusuario where usuario.idusuario=datosusuario.idusuario and usuario.idusuario=".$id;
			 $resultados = $con->ejecutar_sentencia($sql);
			 //echo $sql;
			 
			 while($row=mysql_fetch_array($result))
			 {
				  $this->idusuario=$row['id_usuario'];
				  $this->nombre=$row['nombre'];				
				  $this->email=$row['email'];
				  $this->telefono=$row['telefono'];
			 }
	
	}
}
?>