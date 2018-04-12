<?php

session_start();


if (isset($_POST['semiDriverSubmit'])) {

	include('conn.php');

	// Group
	if ( !isset($_GET['group']) ) {
		$query = "SELECT group_id FROM semi_drivers ORDER BY id DESC";
		$result = mysqli_query($conn, $query);
		$prevGroupID = mysqli_fetch_array($result)['group_id'];
		$groupID = (int)$prevGroupID + 1;
		
		$_SESSION['group'] = $groupID;

	} else {
		$groupID = $_GET['group'];

		if ( $groupID != $_SESSION['group'] ) {
			header("Location: semi-drivers.php");
			exit();
		}
	}

	$firstName = $lastName = $gender = $email = $phone = $student = $maritalStatus = $zip = $residence = $street = $address = $driverFinancialForm = "";

	foreach ($_POST as $key => $value) {
		$$key = strip_tags( trim($_POST[$key]) );
	}


	//Store data
	$status = "In Progress";
	$query = "INSERT INTO semi_drivers VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, '$status')";
	$stmt = mysqli_stmt_init($conn);

	mysqli_stmt_prepare($stmt, $query);
	mysqli_stmt_bind_param($stmt, 'sssssssssssss', $groupID, $firstName, $lastName, $gender, $email, $phone, $student, $maritalStatus, $residence, $zip, $street, $cityState, $driverFinancialForm);

	if ( mysqli_stmt_execute($stmt) ) {

        //Create CSV
		$filename = 'csvfile.csv';
		$file = fopen($filename, 'w');
		fputcsv($file, array('Group ID', 'First Name', 'Last Name', 'Gender', 'Email', 'Phone', 'Student?', 'Marital Status', 'Residence', 'ZIP', 'Street Address', 'City, State, Country', 'SR/22'));
		fputcsv( $file, array_merge( array($groupID), $_POST) );
		fclose($file);

    	//Get the email of operator
		$query = "SELECT email FROM users WHERE username = 'operator'";
		$result = mysqli_query($conn, $query);
		$row = mysqli_fetch_array($result);
		$operatorEmail = $row['email'];

    	//Set Message
		$message = "<p>Hi there, someone submitted their information via <b>Semi Interested</b> form.</p>";
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
							<li>City, State, Country - $cityState</li>
							<li>SR/22 - $driverFinancialForm</li>
						 </ul>
						";
		$message .= "<p>You can also view these details in your admin panel.</p>";

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
		$query = "SELECT id FROM semi_drivers ORDER BY id DESC";
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

				header("Location: semi-vehicles.php?id=$ids&group=$groupID");
				exit();
			} else {
			 	//Set session drivers for future reference
				$_SESSION['drivers'] = $id;

				header("Location: semi-vehicles.php?id=$id&group=$groupID");
				exit();
			}
		}
		
	}
}
?>

<?php include('header.php'); ?>

	<div class="wrapper">
		<form action="" class="form" method="post">

			<h2 class="form-title">
				<?php
					if ( isset($_SESSION['anotherDriver']) ) {
						echo "Other Driver";
						unset($_SESSION['anotherDriver']);
					} else {
						echo $forms_row['form_two_driver'];
					}
				?>
			</h2>
			<div class="row driver-details">
				<div class="four">
					<label for="firstName">First Name:</label>
					<input type="text" id="firstName" name="firstName" required>
				</div>

				<div class="four">
					<label for="lastName">Last Name:</label>
					<input type="text" id="lastName" name="lastName" required>
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
					<input type="email" id="email" name="email" required>
				</div>

				<div class="four">
					<label for="phone">Phone Number:</label>
					<input type="tel" id="phone" name="phone" placeholder="XXX-XXX-XXXX" title="XXX-XXX-XXXX" pattern="\d{3}[\-]\d{3}[\-]\d{4}" maxlength="12" required>
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
					<input type="text" id="zip" name="zip" pattern="[0-9]{5}" maxlength="5" title="Five-Digit ZIP Code" required>
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
				<button type="submit" class="submitBtn" name="semiDriverSubmit">Continue</button>
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

		});

	</script>

</body>
</html>
