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
if(isset($_SESSION['admin']) && $_SESSION['admin']) {
	header('Location: ../admin');
	exit();
}
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>My Blog</title>
		<link rel="stylesheet" href="../css/main.css">
	</head>
	<body>
		<div class="container">
			<h1>Welcome to my Blog</h1>
			<a href="../login/login.php">Log in</a>
			<ul class="blogposts">
				<?php
				$filepath = parse_ini_file('../filepath.ini');
				//Initialize DatabaseHelper object with normal access
				$dbhelper = DatabaseHelper::fromIni($filepath['filepath'] . '../private/', 'normal');
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
					//Normally the user is only allowed to read blog posts
					echo '<ul class="links">';
					echo '<li><a href="blogpost.php?id=' . $row['id'] . '">Read</a></li>';
					echo '</ul></li>';
					}
				}
				?> 
			</ul>
		</div>
	</body>
</html>