// JavaScript Document
$(document).ready (function () {
	function ajaxget(){
	var conexion;
	if (window.XMLHttpRequest)
		{conexion = new XMLHttpRequest();}
	conexion.onreadystatechange = function(){
		if (conexion.readyState==4 && conexion.status==200){
			document.getElementById("messages").innerHTML=conexion.responseText;
		}
	}
	conexion.open("GET","../paginas/comunicado/comunicado.php", true),
	conexion.send();
}
});