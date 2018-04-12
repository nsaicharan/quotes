<?php

session_start();

include('conn.php');

if (isset($_POST['continue'])) {

	$vehicleYear = $make = $model = $vin = $ownership = $parking = $primaryUse = $mileage = $coverage = $insurancePast30 = $insuranceCompany = $expireMonth = $expireYear = $yearsInsured = $injuryLiabilityLimit = "";

	foreach ($_POST as $key => $value) {
		$$key = strip_tags( trim($_POST[$key]) );
	}

	//Store details
	$status = "In Progress";
	$query = "INSERT INTO ready_vehicles VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '$status')";
	$stmt = mysqli_stmt_init($conn);

	mysqli_stmt_prepare($stmt, $query);
	mysqli_stmt_bind_param($stmt, 'sssssssssssssss', $vehicleYear, $make, $model, $vin, $ownership, $parking, $primaryUse, $mileage, $coverage, $insurancePast30, $insuranceCompany, $expireMonth, $expireYear, $yearsInsured, $injuryLiabilityLimit);

	if ( mysqli_stmt_execute($stmt) ) {

		//Create CSV
		$filename = 'csvfile.csv';
		$file = fopen($filename, 'w');
		fputcsv($file, array('Vehicle Year', 'Make', 'Model', 'VIN', 'Ownership', 'Parking', 'Primary Use', 'Mileage', 'Desired Coverage', 'Insurance Past 30', 'Insurance Company', 'Expiration Month', 'Expiration Year', 'Years Insured', 'Inujury Liability Limit'));
		fputcsv($file, array($vehicleYear, $make, $model, $vin, $ownership, $parking, $primaryUse, $mileage, $coverage, $insurancePast30, $insuranceCompany, $expireMonth, $expireYear, $yearsInsured, $injuryLiabilityLimit));
		fclose($file);

    	//Get the email address of operator
		$query = "SELECT email FROM users WHERE username = 'operator'";
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_array($result);
		$operatorEmail = $row['email'];

    	//Set Message
		$message = "<p>Hi there, someone submitted their information via <b>Ready To Buy</b> form.</p>";
		$message .= "<b>Details:</b> <br>
						 <ul>
							<li>Vehicle Year  - $vehicleYear</li>
							<li>Make  - $make</li>
							<li>Model - $model</li>
							<li>VIN  - $vin</li>
							<li>Ownership  - $ownership</li>
							<li>Parking  - $parking</li>
							<li>Primary Use  - $primaryUse</li>
							<li>Mileage - $mileage</li>
							<li>Desired Coverage  - $coverage</li>
							<li>Insurance Past 30 days? - $insurancePast30</li>
							<li>Insurance Company  - $insuranceCompany</li>
							<li>Expiration Month  - $expireMonth</li>
							<li>Expiration Year  - $expireYear</li>
							<li>Years Insured  - $yearsInsured</li>
							<li>Current bodily injury liability limit - $injuryLiabilityLimit</li>
						 </ul>
						";
		$message .= "<p>You can view full details by logging into your admin area.</p>";

		//Send Mail
		include('phpmailer/class.phpmailer.php');

		$mail = new PHPMailer;

		$mail->From = 'hi@saicharan.me';
		$mail->FromName = 'Sai';
		$mail->AddAddress($operatorEmail);
		$mail->WordWrap = 70;
		$mail->IsHTML(true);
		$mail->AddAttachment($filename);
		$mail->Subject = 'New form submission';
		$mail->Body = $message;

		if ($mail->Send()) {
			unlink($filename);
		}

    	//Fetch the ID of vehicle from the db
		$query = "SELECT id FROM ready_vehicles ORDER BY id DESC";
		$result = mysqli_query($conn, $query);
		$idRow = mysqli_fetch_assoc($result);
		$id = $idRow['id'];

		$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$escaped_url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');

		if ($_POST['anotherCar'] == "Yes") {

			if (isset($_GET['id'])) {

				$ids = $_GET['id'] . ",$id";

				$escaped_url = explode('?', $escaped_url)[0];

				header("Location: $escaped_url?id=$ids");

			} else {
				header("Location: $escaped_url?id=$id");
			}

		} else {

			if (isset($_GET['id'])) {
				$ids = $_GET['id'] . ",$id";

			 	//Set session vehicle for future reference
				$_SESSION['vehicle'] = $ids;

				$escaped_url = explode('?', $escaped_url)[0];

				header("Location: drivers.php?id=$ids");
			} else {
			 	//Set session vehicle for future reference
				$_SESSION['vehicle'] = $id;

				header("Location: drivers.php?id=$id");
			}
		}
	}
}
?>

<?php include('header.php'); ?>

	<div class="wrapper">
		<form action="" method="post" class="form">

			<h2 class="form-subtitle">Vehicle Details</h2>

			<div class="row vehicle-details">
				<div class="four">
					<label for="vehicle">Vehicle Year:</label>
					<select name="vehicleYear" id="vehicle" required>
						<option disabled selected value="">
							-- Year --
						</option>
					</select>
				</div>

				<div class="four">
					<label for="make">Make:</label>
					<select name="make" id="make" required>
						<option disabled selected value="">
							-- Select Make --
						</option>
					</select>
				</div>

				<div class="four">
					<label for="model">Model:</label>
					<select name="model" id="model" required>
						<option disabled selected value="">
							-- Select Model --
						</option>
					</select>
				</div>

				<div class="four">
					<label for="vin">VIN:</label>
					<input type="text" name="vin" id="vin" pattern="[a-zA-Z0-9]+" required>
				</div>

				<div class="four">
					<label for="ownership">Ownership:</label>
					<select name="ownership" id="ownership" required>
						<option disabled selected value="">
							-- Owned --
						</option>
						<option value="Financed">Financed</option>
						<option value="Lease">Lease</option>
						<option value="Paid Off">Paid Off</option>
					</select>
				</div>

				<div class="four">
					<label for="parking">Night Parking:</label>
					<select name="parking" id="parking" required>
						<option disabled selected value="">
							-- Select --
						</option>
						<option value="Street">Street</option>
						<option value="Garage">Garage</option>
						<option value="Other">Other</option>
					</select>
				</div>

				<div class="four">
					<label for="primaryUse">Primary Use:</label>
					<select name="primaryUse" id="primaryUse" required>
						<option disabled selected value="">
							-- Select --
						</option>
						<option value="Commuting to/from work/school">Commuting to/from work/school</option>
						<option value="Pleasure/ Personal use">Pleasure/Personal use</option>
						<option value="Business/Commercial">Business/Commercial</option>
					</select>
				</div>

				<div class="four">
					<label for="mileage">Annual Mileage:</label>
					<select name="mileage" id="mileage" required>
						<option disabled selected value="">
							-- Select --
						</option>
						<option value="0-7500">0-7500</option>
						<option value="7500-15000">7500-15000</option>
						<option value="More than 15000">More than 15000</option>
					</select>
				</div>

				<div class="four">
					<label for="coverage">Desired Amount of Coverage:</label>
					<select name="coverage" id="coverage" required>
						<option disabled selected value="">
							-- Select --
						</option>
						<option value="25/65/15">25/65/15 </option>
						<option value="50/100/50">50/100/50</option>
						<option value="100/300/100">100/300/100</option>
						<option value="250/500/250">250/500/250</option>
						<option value="500/500/500">500/500/500</option>
					</select>
				</div>

				<div class="four">
					<span class="span-padding">Have you had insurance past 30 days?</span>

					<div class="radios">
						<label>
							<input type="radio" name="insurancePast30" value="Yes" required>
							Yes
						</label>
						<label>
							<input type="radio" name="insurancePast30" value="No" required>
							No
						</label>
					</div>
				</div>

				<div class="four insuranceItem">
					<label for="insuranceCompany">Insurance Company:</label>
					<input type="text" name="insuranceCompany" id="insuranceCompany" required>
				</div>

				<div class="four insuranceItem">
					<label for="expireMonth">Insurance Expiration Date:</label>

					<div>
						<select name="expireMonth" id="expireMonth" class="half" required>
							<option value="" selected disabled>Month</option>
							<option value="January">January</option>
							<option value="February">February</option>
							<option value="March">March</option>
							<option value="April">April</option>
							<option value="May">May </option>
							<option value="June">June</option>
							<option value="July">July</option>
							<option value="August">August</option>
							<option value="September">September</option>
							<option value="October">October</option>
							<option value="November">November</option>
							<option value="December">December</option>
						</select>

						<select name="expireYear" id="expireYear" class="half" required>
							<option value="" selected disabled>Year</option>
							<option value="2015">2015</option>
							<option value="2016">2016</option>
							<option value="2017">2017</option>
							<option value="2018">2018</option>
							<option value="2019">2019</option>
							<option value="2020">2020</option>
							<option value="2021">2021</option>
							<option value="2022">2022</option>
							<option value="2023">2023</option>
							<option value="2024">2024</option>
							<option value="2025">2025</option>
						</select>
					</div>
				</div>

				<div class="four insuranceItem">
					<label for="yearsInsured">Years Insured:</label>
					<select name="yearsInsured" id="yearsInsured" required>
						<option disabled selected value="">
							-- Insured Years --
						</option>
                        <option value="1 Year">1 Year</option>
                        <option value="2 Years">2 Years</option>
                        <option value="3 Years">3 Years</option>
                        <option value="4 Years">4 Years</option>
                        <option value="5 Years">5 Years</option>
                        <option value="6 Years">6 Years</option>
                        <option value="7 Years">7 Years</option>
                        <option value="8+ Years">8+ Years</option>
					</select>
				</div>

				<div class="four insuranceItem">
					<label for="injuryLiabilityLimit">Current bodily injury liability limit:</label>
					<select name="injuryLiabilityLimit" id="injuryLiabilityLimit" required>
						<option disabled selected value="">
							-- Select --
						</option>
                        <option value="25/65/15">25/65/15 </option>
						<option value="50/100/50">50/100/50</option>
						<option value="100/300/100">100/300/100</option>
						<option value="250/500/250">250/500/250</option>
						<option value="500/500/500">500/500/500</option>
					</select>
				</div>

				<div class="four">
					<span class="span-padding">Add another car?</span>

					<div class="radios">
						<label>
							<input type="radio" name="anotherCar" value="Yes" required>
							Yes
						</label>
						<label>
							<input type="radio" name="anotherCar" value="No" required>
							No
						</label>
					</div>
				</div>

			</div> <!-- Vehicle Details -->

			<div class="text-center">
				<button type="submit" class="submitBtn" name="continue">Continue</button>
			</div>
		</form>
	</div> <!-- wrapper -->
	
</main>

<?php include('footer.php'); ?>

	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

	<script>

		/* ===== Vehicle Years ===== */
		let options = '';
		let year = new Date().getFullYear();
		const lastYear = year - 35;

		for (year; year >= lastYear; year--) {
			options += `<option value="${year}">${year}</option>`;
		}
		$("[name=vehicleYear]").append(options);


		$(document).ready(function() {

			/* ===== Makes ===== */
			$.ajax({
				url: 'cardata.php',
				method: 'post',
				data: {type: 'makes'},
				success: function(options) {
					$("#make").append(options);
				},
				error: function(err) {
					console.log(err);
				}
			});

			/* ===== Models ===== */
			$("#make").change(function() {
				const make = this.value;
				$("#model").html(`<option selected disabled>Populating Models...</option>`);

				$.ajax({
					url: 'cardata.php',
					method: 'post',
					data: {type: 'models', make: make},
					success: function(options) {
						$("#model").html(`<option disabled selected value=''>-- Select Model --</option> ${options}`);
					},
					error: function(err) {
						console.log(err);
					}
				});
			});

			/* ===== Insurance Past 30 ===== */
            if ($("input[name=insurancePast30]")[0].checked) {
                $(".insuranceItem").show();
                $(".insuranceItem input").prop("disabled", false);
                $(".insuranceItem select").prop("disabled", false);
            } else {
                $(".insuranceItem").hide();
                $(".insuranceItem input").prop('disabled', true);
                $(".insuranceItem select").prop('disabled', true);
            }

            $("input[name=insurancePast30]").change(function() {
                if (this.value == 'Yes') {
                    $(".insuranceItem").fadeIn();
                    $(".insuranceItem input").prop("disabled", false);
                    $(".insuranceItem select").prop("disabled", false);
                } else {
                    $(".insuranceItem").fadeOut('fast');
                    $(".insuranceItem input").prop('disabled', true);
                    $(".insuranceItem select").prop('disabled', true);
                }
            });

		});


	</script>

	<!-- FB CHAT -->
	<?php echo $tracking_row['fb_chat']; ?>

</body>
</html>
