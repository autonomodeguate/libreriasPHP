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

function combo_dependiente_uno(){

	var elementoSeleccionado = document.getElementById("combo_uno").options[document.getElementById("combo_uno").selectedIndex].value;
	var nuevoCombo = document.getElementById('combo_uno_uno');
	var ajax = Ajax();
	ajax.open('GET','query.php?id='+elementoSeleccionado,true);
	
	ajax.onreadystatechange = function(){
		if(ajax.readyState == 4){
			nuevoCombo.innerHTML = ajax.responseText;
		}
	}
	
	ajax.send(null);	
}

function combo_dependiente_dos(){

	var elementoSeleccionado = document.getElementById("combo_dos").options[document.getElementById("combo_dos").selectedIndex].value;
	var nuevoCombo = document.getElementById('combo_dos_dos');
	var ajax = Ajax();
	ajax.open('GET','query2.php?id='+elementoSeleccionado,true);
	
	ajax.onreadystatechange = function(){
		if(ajax.readyState == 4){
			nuevoCombo.innerHTML = ajax.responseText;
		}
	}
	
	ajax.send(null);	
}

function combo_dependiente_tres(){

	var elementoSeleccionado = document.getElementById("combo_tres").options[document.getElementById("combo_tres").selectedIndex].value;
	var nuevoCombo = document.getElementById('combo_tres_tres');
	var ajax = Ajax();
	ajax.open('GET','query3.php?id='+elementoSeleccionado,true);
	
	ajax.onreadystatechange = function(){
		if(ajax.readyState == 4){
			nuevoCombo.innerHTML = ajax.responseText;
		}
	}
	
	ajax.send(null);	
}

function combo_dependiente_cuatro(){

	var elementoSeleccionado = document.getElementById("combo_cuatro").options[document.getElementById("combo_cuatro").selectedIndex].value;
	var nuevoCombo = document.getElementById('combo_cuatro_cuatro');
	var ajax = Ajax();
	ajax.open('GET','query4.php?id='+elementoSeleccionado,true);
	
	ajax.onreadystatechange = function(){
		if(ajax.readyState == 4){
			nuevoCombo.innerHTML = ajax.responseText;
		}
	}
	
	ajax.send(null);	
}
