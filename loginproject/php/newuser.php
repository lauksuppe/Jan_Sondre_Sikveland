<html>
	<head>
		<title>Create User</title>
		<link rel="stylesheet" href="http://localhost:1234/public/loginproject/css/main.css">
	</head>
	<body>
	<div class="container">
			<form action="http://localhost:1234/public/loginproject/php/newuser.php" method="post">
				Email (Up to 31 characters): <input type="text" name="email" placeholder="Enter Email" required><br>

				Username (5-20 characters): <input type="text" name="username" placeholder="Enter Username" required><br>

				Password: <input type="password" name="password" placeholder="Enter Password" required><br>

				Repeat Password: <input type="password" name="pwrepeat" placeholder="Repeat Password" required><br>

				<button type="submit" name="submit">Create User</button>

				<span class="one"><a href="http://localhost:1234/public/loginproject/forgotpassword.html">Forgot password?</a></span>
				
				<span class="two"><a href="http://localhost:1234/public/loginproject/index.html">Log In</a></span>
			</form>
		<?php
		$servername = 'localhost';
		$dbusername = 'loginquery';
		$dbpassword = 'password';
		$dbname = 'loginproject';

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
					echo '<p>Email is invalid.</p>';
					exit();
				}

				if(strlen($email) > 31) {
					echo '<p>Email is too long.</p>';
					exit();
				}

				if(strlen($username) > 20) {
					echo '<p>Username is too long.</p>';
					exit();
				} else if(strlen($username) < 5) {
					echo '<p>Username is too short.</p>';
					exit();
				}

				if(preg_match('/\s/', $password) || preg_match('/\s/', $pwrepeat)) {
					echo '<p>Password cannot contain any whitespace.</p>';
					exit();
				}

				if(!($password === $pwrepeat)) {
					echo '<p>Passwords are not identical.</p>';
					exit();
				}

				$password = password_hash($password, PASSWORD_DEFAULT);

				$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
				if ($conn->connect_error) {
				    die('Connection failed: ' . $conn->connect_error);
				} 

				$query = 'SELECT username FROM user WHERE username = ?';
				$stmt = $conn->prepare($query);
				$stmt->bind_param('s', $username);

				$stmt->execute();

				$result = $stmt->get_result();

				if($result->num_rows > 0) {
					echo '<p>Username is already in use.</p>';
					exit();
				}

				$query = 'SELECT email FROM user WHERE email = ?';
				$stmt = $conn->prepare($query);
				$stmt->bind_param('s', $email);

				$stmt->execute();

				$result = $stmt->get_result();

				if($result->num_rows > 0) {
					echo '<p>Email is already registered.</p>';
					exit();
				}

				$query = 'INSERT INTO user (username, password, email) VALUES (?, ?, ?)';
				$stmt = $conn->prepare($query);
				$stmt->bind_param('sss', $username, $password, $email);

				if ($stmt->execute() === TRUE) {
				    header('Location: http://localhost:1234/public/loginproject/php/login.php?message=Account Created, Try Logging In.');
				} else {
				    echo '<p>Error: ' . $query . '<br>' . $conn->error . '</p>';
				}

				$conn->close();
			} else {
				echo '<p>You need to enter the following data: ';
				foreach($data_missing as $missing) {
					echo "$missing, ";
				}
				echo '</p>';
			}
		}
		?>
		</div>
	</body>
</html>