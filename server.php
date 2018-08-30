<?php

// initializing variables
$username = "";
$errors = array(); 



if (isset($_POST['reg_user'])) {
  // connect to the database
  $db = mysqli_connect('localhost', 'root', 'mysql', 'project');
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
  $is_admin = mysqli_real_escape_string($db, $_POST['is_admin']);

  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure 
  $user_check_query = "SELECT * FROM user WHERE uName='$username' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) { // if user exists
    if ($user['uName'] === $username) {
      array_push($errors, "Username already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = $password_1;//encrypt the password before saving in the database
  	$query = "INSERT INTO user (uName, password,isAdmin) 
  			  VALUES('$username', '$password', 'is_admin')";
  	mysqli_query($db, $query);
    mysqli_close($db);
  	header('location: index.php?uName=' . $username);
  }
}