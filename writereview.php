<?php
    $mysqli = new mysqli('localhost', 'nburnetttmysql', 'password', 'osucoursereviews');
    $myvar = $_POST['CID'];
?>

<!doctype html>
<html>
<!-------------------------head---------------------------->
    <head>
        <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="SHORTCUT ICON" href="http://i61.tinypic.com/208fw91.jpg">
  	<title>Reviews</title>
    </head>
<!-------------------------/head---------------------------->
<!-------------------------body---------------------------->
    <body id="body" ng-app="myApp" value=<?php echo $myvar ?>>
        
            <div ng-include="'header.php'"></div>
            <div id="content">
                <div id="filters2">
                    <div id="label">Sorting:</div>
                    <div id="filters-sorting">
                    	<form id="sortingform">
                    	    <input type="radio" name="sorting" value='DESC' checked="checked">High to Low<br>
                    	    <input type="radio" name="sorting" value='ASC'>Low to High<br>
                    	</form>
                    </div>
                </div>
                <div id="results2">
                	<div id="information">
                	</div>
                	<div id="result">
                	</div>
                </div>
                <div id="writing">
                	<div id="writing-label">Rate this Class:</div>
                	<div id="writing-scale">
                		<img src="http://i58.tinypic.com/20r1n6b.jpg" width=100%>
                	</div>
                	<div id="writing-container">
                		<select id="writing-container-rating">
                			<?php
                				for($i = 1; $i < 11; $i++){
                					echo "<option value='$i'>$i</option>";
                				}
                			?>
                		</select>
                		<textarea id="writing-container-comment"> </textarea>
                		<button id="writing-container-button">Submit</button>
                	</div>
                </div>
            </div>

        <script src="angular2.js"></script>
    </body>
<!-------------------------/body---------------------------->
</html>