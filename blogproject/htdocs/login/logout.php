<?php 
/**
 * @Author Jan Sondre Sikveland: jan.s.sikveland@gmail.com
 */
namespace Blog;

session_start();
session_unset();
session_destroy();
header('Location: ../blog');
?>