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

//Check if user is logged in as admin
if($_SESSION['admin'] !== true) {
	header('Location: ../login/login.php?message=login');
	exit();
}

//Check that the url is correct
if(!isset($_GET['from'])) {
	header('Location: ../admin');
	exit();
} else if(!isset($_GET['id'])) {
	header('Location: ../admin' . $_GET['from']);
	exit();
}
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Delete</title>
		<link rel="stylesheet" href="../css/main.css">
	</head>
	<body>
		<div class="container">
			<?php
			echo '<h3>Are you sure you want to delete the blog post?</h3>';
			echo '<a href="delete.php?id=' . $_GET['id'] . '">Yes</a>';
			echo '<a href="../admin' . $_GET['from'] . '">No</a>';
			?>
		</div>
	</body>
</html>