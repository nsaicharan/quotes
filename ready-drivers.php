<?php

session_start();

// Handle submit
if (isset($_POST['submit'])) {

	include('conn.php');

	// Group
	if ( !isset($_GET['group']) ) {
		$query = "SELECT group_id FROM ready_drivers ORDER BY id DESC";
		$result = mysqli_query($conn, $query);
		$prevGroupID = mysqli_fetch_array($result)['group_id'];
		$groupID = (int)$prevGroupID + 1;
		
		$_SESSION['group'] = $groupID;

	} else {
		$groupID = $_GET['group'];

		if ( $groupID != $_SESSION['group'] ) {
			header("Location: ready-drivers.php");
			exit();
		}
	}

	$firstName = $lastName = $gender = $email = $phone = $address = $maritalStatus = $student = $zip = $street = $cityState = $residence = $licence = $licenceState = $licenceAge = $dobMonth = $dobDate = $dobYear = $licenceSuspended = $driverFinancialForm = $speedingTickets = $duiDWI = "";


	foreach ($_POST as $key => $value) {
		$$key = strip_tags( trim($_POST[$key]) );
	}

	$status = "In Progress";
	$query = "INSERT INTO ready_drivers VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '$status')";

	$stmt = mysqli_stmt_init($conn);

	mysqli_stmt_prepare($stmt, $query);
	mysqli_stmt_bind_param($stmt, 'ssssssssssssssssssssss', $groupID, $firstName, $lastName, $gender, $email, $phone, $student, $maritalStatus, $residence, $zip, $street, $cityState, $licence, $licenceState, $licenceAge, $dobMonth, $dobDate, $dobYear, $speedingTickets, $duiDWI, $licenceSuspended, $driverFinancialForm);

	if ( mysqli_stmt_execute($stmt) ) {

        //Create CSV
		$filename = 'csvfile.csv';
		$file = fopen($filename, 'w');
		fputcsv($file, array('Group ID', 'First Name', 'Last Name', 'Gender', 'Email', 'Phone', 'Student?', 'Marital Status', 'Residence', 'ZIP', 'Street Address', 'City, State, Country', 'Licence No.', 'Licence State', 'Licence Age', 'DOB Month', 'DOB Date', 'DOB Year', 'Tickets/Accidents?', 'DUI/DWI?', 'Suspended/Revoked?', 'SR/22?'));
		fputcsv( $file, array_merge( array($groupID), $_POST) );
		fclose($file);

    	//Get the email of operator
		$query = "SELECT email FROM users WHERE username = 'operator'";
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_array($result);
		$operatorEmail = $row['email'];

    	//Set Message
		$message = "<p>Hi there, someone submitted their information via <b>Ready To Buy</b> form.</p>";
		$message .= "<b>Details:</b> <br>
						 <ul>
						 	<li>Group ID - $groupID</li>
							<li>First Name - $firstName</li>
							<li>Last Name - $lastName</li>
							<li>Gender - $gender</li>
							<li>Email - $email</li>
							<li>Phone - $phone</li>
							<li>Student? - $student</li>
							<li>Marital Status - $maritalStatus</li>
							<li>Residence - $residence</li>
							<li>ZIP   - $zip</li>
							<li>Street Address - $street</li>
							<li>Driver Licence Number - $licence</li>
							<li>Driver's License State - $licenceState</li>
							<li>Age First Licensed - $licenceAge</li>
							<li>Driver DOB - $dobMonth/$dobDate/$dobYear</li>
							<li>Tickets/Accidents? - $speedingTickets</li>
							<li>DUI/DWI - $duiDWI</li>
							<li>Suspended/Revoked? - $licenceSuspended</li>
							<li>SR/22? - $driverFinancialForm</li>
						 </ul>
						";
		$message .= "<p>You can view other details in the admin panel.</p>";

		//Send Email
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

		//Fetch the ID of driver from the db
		$query = "SELECT id FROM ready_drivers ORDER BY id DESC";
		$result = mysqli_query($conn, $query);
		$idRow = mysqli_fetch_assoc($result);
		$id = $idRow['id'];

		$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$escaped_url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');


    	//Redirection
    	if ($_POST['anotherDriver'] == "Yes") {

    		//Used to change form title
    		$_SESSION['anotherDriver'] = "Yes";

			if (isset($_GET['id'])) {

				$ids = $_GET['id'] . ",$id";

				$escaped_url = explode('?', $escaped_url)[0];

				header("Location: $escaped_url?id=$ids&group=$groupID");
				exit();

			} else {
				header("Location: $escaped_url?id=$id&group=$groupID");
				exit();
			}

		} else {

			//Used to change form title
    		unset($_SESSION['anotherDriver']);

			if (isset($_GET['id'])) {
				$ids = $_GET['id'] . ",$id";

			 	//Set session drivers for future reference
				$_SESSION['drivers'] = $ids;

				$escaped_url = explode('?', $escaped_url)[0];

				header("Location: ready-vehicles.php?id=$ids&group=$groupID");
				exit();
			} else {
			 	//Set session drivers for future reference
				$_SESSION['drivers'] = $id;

				header("Location: ready-vehicles.php?id=$id&group=$groupID");
				exit();
			}
		}
	} else {
		echo "Something went wrong!";
	}
}

?>

<?php include('header.php'); ?>

	<div class="wrapper">

		<form action="" method="post" class="form">
			
			<h2 class="form-title">
				<?php
					if ( isset($_SESSION['anotherDriver']) ) {
						echo "Other Driver";
						unset($_SESSION['anotherDriver']);
					} else {
						echo $forms_row['form_three_driver'];
					}
				?>
			</h2>

			<div class="row driver-details">

				<div class="four">
					<label for="firstName">First Name:</label>
					<input type="text" name="firstName" id="firstName" required>
				</div>

				<div class="four">
					<label for="lastName">Last Name:</label>
					<input type="text" name="lastName" id="lastName" required>
				</div>

				<div class="four">
					<label for="gender">Gender:</label>
					<select name="gender" id="gender" required>
						<option disabled selected value="">
							-- Select --
						</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
				</div>

				<div class="four">
					<label for="email">Email:</label>
					<input type="email" name="email" id="email" required>
				</div>

				<div class="four">
					<label for="phone">Phone Number:</label>
					<input type="tel" name="phone" id="phone" placeholder="XXX-XXX-XXXX" title="XXX-XXX-XXXX" pattern="\d{3}[\-]\d{3}[\-]\d{4}" maxlength="12" required>
				</div>

				<div class="four">
					<label for="student">Student?</label>
					<select name="student" id="student" required>
						<option disabled selected value="">
							-- Select --
						</option>
						<option value="Current student with 3.0 or better">Current student with 3.0 or better</option>
						<option value="Recent graduate with 3.0 or better">Recent graduate with 3.0 or better</option>
						<option value="Not a current student">Not a current student</option>
					</select>
				</div>

				<div class="four">
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

				<div class="four">
					<label for="residence">Residence:</label>
					<select name="residence" id="residence" required>
						<option disabled selected value="">
							-- Select --
						</option>
						<option value="Own">Own</option>
						<option value="Rent">Rent</option>
						<option value="Other">Other</option>
					</select>
				</div>

				<div class="four">
					<label for="zip">ZIP Code:</label>
					<input type="text" name="zip" id="zip" pattern="[0-9]{5}" maxlength="5" title="Five-Digit ZIP Code" required>
				</div>

				<div class="four">
                    <label for="street">Street Address:</label>
                    <input type="text" id="street" name="street" required>
                </div>

                <div class="four">
                    <label for="cityState">City, State, Country:</label>
                    <input type="text" id="cityState" name="cityState" required>
                </div>

				<div class="four">
					<label for="licence">Driver Licence Number:</label>
					<input type="text" name="licence" id="licence" required>
				</div>

				<div class="four">
					<label for="licenceState">Driver's License State:</label>
					<select name="licenceState" id="licenceState" required>
						<option disabled selected value="">
							-- Select --
						</option>
                        <option value="Alabama">Alabama</option>
						<option value="Alaska">Alaska</option>
						<option value="Arizona">Arizona</option>
						<option value="Arkansas">Arkansas</option>
						<option value="California">California</option>
						<option value="Colorado">Colorado</option>
						<option value="Connecticut">Connecticut</option>
						<option value="Delaware">Delaware</option>
						<option value="District Of Columbia">District Of Columbia</option>
						<option value="Florida">Florida</option>
						<option value="Georgia">Georgia</option>
						<option value="Hawaii">Hawaii</option>
						<option value="Idaho">Idaho</option>
						<option value="Illinois">Illinois</option>
						<option value="Indiana">Indiana</option>
						<option value="Iowa">Iowa</option>
						<option value="Kansas">Kansas</option>
						<option value="Kentucky">Kentucky</option>
						<option value="Louisiana">Louisiana</option>
						<option value="Maine">Maine</option>
						<option value="Maryland">Maryland</option>
						<option value="Massachusetts">Massachusetts</option>
						<option value="Michigan">Michigan</option>
						<option value="Minnesota">Minnesota</option>
						<option value="Mississippi">Mississippi</option>
						<option value="Missouri">Missouri</option>
						<option value="Montana">Montana</option>
						<option value="Nebraska">Nebraska</option>
						<option value="Nevada">Nevada</option>
						<option value="New Hampshire">New Hampshire</option>
						<option value="New Jersey">New Jersey</option>
						<option value="New Mexico">New Mexico</option>
						<option value="New York">New York</option>
						<option value="North Carolina">North Carolina</option>
						<option value="North Dakota">North Dakota</option>
						<option value="Ohio">Ohio</option>
						<option value="Oklahoma">Oklahoma</option>
						<option value="Oregon">Oregon</option>
						<option value="Pennsylvania">Pennsylvania</option>
						<option value="Rhode Island">Rhode Island</option>
						<option value="South Carolina">South Carolina</option>
						<option value="South Dakota">South Dakota</option>
						<option value="Tennessee">Tennessee</option>
						<option value="Texas">Texas</option>
						<option value="Utah">Utah</option>
						<option value="Vermont">Vermont</option>
						<option value="Virginia">Virginia</option>
						<option value="Washington">Washington</option>
						<option value="West Virginia">West Virginia</option>
						<option value="Wisconsin">Wisconsin</option>
						<option value="Wyoming">Wyoming</option>
                    </select>
				</div>

				<div class="four">
					<label for="licenceAge">Age First Licensed:</label>
					<input type="number" name="licenceAge" id="licenceAge" min="16" max="100" value="16" required>
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
				<button type="submit" class="submitBtn" name="submit">Continue</button>
			</div>
		</form>
	</div> <!-- wrapper -->

</main>

<?php include('footer.php');?>

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

			/* ===== City, State, Country ===== */
            $("#zip").on('change keyup', function() {
                const zip = $(this).val();
                const url = `https://maps.googleapis.com/maps/api/geocode/json?address=${zip}&key=AIzaSyAkV84Xk5gHRpupQUNDMgdEMEXy-6RbGRI`;

                if (zip.length !== 5 || $.isNumeric(zip) === false) {
                    return false;
                } else {
                    $.ajax({
                        url: url,
                        success: function(response) {
                            const data = response.results[0].formatted_address.replace(` ${zip}`, '');
                            $('#cityState').val(data);
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

		});
	</script>

</body>
</html>
