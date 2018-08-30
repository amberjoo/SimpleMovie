<html>
	<head>
		<title>
			
		</title>
	</head>
	<body>
		

		<?php
		try{
			

			$movieId = $_GET["movId"];
			$name = $_GET["uName"];
			$time = $_GET["time"];
			$theatId = $_GET["theatId"];
			$seats = $_GET["seats"];
			


			// Create connection
			$servername = "localhost";
			$username = "root";
			$password = "admin123";
			$database = "project";
			$conn = new mysqli($servername, $username, $password, $database);

			// Check connection
			if ($conn->connect_error) {
			    die("Connection failed: " . $conn->connect_error);
			} 
			//echo "<p><font color=\"red\">Connected successfully</font></p>";

			$stmt = $conn->prepare("update showtime set availableSeats= ? where movie = ? and theaterId= ? and showtime = ?");
			$stmt->bind_param("iiis",  $seats, $movieId,$theatId,$time);
			$result = $stmt->execute();
			$stmt->close();

			// Close connection
			mysqli_close($conn);
				header("Location: tickets.php?uName=" . $name ."&movId=".$movieId );
				die();
		}
		catch(PDOException $e)
		{
			echo "Error: " . $e->getMessage();
		}
		?>
	</body>
</html>