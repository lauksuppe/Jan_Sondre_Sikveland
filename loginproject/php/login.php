<html>
	<head>
		<title>Login Page</title>
		<link rel="stylesheet" href="http://localhost:1234/public/loginproject/css/main.css">
	</head>
	<body>
		<div class="container">
			<form action="http://localhost:1234/public/loginproject/php/login.php" method="post">
				Username: <input type="text" name="username" placeholder="Enter Username" required><br>

				Password: <input type="password" name="password" placeholder="Enter Password" required><br>

				<button type="submit" name="submit">Log In</button>

				<br><input type="checkbox" checked="checked" name="remember">Remember me

				<span class="one"><a href="http://localhost:1234/public/loginproject/forgotpassword.html">Forgot password?</a></span>
				
				<span class="two"><a href="http://localhost:1234/public/loginproject/newuser.html">New User</a></span>
			</form>
		</div>
		<?php
		if(!empty($_GET['message'])) {
			$message = $_GET['message'];
			echo "<p>$message</p>";
		}

		$servername = "localhost";
		$dbusername = "loginquery";
		$dbpassword = "password";
		$dbname = "loginproject";


		if(isset($_POST['submit'])) {
			$data_missing = array();

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

			if(empty($data_missing)) {
				if(preg_match('/\s/', $password)) {
					echo "<p>Password cannot contain any whitespace.</p>";
					exit();
				}

				$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
				if ($conn->connect_error) {
				    die("Connection failed: " . $conn->connect_error);
				} 

				$sql = "SELECT username, password FROM user WHERE username = '$username'";

				$result = $conn->query($sql);

				if($result->num_rows == 0) {
					echo "<p>Username is not registered.</p>";
					exit();
				}

				$fetch = mysqli_fetch_array($result);

				if(password_verify($password, $fetch[1])) {
					header("Location: http://localhost:1234/public/loginproject/php/loggedin.php?username=$username");
				}

				echo "<p>Incorrect Password.</p>";

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