<?php
include_once('correo1.php');
include_once('correo1img.php');
include_once('correo1img2.php');
include_once('cliente.php');
include_once('boletin.php');
include_once('correo.php');


class tempcorreo1 extends correo
{
	var $correo1;
	var $cliente;
	var $boletin;
    var $token;
    var $correoPrueba;
	
	function tempcorreo1($idcorreo1,$idcliente,$idboletin, $correoPrueba="")
    {
		$this->correo();    
     	$this->correo1=new correo1($idcorreo1);
		$this->correo1->obtenerCorreo1();
		$this->correo1->listarCorreo1img();
		$this->correo1->listarCorreo1img2();
		$this->cliente=new cliente($idcliente);
		$this->cliente->obtenerCliente();
		$this->boletin= new Boletin($idboletin);
		$this->boletin->obtenerBoletin();	
        $this -> correoPrueba = $correoPrueba;     
    }
    
    function genera_asunto()
    {
        $this->correo->Subject=$this->correo1->titulo;//este es de datos_usuario y nomusuario es de usuario
    }
    
    function genera_destino()
    {
		if($this->cliente->idcliente > 0){
            $this->correo->AddAddress($this->cliente->email);
            $this -> token = $this-> cliente -> token;
        }
		if($this->boletin->idBoletin > 0){
		  $this->correo->AddAddress($this->boletin->correo);
          $this -> token = $this -> boletin -> token;
        }
        if($this -> correoPrueba != ""){
            $this -> correo -> AddAddress($this -> correoPrueba);
            $this -> token = "no-aplicable";
        }

    }
    
    function genera_mensaje()
    {
        //$usuario= $this->usuariocliente;
       	$this->correo->Body = '<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title>Responsive Email Template</title>
                                                                                                                                                                                                                                                                                                                                                                                                        
<style type="text/css">
	.ReadMsgBody {width: 100%; background-color: #ffffff;}
	.ExternalClass {width: 100%; background-color: #ffffff;}
	body	 {width: 100%; background-color: #ffffff; margin:0; padding:0; -webkit-font-smoothing: antialiased;font-family: Georgia, Times, serif}
	table {border-collapse: collapse;}
	
	@media only screen and (max-width: 640px)  {
					body[yahoo] .deviceWidth {width:440px!important; padding:0;}	
					body[yahoo] .center {text-align: center!important;}	 
			}
			
	@media only screen and (max-width: 479px) {
					body[yahoo] .deviceWidth {width:280px!important; padding:0;}	
					body[yahoo] .center {text-align: center!important;}	 
			}

</style>
</head>

<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" yahoo="fix" style="font-family: Georgia, Times, serif">

<!-- Wrapper -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td width="100%" valign="top" bgcolor="#ffffff" style="padding-top:20px">
		
			<!-- Start Header-->
			<table width="580" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth">
				<tr>
					<td width="100%" bgcolor="#ffffff">

                            <!-- Logo -->
                            <table border="0" cellpadding="0" cellspacing="0" align="left" class="deviceWidth">
                                <tr>
                                    <td style="padding:10px 20px" class="center">
                                        <a href="http://clientes.locker.com.mx/patadeperro/"><img src="http://clientes.locker.com.mx/patadeperro/panel/img/logo.png" alt="" border="0" width="200" height="70" /></a>
                                    </td>
                                </tr>
                            </table><!-- End Logo -->
                            
                            <!-- Nav -->
                            <table border="0" cellpadding="0" cellspacing="0" align="right" class="deviceWidth">
                                <tr>
                                    <td class="center" style="font-size: 24px; color: #272727; font-weight: light; text-align: right; font-family: Georgia, Times, serif; line-height: 20px; vertical-align: middle; padding:10px 20px; font-style:italic">
                                        <p>'.$this->correo1->titulo.'</p>
                                    </td>
                                </tr>
                            </table><!-- End Nav -->

					</td>
				</tr>
			</table><!-- End Header -->
			<table width="580"  class="deviceWidth" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff">
				<tr>
					<td>
						<table style="border-bottom: 3px solid #ff5800">
                        	<tr>
                        		<td width="580"></td>
                            </tr>
                        </table>
					</td>
				</tr>
				<tr>
					<td style="font-size: 13px; color: #000; font-weight: normal; text-align: left; font-family: Georgia, Times, serif; line-height: 24px; vertical-align: top; padding:10px 8px 10px 8px">
						Pata de Perro Viajes
					</td>
				</tr>
			</table>
			<!-- One Column -->
			<table width="580"  class="deviceWidth" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff">
				<tr>
					<td valign="top" style="padding:0" bgcolor="#ffffff">
						<a href="#"><img  class="deviceWidth" src="http://clientes.locker.com.mx/patadeperro/panel/correos/correo1/'.$this->correo1->ruta.'" width="580" height="200" alt="" border="0" style="display: block; border-radius: 4px;" /></a>						
					</td>
				</tr>
                <tr>
                    <td style="font-size: 13px; color: #000; font-weight: normal; text-align: left; font-family: Georgia, Times, serif; line-height: 24px; vertical-align: top; padding:10px 8px 10px 8px" bgcolor="#ffffff">
                        
                        <table>
                            <tr>                    
                                <td valign="middle" style="padding:0 10px 10px 0"><a href="#" style="text-decoration: none; color: #272727; font-size: 16px; color: #272727; font-weight: bold; font-family:Arial, sans-serif ">
                                	'.$this->correo1->subtitulo.'
                                </td>
                            </tr>
                        </table>

						'.$this->correo1->desc1.'							
                    </td>
                </tr>              
			</table><!-- End One Column -->
			<table width="580"  class="deviceWidth" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff">
				<tr>
					<td>
						<table style="border-bottom: 3px solid #ff5800">
                        	<tr>
                        		<td width="580"></td>
                            </tr>
                        </table>
					</td>
				</tr>				
			</table>
			<!-- Two Column (Images Stacked over Text) -->
			<table width="580" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth" bgcolor="#ffffff">
				<tr>
					<td class="center" style="padding:10px 0 0 5px">

                        <table width="49%" border="0" cellpadding="0" cellspacing="0" align="left" class="deviceWidth">
                            <tr>
                                <td style="font-size: 12px; color: #000; font-weight: normal; text-align: left; font-family: Georgia, Times, serif; line-height: 24px; vertical-align: top; padding:10px 8px 10px 8px">                                        
                                     <p>'.$this->correo1->desc2.'</p>
                                </td>
                            </tr>                         
                        </table>
                                                
                        <table width="49%" border="0" cellpadding="0" cellspacing="0" align="left" class="deviceWidth">                         
                            <tr>
                                <td style="font-size: 12px; color: #000; font-weight: normal; text-align: left; font-family: Georgia, Times, serif; line-height: 24px; vertical-align: top; padding:10px 8px 10px 8px">                    
                                     <p>'.$this->correo1->desc3.'</p>
                                </td>
                            </tr>                         
                        </table>                                        

					</td>
				</tr>
			</table><!-- End Two Column (Images Stacked over Text) -->
			<!-- Two Column (Images Stacked over Text) -->
			<table width="580" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth" bgcolor="#ffffff">
				<tr>
					<td class="center" style="padding:10px 0 0 5px">';
						foreach ($this->correo1->correo1img as $elemento1) {
							$this->correo->Body.='<table width="49%" border="0" cellpadding="0" cellspacing="0" align="left" class="deviceWidth">
                            <tr>
                                <td align="center">                               
                                    <p style="mso-table-lspace:0;mso-table-rspace:0; margin:0"><img width="267" src="http://clientes.locker.com.mx/patadeperro/panel/correos/correo1/correo1img/'.$elemento1['ruta'].'" alt="" border="0" style="border-radius: 4px; width: 267px" class="deviceWidth" /></p>
                                </td>
                            </tr>                       
                        </table>';
						}
                        $this->correo->Body.='</td>
				</tr>
			</table><!-- End Two Column (Images Stacked over Text) -->

<div style="height:15px">&nbsp;</div><!-- spacer -->
			<table width="580"  class="deviceWidth" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff">
				<tr>
					<td>
						<table style="border-bottom: 3px solid #ff5800">
                        	<tr>
                        		<td width="580"></td>
                            </tr>
                        </table>
					</td>
				</tr>				
			</table>
			<div style="height:15px">&nbsp;</div><!-- spacer -->
			<table width="580"  class="deviceWidth" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#ffffff">
				<tr>
					<td valign="top" style="padding:0" bgcolor="#fff">
						<a href="#"><img  class="deviceWidth" src="http://clientes.locker.com.mx/patadeperro/panel/correos/correo1/correo2img/'.$this->correo1->correo2img[0]['ruta'].'" width="580" height="200" alt="" border="0" style="display: block; border-radius: 4px;" /></a>						
					</td>
				</tr>          
			</table><!-- End One Column -->
           
<div style="height:15px">&nbsp;</div><!-- spacer -->
			 
            <!-- 2 Column Images - text left -->
			<table width="580" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth" bgcolor="#ffffff">
				<tr>
					<td style="padding:10px 0">  
                           
                                                                            
                    </td>
                </tr>
            </table><!-- End 2 Column Images  - text left -->
            <!-- 2 Column Images - text left -->
			<table width="580" border="0" cellpadding="0" cellspacing="0" align="center" class="deviceWidth" bgcolor="#ff5800">
				<tr>
					<td style="padding:10px 0">  
                            <table width="70%" cellpadding="0" cellspacing="0"  border="0" align="left" class="deviceWidth">
                            	<tr>
                                	<td valign="top" style="font-size: 11px; color:#fff; font-family: Arial, sans-serif; padding-bottom:5px; padding-left: 20px" class="center">

                                        T + 52 (999) 944 44 64 | (999) 944 07 05<br/>                                       
                                        - Prolongación Montejo Calle 34 No. 370 entre 35 y 37 Emiliano Zapata Norte C.P. 97129<br>
                                        - Villas la Hacienda Calle 32 No. 328 E local 6 Planta baja entre 53 y 55 Col. Villas la Hacienda C.P. 97119<br>
                                        contacto@patadeperroviajes.com<br/>                 
                                        

                                    </td>
                                </tr>
                            </table>
                             <table align="right" width="30%" cellpadding="0" cellspacing="0" border="0" class="deviceWidth">
                                <tr>
                                    <td valign="top" style="font-size: 18px; color: #000; font-weight: normal; font-family: Georgia, Times, serif; line-height: 26px; pavertical-align: top; padding-right: 10px; padding-top: 10px; text-align:right" class="center">
                                            <a href="https://www.facebook.com/patadeperroviajes?ref=ts&fref=ts"><img src="http://clientes.locker.com.mx/patadeperro/panel/img/logo_facebook_blanco.png" width="25" height="21" alt="Facebook" title="Facebook" border="0" /></a>
                                            <a href="https://twitter.com/patadeperromex"><img src="http://clientes.locker.com.mx/patadeperro/panel/img/logo_twitter_blanco.png" width="25" height="21" alt="Twitter" title="Twitter" border="0" /></a>                                       
                                    </td>
                                </tr>
                            </table>                                                  
                    </td>
                </tr>
            </table><!-- End 2 Column Images  - text left -->
            <table width="580" cellpadding="0" cellspacing="0"  border="0" align="center" class="deviceWidth">
                <tr>
                    <td valign="top" style="font-size: 11px; color:#000; font-family: Arial, sans-serif; padding-bottom:5px; padding-left: 20px" class="center">
                    <br>
                        Usted ha recibido este e-mail porque<br/>
                        1.) Usted es un cliente importante para Pata de Perro Viajes o<br/>
                        2.) Usted esta subscrito via al boletín de <a href="http://clientes.locker.com.mx/patadeperro/" style="color:#000;text-decoration:underline;">Pata de Perro Viajes</a><br/>
                               
                        <br/>
                        <br/>

                        ¿Quieres dejar de recibir estos e-mails? No hay problema, de <a href="http://clientes.locker.com.mx/patadeperro/ManejadorDeBoletin.php?opr=d_b&t='.$this -> token.'" style="color:#000;text-decoration:underline;">click aquí</a> y dejará de recibir mails.
                    </td>
                </tr>
            </table>        
		</td>
	</tr>
</table> <!-- End Wrapper -->

</body>
</html>';                                       
    }
}
?>