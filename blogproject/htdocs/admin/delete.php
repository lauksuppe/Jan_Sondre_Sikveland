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
if(!isset($_GET['id'])) {
	header('Location: ../admin');
	exit();
}

$filepath = parse_ini_file('../filepath.ini');
//Initialize DatabaseHelper object with admin access
$dbhelper = DatabaseHelper::fromIni($filepath['filepath'] . '../private/', 'admin');
$dbhelper->delete($_GET['id']);
header('Location: ../admin');
?>