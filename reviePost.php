<html>
	<head>
		<title>
			
		</title>
	</head>
	<body>
		

		<?php
		try{
			
			$review = $_POST["review"];
			$stars = $_POST["stars"];
			$movieId = $_GET["movId"];
			$name = $_GET["uName"];
			


			// Create connection
			$servername = "localhost";
			$username = "root";
			$password = "mysql";
			$database = "project";
			$conn = new mysqli($servername, $username, $password, $database);

			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 
			//echo "<p><font color=\"red\">Connected successfully</font></p>";
			$uId = 0;
			
			$sql = "SELECT id from user where uName =" . $name;
			//$stmt->bind_param("s",  $name);
			$result = $conn->query($sql);
			if ($result)
			{
				while($row = $result->fetch_assoc())
				{
					$uId = $row["id"];
				}
			}

			// Run a sql
			$stmt = $conn->prepare("insert into review SET reviewText = ? , uId = ? , rating = ?");
			$stmt->bind_param("sii",  $review, $uId, $stars);
			$result = $stmt->execute();
			$sql = "SELECT id from review order by id desc limit 1";
			$revId = 0;
			$result = $conn->query($sql);
			if ($result)
			{
				while($row = $result->fetch_assoc())
				{
					$revId = $row["count(*)"];
				}
			}
			$stmt = $conn->prepare("insert into reviewToMovie SET reviewId = ? , movieId = ?");
			$stmt->bind_param("ii",  $revId, $movieId);
			$result = $stmt->execute();
			/*if ($result) {
				echo "Record successfully edited";
			}
			else{
				echo "Something went wrong";
			}*/
			$stmt->close();

			// Close connection
			mysqli_close($conn);
				header("Location: movies.php?uName=" . $name );
				die();
		}
		catch(PDOException $e)
		{
			echo "Error: " . $e->getMessage();
		}
		?>
	</body>
</html>