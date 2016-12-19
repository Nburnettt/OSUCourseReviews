var app = angular.module("myApp", []);

var bacc = '%';
var dep = '%';
var less = 11;
var sort = 'DESC';
var page = 1;
var page_array = [1];

$(document).ready(function () {
    updatePages(bacc, dep, less, sort);
    getCourses(bacc, dep, less, sort, page);
});

$('#search-button').click(function(){
    var searchString = $('#search-string').val();    
    search = searchString.split(" ");
    if(search.length == 2){
        if (/^[a-zA-Z]+$/.test(search[0])) {
	        if(/^\d+$/.test(search[1])){
	    	    var department = (search[0]).toUpperCase();
	    	    var coursenumber = search[1];
	    	    console.log("Going to search for: " + department + " " + coursenumber);
	    	
	    	    xmlhttp1 = new XMLHttpRequest();
		        xmlhttp1.onreadystatechange = function (){
			        if(xmlhttp1.readyState == 4 && xmlhttp1.status == 200){
				        document.getElementById("result").innerHTML = xmlhttp1.responseText;
			        }
		        }
		    xmlhttp1.open("GET", "query.php?type=search&dep=" + department + "&num=" + coursenumber);
		    xmlhttp1.send();
	        }
	        else{
	    	    console.log("Second word must be a number");
	        }
	    }
	    else{
	        console.log("First word must be alphabetic string");
	    }
    }
    else{
        console.log("Search should be two words");
    }
});

$('#sortingform input').on('change', function () {
    sort = $('input[name=sorting]:checked', '#sortingform').val();
    updatePages(bacc, dep, less, sort);
    getCourses(bacc, dep, less, sort, page);
});
$('#lessthanform input').on('change', function () {
    less = $('input[name=lessthan]:checked', '#lessthanform').val();
    updatePages(bacc, dep, less, sort);
    getCourses(bacc, dep, less, sort, page);
});
$('#bacccoreform input').on('change', function () {
    bacc = $('input[name=bacccore]:checked', '#bacccoreform').val();
    updatePages(bacc, dep, less, sort);
    getCourses(bacc, dep, less, sort, page);
});
$('#departmentform input').on('change', function () {
    dep = $('input[name=department]:checked', '#departmentform').val();
    updatePages(bacc, dep, less, sort);
    getCourses(bacc, dep, less, sort, page);
});

function updatePages(baccore, department, lessthan, sorting){
    page = 1;
    page_array = [];
	//console.log("getting reviews for CID: " + CID + " by " + sort);
	xmlhttp2 = new XMLHttpRequest();
	xmlhttp2.onreadystatechange = function () {
	    if (xmlhttp2.readyState == 4 && xmlhttp2.status == 200) {
	        num_pages = xmlhttp2.responseText;
	        console.log(num_pages);
	        page_array.push(1);
	        page_array.push(page);
	        page_array.push(num_pages);
	    }
	}
	xmlhttp2.open("GET", "query.php?type=pages&bacc=" + baccore + "&dep=" + department 
                    + "&less=" + lessthan + "&sort=" + sorting);
	xmlhttp2.send();
}

function getCourses(baccore, department, lessthan, sorting, current_page){
	//console.log("getting reviews for CID: " + CID + " by " + sort);
	xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function () {
	    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
	        document.getElementById("result").innerHTML = xmlhttp.responseText;
	        //console.log(xmlhttp.responseText);
	    }
	}
	xmlhttp.open("GET", "query.php?type=courses&bacc=" + baccore + "&dep=" + department 
                    + "&less=" + lessthan + "&sort=" + sorting + "&page=" + current_page);
	xmlhttp.send();
}