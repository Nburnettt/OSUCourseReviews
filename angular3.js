var app = angular.module("myApp", []);

$('#holder').on("click","#submitbutton", function(){
	var bigstring = $('#enteredstring').val();
	var specialstring = $('#specialstring').val();
	bigstring = bigstring.replace(/\n/g, "|");
	
	xml = new XMLHttpRequest();
	xml.onreadystatechange = function (){
		if(xml.readyState == 4 && xml.status == 200){
			document.getElementById("messagebox").innerHTML = xml.responseText;
		}
	}
	xml.open("GET", "query.php?type=entercourses&special=" + specialstring+ "&bigstring=" + bigstring);
	xml.send();
});



$('#sign-in-button').click(function(){
	var username = $('#username').val();
	var password = $('#password').val();
	xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function (){
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			if(xmlhttp.responseText == '1'){
				console.log("User is recognized");
				giveAdmin();
			}
			else if (xmlhttp.responseText == '0'){
				console.log("No records matching");
			} 
			else{
				console.log("Not 1 or 0: " + xmlhttp.responseText);
				
			}
		}
	}
	xmlhttp.open("GET", "query.php?type=admin&username=" + username+ "&password=" + password);
	xmlhttp.send();
});

function giveAdmin(){
	$('#sign-in').remove();
	var newDiv = document.createElement("div");
	
	newDiv.style.width = '100%';
	newDiv.style.height = '100%';
	newDiv.style.backgroundColor = 'lightblue';

	var specialtext = document.createElement("textarea");
  	specialtext.setAttribute("id", "specialstring");
  	specialtext.setAttribute("placeholder", "special");
  	specialtext.style.width='80%';
  	specialtext.style.height='10%';

  	var textarea = document.createElement("textarea");
  	textarea.setAttribute("id", "enteredstring");
  	textarea.setAttribute("placeholder", "Courses");
  	textarea.style.width='80%';
  	textarea.style.height='90%';
  	
  	var button = document.createElement("button");
  	button.setAttribute("type", "submit");
  	button.setAttribute("id", "submitbutton");
  	button.innerHTML = "Submit";
  	
  	newDiv.appendChild(specialtext);
  	newDiv.appendChild(textarea);
  	newDiv.appendChild(button);
  	
  	var body = document.getElementById("holder");
	body.appendChild(newDiv);
}