<?php
    $mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'burnettn-db', 'censor', 'burnettn-db');

    // Check connection
    if (mysqli_connect_errno())
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

?>

<!doctype html>
<html>
<!-------------------------head---------------------------->
    <head>
        <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" type="text/css" href="style.css">
        <link rel="SHORTCUT ICON" href="http://i61.tinypic.com/208fw91.jpg">
  	<title>Courses</title>
    </head>
<!-------------------------/head---------------------------->
<!-------------------------body---------------------------->
    <body ng-app="myApp">
        
            <div ng-include="'header.php'"></div>
            <div id="content">
                <div id="filters">
                    <div id="space">Filter Results</div>
                    <div id="filters-pages">Page:</div>
                    <div id="pages-list">
                        <div class="pages-list-item" id="pages-list-0"></div>
                        <div class="pages-list-item" id="pages-list-1"></div>
                        <div class="pages-list-item" id="pages-list-2"></div>
                        <div class="pages-list-item" id="pages-list-3"></div>
                        <div class="pages-list-item" id="pages-list-4"></div>
                    </div>
                    <div id="label">Quick Jump:</div>
                    	    <input type="textarea" placeholder="HST 101 ([Dep] [Num])" id="search-string" name="search"></input>
                    	    <button id="search-button">Search</button>
                    	    <br><br>
                    <div id="label">Sorting:</div>
                    <div id="filters-sorting">
                    	<form id="sortingform">
                    	    <input type="radio" name="sorting" value='DESC' checked="checked">High to Low<br>
                    	    <input type="radio" name="sorting" value='ASC'>Low to High<br>
                    	</form><br>
                    </div>
                    <div id="label">Class Difficulty Rating:</div>
                    <div id="filters-rating">
                        <form id="lessthanform">
                            <input type="radio" name="lessthan" value=11 checked="checked">Show All<br>
                            <input type="radio" name="lessthan" value=8>Less than 8<br>
                            <input type="radio" name="lessthan" value=6>Less than 6<br>
                            <input type="radio" name="lessthan" value=4>Less than 4<br>
                            <input type="radio" name="lessthan" value=2>Less than 2
                        </form>
                    </div>
                    <div id="label">Bacc Core:</div>
                    <div id="filters-bacc">
                        <form id="bacccoreform">
                            <input type="radio" name="bacccore" value='%' checked="checked">Show All<br>
                            <?php
                                $result = $mysqli->query("SELECT * FROM Groups ORDER BY name");
                                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                	$string = str_replace("_", " ",  $row[name]);
                                	echo "<input type='radio' name='bacccore' value= $row[name]>$string<br>";
                               	}              
                            ?>
                        </form>
                    </div>
                    <div id="label">Department:</div>
                    <div id="filters-department">
                    	<form id="departmentform">
                            <input type="radio" name="department" value='%' checked="checked">Show All<br>
                            <?php
                                $result = $mysqli->query("SELECT * FROM Departments");
                                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                	$string = str_replace("_", " ",  $row[name]);
                                	echo "<input type='radio' name='department' value= $row[name]>$row[name]<br>";
                               	}              
                            ?>
                        </form>
                    </div>
                </div>
                <div id="results">
                	<div id="result">
                	
                	</div>
                </div>
                <div id="google">

                </div>
            </div>

        <script src="angular.js"></script>
    </body>
<!-------------------------/body---------------------------->
</html>