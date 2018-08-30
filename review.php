<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Review</title>
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
  $movId = $_GET["movieId"];
  $title;
  $plot;
  $runtime;
  $fName;
  $lName;
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
              Logged in as <a href="#" class="navbar-link"><?php echo $uName ?></a>
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
              <li><a href="#">Home Page</a></li>
              <li><a href="movies.php?uName=<?php echo $uName ?>">Movies</a></li>
              <li><a href="#">Theatres</a></li>
              <li><a href="#">Top Rated Movies</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->

        <!-- 2.2 center pane -->
        <div class="span7" >
          <div class="center-info">
          <!-- movie section-->
          <h2><?php echo $title ?></h2>
          <h4><?php echo $runtime ?></h4>
          <div class="row-fluid border blo">
            <div class="span4">
              <img id="poster" src="img/default.jpg">
            </div><!--/span-->
            <div class="span8">
              <p>Discription: <?php echo $plot ?></p>
              <p>Directors: <?php echo $fName . " " . $lName ?></p>

             
            </div><!--/span-->
           
          </div><!--/row-->

          <div class="row-fluid  text-list">
          <form name="reviePost" method="post" action='reviePost.php?movId=<?php echo movId ."&uName=" . $uName ?>'>  
            <p><h4>Your Rating</h4></p>
            <select name="stars">
              <option value="1">1 star</option>
              <option value="2">2 stars</option>
              <option value="3">3 stars</option>
              <option value="4">4 stars</option>
			  <option value="4">5 stars</option>
			  <option value="4">6 stars</option>
			  <option value="4">7 stars</option>
			  <option value="4">8 stars</option>
			  <option value="4">9 stars</option>
			  <option value="4">10 stars</option>
            </select>
            <p><h4>Your Review</h4></p>
            <textarea name="review" style="width: 98%;"cols="50" rows="10"> </textarea>
            <input type="submit" value="submit">
            </form>
          </div><!--/row-->

        </div><!--/span-->
        </div>

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
