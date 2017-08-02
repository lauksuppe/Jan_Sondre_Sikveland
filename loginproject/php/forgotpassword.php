<html>
	<head>
		<title>Forgot Password</title>
		<link rel="stylesheet" href="http://localhost:1234/loginproject/css/main.css">
	</head>
	<body>
		<div class="container">
			<form action="http://localhost:1234/loginproject/php/forgotpassword.php" method="post">
				Email: <input type="text" name="email" placeholder="Enter Your Email Address" required><br>

				<button type="submit" name="submit">Reset Password</button>

				<span class="one"><a href="http://localhost:1234/loginproject/newuser.html">New User</a></span>
				
				<span class="two"><a href="http://localhost:1234/loginproject/index.html">Log In</a></span>
			</form>
		</div>
		<?php
		$servername = "localhost";
		$dbusername = "loginquery";
		$dbpassword = "password";
		$dbname = "loginproject";

		if(isset($_POST['submit'])) {
			$data_missing = array();

			if(empty($_POST['email'])) {
				$data_missing[] = 'Email';
			} else {
				$email = $_POST['emai'];
			}

			if(empty($data_missing)) {
				

				$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
				if ($conn->connect_error) {
				    die("Connection failed: " . $conn->connect_error);
				} 



				if ($conn->query($sql) === TRUE) {
				    echo "<p>Logged In.</p>";
				} else {
				    echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
				}

				$conn->close();
			} else {
				echo "<p>You need to enter the following data: ";
				foreach($data_missing as $missing) {
					echo "$missing, ";
				}
				echo "</p>";
			}
		}
		?> 
	</body>
</html>