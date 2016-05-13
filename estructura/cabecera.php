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
   
<?php	echo '<div class="menu_des"><ul>';
 		echo '<li><a href="index.php?page=categorias">Inicio</a></li>';
		if($user->usertype == 'Usuario' || $user->usertype == 'Administrador' || $user->usertype == 'Editor'){ ?>
				<li><a href="index.php?page=miespacio">Mi espacio</a>
					<ul>
						<li><a href="index.php?page=perfil">Perfil</a></li>
				<?php	if($empresa->empresa_Id != NULL) { echo '<li><a href="index.php?page=empresa">Empresa</a></li>'; } ?>
						<li><a href="index.php?page=ver_presupuestos_cliente">Presupuestos</a>
                        </li>
						<li><a href="#">Pedidos</a></li>
						<li><a href="index.php?page=pass">Cambiar contraseña</a></li>
					</ul>
				</li> 
<?php	}
 		if($user->usertype == 'Administrador' || $user->usertype == 'Editor'){ echo '<li><a href="admin.php">Administrar</a></li>'; }
	//	echo '<li><a href="index.php?page=chart">Mi Carrito</a></li> | ';
		echo '<li><a href="index.php?page=contacto">Localización y Contacto</a></li>';
		echo '</ul>';
?>		
            
		<div id="loginBox" class="login">
        <?php if ($user->usertype == 'Administrador' || $user->usertype == 'Editor' || $user->usertype == 'Usuario'){ 
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