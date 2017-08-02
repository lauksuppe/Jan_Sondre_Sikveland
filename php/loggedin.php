<html>
	<head>
		<title>Welcome</title>
		<link rel="stylesheet" href="http://localhost:1234/loginproject/css/main.css">
	</head>
	<body>
		<?php
		$username = $_GET['username'];
		echo "<p>You are now logged in as $username.<br> Welcome.</p>";
		?>
	</body>
</html>