<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Movies</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
      .sidebar-nav {
        padding: 9px 0;
      }

      @media (max-width: 980px) {
        /* Enable use of floated navbar text */
        .navbar-text.pull-right {
          float: none;
          padding-left: 5px;
          padding-right: 5px;
        }
      }
    </style>
    <link href="css/bootstrap-responsive.css" rel="stylesheet">

    <!-- Fav and touch icons -->
  </head>

  <body>
  <?php 
  $servername = "localhost";
			$username = "root";
			$password = "mysql";
			$database = "project";
			$conn = new mysqli($servername, $username, $password, $database);
  
  $uName = $_GET["uName"]; 
  ?>
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="brand" href="#">MBME</a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
              Logged in as <a href="#" class="navba Logged in as <a href="login.php" class="navbar-link"><?php if($uName!==null) echo $uName; else echo 'Username';?></a>
            &nbsp;&nbsp;<a href="login.php">Log out</a>
            </p>
            <img src="img/search.png">
            <form action="search.php" method="POST" style="display: inline;">
            <input id="search" type="text" name="search">
            <button id="search_btn" type="submit">Search</button>
          </form>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

<!-- 2. content -->
    <div class="container-fluid">
      <div class="row-fluid">
        <!-- 2.1 left pane -->
        <div class="span2 menu">
          <div class="well sidebar-nav">
            <ul class="nav nav-list">
              <li class="nav-header">MENU</li>
              <li><a href="index.php?uName=<?php echo $uName ?>">Home Page</a></li>
              <li><a href="movies-inTheater.php">Movies</a></li>
              <li><a href="#">Theatres</a></li>
              <li><a href="list.php">Top Rated Movies</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->

        <!-- 2.2 center pane -->
        <div class="span7" >
		<?php 
		  //$stmt = $conn->prepare("select title from movies limit 5");
			//$stmt->bind_param("ss", $uName, $pass);
			//$result = $stmt->execute();
      $mid = $_GET["movieId"]==""?$_POST['movieId']:$_GET["movieId"];
			$sql = "SELECT distinct movies.id,title,plot,runtime,fName,lName FROM movies join showtime on movies.id = showtime.movie  join directorToMovie on movies.id = directorToMovie.movieId join director on director.id = directorToMovie.directorId and movies.id = ".$mid;
      $sql2 = "SELECT distinct movies.id,title,plot,runtime,studio,rating FROM movies where movies.id = ".$mid; 
			$result = $conn->query($sql);
      $result2 = $conn->query($sql2);
			if($result){
				echo "<div class='center-info'>";
				while($row = $result->fetch_assoc()){
					
					echo "<h2>". $row["title"] ."</h2>";
					echo "<h4> Runtime: ". $row["runtime"] ."</h4>";
					echo "<div class='row-fluid border blo'>";
					echo "<div class='span4'>";
					echo "<img id='poster' src='img/default.jpg'>";
					echo "</div>";
					echo "<div class='span8'>";
					echo "<p>Discription: " . $row["plot"] ."</p>";
					echo "<p>Director: ". $row["fName"] . " " . $row["lName"] ."</p>";
					echo "</div>";
					echo "</div>";
					$sql2 = "select fName, lName from actor join actorToMovie on actor.id = actorToMovie.actorId where actorToMovie.movieId ="  . $row["id"];
					$result2 = $conn->query($sql2);
					if($result2){
					echo "<div class='row-fluid border text-list'>";
					echo "<p><h4>Cast</h4></p>";
					while($row2 = $result2->fetch_assoc()){
						echo "<p>" . $row2["fName"] . " " . $row2["lName"].  "</p>";
					}
					echo "</div>";
					}
					$sql3 = "SELECT distinct review.rating,reviewText,uName FROM review join user on review.uId = user.id join reviewToMovie on reviewToMovie.reviewId = review.id join movies on movies.id = reviewToMovie.movieId where movieId = "  . $row["id"];
					$result3 = $conn->query($sql3);
					if($result3){
					echo "<div class='row-fluid border text-list'>";
					echo "<p><h4>User Reviews</h4></p>";
					while($row3 = $result3->fetch_assoc()){
						echo "<p>Rating: " . $row3["rating"] . "</p>";
						echo "<p>Username: "  . $row3["uName"] .  " </p>";
						echo "<p>Review Text: "  . $row3["reviewText"] .  " </p>";
						echo "<hr>";
					}
					echo "<p style='float: right;'><a class='btn' href='review.php?uName=" .$uName ."&movieId=" . $row["id"] . " ' >Write a review &raquo;</a></p>";
					
				}
				echo "</div>";
			}
			}
		  
		  if($result2){
        echo "<div class='center-info'>";
        while($row = $result2->fetch_assoc()){
          
          echo "<h2>". $row["title"] ."</h2>";
          echo "<h4> Runtime: ". $row["runtime"] ."</h4>";
          echo "<div class='row-fluid border blo'>";
          echo "<div class='span4'>";
          echo "<img id='poster' src='img/default.jpg'>";
          echo "</div>";
          echo "<div class='span8'>";
          echo "<p>Discription: " . $row["plot"] ."</p>";
          echo "</div>";
          echo "</div>";
          $sql2 = "select fName, lName from actor join actorToMovie on actor.id = actorToMovie.actorId where actorToMovie.movieId ="  . $row["id"];
          $result2 = $conn->query($sql2);
          if($result2){
          echo "<div class='row-fluid border text-list'>";
          echo "<p><h4>Cast</h4></p>";
          while($row2 = $result2->fetch_assoc()){
            echo "<p>" . $row2["fName"] . " " . $row2["lName"].  "</p>";
          }
          echo "</div>";
          }
          $sql3 = "SELECT distinct review.rating,reviewText,uName FROM review join user on review.uId = user.id join reviewToMovie on reviewToMovie.reviewId = review.id join movies on movies.id = reviewToMovie.movieId where movieId = "  . $row["id"];
          $result3 = $conn->query($sql3);
          if($result3){
          echo "<div class='row-fluid border text-list'>";
          echo "<p><h4>User Reviews</h4></p>";
          while($row3 = $result3->fetch_assoc()){
            echo "<p>Rating: " . $row3["rating"] . "</p>";
            echo "<p>Username: "  . $row3["uName"] .  " </p>";
            echo "<p>Review Text: "  . $row3["reviewText"] .  " </p>";
            echo "<hr>";
          }
          echo "<p style='float: right;'><a class='btn' href='review.php?uName=" .$uName ."&movieId=" . $row["id"] . " ' >Write a review &raquo;</a></p>";
          
        }
        echo "</div>";
      }
      }
		  ?>

        </div>

        <!-- 2.3 right pane 
		
        <div class="span3">
          <div class="card">
            <div class="card-header">
              <h4 class="font-weight-normal">Related to this movie</h4>
            </div>
            <div class="card-body">
              <ul class="">
                <li><a href="#">movie name</a></li>
                <li><a href="#">movie name</a></li>
                <li><a href="#">movie name</a></li>
                <li><a href="#">movie name</a></li>
                <li><a href="#">movie name</a></li>
              </ul>
            </div>
          </div>

        </div>
		-->
      </div><!--/row-->

     

    </div><!--/.fluid-container-->
    <div class="span12">
 <hr>

      <footer>
        <p>&copy; Company 2013</p>
      </footer>
      </div>
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap-transition.js"></script>
    <script src="../assets/js/bootstrap-alert.js"></script>
    <script src="../assets/js/bootstrap-modal.js"></script>
    <script src="../assets/js/bootstrap-dropdown.js"></script>
    <script src="../assets/js/bootstrap-scrollspy.js"></script>
    <script src="../assets/js/bootstrap-tab.js"></script>
    <script src="../assets/js/bootstrap-tooltip.js"></script>
    <script src="../assets/js/bootstrap-popover.js"></script>
    <script src="../assets/js/bootstrap-button.js"></script>
    <script src="../assets/js/bootstrap-collapse.js"></script>
    <script src="../assets/js/bootstrap-carousel.js"></script>
    <script src="../assets/js/bootstrap-typeahead.js"></script>

  </body>
</html>
