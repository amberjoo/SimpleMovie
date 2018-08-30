
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>HomePage</title>
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
            <li class="active"><a href="index.php">Home Page</a></li>
            <li><a href="movies-inTheater.php">Movies</a></li>
            <li><a href="#">Theatres</a></li>
            <li><a href="list.php">Top Rated Movies</a></li>
          </ul>
        </div><!--/.well -->
      </div><!--/span-->

      <!-- 2.2 center pane -->
      <div class="span7">
        <div class="center">
          <div class="border">
            <h3>
              In Theaters
            </h3>
            <h4 class="more"><a href="movies-inTheater.php">more  &raquo;</a></h4>
          </div>
          <!-- movie section-->
          <div class="row-fluid">
            <?php 
		  //$stmt = $conn->prepare("select title from movies limit 5");
			//$stmt->bind_param("ss", $uName, $pass);
			//$result = $stmt->execute();
            $sql = "SELECT movies.id, title FROM movies join showtime on movies.id = showtime.movie where showtime.showtime > now() and showtime.showtime < now() +10000000 limit 4";
            $result = $conn->query($sql);
            if($result){
              $count = 0;
              while($row = $result->fetch_assoc())
              {		
                $count++;
                if($count==1){
                  echo "<div class='row-fluid'>";
                }
                echo "<div class='span3'>";
                echo "<img src='img/default.jpg'>";
                $title = $row["title"];
                echo "<h5>" . $title . "</h5>";
                echo "<p><a class='btn' href='tickets.php?uName=" . $uName ."&movId=" . $row["id"] ."'>Get tickets &raquo;</a></p>";
                echo "</div>";
                if($count==4){
                  $count=0;
                  echo "</div>";
                }


              }

            }


            ?>


          </div><!--/row-->

          <div class="border">
            <h3>
              Coming Soon
            </h3>
            <h4 class="more"><a href="movies-comingSoon.php">more  &raquo;</a></h4>
          </div>
          <!-- movie section-->
          <div class="row-fluid">
           <?php 
		  //$stmt = $conn->prepare("select title from movies limit 5");
			//$stmt->bind_param("ss", $uName, $pass);
			//$result = $stmt->execute();
           $sql = "SELECT movies.id, title FROM movies join showtime on showtime.movie = movies.id where showtime.showtime > now() + 10000000 and showtime.showtime < now() + 100000000 limit 4";
           $result = $conn->query($sql);
           if($result){
            $count1=0;
            while($row = $result->fetch_assoc())
            {	
              $count1++;
              if($count1==1){
                echo "<div class='row-fluid'>";
              }
              echo "<div class='span3'>";
              echo "<img src='img/default.jpg'>";			
              $title = $row["title"];
              echo "<h5>" . $title . "</h5>";
              echo "<p><a class='btn' href='tickets.php?uName=" . $uName ."&movId=" . $row["id"] ."'>View Details &raquo;</a></p>";
              echo "</div>";
              if($count1==4){
                  $count1=0;
                  echo "</div>";
                }
            }

          }


          ?>

        </div><!--/row-->
      </div><!--/span-->
    </div>

    <!-- 2.3 right pane -->
    <div class="span3"> 
        <div class="card">
            <div class="card-header">
              <h4 class="font-weight-normal">Top 10 Rated Movies</h4>
            </div>
            <div class="card-body">
              <ol class="">
                <?php
                $sql = "SELECT m.id mid, m.title mtitle, avg(r.rating) rating FROM review r,movies m, reviewtomovie rm where r.id=rm.reviewId and m.id=rm.movieId group by m.id order by rating desc limit 10";
                $result = $conn->query($sql);
                if($result){
                  while($row = $result->fetch_assoc()){
                    echo "<li><a href='movies.php?movieId=".$row['mid']."'>".$row['mtitle'] ."(".$row['rating'].")</a></li>";
                  }
                }
                ?>
              </ol>
            </div>
          </div>
        

      </div>
    </div><!--/row-->

    <hr>

    <footer class="span12">
      <p>&copy; 2018</p>
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
