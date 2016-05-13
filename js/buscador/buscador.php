$res='';
	if(!empty($_GET['b'])) {$m=$_GET['b'];}?>  
		<form action="admin.php" method="post"><input name="b" "type="text" id="busqueda" value=""/><input type="submit" value="&gt;"></form>
        
        <?php  /* 
	echo '<div id="resultado">'.$res.'</div>'; echo '<div id="valor">'.$res.'</div>';
	if(!empty($_GET['b'])) {
             if(count($list) == 0){
                  echo "No se han encontrado resultados para '<b>".$b."</b>'.";
            }else{
                  foreach($comunicados->getComunicados($user->user_Id) as $v){
                        if ($_GET['b'] == $v['texto']){echo '<div id="resultado">'.$v['texto'].'</div>';}
                  }
            }   
      } */
		