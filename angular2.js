var app = angular.module("myApp", []);

$(document).ready(function () {
    var CID = $('#body').attr('value');
    var sort = 'DESC';
    console.log("Value is " + CID);
    getInfo(CID);
    getReviews(CID, sort);
});

$('#sortingform input').on('change', function () {
    var CID = $('#body').attr('value');
    sorting = $('input[name=sorting]:checked', '#sortingform').val();
    getReviews(CID, sorting);
});

function getInfo(CID){
	console.log("getting info for: " + CID);
	xmlhttp1 = new XMLHttpRequest();
	xmlhttp1.onreadystatechange = function (){
		if(xmlhttp1.readyState == 4 && xmlhttp1.status == 200){
			document.getElementById("information").innerHTML = xmlhttp1.responseText;
		}
	}
	xmlhttp1.open("GET", "query.php?type=info&CID=" + CID);
	xmlhttp1.send();
}

function getReviews(CID, sort){
	console.log("getting reviews for CID: " + CID + " by " + sort);
	xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function (){
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById("result").innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET", "query.php?type=reviews&CID=" + CID + "&sort=" + sort);
	xmlhttp.send();
}

$('#writing-container-button').click(function(){
	var rating = $('#writing-container-rating').val();
	var comment = $('#writing-container-comment').val();,
	//console.log("rating is " + rating + " comment is "+ comment);
	$('#writing-container').remove();
	var newDiv = document.createElement("div");
	newDiv.style.width = '100%';
	newDiv.style.textAlign = 'center';
	newDiv.style.color = 'blue';
  	var newContent = document.createTextNode("Thanks for the Review!"); 
  	newDiv.appendChild(newContent);
  	var container = document.getElementById("writing");
  	container.appendChild(newDiv);
  	
  	var CID = $('#body').attr('value');
	createReview(CID, rating, comment);
	
	sorting = $('input[name=sorting]:checked', '#sortingform').val();
    	getReviews(CID, sorting);
});

function createReview(CID, rating, comment){
	console.log("Creating review for CID: " + CID + " rating: " + rating + " and comment: " + comment);
	xmlhttp2 = new XMLHttpRequest();
	xmlhttp2.onreadystatechange = function (){
		if(xmlhttp2.readyState == 4 && xmlhttp2.status == 200){
			//document.getElementById("result").innerHTML = xmlhttp2.responseText;
			console.log("Response is: " + xmlhttp2.responseText);
		}
	}
	xmlhttp2.open("GET", "query.php?type=writing&CID=" + CID + "&rating=" + rating + "&comment=" + comment);
	xmlhttp2.send();
}