<?php define(MI_RUTA, "/patadeperro/panel/");?>
<!--wrapper es el que contiene a toda la pagina-->
    <div id="wrapper" class="wrapper-movil">
        <!-- Sidebar Seccion del menu -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                 <li <?php if ($page == MI_RUTA."listpaquete.php" or $page == MI_RUTA."formpaquete.php"){ echo "class='active'";} ?>><a href="listpaquete.php">Paquetes</a>
                </li>
 				<hr class="hrmenu">            
                 <li <?php if ($page == MI_RUTA."listtip.php" or $page == MI_RUTA."formtip.php"){ echo "class='active'";} ?>><a href="listtip.php">Tips</a>
                </li>
                <hr class="hrmenu"> 
                 <li <?php if ($page == MI_RUTA."listpromocion.php" or $page == MI_RUTA."formpromocion.php"){ echo "class='active'";} ?>><a href="listpromocion.php">Promociones</a>
                </li>
                <hr class="hrmenu"> 
                 <li <?php if ($page == MI_RUTA."listslide.php" or $page == MI_RUTA."formslide.php"){ echo "class='active'";} ?>><a href="listslide.php">Slide</a>
                </li>
                <hr class="hrmenu">
                 <li <?php if ($page == MI_RUTA."listboletin.php" or $page == MI_RUTA."formboletin.php"){ echo "class='active'";} ?>><a href="listboletin.php">Clientes</a>
                </li>
                <hr class="hrmenu">
                <li <?php if ($page == MI_RUTA."mailing.php" or $page == MI_RUTA."mailing.php"){ echo "class='active'";} ?>><a href="mailing.php">Newsletter</a>
                </li>
                <hr class="hrmenu">
            </ul>
        </div>