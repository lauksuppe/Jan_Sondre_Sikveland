<html>
	<head>
		<title>Create User</title>
		<link rel="stylesheet" href="http://localhost:1234/loginproject/css/main.css">
	</head>
	<body>
	<div class="container">
			<form action="http://localhost:1234/loginproject/php/newuser.php" method="post">
				Email: <input type="text" name="email" placeholder="Enter Email" required><br>

				Username: <input type="text" name="username" placeholder="Enter Username" required><br>

				Password: <input type="password" name="password" placeholder="Enter Password" required><br>

				Repeat Password: <input type="password" name="pwrepeat" placeholder="Repeat Password" required><br>

				<button type="submit" name="submit">Create User</button>

				<span class="one"><a href="http://localhost:1234/loginproject/forgotpassword.html">Forgot password?</a></span>
				
				<span class="two"><a href="http://localhost:1234/loginproject/index.html">Log In</a></span>
			</form>
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
				$email = $_POST['email'];
			}

			if(empty($_POST['username'])) {
				$data_missing[] = 'Username';
			} else {
				$username = $_POST['username'];
			}

			if(empty($_POST['password'])) {
				$data_missing[] = 'Password';
			} else {
				$password = $_POST['password'];
			}

			if(empty($_POST['pwrepeat'])) {
				$data_missing[] = 'Repeat Password';
			} else {
				$pwrepeat = $_POST['pwrepeat'];
			}

			if(empty($data_missing)) {
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					echo "<p>Email is invalid.</p>";
					exit();
				}

				if(preg_match('/\s/', $password) || preg_match('/\s/', $pwrepeat)) {
					echo "<p>Password cannot contain any whitespace.</p>";
					exit();
				}

				if(!($password === $pwrepeat)) {
					echo "<p>Passwords are not identical.</p>";
					exit();
				}

				$password = password_hash($password, PASSWORD_DEFAULT);

				$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
				if ($conn->connect_error) {
				    die("Connection failed: " . $conn->connect_error);
				} 

				$sql = "SELECT username FROM user WHERE username = '$username'";

				$result = $conn->query($sql);

				if($result->num_rows > 0) {
					echo "<p>Username is already in use.</p>";
					exit();
				}

				$sql = "SELECT email FROM user WHERE email = '$email'";

				$result = $conn->query($sql);

				if($result->num_rows > 0) {
					echo "<p>Email is already registered.</p>";
					exit();
				}

				$sql = "INSERT INTO user (username, password, email)
				VALUES ('$username', '$password', '$email')";

				if ($conn->query($sql) === TRUE) {
				    header("Location: http://localhost:1234/loginproject/php/login.php?message=Account Created, Try Logging In.");
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
		</div>
	</body>
</html>