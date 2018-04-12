<?php

	session_start();

	if (!$_SESSION['loggedInUser']) {
		header("Location: index.php");
		exit();

	} else {

		if ( isset($_POST['key']) ) {

			include('../conn.php');

			//STATUS
			if ( $_POST['key'] == 'statusUpdate') {

				$id = mysqli_real_escape_string($conn, $_POST['id']);
				$status = mysqli_real_escape_string($conn, $_POST['status']);
				$table = mysqli_real_escape_string($conn, $_POST['table']);

				$query = "UPDATE $table SET status = '$status' WHERE id = '$id' LIMIT 1";
	    		$result = mysqli_query($conn, $query);

	    		if($result) {
					$_SESSION['status'] = "$id";

					if ($status == 'Sell Back') {

						if ($table == 'quick') {
							$form = 'Just Curious';
						} else if ($table == 'semi') {
							$form = 'Semi Interested';
						} else {
							$form = 'Ready To Buy';
						}

						$offeror = $_SESSION['loggedInUser'];
						$info = "ID - " . "$id, Form - $form";

						//Store the details
						$query = "INSERT INTO sellback (info, offeror) VALUES('$info', '$offeror')";
						$result = mysqli_query($conn, $query);

						//Get the email address of operator
						$query = "SELECT email FROM users WHERE username = 'operator'";
						$result = mysqli_query($conn, $query);
						$row = mysqli_fetch_array($result);
						$operatorEmail = $row['email'];

						//Send an email to notify operator about the sell back
						$to = $operatorEmail;
						$subject = "New Sell Back Offer";
						$message =  "<p>Hi there, <b style='text-transform: capitalize;'>$offeror</b> wants to sell back a lead to you.</p>";
						$message .= "<ul> <li>Lead ID - $id</li> <li>Form - $form</li> </ul>";
						$message .= "<p>You can accept or reject this offer by logging into your admin area.</p>";
						$headers = "From: Sai <hi@saicharan.me>\r\n";
						$headers .= "Reply-To: noreply@saicharan.me\r\n";
						$headers .= "Content-type: text/html\r\n";

						if ( mail($to, $subject, $message, $headers) ) {
							echo 'statusSuccess';
						} else {
						    echo "Mail NOT sent!";
						}
					} else {
						echo 'statusSuccess';
					}

				} else {
					echo mysqli_error($conn);
				}

			}

			//SELL BACK RESPONSE
			if ( $_POST['key'] == 'sellbackResponse' ) {
				$sellbackID = mysqli_real_escape_string($conn, $_POST['sellbackID']);
				$leadInfo = mysqli_real_escape_string($conn, $_POST['leadInfo']);
				$offeror = mysqli_real_escape_string($conn, $_POST['offeror']);
				$response = mysqli_real_escape_string($conn, $_POST['response']);
				$responseMessage = $_POST['message'];
				$responseMessageEsc = mysqli_real_escape_string($conn, $_POST['message']);

				//Store operator's response
				$query = "UPDATE sellback set response = '$response', message = '$responseMessageEsc' WHERE id = '$sellbackID'";
				$result = mysqli_query($conn, $query);

				if ($result) {

					//Get email of the offeror
					$query = "SELECT email FROM users WHERE username = '$offeror'";
					$result = mysqli_query($conn, $query);
					$row = mysqli_fetch_array($result);
					$offerorEmail = $row['email'];

					if ( !empty($responseMessage) ) {
						$responseMessage = "<b><u>Message:</u></b> <br>". nl2br($responseMessage);
					}

					//Send an email about operator's response to offeror
					$to = $offerorEmail;
					$subject = "Response to your sell back offer";
					$message =  "<p>Your offer has been $response.</p>";
					$message .= "<p><b>Lead Info:</b> $leadInfo.</p>";
					$message .= "$responseMessage";
					$headers = "From: Sai <hi@saicharan.me>\r\n";
					$headers .= "Reply-To: noreply@saicharan.me\r\n";
					$headers .= "Content-type: text/html\r\n";

					if ( mail($to, $subject, $message, $headers) ) {
						$_SESSION['response'] = "$offeror";
						echo 'responseSuccess';
					} else {
					    echo "Mail NOT sent!";
					}

				} else {
					echo mysqli_error($conn);
				}
			}

			//Delete Item
			if ( $_POST['key'] == 'delete' ) {

				$id = mysqli_real_escape_string($conn, $_POST['id']);
				$table = mysqli_real_escape_string($conn, $_POST['table']);

				$query = "DELETE FROM $table WHERE id = '$id' LIMIT 1";
				$result = mysqli_query($conn, $query);

				if ($table == 'ready_vehicles') {
					$query = "DELETE FROM ready_drivers WHERE vehicle = $id";
					$result = mysqli_query($conn, $query);
				}

				if($result) {
					$_SESSION['delete'] = "$id";
					echo 'deleteSuccess';
				} else {
					echo mysqli_error($conn);
				}
			}

			//Delete Selected Items
			if ( $_POST['key'] == 'deleteSelected' ) {

				$table = mysqli_real_escape_string($conn, $_POST['table']);

				foreach($_POST['ids'] as $id) {
					$id = mysqli_real_escape_string($conn, $id);

					$query = "DELETE FROM $table WHERE id = '$id' LIMIT 1";
					$result = mysqli_query($conn, $query);

					if ($table == 'ready_vehicles') {
						$query = "DELETE FROM ready_drivers WHERE vehicle = $id";
						$result = mysqli_query($conn, $query);
					}

					if ($result) {
						$_SESSION['deleteSelected'] .= "$id ";
						echo "deleteSuccess";
					} else {
						echo mysqli_error($conn);
					}
				}
			}

			//BACKGROUND
			if ( $_POST['key'] == 'background' ) {
				$bgXAxis = mysqli_real_escape_string($conn, $_POST['bgXAxis']);
				$bgYAxis = mysqli_real_escape_string($conn, $_POST['bgYAxis']);
				$mobileXAxis = mysqli_real_escape_string($conn, $_POST['mobileXAxis']);
				$mobileYAxis = mysqli_real_escape_string($conn, $_POST['mobileYAxis']);

				$query = "UPDATE bg_logo SET
							bg_xaxis = '$bgXAxis',
							bg_yaxis = '$bgYAxis',
							mobile_bg_xaxis = '$mobileXAxis',
							mobile_bg_yaxis = '$mobileYAxis'
						 ";
				$result = mysqli_query($conn, $query);

				//Large Screens Image
				if ( isset($_FILES['bg']) ) {

				    $file = $_FILES['bg'];
				    $fileName = $_FILES['bg']['name'];
				    $fileTmpName = $_FILES['bg']['tmp_name'];
				    $fileSize = $_FILES['bg']['size'];
				    $fileError = $_FILES['bg']['error'];
				    $fileType = $_FILES['bg']['type'];

				    $fileActualExt = explode('.', $fileName);
				    $fileExt = strtolower(end($fileActualExt));

				    if ($fileError === 0) {
				        $fileNameNew = uniqid('').".".$fileExt;
						$fileDest = '../img/'.$fileNameNew;

				        move_uploaded_file($fileTmpName, $fileDest);

				        //Remove old img
				        $query = "SELECT bg FROM bg_logo";
				        $result = mysqli_query($conn, $query);
				        $oldImg = mysqli_fetch_array($result)['bg'];
				        unlink('../img/'.$oldImg);

				        //Store new img name
				        $query = "UPDATE bg_logo SET bg = '$fileNameNew'";
				        $result = mysqli_query($conn, $query);
					}
				}

				//Mobile Image
				if ( isset($_FILES['mobileBG']) ) {

				    $file = $_FILES['mobileBG'];
				    $fileName = $_FILES['mobileBG']['name'];
				    $fileTmpName = $_FILES['mobileBG']['tmp_name'];
				    $fileSize = $_FILES['mobileBG']['size'];
				    $fileError = $_FILES['mobileBG']['error'];
				    $fileType = $_FILES['mobileBG']['type'];

				    $fileActualExt = explode('.', $fileName);
				    $fileExt = strtolower(end($fileActualExt));

				    if ($fileError === 0) {
				        $fileNameNew = uniqid('').".".$fileExt;
						$fileDest = '../img/'.$fileNameNew;

				        move_uploaded_file($fileTmpName, $fileDest);

				        //Remove old img
				        $query = "SELECT mobile_bg FROM bg_logo";
				        $result = mysqli_query($conn, $query);
				        $oldImg = mysqli_fetch_array($result)['mobile_bg'];
				        unlink('../img/'.$oldImg);

				        //Store new img name
				        $query = "UPDATE bg_logo SET mobile_bg = '$fileNameNew'";
				        $result = mysqli_query($conn, $query);
					}
				}
			}

			//LOGO
			if ( $_POST['key'] == 'logo' ) {

				$logoHeight = mysqli_real_escape_string($conn, $_POST['logoHeight']);
				$logoAltText = mysqli_real_escape_string($conn, $_POST['logoAltText']);

				$query = "UPDATE bg_logo SET logo_height = '$logoHeight', logo_alt_text = '$logoAltText'";
				$result = mysqli_query($conn, $query);

				if (isset ($_FILES['logoImage'])) {

				    $file = $_FILES['logoImage'];
				    $fileName = $_FILES['logoImage']['name'];
				    $fileTmpName = $_FILES['logoImage']['tmp_name'];
				    $fileSize = $_FILES['logoImage']['size'];
				    $fileError = $_FILES['logoImage']['error'];
				    $fileType = $_FILES['logoImage']['type'];

				    $fileActualExt = explode('.', $fileName);
				    $fileExt = strtolower(end($fileActualExt));

				    if ($fileError === 0) {
				        $fileNameNew = uniqid('').".".$fileExt;
				        $fileDest = '../img/'.$fileNameNew;

				        move_uploaded_file($fileTmpName, $fileDest);

				        //Remove old img
				        $query = "SELECT logo FROM bg_logo";
				        $result = mysqli_query($conn, $query);
				        $oldImg = mysqli_fetch_array($result)['logo'];
				        unlink('../img/'.$oldImg);

				        //Store new img name
				        $query = "UPDATE bg_logo SET logo = '$fileNameNew'";
				        $result = mysqli_query($conn, $query);
				    }
				}
			}

			//BUTTONS
			if ( $_POST['key'] == 'btnColors' ) {

				foreach ($_POST as $key => $value) {
					$$key = mysqli_real_escape_string($conn, $_POST[$key]);
				}

				$query = "UPDATE bg_logo SET
								btn_one_color = '$btnOneColor', btn_two_color = '$btnTwoColor', btn_three_color = '$btnThreeColor',
								btn_one_text = '$btnOneText', btn_two_text = '$btnTwoText', btn_three_text = '$btnThreeText',
								btn_one_subtext = '$btnOneSubtext', btn_two_subtext = '$btnTwoSubtext', btn_three_subtext = '$btnThreeSubtext'";
				$result = mysqli_query($conn, $query);

				if (!$result) {
					echo mysqli_error($conn);
				}
			}

			//TRACKING CODE
			if ( $_POST['key'] == 'tracking' ) {

				foreach ($_POST as $key => $value) {
					$$key = mysqli_real_escape_string($conn, $_POST[$key]);
				}

				$query = "UPDATE tracking_code SET g_analytics= '$gAnalytics', fb_chat = '$fbChat', other_scripts = '$otherScripts'";
				$result = mysqli_query($conn, $query);

				if (!$result) {
					echo mysqli_error($conn);
				}
			}

			//SITE INFO
			if ( $_POST['key'] == 'siteInfo' ) {

				$siteTitle = mysqli_real_escape_string($conn, $_POST['siteTitle']);
				$siteDescription = mysqli_real_escape_string($conn, $_POST['siteDescription']);

				$query = "UPDATE bg_logo SET site_title = '$siteTitle', site_description = '$siteDescription'";
				$result = mysqli_query($conn, $query);

				//Large Screens Image
				if ( isset($_FILES['favicon']) ) {

				    $file = $_FILES['favicon'];
				    $fileName = $_FILES['favicon']['name'];
				    $fileTmpName = $_FILES['favicon']['tmp_name'];
				    $fileSize = $_FILES['favicon']['size'];
				    $fileError = $_FILES['favicon']['error'];
				    $fileType = $_FILES['favicon']['type'];

				    $fileActualExt = explode('.', $fileName);
				    $fileExt = strtolower(end($fileActualExt));

				    if ($fileError === 0) {
				        $fileNameNew = uniqid('').".".$fileExt;
						$fileDest = '../img/'.$fileNameNew;

				        move_uploaded_file($fileTmpName, $fileDest);

				        //Remove old img
				        $query = "SELECT favicon FROM bg_logo";
				        $result = mysqli_query($conn, $query);
				        $oldImg = mysqli_fetch_array($result)['bg'];
				        unlink('../img/'.$oldImg);

				        //Store new img name
				        $query = "UPDATE bg_logo SET favicon = '$fileNameNew'";
				        $result = mysqli_query($conn, $query);
					}
				}

				if (!$result) {
					echo mysqli_error($conn);
				}
			}

			//FOOTER
			if ( $_POST['key'] == 'footer' ) {

				$footerColor = mysqli_real_escape_string($conn, $_POST['footerColor']);

				$query = "UPDATE bg_logo SET footer_color = '$footerColor'";
				$result = mysqli_query($conn, $query);

				if (!$result) {
					echo mysqli_error($conn);
				}
			}

			//Add User
			if ( $_POST['key'] == 'addUser' ) {

				$username = mysqli_real_escape_string( $conn, trim($_POST['username']) );
				$password = mysqli_real_escape_string($conn, $_POST['password']);
				$email = mysqli_real_escape_string($conn, $_POST['email']);

				if ( !empty($username) && !empty($password) && !empty($email) ) {

					$query = "SELECT * FROM users WHERE username = '$username'";
					$result = mysqli_query($conn, $query);

					if ( mysqli_num_rows($result) > 0 ) {
						echo 'userExist';
					} else {
						$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

						$query = "INSERT INTO users (username, password, email) VALUES('$username', '$hashedPassword', '$email')";
						$result = mysqli_query($conn, $query);

						if ($result) {
							$_SESSION['userAdded'] = $username;
							echo 'userAdded';
						} else {
							echo mysqli_error($conn);
						}
					}
				}
			}

			//Edit User
			if ( $_POST['key'] == 'editUser' ) {
				$username = mysqli_real_escape_string($conn, $_POST['username']);
				$password = mysqli_real_escape_string($conn, $_POST['password']) ;
				$email = mysqli_real_escape_string($conn, $_POST['email']);

				if ($username != 'operator') {

					if (!empty($password)) {
						$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

						$query = "UPDATE users set password = '$hashedPassword', email = '$email' WHERE username = '$username'";
						$result = mysqli_query($conn, $query);

						if ($result) {
							$_SESSION['userEdited'] = $username;
							echo 'userEdited';
						} else {
							echo mysqli_error($conn);
						}

					}

				} else {
					//When username is operator
					//Allow edit only if loggedin user is operator
					if ($_SESSION['loggedInUser'] == 'operator') {

						if (!empty($password)) {
							$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

							$query = "UPDATE users set password = '$hashedPassword', email = '$email' WHERE username = '$username'";
							$result = mysqli_query($conn, $query);

							if ($result) {
								$_SESSION['userEdited'] = $username;
								echo 'userEdited';
							} else {
								echo mysqli_error($conn);
							}

						}
					}
				}

			}

			//Delete User
			if ( $_POST['key'] == 'deleteUser' ) {
				$username = mysqli_real_escape_string($conn, $_POST['username']);

				if ($username != 'operator') {
					$query = "DELETE FROM users WHERE username = '$username'";
					$result = mysqli_query($conn, $query);

					if ($result) {
						$_SESSION['userDeleted'] = $username;
						echo 'userDeleted';
					} else {
						echo mysqli_error($conn);
					}
				}

			}

		}
	}

 ?>
