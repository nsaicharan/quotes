<?php 

	session_start();

	if (!$_SESSION['loggedInUser']) {
		header("Location: ../index.php");
		exit();

    } else {

    	include('../../conn.php');

    	$id = mysqli_real_escape_string($conn, $_GET['id']);
    	$query = "SELECT * FROM quick WHERE id = '$id'";
    	$result = mysqli_query($conn, $query);
    	$row = mysqli_fetch_array($result);
    }

?>

<table class="table table-responsive table-striped table-sm" width="100%" cellspacing="0">
	
	<tbody>

		<tr style="background: #011638">
			<th colspan="2">
				<h2 style="margin: 0; padding: 5px 0; text-align: center; ">Full Details</h2>
			</th>
		</tr>
		
		
			<th>First Name</th>
			<td><?php echo $row['first']; ?></td>
		</tr>
		<tr>
			<th>Last Name</th>
			<td><?php echo $row['last']; ?></td>
		</tr>
		<tr>
			<th>Email</th>
			<td><?php echo $row['email']; ?></td>
		</tr>
		<tr>
			<th>Phone</th>
			<td><?php echo $row['phone']; ?></td>
		</tr>
		<tr>
			<th>ZIP Code:</th>
			<td><?php echo $row['zip']; ?></td>
		</tr>
		<tr>
			<th>Street Address</th>
			<td><?php echo $row['street']; ?></td>
		</tr>
		<tr>
			<th>City, State, Country</th>
			<td><?php echo $row['city_state']; ?></td>
		</tr>
		<tr>
			<th>Current Insurance Co.</th>
			<td><?php echo $row['insurance']; ?></td>
		</tr>
	</tbody>
</table>