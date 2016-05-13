<div id="cabecera">
	<div id="pro1">
        > Etiquetas textiles impresas<br />
		> Etiquetas tejidas<br />
		> Etiquetas adhesivas en blanco<br />
		> Etiquetas adhesivas impresas<br />
		> Etiquetas de cartulina <br />
		> Impresoras de etiquetas<br />
		> Ribbon para impresoras<br />
		> Hojas l&aacute;ser para impresoras<br />
		> Rollos de tela para impresoras
  	</div>
    <div id="pro2"> 
        > Sellos de caucho autom&aacute;ticos<br />
  		> Sellos de caucho manuales<br />
 		> Sellos fechadores<br />
  		> Navetes de pl&aacute;stico<br />
  		> Aplicadoras de navetes<br />
  		> Folletos, tr&iacute;pticos y flyers<br />
  		> Impresi&oacute;n digital<br />
  		> Precinto impreso<br />
 		> Dise&ntilde;o de p&aacute;ginas web 
    </div>
    
	<div class="menu_des">
			<ul>
            	<li><a href="index.php">Inicio</a></li>
                <li><a href="admin.php">Comunicador</a></li>
                <li><a href="admin.php?page=ver_clientes">Clientes</a>
                	<ul>
                    	<li><a href="admin.php?page=ver_clientes">Ver clientes</a></li>
                    </ul>
                </li>
                <li><a href="#">Articulos</a>
                	<ul>
                    	<li><a href="#">Nuevo artículo</a></li>
                        <li><a href="admin.php?page=ver_articulos">Ver artículos</a></li>
                    </ul>
                </li>
                <li><a href="admin.php?page=ver_presupuestos">Presupuestos</a>
                	<ul>
                    	<li><a href="admin.php?page=nuevo_presupuesto">Nuevo Presupuesto Etiqueta Impresa</a></li>
                        <li><a href="admin.php?page=ver_presupuestos">Ver presupuestos de Etiquetas Impresas</a></li>
                    </ul>
                </li>
                <li><a href="#">Pedidos</a>
                	<ul>
                    	<li><a href="#">Nuevo pedido</a></li>
                        <li><a href="#">Ver pedidos</a></li>
                    </ul>
                </li>
			</ul>  	 
		<div id="loginBox" class="login">
        <?php if ($user->usertype == 'Administrador' || $user->usertype == 'Editor' || $user->usertype == 'Cliente'){ 
			echo '<span class="loginName">'.$user->nombre.' '.$user->apellidos.'</span>';
		?>
        	<a href="../php/scripts/salir.php"><img src="../img/base/iconos/eixir.png" border="0px"/></a>
		<?php } else {?>
                	<form id="login" name="login" method="POST" action="index.php">
				Usuario:<input name="user" type="text" class="login" size="15"/>
				Contraseña:<input name="pass" type="password" class="login" size="15"/>
				<input type="submit" name="entrar" value="entrar" class="login"/>	
       		</form>
        <?php } ?>
			
		</div>
	</div>
</div>