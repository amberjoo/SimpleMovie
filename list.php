<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Top Rated Movies</title>
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
              <li><a href="index.php">Home Page</a></li>
              <li><a href="movies-inTheater.php">Movies</a></li>
              <li><a href="#">Theatres</a></li>
              <li class="active"><a href="list.php">Top Rated Movies</a></li>
            </ul>
          </div><!--/.well -->
        </div><!--/span-->

        <!-- 2.2 center pane -->
        <div class="span7" >
          <div class="center-ticket">
            <div class="row" style="margin: 30px 0 0px 0;">
              <div class="span7">
                <form action="list.php" method="POST">
                <select class= "span10" name="model" required>
                  <option value="number">Number of Ratings</option>
                  <option value="rating" selected>Rating</option>
                </select>
                <button type="submit" style="border: solid 1px;float: right;">GO</button>
                </form>
              </div>
            </div>

          <div class="table-responsive">
            <table class="table table-striped">

                <?php 
                  $model = $_POST['model'];
                  if($model == 'number'){
                    $sql1 = "SELECT m.id mid, m.title mtitle, count(*) c FROM review r,movies m, reviewtomovie rm where r.id=rm.reviewId and m.id=rm.movieId group by m.id order by c desc";
                    $result1 = $conn->query($sql1);
                     $count = 0;
                      echo "<thead>";
                      echo "<tr>";
                      echo "<th>Ranking</th>";
                      echo "<th>Title</th>";
                      echo "<th>Number of Reviews</th>";
                      echo "</tr>";
                      echo "</thead>";
                      echo "<tbody>";
                     if($result1){
                      while($row = $result1->fetch_assoc()){
                        $count++;
                         echo "<tr>";
                        echo "<td>".$count."</td>";
                        echo "<td>".$row['mtitle']."</td>";
                        echo "<td>".$row['c']."</td>";
                        echo "</tr>";
                      }
                  }

                  }
                  else{
                    $sql2 = "SELECT m.id mid, m.title mtitle, avg(r.rating) a FROM review r,movies m, reviewtomovie rm where r.id=rm.reviewId and m.id=rm.movieId group by m.id order by a desc";
                    $result2 = $conn->query($sql2);
                     $count = 0;
                      echo "<thead>";
                      echo "<tr>";
                      echo "<th>Ranking</th>";
                      echo "<th>Title</th>";
                      echo "<th>Average Rating</th>";
                      echo "</tr>";
                      echo "</thead>";
                      echo "<tbody>";
                     if($result2){
                      while($row = $result2->fetch_assoc()){
                        $count++;
                        echo "<tr>";
                        echo "<td>".$count."</td>";
                        echo "<td>".$row['mtitle']."</td>";
                        echo "<td>".$row['a']."</td>";
                        echo "</tr>";
                      }
                  }
                  }
                  
                  
                  
                 
                ?>
              </tbody>
            </table>
          </div>
          </div>
        </div>
          <!-- movie section-->
          

        <!-- 2.3 right pane -->
        <div class="span3">
          <div class="card">
            <div class="card-header">
              <h4 class="font-weight-normal">Recommendation</h4>
            </div>
            <div class="card-body">
              <ul class="">

                <?php
                $sql = "SELECT m.id mid, m.title mtitle, avg(r.rating) rating FROM review r,movies m, reviewtomovie rm where r.id=rm.reviewId and m.id=rm.movieId group by m.id order by rating desc limit 10";
                $result = $conn->query($sql);
                if($result){
                  while($row = $result->fetch_assoc()){
                    echo "<li><a href='movies.php?movieId=".$row['mid']."'>".$row['mtitle'] ."(".$row['rating'].")</a></li>";
                  }
                }
                ?>
              </ul>
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
