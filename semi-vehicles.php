<?php

session_start();

include('conn.php');

$ids = explode(',', $_GET['id']);

// Set options for driver
$options = "";
$query = "SELECT id, first_name, last_name FROM semi_drivers WHERE id = ?";
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
if (isset($_POST['semiVehicleSubmit'])) {

	$driver = $vehicleYear = $make = $model = $ownership = $primaryUse = $coverage = $insurance = "";

	foreach ($_POST as $key => $value) {
		$$key = strip_tags( trim($_POST[$key]) );
	}

	//Only store details if driver session contains vehicle driver
	if (isset($_SESSION['drivers'])) {
		if (strpos($_SESSION['drivers'], $driver) !== false) {

			$query = "INSERT INTO semi_vehicles VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?)";

			$stmt = mysqli_stmt_init($conn);

			mysqli_stmt_prepare($stmt, $query);
			mysqli_stmt_bind_param($stmt, 'ssssssss', $driver, $vehicleYear, $make, $model, $ownership, $primaryUse, $coverage, $insurance);

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
		<form action="" class="form" method="post">

			<h2 class="form-title"><?php echo $forms_row['form_two_vehicle']; ?></h2>
			<div class="row vehicle-details">
				
				<div class="four">
					<label for="driver">Driver:</label>
					<select name="driver" id="driver">
						<?php echo $options; ?>
					</select>
				</div>

				<div class="four">
					<label for="vehicleYear">Vehicle Year:</label>
					<select name="vehicleYear" id="vehicleYear" required>
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
						<option value="Pleasure/Personal use">Pleasure/Personal use</option>
						<option value="Business/Commercial">Business/Commercial</option>
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
					<label for="insurance"> Current Insurance Company (Optional):</label>
					<input type="text" id="insurance" name="insurance">
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
				<button type="submit" class="submitBtn" name="semiVehicleSubmit">Submit</button>
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

			 /* ===== Phone ===== */
			 $("[name=phone]").on('keyup', function (e) {
                 if ( /[0-9-]/.test( this.value.substr(-1) ) === false ) {
                     this.value = this.value.slice(0,-1);
                     return false;
                 } else {
                     this.value = this.value.replace(/^(\d{3})(\d)/, '$1-$2')
                                 .replace(/^(\d{3}-\d{3})(\d)/, '$1-$2');
                 }
             });

			/* ===== Address===== */
			$("#zip").on('change keyup', function() {
				const zip = $(this).val();
				const url = `https://maps.googleapis.com/maps/api/geocode/json?address=${zip}&key=AIzaSyAkV84Xk5gHRpupQUNDMgdEMEXy-6RbGRI`;

				if (zip.length !== 5 || $.isNumeric(zip) === false) {
					return false;
				} else {
					$.ajax({
						url: url,
						success: function(data) {
							$('#address').val(data.results[0].formatted_address);
						}
					})
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
