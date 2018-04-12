<?php

session_start();

include('conn.php');

$ids = explode(',', $_GET['id']);

// Set options for vehicle
$options = "";
$query = "SELECT id, make FROM ready_vehicles WHERE id = ?";
$stmt = mysqli_stmt_init($conn);
mysqli_stmt_prepare($stmt, $query);
mysqli_stmt_bind_param($stmt, 's', $id);

foreach ($ids as $id) {

	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);
	$vehicle_row = mysqli_fetch_array($result);

	$options .= "<option value='" . $vehicle_row['id'] . "'>" . $vehicle_row['make'] . "</option>";
}

// Handle submit
if (isset($_POST['submit'])) {

	$vehicle = $firstName = $lastName = $gender = $email = $phone = $address = $maritalStatus = $education = $zip = $residence = $licence = $licenceAge = $dobMonth = $dobDate = $dobYear = $licenceSuspended = $driverFinancialForm = $speedingTickets = $duiDWI = $currentInsurance = $currentCompany = $currentAmount = $currentExpireMonth = $currentExpireYear = $currentYearsInsured = $deductible = "";


	foreach ($_POST as $key => $value) {
		$$key = mysqli_real_escape_string($conn, strip_tags($_POST[$key]));
	}

	//Only store details if ready to buy vehicle session contains driver vehicle
	if (isset($_SESSION['vehicle'])) {
		if (strpos($_SESSION['vehicle'], $vehicle) !== false) {

			$query = "INSERT INTO ready_drivers VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

			$stmt = mysqli_stmt_init($conn);

			mysqli_stmt_prepare($stmt, $query);
			mysqli_stmt_bind_param($stmt, 'sssssssssssssssssssssssssss', $vehicle, $firstName, $lastName, $gender, $email, $phone, $education, $maritalStatus, $zip, $residence, $address, $licence, $licenceAge, $dobMonth, $dobDate, $dobYear, $licenceSuspended, $driverFinancialForm, $speedingTickets, $duiDWI, $currentInsurance, $currentCompany, $currentAmount, $currentExpireMonth, $currentExpireYear, $currentYearsInsured, $deductible);

			mysqli_stmt_execute($stmt);
		}
	}

	if (isset($_POST['anotherDriver']) && $_POST['anotherDriver'] == 'No') {
		// Redirect
		header("Location: thankyou");
	}
}
?>

<?php include('header.php'); ?>

	<div class="wrapper">

		<form action="" method="post" class="form">

			<h2 class="form-subtitle">Primary Driver Details</h2>
			<div class="row driver-details">
				<div class="three">
					<label for="vehicle">Vehicle:</label>
					<select name="vehicle" id="vehicle">
						<?php echo $options; ?>
					</select>
				</div>

				<div class="three">
					<label for="firstName">First Name:</label>
					<input type="text" name="firstName" id="firstName" required>
				</div>

				<div class="three">
					<label for="lastName">Last Name:</label>
					<input type="text" name="lastName" id="lastName" required>
				</div>

				<div class="three">
					<label for="gender">Gender:</label>
					<select name="gender" id="gender" required>
						<option disabled selected value="">
							-- Select --
						</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
				</div>

				<div class="three">
					<label for="email">Email:</label>
					<input type="email" name="email" id="email" required>
				</div>

				<div class="three">
					<label for="phone">Phone Number:</label>
					<input type="tel" name="phone" id="phone" placeholder="XXX-XXX-XXXX" title="XXX-XXX-XXXX" pattern="\d{3}[\-]\d{3}[\-]\d{4}" maxlength="12" required>
				</div>

				<div class="three">
					<label for="education">Educational Level:</label>
					<select name="education" id="education" required>
						<option disabled selected value="">
							-- Select --
						</option>
						<option value="Current student with 3.0 or better">Current student with 3.0 or better</option>
						<option value="Recent graduate with 3.0 or better">Recent graduate with 3.0 or better</option>
						<option value="Not a current student">Not a current student</option>
					</select>
				</div>

				<div class="three">
					<label for="maritalStatus">Marital Status:</label>
					<select name="maritalStatus" id="maritalStatus" required>
						<option disabled selected value="">
							-- Select --
						</option>
						<option value="Married">Married</option>
						<option value="Single">Single</option>
						<option value="Single">Single with child</option>
						<option value="Divorced/Separated">Divorced</option>
						<option value="Widowed">Widowed</option>
					</select>
				</div>

				<div class="three">
					<label for="zip">ZIP Code:</label>
					<input type="text" name="zip" id="zip" pattern="\d*" maxlength="5" minlength="5" required>
				</div>

				<div class="three">
					<label for="residence">Residence:</label>
					<select name="residence" id="residence" required>
						<option disabled selected value="">
							-- Select --
						</option>
						<option value="Own">Own</option>
						<option value="Rent/Lease">Rent/Lease</option>
						<option value="Other">Other</option>
					</select>
				</div>

				<div class="six">
					<label for="address">Address:</label>
					<textarea id="address" name="address" required></textarea>
				</div>

				<div class="four">
					<label for="licence">Driver Licence Number:</label>
					<input type="text" name="licence" id="licence" required>
				</div>

				<div class="four">
					<label for="licenceAge">Age First Licensed:</label>
					<input type="number" name="licenceAge" id="licenceAge" min="16" max="100" required>
				</div>

				<div class="four">
					<label for="dobMonth">What's this driver's date of birth?</label>

					<div class="driver-dob">
						<select name="dobMonth" id="dobMonth" class="dob" required>
							<option disabled selected value="">Month </option>
							<option value="1">January</option>
							<option value="2">February</option>
							<option value="3">March</option>
							<option value="4">April</option>
							<option value="5">May </option>
							<option value="6">June</option>
							<option value="7">July</option>
							<option value="8">August</option>
							<option value="9">September</option>
							<option value="10">October</option>
							<option value="11">November</option>
							<option value="12">December</option>
						</select>

						<select name="dobDate" id="dobDate" class="dob" required>
							<option disabled selected value="">Date</option>
							<option value="1">1</option>
							<option value="2">2</option>
							<option value="3">3</option>
							<option value="4">4</option>
							<option value="5">5</option>
							<option value="6">6</option>
							<option value="7">7</option>
							<option value="8">8</option>
							<option value="9">9</option>
							<option value="10">10</option>
							<option value="11">11</option>
							<option value="12">12</option>
							<option value="13">13</option>
							<option value="14">14</option>
							<option value="15">15</option>
							<option value="16">16</option>
							<option value="17">17</option>
							<option value="18">18</option>
							<option value="19">19</option>
							<option value="20">20</option>
							<option value="21">21</option>
							<option value="22">22</option>
							<option value="23">23</option>
							<option value="24">24</option>
							<option value="25">25</option>
							<option value="26">26</option>
							<option value="27">27</option>
							<option value="28">28</option>
							<option value="29">29</option>
							<option value="30">30</option>
							<option value="31">31</option>
						</select>

						<select name="dobYear" id="dobYear" class="dob" required>
							<option value="" selected disabled>Year</option>
						</select>
					</div> <!-- driver-dob -->
				</div>

				<div class="four">
					<span class="span-padding">Any tickets/accidents within the last 3 years?</span>

					<div class="radios">
						<label>
							<input type="radio" name="speedingTickets" value="Yes" required>
							Yes
						</label>
						<label>
							<input type="radio" name="speedingTickets" value="No" required>
							No
						</label>
					</div>
				</div>

				<div class="four">
					<span class="span-padding">Any DUI/DWI in the past 5 years?
					</span>

					<div class="radios">
						<label>
							<input type="radio" name="duiDWI" value="Yes" required>
							Yes
						</label>
						<label>
							<input type="radio" name="duiDWI" value="No" required>
							No
						</label>
					</div>
				</div>

				<div class="four">
					<span class="span-padding">Need SR/22?</span>

					<div class="radios">
						<label>
							<input type="radio" name="driverFinancialForm" value="Yes" required>
							Yes
						</label>
						<label>
							<input type="radio" name="driverFinancialForm" value="No" required>
							No
						</label>
					</div>
				</div>

				<div class="four">
					<span class="span-padding">Has driver license been suspended/revoked in the last 5 years?</span>

					<div class="radios">
						<label>
							<input type="radio" name="licenceSuspended" value="Yes" required>
							Yes
						</label>
						<label>
							<input type="radio" name="licenceSuspended" value="No" required>
							No
						</label>
					</div>
				</div>

				<div class="four">
					<span class="span-padding">Do you currently have insurance?
					</span>

					<div class="radios">
						<label>
							<input type="radio" name="currentInsurance" value="Yes" required>
							Yes
						</label>
						<label>
							<input type="radio" name="currentInsurance" value="No" required>
							No
						</label>
					</div>
				</div>

				<div class="four currentInsuranceItem">
					<label for="currentCompany">Current Company?</label>
					<input type="text" name="currentCompany" id="currentCompany" required>
				</div>

				<div class="six currentInsuranceItem">
					<label for="currentAmount">How much do you pay per month OR every 6 months?</label>
					<input type="text" name="currentAmount" id="currentAmount" required>
				</div>

				<div class="three currentInsuranceItem">
					<label for="currentExpireMonth">Expiration Date?</label>

					<div>
						<select name="currentExpireMonth" id="currentExpireMonth" class="half" required>
							<option value="" selected disabled>-- Month --</option>
							<option value="January">January</option>
							<option value="Februay">February</option>
							<option value="March">March</option>
							<option value="April">April</option>
							<option value="May">May </option>
							<option value="June">June</option>
							<option value="July">July</option>
							<option value="August">August</option>
							<option value="Septeber">September</option>
							<option value="October">October</option>
							<option value="November">November</option>
							<option value="December">December</option>
						</select>

						<select name="currentExpireYear" id="currentExpireYear" class="half" required>
							<option value="" selected disabled>-- Year --</option>
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

				<div class="three currentInsuranceItem">
					<label for="currentYearsInsured">Years Insured?</label>
					<select name="currentYearsInsured" id="currentYearsInsured" required>
						<option value="" disabled selected>-- Insured Years --</option>
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

				<div class="three currentInsuranceItem">
					<label for="deductible">Deductible:</label>
					<input type="text" name="deductible" id="deductible" required>
				</div>

				<div class="three">
					<span class="span-padding">Add another driver?</span>

					<div class="radios">
						<label>
							<input type="radio" name="anotherDriver" value="Yes" required>
							Yes
						</label>
						<label>
							<input type="radio" name="anotherDriver" value="No" required>
							No
						</label>
					</div>
				</div>

			</div> <!-- Driver Details -->

			<div class="text-center">
				<button type="submit" class="submitBtn" name="submit">Submit</button>
			</div>
		</form>
	</div> <!-- wrapper -->

</main>

<?php include('footer.php'); ?>

	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

	<script>

		$(document).ready(function() {

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

			/* ===== Driver Years ===== */
			let options = '';
			let year = new Date().getFullYear() - 16;
			const lastYear = year - 100;

			for (year; year >= lastYear; year--) {
				options += `<option value="${year}">${year}</option>`;
			}
			$("[name=dobYear]").append(options);

            /* ===== Current Insurance ===== */
            if ($("input[name=currentInsurance]")[0].checked) {
                $(".currentInsuranceItem").show();
                $(".currentInsuranceItem input").prop("disabled", false);
                $(".currentInsuranceItem select").prop("disabled", false);
            } else {
                $(".currentInsuranceItem").hide();
                $(".currentInsuranceItem input").prop('disabled', true);
                $(".currentInsuranceItem select").prop('disabled', true);
            }

            $("input[name=currentInsurance]").change(function() {
                if (this.value == 'Yes') {
                    $(".currentInsuranceItem").fadeIn();
                    $(".currentInsuranceItem input").prop("disabled", false);
                    $(".currentInsuranceItem select").prop("disabled", false);
                } else {
                    $(".currentInsuranceItem").fadeOut('fast');
                    $(".currentInsuranceItem input").prop('disabled', true);
                    $(".currentInsuranceItem select").prop('disabled', true);
                }
            });

            $("input[name=anotherDriver]").change(function() {
                if (this.value == 'Yes') {
                    $("button[type=submit]").text('Continue');
                } else {
                   $("button[type=submit]").text('Submit');
                }
            });

		});
	</script>

	<!-- FB CHAT -->
	<?php echo $tracking_row['fb_chat']; ?>

</body>
</html>
