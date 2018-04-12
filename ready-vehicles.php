<?php

session_start();

include('conn.php');

$ids = explode(',', $_GET['id']);

// Set options for driver
$options = "";
$query = "SELECT id, first_name, last_name FROM ready_drivers WHERE id = ?";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $query);
mysqli_stmt_bind_param($stmt, 's', $id);

foreach ($ids as $id) {

	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);
	$driver_row = mysqli_fetch_array($result);

	$options .= "<option value='" . $driver_row['id'] . "'>" . $driver_row['first_name'] . " " . $driver_row['last_name']  . "</option>";
}

// Handle submit
if (isset($_POST['submit'])) {

	$driver = $vehicleYear = $make = $model = $vin = $ownership = $primaryUse = $mileage = $coverage = $insurancePast30 = $insuranceCompany = $expireMonth = $expireYear = $yearsInsured = $injuryLiabilityLimit = "";

	foreach ($_POST as $key => $value) {
		$$key = strip_tags( trim($_POST[$key]) );
	}
	
	//Only store details if driver session contains vehicle driver
	if (isset($_SESSION['drivers'])) {
		if (strpos($_SESSION['drivers'], $driver) !== false) {

			$status = "In Progress";
			$query = "INSERT INTO ready_vehicles VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '$status')";
			$stmt = mysqli_stmt_init($conn);

			mysqli_stmt_prepare($stmt, $query);
			mysqli_stmt_bind_param($stmt, 'sssssssssssssss', $driver, $vehicleYear, $make, $model, $vin, $ownership, $primaryUse, $mileage, $coverage, $insurancePast30, $insuranceCompany, $expireMonth, $expireYear, $yearsInsured, $injuryLiabilityLimit);

			mysqli_stmt_execute($stmt);
		} 
	}

	if (isset($_POST['anotherCar']) && $_POST['anotherCar'] == 'No') {
		// Redirect
		header("Location: thankyou");
	}
}
?>

<?php include('header.php'); ?>

	<div class="wrapper">
		<form action="" method="post" class="form">

			<h2 class="form-title"><?php echo $forms_row['form_three_vehicle']; ?></h2>

			<div class="row vehicle-details">
				<div class="four">
					<label for="driver">Driver:</label>
					<select name="driver" id="driver">
						<?php echo $options; ?>
					</select>
				</div>

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
				<button type="submit" class="submitBtn" name="submit">Submit</button>
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

            /* ===== Submit Button ===== */
            $("input[name=anotherCar]").change(function() {
                if (this.value == 'Yes') {
                    $("button[type=submit]").text('Continue');
                } else {
                   $("button[type=submit]").text('Submit');
                }
            });

		});


	</script>

</body>
</html>
