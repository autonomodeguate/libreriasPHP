function Ajax(){ 
    var xmlhttp=false;
    try
    {
        xmlhttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch(E)
    {
		try
		{
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(E)
		{
			if (!xmlhttp && typeof XMLHttpRequest!='undefined') xmlhttp=new XMLHttpRequest();
		}
    }
    return xmlhttp; 
}

function combo_dependiente(){

	var elementoSeleccionado = document.getElementById("combo").options[document.getElementById("combo").selectedIndex].value;
	var nuevoCombo = document.getElementById('combo2');
	var ajax = Ajax();
	ajax.open('GET','query.php?id='+elementoSeleccionado,true);
	
	ajax.onreadystatechange = function(){
		if(ajax.readyState == 4){
			nuevoCombo.innerHTML = ajax.responseText;
		}
	}
	
	ajax.send(null);
	
}
