<?php
require_once dirname(__FILE__).'/../../php/objects/Categoria.php';
$categoria = new Categoria();
$categorias = $categoria->getCategorias();
if (isset($_GET['cat'])){	
	$categoria->getCategoria($_GET['cat']); ?>
		<div class="cabeceraArt"><div><h1><?php echo $categoria->nomCategoria; ?></h1></div>
		   <div style="width:350px; float:left;"><img src="../img/categorias/cabecera/<?php echo $categoria->imgdesc; ?>"height="117"></div>
		   <div style="width:350px; margin-left:350px; overflow:visible;">
		   <p style="position:absolute; margin-top: 10px; width:350px;"><?php echo $categoria->descripcion; ?></p>
		   </div>
         </div>  
           <?php fotosArticulos($categoria->categoria_Id);?>
				
<?php } else {
	foreach( $categorias as $v){
			echo('<div id="categoria">');		
			echo('<div id="caixodalt"></div>');			
			echo('<div id="caixoesquerra"></div>');        	
			echo('<div id="caixomig">');
				echo('<div id="cont_categoria">');
					echo('<div id="titulo_categoria">');echo $v['nomCategoria'];echo('</div>');
					echo('<div id="desc_categoria">');echo $v['descripcion'];echo('</div>');
				echo('</div>');
				echo('<div id="foto_categoria">');echo ('<a href="index.php?page=inicio&cat=').$v['categoria_Id'].('"><img  src="../img/categorias/'.$v['imagen'].'" width="120" height="96" border="0"/></a>');echo('</div>');				
			echo('</div>');
			echo('<div id="caixodreta"></div>');       	
			echo('<div id="caixobaix"></div>');       		
			echo('</div>');
		} 
}
	
function fotosArticulos($categoria){
	switch ($categoria){
	case 1: include (dirname(__FILE__).'/fotos/impresas.php'); break;
	case 2: include (dirname(__FILE__).'/fotos/tejidas.php');break;
	case 3: include (dirname(__FILE__).'/fotos/adhesivas.php');break;
	case 4: include (dirname(__FILE__).'/fotos/adhesivas_blanco.php');break;
	case 5: include (dirname(__FILE__).'/fotos/laser.php');break;
	case 6: include (dirname(__FILE__).'/fotos/manuales.php');break;
	case 7: include (dirname(__FILE__).'/fotos/automaticos.php');break;
	case 8: include (dirname(__FILE__).'/fotos/ribbon.php');break;
	case 9: include (dirname(__FILE__).'/fotos/impresoras.php');break;
	case 10: include (dirname(__FILE__).'/fotos/poliamida.php');break;
	case 11: include (dirname(__FILE__).'/fotos/digital.php');break;
	case 12: include (dirname(__FILE__).'/fotos/rotulacion.php');break;
	case 13: include (dirname(__FILE__).'/fotos/complementos.php');break;
	case 14: include (dirname(__FILE__).'/fotos/web.php');break;
	}
}
?>