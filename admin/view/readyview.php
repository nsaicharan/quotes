<?php 

	session_start();

	if (!$_SESSION['loggedInUser']) {
		header("Location: ../index.php");
		exit();

    } else {

    	include('../../conn.php');

    	$id = mysqli_real_escape_string($conn, $_GET['id']);
    	$query = "SELECT * FROM ready_drivers WHERE id = '$id'";
    	$result = mysqli_query($conn, $query);
    	$row = mysqli_fetch_array($result);
    }

?>

<table class="table table-responsive table-striped table-sm" width="100%" cellspacing="0">
	
	<tbody>

		<tr style="background: #011638">
			<th colspan="2">
				<h2 style="margin: 0; padding: 5px 0; text-align: center; ">Driver Details</h2>
			</th>
		</tr>

		<tr>
			<th>Group ID</th>
			<td><?php echo $row['group_id']; ?></td>
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
			<th>Gender</th>
			<td><?php echo $row['gender']; ?></td>
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
			<th>Student?</th>
			<td><?php echo $row['student']; ?></td>
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
			<th>ZIP</th>
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
			<th>Licence Number</th>
			<td><?php echo $row['licence']; ?></td>
		</tr>
		<tr>
			<th>Licence State</th>
			<td><?php echo $row['licence_state']; ?></td>
		</tr>
		<tr>
			<th>Age First Licensed</th>
			<td><?php echo $row['licence_age']; ?></td>
		</tr>
		<tr>
			<th>Date of Birth (M/D/Y)</th>
			<td>
				<?php echo $row['dob_month']; ?>/<?php echo $row['dob_date']; ?>/<?php echo $row['dob_year']; ?>
			</td>
		</tr>
		<tr>
			<th>Tickets/Accidents?</th>
			<td><?php echo $row['speeding_tickets']; ?></td>
		</tr>
		<tr>
			<th>DUI or DWI?</th>
			<td><?php echo $row['dui_dwi']; ?></td>
		</tr>
		<tr>
			<th>Licence Suspended?</th>
			<td><?php echo $row['licence_suspended']; ?></td>
		</tr>
		<tr>
			<th>SR/22?</th>
			<td><?php echo $row['driver_financial_form']; ?></td>
		</tr>

		<?php 

			$id = $row['id'];
			$query = "SELECT * FROM ready_vehicles WHERE driver like '$id'";
			$result = mysqli_query($conn, $query);

			$vehicleCount = (mysqli_num_rows($result) > 1) ? 1 : '';

			while ($row = mysqli_fetch_array($result)) :

		?>

			<tr style="background: #fff; padding: 5px;">
				<td colspan="2"></td>
			</tr>
			<tr style="background: #011638; margin-top: 2px;">
				<th colspan="2">
					<h2 style="margin: 0; padding: 5px 0; text-align: center; ">Vehicle <?php echo $vehicleCount; ?> Details</h2>
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
				<th>VIN</th>
				<td><?php echo $row['vin']; ?></td>
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
				<th>Mileage</th>
				<td><?php echo $row['mileage']; ?></td>
			</tr>
			<tr>
				<th>Desired Amount of Coverage</th>
				<td><?php echo $row['coverage']; ?></td>
			</tr>
			<tr>
				<th>Insurance Past 30 days?</th>
				<td><?php echo $row['insurance_past_30']; ?></td>
			</tr>
			
			<?php if ($row['insurance_past_30'] == 'Yes') : ?>
				<tr>
					<th>Insurance Company</th>
					<td><?php echo $row['insurance_company']; ?></td>
				</tr>
				<tr>
					<th>Insurance Expiration</th>
					<td>
						<?php echo $row['expire_month']; ?>  <?php echo $row['expire_year']; ?>
					</td>
				</tr>
				<tr>
					<th>Years Insured</th>
					<td><?php echo $row['years_insured']; ?></td>
				</tr>
				<tr>
					<th>Bodily Injury Liability</th>
					<td><?php echo $row['injury_liability_limit']; ?></td>
				</tr>	
			<?php endif; ?>

		<?php $vehicleCount++; endwhile; ?>
	</tbody>
</table>