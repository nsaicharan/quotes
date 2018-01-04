<?php 
	
	include('../conn.php');

	$tracking_query = "SELECT * FROM tracking_code";
	$tracking_result = mysqli_query($conn, $tracking_query);
	if ($tracking_result) {
		$tracking_row = mysqli_fetch_array($tracking_result);
	}

	$logo_query = "SELECT * FROM bg_logo";
	$logo_result = mysqli_query($conn, $logo_query);
	if ($logo_result) {
		$logo_row = mysqli_fetch_array($logo_result);
	}

	$hero_query = "SELECT * FROM thankyou";
	$hero_result = mysqli_query($conn, $hero_query);
	if ($hero_result) {
		$hero_row = mysqli_fetch_array($hero_result);
	}

	$icons_query = "SELECT * FROM social_icons WHERE display = 'yes'";
	$icons_result = mysqli_query($conn, $icons_query);
	if ($icons_result) {
		$icons_row = mysqli_fetch_all($icons_result);
	} 

	// Curious
	if ( isset( $_POST['curiousSubmit']) ) {

        $first = $last = $email = $phone = $insurance = "";

        foreach ($_POST as $key => $value) {
   	 		$$key = mysqli_real_escape_string($conn, strip_tags($_POST[$key]));
   	 	}

        $query = "INSERT INTO quick VALUES (NULL, '$firstName', '$lastName', '$email', '$phone', '$insurance')";
        $result = mysqli_query($conn, $query);
    } 

    // Semi Interested
    if ( isset($_POST['semiSubmit']) ) {

    	$vehicleYear = $make = $model = $ownership = $primaryUse = $parking = $zip = $insurance = $coverage = $firstName = $lastName = $email = $phone = $gender = $education = $occupation = $maritalStatus = $residence = $creditEvaluation = $driverFinancialForm = "";

    	foreach ($_POST as $key => $value) {
   	 		$$key = mysqli_real_escape_string($conn, strip_tags($_POST[$key]));
   	 	}

    	$query = "INSERT INTO semi VALUES (NULL, '$vehicleYear', '$make', '$model', '$ownership', '$primaryUse', '$parking', '$zip', '$insurance', '$coverage', '$firstName',' $lastName', '$email', '$phone', '$gender', '$education', '$occupation', '$maritalStatus', '$residence', '$creditEvaluation', '$driverFinancialForm')";
    	
    	$result = mysqli_query($conn, $query);

    	if (!$result) {
    		echo mysqli_error($conn);
    	} 
   	}

   	// Ready To Buy
	if ( isset($_POST['readySubmit']) ) {

		$vehicle = $make = $model = $vin = $ownership = $parking = $primaryUse = $mileage = $zip = $coverage = $insurancePast30 = $insuranceCompany = $expireMonth = $expireYear = $yearsInsured = $injuryLiabilityLimit = $firstName = $lastName = $gender = $email = $phone = $maritalStatus = $occupation = $education = $residence = $licence = $licenceAge = $creditEvaluation = $dobMonth = $dobDate = $dobYear = $licenceSuspended = $driverFinancialForm = $speedingTickets = $duiDWI = $currentInsurance = $currentCompany = $currentAmount = $currentExpireMonth = $currentExpireYear = $currentYearsInsured = $currentLimits = $yourList = $deductible = "";


		foreach ($_POST as $key => $value) {
			$$key = mysqli_real_escape_string($conn, strip_tags($_POST[$key]));
		}
		 
		$query = "INSERT INTO ready VALUES (NULL,'$vehicle', '$make', '$model', '$vin', '$ownership', '$parking', '$primaryUse', '$mileage', '$zip', '$coverage', '$insurancePast30', '$insuranceCompany', '$expireMonth', '$expireYear', '$yearsInsured', '$injuryLiabilityLimit', '$firstName', '$lastName', '$gender', '$email', '$phone', '$maritalStatus', '$occupation', '$education', '$residence', '$licence', '$licenceAge', '$creditEvaluation', '$dobMonth', '$dobDate', '$dobYear', '$licenceSuspended', '$driverFinancialForm', '$speedingTickets', '$duiDWI', '$currentInsurance', '$currentCompany', '$currentAmount', '$currentExpireMonth', '$currentExpireYear', '$currentYearsInsured', '$currentLimits', '$yourList', '$deductible')";

		$result = mysqli_query($conn, $query);

		if (!$result) {
			echo mysqli_error($conn);
		} 
	}
	
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="Max">
	<meta name="description" content="We provide insurance for all types of vehicles.">
	<meta property="og:title" content="Best Vehicle Insurance"/>
	<meta property="og:type" content="article"/>
	<meta property="og:description" content="We provide insurance for all types of vehicles."/>
	<meta property="og:image" content="https://scontent.fhyd6-1.fna.fbcdn.net/v/t1.0-9/10868235_10153068640606473_3992284990222677775_n.jpg?oh=f9ab785ae05fac9548acd1560901e7fa&oe=5AB4A48C"/>

	<meta name="twitter:title" content="Best Vehicle Insurance">
	<meta name="twitter:description" content="We provide insurance for all types of vehicles.">
	<meta name="twitter:image:src" content="https://scontent.fhyd6-1.fna.fbcdn.net/v/t1.0-9/10868235_10153068640606473_3992284990222677775_n.jpg?oh=f9ab785ae05fac9548acd1560901e7fa&oe=5AB4A48C">
	

	<title>Thank You</title>
	<link href="https://fonts.googleapis.com/css?family=Mate+SC|Satisfy|Open+Sans:400,300,700" rel="stylesheet">
	<link rel="stylesheet" href="thankstyles.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

	<?php echo $tracking_row['fb_pixel']; ?>
	<?php echo $tracking_row['g_analytics']; ?>
	
	<style>
		body {
			font-family:  -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
			margin: 0;
			background: #f3f3f3;
		}

		* {
			box-sizing: border-box;
		}
		
		.logo img {
			vertical-align: middle;
			height: <?php echo $logo_row['logo_height']; ?>;
		}

		.hero {
			background: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,.3)), url('img/<?php echo $hero_row['image']; ?>') no-repeat fixed; 
			background-position: <?php echo $hero_row['image_xaxis']; ?> <?php echo $hero_row['image_yaxis']; ?>;
			background-size: cover;
			padding: 130px 20px;
			color: white;
			text-align: center;
		}
		
		h1 {
			font-size: 80px;
			font-weight: 400;
			color: white;
			font-family: 'Mate SC', serif;
			margin-top: 0;
			text-shadow: 0 1px 2px rgba(0,0,0,.15);
			text-align: center;
		}
		
		
		.narrow {
			margin: 0 auto;
			max-width: 800px;
			padding: 0 20px;
		}

		.lead {
			font-size: 1.5rem;
			font-weight: 400;
			line-height: 1.5;
			text-shadow: 0 1px 2px rgba(0,0,0,.15);
			color: white;
		}

		@media (max-width: 768px) {

			.wrapper--nav {
				padding: 10px;
			}

			.hero {
				padding: 80px 0;
			}

			h1 {
				font-size: 16vmin ;
			}

			.narrow {
				margin: 0 auto;
				max-width: 800px;
				padding: 0 18px;
			}

			.lead {
				font-size: 1.2rem;
			}
		}
		
		.muted {
			color: #636c72;
		}

		.social {
			padding: 30px 5px;
		}

		.share-container {
			display: flex;
			justify-content: center;
			margin-top: 25px;
			flex-wrap: wrap;
			text-align: center;
		}

		.share-container i {
			display: inline-block;
			margin-right: 5px;
		}


		.share-fb,
		.share-twitter,
		.share-email {
			display: inline-block;
			margin: 0 10px;
			padding: 10px 20px;
			text-decoration: none;
			color: white;
			border-radius: 3px;
			min-width: 198px;
		}

		@media (max-width: 768px) {
			.share-container {
				display: block;
			}

			.share-fb,
			.share-twitter,
			.share-email {
				margin: 5px 10px;
			}
		}

		.share-email {
			background: #2c3e50;
		}

		.share-fb,
		.fa-facebook {
			background: #3B5998;
		}

		.share-twitter,
		.fa-twitter {
			background: #1DA1F2;
		}

		.fa-google-plus {
			background: #DB4437;
		}

		.fa-linkedin {
			background: #0087be;
		}

		.fa-youtube {
			background: #FF0000;
		}
		.icons-container {
			margin: 40px 0 10px;
		}


		.icons {
			display: flex;
			justify-content: center;
			text-align: center;
			flex-wrap: wrap;
		}

		.icons .fa {
			margin: 0 6px;
			height: 50px;
			width: 50px;
			line-height: 50px;
			border-radius: 50%;
			border: 1px solid white;
			font-size: 20px;
			color: white;
			cursor: pointer;
			transition: .3s ease-out;
		}

		.icons .fa:hover {
			transform: scale(1.15) rotate(360deg);
		}
	</style>
</head>
<body>
	
	<header>
		<div class="wrapper wrapper--nav">
			<div class="logo">
				<a href="../index.php">
					<img alt="<?php echo $logo_row['logo_alt_text']; ?>" src="../img/<?php echo $logo_row['logo']; ?>">
				</a>
			</div>
			<nav>
				<a href="../index.php">Home</a>
				<a href="#">About Us</a>
				<a href="#">FAQ</a>
				<a href="#">Contact</a>
			</nav>
		</div>
	</header>
	
	<div class="hero">
		<div class="narrow">
			<h1><?php echo $hero_row['title']; ?></h1>
			<p class="lead"><?php echo $hero_row['message']; ?></p>
		</div>
	</div>

	<div class="social text-center">
		<h2>Have friends who would like our service? <br> Tell them about it.</h2>

		<div class="share-container">

			<div>
				<a href="https://twitter.com/intent/tweet?source=https%3A%2F%2Fsaicharan.me%2Fmax&text=Max%20Insurance%20Company:%20https%3A%2F%2Fsaicharan.me%2Fmax&via=michaeljackson" target="_blank" class="share-twitter"><i class="fa fa-twitter"></i>  Share on Twitter</a>
			</div>

			<div>
				<a href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fsaicharan.me%2Fmax&quote=Max%20Insurance%20Company" target="_blank" class="share-fb"><i class="fa fa-facebook"></i>  Share on Facebook</a>
			</div>
			
			<div>
				<a class="share-email" href="mailto:?subject=I%20think%20you%20might%20like%20this%20service&body=Hey%20there%2C%20I%20recently%20discovered%20a%20car%20insurance%20company%2C%20check%20out%20this%20-%20https%3A//saicharan.me/max"><i class="fa fa-envelope-o"></i>  Send a quick email</a>
			</div>
		</div>

		<div class="icons-container">
			<p class="muted">- OR -</p>

			<h2>Connect with us on social networks</h2>

			<div class="icons">
				<?php for ($i=0; $i < mysqli_num_rows($icons_result); $i++): ?>
					
					<a href="<?php echo $icons_row[$i][3]; ?>" target="_blank"><i class="<?php echo $icons_row[$i][2]; ?>"></i></a>

				<?php endfor; ?>
			</div>
		</div>

	</div>	
</body>
</html>