
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
<!--1. header -->
    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container-fluid">
          <a class="brand" href="#">MBME</a>
          <div class="nav-collapse collapse">
            <p class="navbar-text pull-right">
              Logged in as <a href="#" class="navbar-link">Username</a>
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
              <li><a href="index.php">Home Page</a></li>
              <li class="active"><a href="movies-inTheater.php">Movies</a></li>
              <li><a href="#">Theatres</a></li>
              <li><a href="list.php">Top Rated Movies</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->

        <!-- 2.2 center pane -->
        <div class="span7" >
          <div class="navbar" style="margin-top: 20px; ">
            <div class="navbar-inner">
                <ul class="nav">
                  <li class="active"><a href="movies-inTheater.php">In Theater</a></li>
                  <li><a href="movies-comingSoon.php">Coming Soon</a></li>
                </ul>
            </div>
          </div><!-- /.navbar -->

          <div class="center">
          <!-- movie section-->
          <?php 
            $sql = "SELECT movies.id mid, title,runtime,plot,rating,studio,concat(d.fName,' ',d.lName) as director,d.id as did from movies,showtime,director d,directortomovie dm where movies.id = dm.movieId and dm.directorId = d.id and movies.id = showtime.movie and showtime.showtime>now() and showtime.showtime< now() +10000000 order by showtime";
            $result = $conn->query($sql);
            $sql2 = "select count(*) number from movies,showtime,director d,directortomovie dm where movies.id = dm.movieId and dm.directorId = d.id and movies.id = showtime.movie and showtime.showtime>now() and showtime.showtime< now() +10000000 order by showtime ";
            $result2 = $conn->query($sql2);
            if($result){
              $row2 = $result2->fetch_assoc();
              echo "<p style='width: 100%;text-align: center;'>Total number: ". $row2['number']."</p>";
              while($row = $result->fetch_assoc())
              {   
                echo "<div class='row-fluid border'>";
                echo "<div class='span3 '>";
                echo "<img src='img/default.jpg'></div><div class='span6'>";
                $mid = $row["mid"];
                $title = $row["title"];
                $runtime = $row["runtime"];
                $plot = $row["plot"];
                $rating = $row["rating"];
                $studio = $row["studio"];
                $director = $row["director"];

                echo "<h5>" . $title . "</h5>";
                echo "<p><b>Runtime:&nbsp;&nbsp;&nbsp;</b>" . $runtime . "</p>";
                echo "<p><b>Description:&nbsp;&nbsp;&nbsp;</b>" . $plot . "</p>";
                echo "<p><b>Studio:&nbsp;&nbsp;&nbsp;</b>" . $studio . "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Rating:&nbsp;&nbsp;&nbsp;</b>" . $rating . "</p>";
                echo "<p><b>Director:&nbsp;&nbsp;&nbsp;</b>" . $director . "</p>";
                   $sql1 = "SELECT concat(a.fName,' ',a.lName) as actor from actor a,actortomovie am where am.movieId = ".$mid ." and am.actorId = a.id";
                   $result1 = $conn->query($sql1);
                   if($result1){
                    echo "<p><b>Cast:&nbsp;&nbsp;&nbsp;</b>";
                       while($row1 = $result1->fetch_assoc()){
                       echo $row1["actor"].",&nbsp;";
                       
                     }
                    echo "</p>";
                 }
                 
                echo "</div>";
                echo "<div class='span3'>";
                echo "<p style='margin-top: 50px;'><a class='btn' href='tickets.php?movId=".$mid."' >Get tickets &raquo;</a></p>";
                echo "</div></div>";
              }

            }


            ?>

        </div><!--/span-->
        </div>

        <!-- 2.3 right pane -->
        <div class="span3">
          <div class="card">
            <div class="card-header">
              <h4 class="font-weight-normal">Recommendation</h4>
            </div>
            <div class="card-body">
              <ol class="">
                <?php
                $sql = "select title,movies.id mid from movies,directortomovie dm where movies.id=dm.movieId and directorId in (SELECT d.id as did from movies,showtime,director d,directortomovie dm where movies.id = dm.movieId and dm.directorId = d.id and movies.id = showtime.movie and showtime.showtime>now() and showtime.showtime< now() +10000000 order by showtime) limit 10";
                $result = $conn->query($sql);
                if($result){
                  while($row = $result->fetch_assoc()){
                    echo "<li><a href='movies.php?movieId=".$row['mid']."'>".$row['title'] ."</a></li>";
                  }
                }
                ?>
              </ol>
            </div>
          </div>

        </div>
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
