<?php 
	session_start(); 

	if (!$_SESSION['loggedInUser']) {
		header("Location: index.php");

	} else {
		include('../conn.php');

		if ( isset($_GET['username']) )		{
			$username = mysqli_real_escape_string($conn, $_GET['username']);

			$query = "SELECT * FROM users WHERE username = '$username'";
			$result = mysqli_query($conn, $query);
			$row = mysqli_fetch_array($result);
		}
	}

?>

<form id="editUserForm" onsubmit="return editUser(this)">

	<div class="form-group">
		<label>Password:</label>
		<input type="password" class="form-control" name="password" required>
	</div>

	<div class="form-group">
		<label>Confirm Password:</label>
		<input type="password" class="form-control" name="cpassword" required>
	</div>

	<div class="form-group">
		<label>Email:</label>
		<input type="email" class="form-control" name="email" required value="<?php echo $row['email'] ?>">
	</div>
		
	<input type="hidden" name="username" value="<?php echo $row['username'] ?>">	
	<input type="hidden" name="key" value="editUser">

	<button class="btn btn-primary btn-block mb-1" type="submit">EDIT USER</button>

	<div class="error"></div>
	
</form>
