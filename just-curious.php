<?php
if (isset($_POST['curiousSubmit'])) {

    include('conn.php');

    $firstName = $lastName = $email = $phone = $zip = $street = $cityState = $insurance = "";

    foreach ($_POST as $key => $value) {
        $$key = strip_tags( trim($_POST[$key]) );
    }

    //Store data
    $status = 'In Progress';
    $query = "INSERT INTO quick VALUES (NULL, ?, ?, ?, ?, ?, ?, ?, ?, '$status')";
    $stmt = mysqli_stmt_init($conn);

    mysqli_stmt_prepare($stmt, $query);
    mysqli_stmt_bind_param($stmt, "ssssssss", $firstName, $lastName, $email, $phone, $zip, $street, $cityState, $insurance);

    if ( mysqli_stmt_execute($stmt) ) {

        //Create CSV
        $filename = 'csvfile.csv';
        $file = fopen($filename, 'w');
        fputcsv($file, array('First Name', 'Last Name', 'Email', 'Phone', 'ZIP', 'Street Address', 'City, State, Country', 'Cur. Insurance Co.'));
        fputcsv($file, $_POST);
        fclose($file);

        //Get the email of operator
        $query = "SELECT email FROM users WHERE username = 'operator'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
        $operatorEmail = $row['email'];

        //Set Message
        $message = "<p>Hi there, someone submitted their information via <b>Just Curious</b> form.</p>";
        $message .= "<b>Details:</b> <br>
                         <ul>
                            <li>Name    - $firstName $lastName</li>
                            <li>Email   - $email</li>
                            <li>Phone No. - $phone</li>
                            <li>ZIP - $zip</li>
                            <li>Street Address - $street</li>
                            <li>City, State, Country - $cityState</li>
                            <li>Current Insurance Co. - $insurance</li>
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

        //Redirect
        header('Location: thankyou');
    }
}

?>

<?php include('header.php'); ?>

<div class="wrapper">
		<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form form--curious" id="curiousForm">

			<div class="form-header">
				<h2 class="form-header__title"><?php echo $forms_row['form_one_title']; ?></h2>
				<p><?php echo $forms_row['form_one_subtitle']; ?></p>
			</div>

			<div class="row">
				<div class="six">
					<label for="firstName">First Name:</label>
					<input type="text" id="firstName"  name="firstName" required>
				</div>

				<div class="six">
					<label for="lastName">Last Name:</label>
					<input type="text" id="lastName" name="lastName" required>
				</div>

				<div class="six">
					<label for="email">Email:</label>
					<input type="email" id="email" name="email" required>
				</div>

				<div class="six">
					<label for="phone">Phone Number:</label>
					<input type="tel" name="phone" id="phone" placeholder="XXX-XXX-XXXX" title="XXX-XXX-XXXX" pattern="\d{3}[\-]\d{3}[\-]\d{4}" maxlength="12" required>
				</div>

				<div class="six">
					<label for="zip">ZIP Code:</label>
					<input type="text" id="zip" name="zip" pattern="[0-9]{5}" maxlength="5" title="Five-Digit ZIP Code" required>
				</div>

                <div class="six">
                    <label for="street">Street Address:</label>
                    <input type="text" id="street" name="street" required>
                </div>


                <div class="six">
                    <label for="cityState">City, State, Country:</label>
                    <input type="text" id="cityState" name="cityState" required>
                </div>

				<div class="six">
					<label for="insurance">Current Insurance Company (Optional):</label>
					<input type="text" id="insurance" name="insurance">
				</div>

			</div> <!-- row -->

			<div class="text-center">
				<button type="submit" class="submitBtn" name="curiousSubmit">Submit</button>
			</div>
		</form>
	</div>

</main>

<?php include('footer.php'); ?>

	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>

	<script>
       $(document).ready(function () {
            /* ===== Animation ===== */
            $(".form-header p").addClass('zoomIn');

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
