<?php 
	
	session_start();
	session_unset();
	session_destroy();

	setcookie('loggedInUser', '', time() - 3600, '/');
	unset($_COOKIE['loggedInUser']);

	header("Location: index.php");
	
 ?>

<h3>You're logged out! </h3>

<?php if ($_SESSION) {
		echo $_SESSION['loggedInUser'];
	} 
?>

