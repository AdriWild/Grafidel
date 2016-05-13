// JavaScript Document
$(document).ready(function(){
                                
        var consulta;
                                                                          
         //hacemos focus al campo de búsqueda
		
                                                                                                    
        //comprobamos si se pulsa una tecla
		consulta = $("#busqueda").val();
       	$("#busqueda").focus();
	    $("#busqueda").keyup(function(e){
                                     
              //obtenemos el texto introducido en el campo de búsqueda

			  function redirect(){
			  location.href="admin.php?b="+consulta;
			  }
			  $("#resultado").html("<div align='center'><img src='../img/iconos/ajax-loader.gif' /></div>");
			   
			  redirect();
              /*hace la búsqueda
                                                                                  
              $.ajax({
                    url: "../../ES/admin.php?b="+consulta,
                    beforeSend: function(){
                          
                    },
                    error: function(){
                          $("#resultado").html("<div align='center'>NOP</div>");
                    },
                    onSuccess: function(data){                                                    
                         $("#resultado").empty();
                         $("#busqueda").append(data);   
                    }
			                                                                    
              }); */                                                            
        });
                                                                  
});