<?php
    $mysqli = new mysqli('localhost', 'nburnetttmysql', 'password', 'osucoursereviews');
?>

<!doctype html>
<html>
<!-------------------------head---------------------------->
    <head>
        <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
<!-------------------------/head---------------------------->
<!-------------------------body---------------------------->
    <body ng-app="myApp">
        
            <div ng-include="'header.php'"></div>
            
            <div id="sign-in">
            	Username:
            	<input type="textarea" id="username"></input> <br>
            	Password:
            	<input type="password" id="password"></input>
            	<button id="sign-in-button" type="submit">log in</button>
	    </div>
	    <div id="holder"></div>
	    <div id="messagebox"></div>
        <script src="angular3.js"></script>
    </body>
<!-------------------------/body---------------------------->
</html>