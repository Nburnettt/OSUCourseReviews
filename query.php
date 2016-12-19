<?php
	$mysqli = new mysqli('oniddb.cws.oregonstate.edu', 'burnettn-db', 'censor', 'burnettn-db');

    // Check connection
    if (mysqli_connect_errno())
      {
      echo "Failed to connect to MySQL: " . mysqli_connect_error();
      }

	$type = $_GET['type'];

//**************************************************************************************
//Query: courses
//Purpose: Selects all courses that match the given criteria
//Pages Used: Index.php
//**************************************************************************************
	if($type == 'courses'){		//Query for chosen classes to show on reviews page
        $group = $_GET['bacc'];
	    $dep = $_GET['dep'];
	    $less = $_GET['less'];
	    $sort = $_GET['sort'];
        $page = (int)$_GET['page'] - 1;

        $result = $mysqli->query("SELECT C.department as department, C.number as number, C.description as description, ROUND(AVG(R.Rating), 1) as rating
                                    FROM Courses C, Reviews R, Groups G, Course_Group CG
                                    WHERE C.department LIKE '$dep'
                                    AND   C.department = R.department
                                    AND   C.number     = R.number
                                    AND   C.department = CG.department
                                    AND   C.number     = CG.number
                                    AND   CG.gid       = G.gid
                                    AND   G.name       LIKE '$group'

                                    GROUP BY C.department, C.number
                                    HAVING AVG(R.Rating) < '$less'
                                    ORDER BY AVG(R.Rating) $sort

                                    LIMIT 10 offset $page
                                ");

		    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
            {
           // $rating = $row[rating];
            //$rating = $rating * 10;
           // $rating_image = "./ratings/".$rating.".jpg";
                	    echo "<div id='course'>
                            <div id='courserating'>
                                $row[rating]
                            </div>
                            <div id='courseidentifier'>
                		        <div id='coursedepartment'>
                                    $row[department] 
                                </div>
                		        <div id='coursenumber'>
                                    $row[number] 
                                </div>
                            </div>
                		    <div id='coursedescription'>
                                $row[description]
                            </div>
                	        <div id='coursereview'>
                			    <form action='writereview.php' method='post'>
              			        <button type='submit' id='course-button'>reviews</button>
                			    </form>
                		    </div>

                	    </div>";
            }
	}

//**************************************************************************************
//Query: pages
//Purpose: Returns number of pages the current query will return
//Pages Used: Index.php
//**************************************************************************************
	if($type == 'pages'){		//Query for chosen classes to show on reviews page
        $group = $_GET['bacc'];
	    $dep = $_GET['dep'];
	    $less = $_GET['less'];
	    $sort = $_GET['sort'];

        $result = $mysqli->query("SELECT COUNT(*) as count FROM
                                    (SELECT C.department as department, C.number as number, C.description as description, ROUND(AVG(R.Rating), 1) as rating
                                    FROM Courses C, Reviews R, Groups G, Course_Group CG
                                    WHERE C.department LIKE '$dep'
                                    AND   C.department = R.department
                                    AND   C.number     = R.number
                                    AND   C.department = CG.department
                                    AND   C.number     = CG.number
                                    AND   CG.gid       = G.gid
                                    AND   G.name       LIKE '$group'

                                    GROUP BY C.department, C.number
                                    HAVING AVG(R.Rating) < '$less'
                                    ORDER BY AVG(R.Rating) $sort) AS TB
                                ");

        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
            $num_rows = (int)$row[count];
            echo ((($num_rows - 1) - (($num_rows - 1) % 10)) / 10) + 1;
       }
	}

//**************************************************************************************
//Query: search
//Purpose: Selects the exact course based off dep and num
//Pages Used: Index.php
//**************************************************************************************
	else if ($type == 'search'){
		$department = $_GET['dep'];
		$number = $_GET['num'];
		$result = $mysqli->query("SELECT C.department as department, C.number as number, C.description as description, ROUND(AVG(R.Rating), 1) as rating
                                FROM Courses C, Reviews R
                                WHERE C.department LIKE '$department'
                                AND   C.department = R.department
                                AND   C.number     LIKE '$number'
                                AND   C.number     = R.number

                                GROUP BY C.department, C.number
                            ");
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
			echo "<div id='course'>
                        <div id='courserating'>$row[rating] </div>
                        <div id='courseidentifier'>
                		    <div id='coursedepartment'>$row[department] </div>
                		    <div id='coursenumber'>$row[number] </div>
                        </div>
                		<div id='coursedescription'>$row[description]</div>
                	    <div id='coursereview'>
                			<form action='writereview.php' method='post'>
              			    <button type='submit' id='course-button'>reviews</button>
                			</form>
                		</div>

                	</div>";
		}
	
	}
//**************************************************************************************
//Query: reviews
//Purpose: Selects all reviews for a given course
//Pages Used: Writeareview.php
//**************************************************************************************
    else if($type == 'reviews')
    {
		$cid = $_GET['CID'];
		$sorting = $_GET['sort'];
		$result = $mysqli->query("SELECT * FROM reviews WHERE cid LIKE '$cid' ORDER BY rating $sorting");
		
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
			echo "<div id='course'>
				<div id='courserating'> $row[rating] </div>
				<div id='coursedescription'> $row[comment] </div>
			      </div>";
		}
	}
//**************************************************************************************
//Query: info
//Purpose: Selects information about a given course
//Pages Used: Writeareview.php
//**************************************************************************************
    else if ($type == 'info')
    {
		$cid = $_GET['CID'];
		$result = $mysqli->query("SELECT * FROM courses WHERE cid LIKE '$cid'");
		while($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
        {
			echo "<div id='information-name'>
				<div id='information-name-department'>
					$row[department]
				</div>
				<div id='information-name-number'>
					$row[number]
				</div>
			      </div>
			      <div id='information-description'>
			      		$row[description]
			      </div>";
		}
	}
//**************************************************************************************
//Query: admin
//Purpose: Determines if a user has administrator priv. 
//Pages Used: admin.php
//**************************************************************************************
	else if ($type == 'admin'){
		$username = $_GET['username'];
		$password = md5($_GET['password']);
		
		$result = $mysqli->query("SELECT * FROM admins WHERE username ='$username' AND password = '$password'");
		if(mysqli_num_rows($result) == 0){
			echo "0";
		}
		else{
			echo "1";
		}
	}
//**************************************************************************************
//Query: entercourses
//Purpose: Allows an admin to enter new course (including str concat methods specific to OSU webpage)
//Pages Used: admin.php
//**************************************************************************************
	else if ($type == 'entercourses'){
		$special = $_GET['special'];
		$bigstring = $_GET['bigstring'];
		$coursearray = explode("|",$bigstring);
		$number = count($coursearray);
		$reviews = 1;
		$reviewsum = 5;
		$average = 5;
		//echo "<p> There are $number rows in $bigstring</p>";
		for($i = 0; $i < count($coursearray) ; $i++){
			$currentcourse = explode(" ", $coursearray[$i]);
			$department = $currentcourse[0];
			$number = $currentcourse[1];
			$description = $currentcourse[2];
			for($x = 3; $x < count($currentcourse); $x++){
				$description .= " "; 
				$description .= $currentcourse[$x];
			}
			//echo "<p> Dep: |$department| Num: |$number| Desc: |$description| </p>";
			
			$result = $mysqli->query("SELECT * FROM courses WHERE department LIKE '$department' AND number LIKE '$number'");
			if(mysqli_num_rows($result) == 0){
			
				$write = "INSERT INTO courses (department, number, description, reviews, reviewsum, average, special1) 
			  		  VALUES (?, ?, ?, ?, ?, ?, ?)";
				$query = $mysqli->prepare($write);
				$query->bind_param('sisiiis', $department, $number, $description, $reviews, $reviewsum, $average, $special);
				$query->execute();
			
				//echo $department . " " . $number . "Was succesfully added";
			}
			else{
				echo "<p>". $department . " " . $number . " Already Exists ***********************</p>";
			}
		}	
		
	}
?>