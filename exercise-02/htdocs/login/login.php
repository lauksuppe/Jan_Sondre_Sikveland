<?php 
/**
 * @Author Jan Sondre Sikveland: jan.s.sikveland@gmail.com
 */
namespace Blog;

header('Content-Type: text/html; charset=ISO-8859-1');

session_start();
//Regenerate session id if more than 15 minutes have passed since last regeneration
if (!isset($_SESSION['CREATED'])) {
    $_SESSION['CREATED'] = time();
} else if (time() - $_SESSION['CREATED'] > 900) {
    session_regenerate_id(true);
    $_SESSION['CREATED'] = time();
}

//Check if user is already logged in as admin
if(isset($_SESSION['admin']) && $_SESSION['admin']) {
	header('Location: ../admin');
	exit();
}
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link rel="stylesheet" href="../css/main.css">
	</head>
	<body>
		<div class="container">
			<h1>Log in to admin panel</h1>
			<?php
				if(!empty($_GET) && isset($_GET['message'])) {
					if($_GET['message'] === 'invalid') {
						echo '<p>Invalid login credentials.';
					} else if($_GET['message'] === 'login') {
						echo '<p>You need to log in first.';
					}
				}
			?>
			<form action="validate.php" method="post">
				Username:<br>
				<input type="text" name="username" requried><br>
				Password:<br>
				<input type="password" name="password" required><br>
				<input type="submit" name="submit" value="Submit">
				<a href="../blog/">Return</a>
			</form>
		</div>
	</body>
</html>