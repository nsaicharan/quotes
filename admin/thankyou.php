<?php 
	session_start(); 

	// if (!$_SESSION['loggedInUser']) {
	// 	header("Location: index.php");
	// }

	include('../conn.php');

	$message = '';

	$hero_query = "SELECT * FROM thankyou";
	$hero_result = mysqli_query($conn, $hero_query);
	$hero_row = mysqli_fetch_array($hero_result);

	$icon_query = "SELECT * FROM social_icons";
	$icon_result = mysqli_query($conn, $icon_query);
	$icon_row = mysqli_fetch_all($icon_result);

	$tracking_query = "SELECT * FROM tracking_code";
	$tracking_result = mysqli_query($conn, $tracking_query);
	$tracking_row = mysqli_fetch_array($tracking_result);
	

	$dummy = "You will soon receive quotes from your local agents in your area so you don't have to talk to a machine or someone who lives far away.";

	if (isset($_POST['update'])) {
		$title = mysqli_real_escape_string($conn, $_POST['title']);
		$message = mysqli_real_escape_string($conn, $_POST['message']);
		$xAxis = mysqli_real_escape_string($conn, $_POST['xAxis']);
		$yAxis = mysqli_real_escape_string($conn, $_POST['yAxis']);
		
		$query = "UPDATE thankyou SET title = '$title', message = '$message', image_xaxis = '$xAxis', image_yaxis = '$yAxis'";
		$result = mysqli_query($conn, $query);

		//ICONS
		$facebookDisplay = mysqli_real_escape_string($conn, $_POST['facebookDisplay']);
		$facebookURL = mysqli_real_escape_string($conn, $_POST['facebookURL']);
		$query = "UPDATE social_icons SET display = '$facebookDisplay', url = '$facebookURL' WHERE id = 1";
		$result = mysqli_query($conn, $query);

		$twitterDisplay = mysqli_real_escape_string($conn, $_POST['twitterDisplay']);
		$twitterURL = mysqli_real_escape_string($conn, $_POST['twitterURL']);
		$query = "UPDATE social_icons SET display = '$twitterDisplay', url = '$twitterURL' WHERE id = 2";
		$result = mysqli_query($conn, $query);

		$youtubeDisplay = mysqli_real_escape_string($conn, $_POST['youtubeDisplay']);
		$youtubeURL = mysqli_real_escape_string($conn, $_POST['youtubeURL']);
		$query = "UPDATE social_icons SET display = '$youtubeDisplay', url = '$youtubeURL' WHERE id = 3";
		$result = mysqli_query($conn, $query);

		$googleDisplay = mysqli_real_escape_string($conn, $_POST['google+Display']);
		$googleURL = mysqli_real_escape_string($conn, $_POST['google+URL']);
		$query = "UPDATE social_icons SET display = '$googleDisplay', url = '$googleURL' WHERE id = 4";
		$result = mysqli_query($conn, $query);

		$linkedinDisplay = mysqli_real_escape_string($conn, $_POST['linkedinDisplay']);
		$linkedinURL = mysqli_real_escape_string($conn, $_POST['linkedinURL']);
		$query = "UPDATE social_icons SET display = '$linkedinDisplay', url = '$linkedinURL' WHERE id = 5";
		$result = mysqli_query($conn, $query);

		//Tracking Code
		$fbPixel = mysqli_real_escape_string($conn, $_POST['fbPixel']);
		$gAnalytics = mysqli_real_escape_string($conn, $_POST['gAnalytics']);
		$query = "UPDATE tracking_code set fb_pixel = '$fbPixel', g_analytics = '$gAnalytics'";
		$result = mysqli_query($conn, $query);

		if ($result) {
			$message = '<div class="alert alert-success">Data Successfully Updated! <button class="close" data-dismiss="alert">&times;</button></div>';

			$hero_query = "SELECT * FROM thankyou";
			$hero_result = mysqli_query($conn, $hero_query);
			$hero_row = mysqli_fetch_array($hero_result);

			$icon_query = "SELECT * FROM social_icons";
			$icon_result = mysqli_query($conn, $icon_query);
			$icon_row = mysqli_fetch_all($icon_result);

			$tracking_query = "SELECT * FROM tracking_code";
			$tracking_result = mysqli_query($conn, $tracking_query);
			$tracking_row = mysqli_fetch_array($tracking_result);
		} else {
			$message = '<div class="alert alert-danger">Update Failed! <button class="close" data-dismiss="alert">&times;</button></div>';
		}

		//Image File
		if (isset ($_FILES['image'])) {
	        $file = $_FILES['image'];

	        $fileName = $_FILES['image']['name'];
	        $fileTmpName = $_FILES['image']['tmp_name'];
	        $fileSize = $_FILES['image']['size'];
	        $fileError = $_FILES['image']['error'];
	        $fileType = $_FILES['image']['type'];

	        $fileExt = explode('.', $fileName);
	        $fileActualExt = strtolower(end($fileExt));

	        $allowed = array('jpg', 'jpeg', 'png', 'gif', 'svg', 'webp');

	        if (in_array($fileActualExt, $allowed)) {
	            if ($fileError === 0) {
	                $fileNameNew = uniqid('').".".$fileActualExt;

	                $fileDest = '../thankyou/img/'.$fileNameNew;

	                move_uploaded_file($fileTmpName, $fileDest);

	                $query = "UPDATE thankyou SET image = '$fileNameNew'";
	                $result = mysqli_query($conn, $query);

	                if ($result) {
	                	$message = '<div class="alert alert-success">Image uploaded and data successfully updated! <button class="close" data-dismiss="alert">&times;</button></div>';
	                } else {
	                	$message = '<div class="alert alert-danger">Something went wrong while uploading the image! <button class="close" data-dismiss="alert">&times;</button></div>';
	                }
	            }
	        }
	    }
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Thank You Page</title>
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.css">
    <link href="https://fonts.googleapis.com/css?family=Mate+SC|Roboto:300,400,700|Satisfy|Open+Sans:400,700,300" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

	<style type="text/css">

		body {
			background: #f3f3f3;
			background: hsl(48, 100%, 67%);
		}
		button {
			cursor: pointer;
		}

		/* === Start Navbar === */
		.container--nav {
			padding: 0;
		}

		.mr-onepx {
			margin-right: 1px;
		}

		.mr-twopx {
			margin-right: 2px;
		}

		.navbar {
			padding: 0 1rem .16rem;
			box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
		    background-color: #fff;
		    margin-bottom: 30px;
		    font-family: 'Open Sans', sans-serif;
		}

		 .nav-link {
			color: rgba(0, 0, 0, .7);
		}

		.nav-link:hover,
		.nav-link:focus {
			color: rgba(0, 0, 0, 1);
		}

		.navbar-brand {
			font-size: 2rem;
			color: #007bff !important;
			font-family: 'Mate SC', serif;
		}

		@media (max-width: 767px) {
			.navbar {
				padding: 0 1rem;
			}

			.navbar-brand {
				font-size: 1.8rem;
			}

			.navbar-toggler {
				font-size: 1.1rem;
			}
		}
		/* === End Navbar === */

		.alert {
			width: 90vw;
			max-width: 1170px;
			margin: 10px auto 12px;
		}

		@media (max-width: 480px) {
			.alert {
				width: 95vw;
			}
		}

		h2 {
			font-family: 'Mate SC', satisfy;
			margin: 0 0 20px;
			font-size: 24px;
			background: #011638;
			padding: 12px 0;
			color: white;
			text-align: center;
		}

		.container--thanks {
			width: 1170px;
			max-width: 90vw;
			margin: 0 auto;
			background: white;
			box-shadow: 0 1px 5px rgba(0, 0, 0, .15);
			margin-bottom: 25px;
		}

		@media (max-width: 480px) {
			.container--thanks {
				max-width: 95vw;
			}
		}

		.wrapper {
			padding: 0 20px;
		}

		input[type=file] {
			padding: 25px;
			border: 1px dashed hsl(48, 100%, 67%);
			background: #fbfbfb;
			cursor: pointer;
			width: 100%;
			display: inline-block;
			outline: none;
		}

		.axis-container {
			margin: 23px auto 0;

		}

		.axis-container > * {
			flex: 1;
		}

		@media (max-width: 767px) {
			input[type=file] {
				margin-top: 5px;
			}
			.axis-container {
				margin-top: 5px;
			}
		}

		.update-btn {
			padding: 10px 30px;
			border: none;
			display: inline-block;
			font-weight: 500;
			border-radius: 3px;
			margin: 25px 0;
			font-size: 18px;
		}

		h5 {
			font-family: 'Mate SC';
			font-weight: normal;
			font-size: 24px;
		}

	</style>
</head>
<body>

	<nav class="navbar navbar-expand-lg  static-top">
		<div class="container container--nav">
			<a class="navbar-brand" href="data.php">Data Collection</a>
			<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				Menu
				<i class="fa fa-bars"></i>
			</button>
			<div class="collapse navbar-collapse mt-lg-2" id="navbarResponsive">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="dropdownThemes" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-id-card-o mr-twopx"></i>
							Insurance Listing
						</a>
						<div class="dropdown-menu" aria-labelledby="dropdownThemes">
							<a class="dropdown-item" href="data.php">
								<i class="fa fa-binoculars fa-fw mr-1"></i>
								Just Curious
							</a>
							<a class="dropdown-item" href="semi.php">
								<i class="fa fa-balance-scale fa-fw mr-1"></i>
								Semi Interested
							</a>
							<a class="dropdown-item" href="ready.php">
								<i class="fa fa-handshake-o fa-fw mr-1"></i>
								Ready To Buy
							</a>
						</div>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="thankyou.php" title="Edit thank you page">
							<i class="fa fa-heart-o mr-onepx"></i>
							Thank You
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="bg-logo.php" title="Change background or logo">
							<i class="fa fa-file-image-o mr-twopx"></i>
							Background &amp; Logo
						</a>
					</li>
				</ul>
				<ul class="navbar-nav">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-capitalize" href="#" id="dropdownPremium" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-user-circle-o fa-lg fa-fw"></i>
							Max
						</a>
						<div class="dropdown-menu dropdown-menu-right mb-1" aria-labelledby="dropdownPremium">
							<a class="dropdown-item" href="logout.php">
								<i class="fa fa-sign-out"></i>
								Logout</a>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<?php echo $message; ?>
	
	<div class="container--thanks">
		<h2>Thank You Page</h2>

		<div class="wrapper">

			<form action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data" method="post">
				<div class="form-group">
					<label for="title"><strong>Title:</strong></label>
					<input type="text" class="form-control" name="title" id="title" value="<?php echo $hero_row['title']; ?>">
				</div>

				<div class="form-group">
					<label for="message"><strong>Message:</strong></label>
					<textarea rows="3" class="form-control" name="message" id="message"><?php echo $hero_row['message']; ?></textarea>
				</div>

				<div class="row">
					<div class="col-md-6">
						<div class="form-group">
							<label for="image"><strong>Image:</strong></label>
							<input type="file" accept="image/*" name="image" id="image">
						</div>
					</div>

					<div class="col-md-6 d-flex row axis-container">
						<div class="form-group text-center mr-1">
							<label for="xAxis">X-Axis Position:</label>
							<select class="form-control" name="xAxis">
								<option <?php echo ($hero_row['image_xaxis'] == 'center') ? 'selected' : ''; ?> value="center">Center</option>
								<option <?php echo ($hero_row['image_xaxis'] == 'left') ? 'selected' : ''; ?> value="left">Start From Left</option>
								<option <?php echo ($hero_row['image_xaxis'] == 'right') ? 'selected' : ''; ?> value="right">Start From Right</option>
							</select>
						</div>

						<div class="form-group text-center ml-1">
							<label for="yAxis">Y-Axis Position:</label>
							<select class="form-control" name="yAxis">
								<option <?php echo ($hero_row['image_yaxis'] == 'center') ? 'selected' : ''; ?> value="center">Center</option>
								<option <?php echo ($hero_row['image_yaxis'] == 'top') ? 'selected' : ''; ?> value="top">Start From Top</option>
								<option <?php echo ($hero_row['image_yaxis'] == 'bottom') ? 'selected' : ''; ?> value="bottom">Start From Bottom</option>
							</select>
						</div>
					</div>
				</div>

				<h5 class="mt-5 mb-3 text-center">Social Icons</h5>
					
				<?php for($i=0; $i < mysqli_num_rows($icon_result); $i++) : ?>
				
					<h6 class="text-capitalize mt-2"><strong><?php echo $icon_row[$i][1]; ?></strong></h6>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="<?php echo $icon_row[$i][1] ?>Display">Display: </label>
								<select class="form-control form-control-inline" name="<?php echo $icon_row[$i][1] ?>Display" id="<?php echo $icon_row[$i][1] ?>Display">
									<option value="yes" <?php echo ($icon_row[$i][4] == 'yes') ? 'selected' : ''; ?>>Yes</option>
									<option value="no" <?php echo ($icon_row[$i][4] == 'no') ? 'selected' : ''; ?>>No</option>
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="<?php echo $icon_row[$i][1] ?>URL">URL:</label>
								<input class="form-control" name="<?php echo $icon_row[$i][1] ?>URL" id="<?php echo $icon_row[$i][1] ?>URL" value="<?php echo $icon_row[$i][3]; ?>">
							</div>
						</div>
					</div>

				<?php endfor; ?>
			
				<h5 class="mt-5 text-center">Tracking Code</h5>
				<div class="row mt-sm-2">
					<div class="col-sm-6">
						<h6 class="text-sm-center mt-3">Facebook Pixel</h6>
						<textarea class="form-control" name="fbPixel" id="fbPixel" rows="4">
							<?php echo $tracking_row['fb_pixel']; ?>
						</textarea>
					</div>
					<div class="col-sm-6">
						<h6 class="text-sm-center mt-3">Google Analytics</h6>
						<textarea class="form-control" name="gAnalytics" id="gAnalytics" rows="4">
							<?php echo $tracking_row['g_analytics']; ?>
						</textarea>
					</div>
				</div>

				<button class="update-btn btn-primary" name="update">UPDATE</button>
					
			</form>
		</div>

	</div>
	
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
</body>
</html>