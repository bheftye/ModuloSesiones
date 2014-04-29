<?php
include_once('class.phpmailer.php');

class correo
{
var $correo;

    
function Correo()
{

$this->correo = new PHPMailer();
$this->correo->Host='localhost';
$this->correo->From='soporte@locker.com.mx';
$this->correo->FromName='Pata de Perro Viajes';
$this->correo->AddCC='soporte@locker.com.mx, copia';    
$this->correo->IsHTML(true);
$this->correo->CharSet='UTF-8';
}
    
function genera_mensaje()
{
$this->correo->Body='<h3 style="color:#333"></h3>';
}

function genera_asunto()
{
$this->correo->Subject='Registro completado';
}
    
function genera_destino()
{
$this->correo->AddAddress('http://clientes.locker.com.mx/patadeperro/');
}
    
function enviar()
{
$this->genera_asunto();
$this->genera_destino();
$this->genera_mensaje();

if($this->correo->Send())
{    

}
else
echo 'Error'.$this->correo->ErrorInfo;
}
}
?>