<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Tickets</title>
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
  		// Create connection
			$servername = "localhost";
			$username = "root";
			$password = "mysql";
			$database = "project";
			$conn = new mysqli($servername, $username, $password, $database);
			$uName = $_GET["uName"];
			$movId = $_GET["movId"];
			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 
			$sql = "SELECT title,plot,runtime,fName,lName FROM movies join showtime on movies.id = showtime.movie  join directorToMovie on movies.id = directorToMovie.movieId join director on director.id = directorToMovie.directorId where movies.id=". $movId;
			$result = $conn->query($sql);
			if ($result)
			{
				while($row = $result->fetch_assoc())
				{
					  $title = $row["title"];
					  $plot = $row["plot"];
					  $runtime = $row["runtime"];
					  $fName = $row["fName"];
					  $lName = $row["lName"];
				}
				
			}
  ?>
<!--1. header -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="brand" href="#">MBME</a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
               Logged in as <a href="login.php" class="navbar-link"><?php if($uName!==null) echo $uName; else echo 'Username';?></a>
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
          <div class="center-ticket">

          <!-- movie section-->
                    <div class="row-fluid border blo">
            <div class="span4">
              <img id="poster" src="img/default.jpg">
            </div><!--/span-->
            <div class="span8">
			<p>Title: <?php echo $title ?></p>
              <p>Discription: <?php echo $plot ?></p>
              <p>Directors: <?php echo $fName . " " . $lName ?></p>

             
            </div><!--/span-->
           
          </div><!--/row-->
		  <?php 
		  	$sql = "SELECT * FROM showtime where movie = ". $movId." and showtime > now()";
			$result = $conn->query($sql);
			if ($result)
			{
				
				while($row = $result->fetch_assoc())
				{
					echo "<div class='theater-blo title-blue'>";
					echo "<h5>".$row['theaterId'] ."</h5>";
					$newSeats = $row['availableSeats']-1;
					if($newSeats < 0){
						$newSeats = 0;
					}
					echo "<p><a href='decSeats.php?uName=".$uName."&movId=".$movId."&theatId=".$row['theaterId']."&time=".$row['showtime']."&seats=" .$newSeats. "'>" .$row['showtime'] ."</a>&nbsp;</p>";
				echo "</div><!--/row-->";
				}
			}
		  ?>

 <!--/row-->



        <!-- 2.3 right pane -->

      </div><!--/row-->

      <hr>

      <footer>
        <p>&copy; Company 2013</p>
      </footer>

    </div><!--/.fluid-container-->

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
