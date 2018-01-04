<?php 

	session_start();

	if (!$_SESSION['loggedInUser']) {
		header("Location: ../index.php");

    }  else {

    	include('../../conn.php');

    	$id = mysqli_real_escape_string($conn, $_GET['id']);
    	$query = "SELECT * FROM multi_vehicle WHERE id = '$id'";
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
			<th>Parking</th>
			<td><?php echo $row['parking']; ?></td>
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
			<th>ZIP</th>
			<td><?php echo $row['zip']; ?></td>
		</tr>

		

		<?php 

			$id = $row['id'];

			$query = "SELECT * FROM multi_drivers WHERE vehicle like '$id'";
			$result = mysqli_query($conn, $query);
			while ($row = mysqli_fetch_array($result)) :

		?>

			<tr style="background: #fff; padding: 5px;">
				<td colspan="2"></td>
			</tr>
			<tr style="background: #011638; margin-top: 2px;">
				<th colspan="2">
					<h2 style="margin: 0; padding: 5px 0; text-align: center; ">Driver Details</h2>
				</th>
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
				<th>Marital Status</th>
				<td><?php echo $row['marital_status']; ?></td>
			</tr>
			<tr>
				<th>Occupation</th>
				<td><?php echo $row['occupation']; ?></td>
			</tr>
			<tr>
				<th>Educational Level</th>
				<td><?php echo $row['education']; ?></td>
			</tr>
			<tr>
				<th>Licence Number</th>
				<td><?php echo $row['licence']; ?></td>
			</tr>
			<tr>
				<th>Age First Licensed</th>
				<td><?php echo $row['licence_age']; ?></td>
			</tr>
			<tr>
				<th>Credit Evaluation</th>
				<td><?php echo $row['credit_evaluation']; ?></td>
			</tr>
			<tr>
				<th>Date of Birth (M/D/Y)</th>
				<td>
					<?php echo $row['dob_month']; ?>/<?php echo $row['dob_date']; ?>/<?php echo $row['dob_year']; ?>
				</td>
			</tr>
			<tr>
				<th>Licence Suspended?</th>
				<td><?php echo $row['licence_suspended']; ?></td>
			</tr>
			<tr>
				<th>Financial Responsibility Form?</th>
				<td><?php echo $row['driver_financial_form']; ?></td>
			</tr>
			<tr>
				<th>Speeding Tickets?</th>
				<td><?php echo $row['speeding_tickets']; ?></td>
			</tr>
			<tr>
				<th>DUI or DWI?</th>
				<td><?php echo $row['dui_dwi']; ?></td>
			</tr>
			<tr>
				<th>Currently Have Insurance?</th>
				<td><?php echo $row['current_insurance']; ?></td>
			</tr>
			
			<?php if ($row['current_insurance'] == 'Yes' ) : ?>
			
				<tr>
					<th>Current Company</th>
					<td><?php echo $row['current_company']; ?></td>
				</tr>
				<tr>
					<th>Paying Amount</th>
					<td><?php echo $row['current_amount']; ?></td>
				</tr>
				<tr>
					<th>Expiration</th>
					<td>
						<?php echo $row['current_expire_month']; ?>  <?php echo $row['current_expire_year']; ?>
					</td>
				</tr>
				<tr>
					<th>Years Insured</th>
					<td><?php echo $row['current_years_insured']; ?></td>
				</tr>
				<tr>
					<th>Current Limits</th>
					<td><?php echo $row['current_limits']; ?></td>
				</tr>
				<tr>
					<th>Your Lists</th>
					<td><?php echo $row['your_list']; ?></td>
				</tr>
				<tr>
					<th>Deductible</th>
					<td><?php echo $row['deductible']; ?></td>
				</tr>

			<?php endif;  ?>
		<?php endwhile; ?>
	</tbody>
</table>