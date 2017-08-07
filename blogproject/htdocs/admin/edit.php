<?php 
/**
 * @Author Jan Sondre Sikveland: jan.s.sikveland@gmail.com
 */
namespace Blog;

header('Content-Type: text/html; charset=ISO-8859-1');

//Autoload helper classes
spl_autoload_register(function($class_name) {
	include '../src/' . $class_name . '.php';
});

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
} else if(!isset($_GET['action']) || ($_GET['action'] === 'edit' && !isset($_GET['id']))) {
	header('Location: ../admin' . $_GET['from']);
	exit();
} 
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Post Editor</title>
		<link rel="stylesheet" href="../css/main.css">
	</head>
	<body>
		<div class="container">
			<h1>Post Editor</h1>
			<?php
			$filepath = parse_ini_file('../filepath.ini');
			//Initialize DatabaseHelper object with admin access
			$dbhelper = DatabaseHelper::fromIni($filepath['filepath'] . '../private/', 'admin');
			if($_GET['action'] === 'edit') {
				$result = $dbhelper->select($_GET['id']);
				$fetch = mysqli_fetch_assoc($result);
				echo '<form action="save.php?id=' . $_GET['id'] . '" method="post">';
				echo 'Title:<br><textarea rows="1" cols="50" name="title" class="smalltext" required>' . $fetch['title'] . '</textarea><br>';
				echo 'Content:<br><textarea rows="40" cols="50" name="content" class="bigtext" required>' . $fetch['content'] . '</textarea><br>';
				echo '<input type="submit" value="Save changes">';
			} else {
				echo '<form action="save.php" method="post">';
				echo 'Title:<br><textarea rows="1" cols="50" name="title" class="smalltext" required></textarea><br>';
				echo 'Content:<br><textarea rows="40" cols="50" name="content" class="bigtext" required></textarea><br>';
				echo '<input type="submit" value="Create post">';
			}
			echo '<a href="../admin' . $_GET['from'] . '">Return</a>';
			?> 
		</div>
	</body>
</html>