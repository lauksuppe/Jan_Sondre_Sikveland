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
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Admin panel</title>
		<link rel="stylesheet" href="../css/main.css">
	</head>
	<body>
		<div class="container">
			<h1>Admin panel</h1>
			<a href="../login/logout.php">Log out</a>
			<ul class="blogposts">
				<?php
				$filepath = parse_ini_file('../filepath.ini');
				//Initialize DatabaseHelper object with admin access
				$dbhelper = DatabaseHelper::fromIni($filepath['filepath'] . '../private/', 'admin');
				//Fetch all blog posts from database and display the title + small part of content
				$result = $dbhelper->selectAll();
				if($result != false) {
					while($row = mysqli_fetch_assoc($result)) { 
					echo '<li class="blogpost" id="' . $row['id'] . '">';
					echo '<h2>' . $row['title'] . '</h2>';
					if(strlen($row['content']) > 97) {
						echo '<p>' . substr($row['content'], 0, 97) . '...</p>';
					} else {
						echo '<p>' . $row['content'] . '</p>';
					}
					echo '<ul class="links">';
					echo '<li><a href="blogpost.php?id=' . $row['id'] . '">Read</a></li>';
					//When the user has access to the admin panel he/she can also edit, delete and crate new posts
					echo '<li><a href="edit.php?action=edit&id=' . $row['id'] . '&from=/">Edit</a></li>';
					echo '<li><a href="verify.php?id=' . $row['id'] . '&from=/">Delete</a></li>';
					echo '</ul></li>';
					}
				}
				echo '<a href="edit.php?action=create&from=/">New post</a>';
				?> 
			</ul>
		</div>
	</body>
</html>