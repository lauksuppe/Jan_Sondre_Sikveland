<html>
	<head>
		<title>Forgot Password</title>
		<link rel="stylesheet" href="http://localhost:1234/public/loginproject/css/main.css">
	</head>
	<body>
		<div class="container">
			<form action="http://localhost:1234/public/loginproject/php/forgotpassword.php" method="post">
				Email: <input type="text" name="email" placeholder="Enter Your Email Address" required><br>

				<button type="submit" name="submit">Reset Password</button>

				<span class="one"><a href="http://localhost:1234/public/loginproject/newuser.html">New User</a></span>
				
				<span class="two"><a href="http://localhost:1234/public/loginproject/index.html">Log In</a></span>
			</form>
		</div>
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

			if(empty($data_missing)) {
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					echo '<p>Email is invalid.</p>';
					exit();
				}

				$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
				if ($conn->connect_error) {
				    die('Connection failed: ' . $conn->connect_error);
				} 

				$query = 'SELECT email FROM user WHERE email = ?';
				$stmt = $conn->prepare($query);
				$stmt->bind_param('s', $email);

				$stmt->execute();

				$result = $stmt->get_result();

				if($result->num_rows < 1) {
					echo '<p>Email is not registered to any account.</p>';
					exit();
				}

				//TODO: Send email with password reset/link

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
	</body>
</html>