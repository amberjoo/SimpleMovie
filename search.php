  
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
            <li><a href="#">Home Page</a></li>
            <li><a href="movies.php?uName=<?php echo $uName ?>">Movies</a></li>
            <li><a href="#">Theatres</a></li>
            <li><a href="#">Top Rated Movies</a></li>
          </ul>
        </div><!--/.well -->
      </div><!--/span-->

      <!-- 2.2 center pane -->
      <div class="span7">
        <div class="center">
          <div class="border">
            <h3>
              Search Results: 
            </h3>
            
          </div>
          <!-- movie section-->
          <div class="row-fluid">
            <?php 
            //$stmt = $conn->prepare("select title from movies limit 5");
            //$stmt->bind_param("ss", $uName, $pass);
            //$result = $stmt->execute();
            $search = $_POST["search"]; 
            $sql = "SELECT movies.id, title FROM movies join showtime on showtime.movie = movies.id where title like '%". $search."%' order by showtime limit 100";
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
  </div><!--/span-->
</div>

</div><!--/row-->



</div><!--/.fluid-container-->
<hr>

<footer class="span12">
  <p>&copy; 2018</p>
</footer>
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
