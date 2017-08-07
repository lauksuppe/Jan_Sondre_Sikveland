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

//Check if user is already logged in as admin
if(isset($_SESSION['admin']) && $_SESSION['admin']) {
	header('Location: ../admin');
	exit();
}

$filepath = parse_ini_file('../filepath.ini');
//Credentials stored outside htdocs for security
$credentials = parse_ini_file($filepath['filepath'] . '../private/admincredentials.ini');
//Create DatabaseHelper object using credentials from user
$dbhelper = new DatabaseHelper($credentials['servername'], $_POST['username'], $_POST['password'], $credentials['dbname']);

//Try to connect to the database with user supplied username and password
$conn = $dbhelper->connect();
if(!($conn === false) && ($_POST['username'] === $credentials['dbusername'])) {
	//I chose this method of logging in because it's simple, you could also have a table in the database where you store admin users
	$_SESSION['admin'] = true;
	header('Location: ../admin');
	exit();

} else { 
	//If something goes wrong (wrong username or pw etc) send user back to login page
	header('Location: login.php?message=invalid');
	exit();
}
?>