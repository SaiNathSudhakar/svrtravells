// JavaScript Document

var xmlHttp
var xmlHttp1

function showdiv(){ 
xmlHttp=GetXmlHttpObject()
if (xmlHttp==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 } 
var url="header.html"
url=url+"?sid="+Math.random()
xmlHttp.onreadystatechange=stateChanged 
xmlHttp.open("GET",url,true)
xmlHttp.send(null)
}

function stateChanged() { 
 if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
 { 
 document.getElementById("header").innerHTML=xmlHttp.responseText
 }  
}



function showdiv1(){ 
xmlHttp1=GetXmlHttpObject()
if (xmlHttp1==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 } 
var url="footer.html"
url=url+"?sid="+Math.random()
xmlHttp1.onreadystatechange=stateChanged1
xmlHttp1.open("GET",url,true)
xmlHttp1.send(null)
}

function stateChanged1() { 
 if (xmlHttp1.readyState==4 || xmlHttp1.readyState=="complete")
 { 
 document.getElementById("footer").innerHTML=xmlHttp1.responseText
 }  
}


function showdiv1(){ 
xmlHttp2=GetXmlHttpObject()
if (xmlHttp2==null)
 {
 alert ("Browser does not support HTTP Request")
 return
 } 
var url="rightbar.html"
url=url+"?sid="+Math.random()
xmlHttp2.onreadystatechange=stateChanged2
xmlHttp2.open("GET",url,true)
xmlHttp2.send(null)
}

function stateChanged2() { 
 if (xmlHttp2.readyState==4 || xmlHttp2.readyState=="complete")
 { 
 document.getElementById("rightbar").innerHTML=xmlHttp2.responseText
 }  
}



function GetXmlHttpObject()
{
	var xmlHttp=null;
	var xmlHttp1=null;
	
	try { 
 xmlHttp=new XMLHttpRequest(); 
 xmlHttp1=new XMLHttpRequest();
 
 } catch (e) { 
 	try  {  
	xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
	xmlHttp1=new ActiveXObject("Msxml2.XMLHTTP");
	 } catch (e)  { 
	  xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
	  xmlHttp1=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	 }
	return xmlHttp;
	return xmlHttp1;
}


showdiv();
showdiv1();
