<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Sign in</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Le styles -->
</head>

<body>
	<?php
	$uName = $_POST["username"];
	$pass = $_POST["password"];

	if (empty($uName)||empty($pass)) { 
		$error = "Username and password are required";
		header("Location: login.php?error=".$error); 
	}
else{
	try{
			// Create connection
		$conn = mysqli_connect('localhost', 'root', 'mysql', 'project');

			// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		} 

			// Run a sql
		$stmt = $conn->prepare("select uName from user where uName = ? and password = ?");
		$stmt->bind_param("ss", $uName, $pass);
			//$result = $stmt->execute();
		$stmt->execute();
		$stmt->store_result();

		if ($stmt->num_rows <= 0) {
			$error = 'Please check! Your username or password is wrong!';
			header("Location: login.php?error=".$error);
			die();
		}
		if ($stmt->num_rows > 0) {
			header("Location: index.php?uName=" . $uName );
			die();
		}
		$stmt->close();

			// Close connection
		mysqli_close($conn);
	}
	catch(PDOException $e)
	{
		echo "Error: " . $e->getMessage();
	}
}
?>

</body>
</html>
