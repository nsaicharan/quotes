<?php 

	session_start();

	if (!$_SESSION['loggedInUser']) {
		header("Location: ../index.php");

    }  else {

    	include('../../conn.php');

    	$id = mysqli_real_escape_string($conn, $_GET['id']);
    	$query = "SELECT * FROM semi WHERE id = '$id'";
    	$result = mysqli_query($conn, $query);
    	$row = mysqli_fetch_array($result);
    }

?>

<table class="table table-responsive table-striped table-sm" width="100%" cellspacing="0">
	
	<tbody>

		<tr style="background: #011638">
			<th colspan="2">
				<h2 style="margin: 0; padding: 5px 0; text-align: center; ">Vehicle Details</h2>
			</th>
		</tr>
		
		<tr>
			<th>Year</th>
			<td><?php echo $row['vehicle_year']; ?></td>
		</tr>
		<tr>
			<th>Make</th>
			<td><?php echo $row['make']; ?></td>
		</tr>
		<tr>
			<th>Model</th>
			<td><?php echo $row['model']; ?></td>
		</tr>
		<tr>
			<th>Ownership</th>
			<td><?php echo $row['ownership']; ?></td>
		</tr>
		<tr>
			<th>Primary Use</th>
			<td><?php echo $row['primary_use']; ?></td>
		</tr>
		<tr>
			<th>Parking</th>
			<td><?php echo $row['parking']; ?></td>
		</tr>
		<tr>
			<th>ZIP</th>
			<td><?php echo $row['zip']; ?></td>
		</tr>
		<tr>
			<th>Current Insurance Company</th>
			<td><?php echo $row['insurance']; ?></td>
		</tr>
		<tr>
			<th>Desired Amount of Coverage</th>
			<td><?php echo $row['coverage']; ?></td>
		</tr>

		<tr style="background: #011638">
			<th colspan="2">
				<h2 style="margin: 0; padding: 5px 0; text-align: center; ">Driver Details</h2>
			</th>
		</tr>

		<tr>
			<th>First Name</th>
			<td><?php echo $row['first_name']; ?></td>
		</tr>
		<tr>
			<th>Last Name</th>
			<td><?php echo $row['last_name']; ?></td>
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
			<th>Gender</th>
			<td><?php echo $row['gender']; ?></td>
		</tr>
		<tr>
			<th>Educational Level</th>
			<td><?php echo $row['education']; ?></td>
		</tr>
		<tr>
			<th>Occupation</th>
			<td><?php echo $row['occupation']; ?></td>
		</tr>
		<tr>
			<th>Marital Status</th>
			<td><?php echo $row['marital_status']; ?></td>
		</tr>
		<tr>
			<th>Residence</th>
			<td><?php echo $row['residence']; ?></td>
		</tr>
		<tr>
			<th>Credit Evaluation</th>
			<td><?php echo $row['credit_evaluation']; ?></td>
		</tr>
		<tr>
			<th>Driver Financial Form</th>
			<td><?php echo $row['driver_financial_form']; ?></td>
		</tr>
		
	</tbody>
</table>