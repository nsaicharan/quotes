<?php 

	session_start();
	
	include('conn.php');

	$query = "SELECT * FROM bg_logo";
	$result = mysqli_query($conn, $query);

	if ($result) {
		$row = mysqli_fetch_array($result);
	}

	$tracking_query = "SELECT * FROM tracking_code";
	$tracking_result = mysqli_query($conn, $tracking_query);
	if ($tracking_result) {
		$tracking_row = mysqli_fetch_array($tracking_result);
	}


	if ( isset($_POST['continue']) ) {
		print_r($_POST);

		print_r($_GET);

		$vehicleYear = $make = $model = $vin = $ownership = $parking = $primaryUse = $mileage = $zip = "";

		foreach ($_POST as $key => $value) {
			$$key = mysqli_real_escape_string( $conn, strip_tags($_POST[$key]) );
		}

		$query = "INSERT INTO multi_vehicle VALUES (NULL, '$vehicleYear', '$make', '$model', '$vin', '$ownership', '$parking', '$primaryUse', '$mileage', '$zip')";
		$result = mysqli_query($conn, $query);

		if ($result) {
			echo '<br> Entered! <br>';

			$query = "SELECT id FROM multi_vehicle ORDER BY id DESC";
			$result = mysqli_query($conn, $query);
			$idRow = mysqli_fetch_assoc($result);
			$id = $idRow['id'];

			$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

			
			$escaped_url = htmlspecialchars( $url, ENT_QUOTES, 'UTF-8' );
			echo "URL: " . $url;

			if ( $_POST['anotherCar'] == "Yes" ) {

			echo "SET <br>";
			
				if ( isset($_GET['id']) ) {
					$exisiting_ids = $_GET['id'];

					echo  "Existing IDs: $exisiting_ids" . "<br>";

					$_SESSION['vehicle'] = $exisiting_ids . ",$id";
					$vehicle = $_SESSION['vehicle'];

					$escaped_url = explode( '?', $escaped_url)[0];

					header("Location: $escaped_url?id=$vehicle");

				} else {
					$vehicle = $_SESSION['vehicle'];
					$vehicle = "$id";
					header("Location: $escaped_url?id=$vehicle");
				}
				

			 } else {
			 	echo "NOT SET";

			 	if ( isset($_GET['id']) ) {
			 		$ids = $_GET['id'] . ",$id";

			 		$escaped_url = explode( '?', $escaped_url)[0];

			 		header("Location: drivers.php?id=$ids");
			 	} else {
			 		header("Location: drivers.php?id=$id");
			 	}
			}
 
		} else {
			echo mysqli_error($conn);
		}


	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Multi Step Form</title>

	<link href="https://fonts.googleapis.com/css?family=Mate+SC|Satisfy" rel="stylesheet">
	<link rel="stylesheet" href="style1a.css">

	<?php echo $tracking_row['fb_pixel']; ?>
	<?php echo $tracking_row['g_analytics']; ?>
	
	<style>
		body {
			background-image: linear-gradient(rgba(0,0,0,.5), rgba(0,0,0,.5)), url(img/<?php echo $row['background']; ?>);
			background-position: <?php echo $row['bg_xaxis'] ?> <?php echo $row['bg_yaxis'] ?>;
		}

		.logo img {
			height: <?php echo $row['logo_height']; ?>;
		}
	</style>
</head>

<body>

	<header>
		<div class="wrapper wrapper--nav">
			<div class="logo">
				<a href="index.php"><img alt="<?php echo $row['logo_alt_text']; ?>" src="img/<?php echo $row['logo']; ?>"></a>
			</div>
			<nav>
				<a href="index.php">Home</a>
				<a href="#">About Us</a>
				<a href="#">FAQ</a>
				<a href="#">Contact</a>
			</nav>
		</div>
	</header>

	<div class="wrapper">
		<form method="post" id="readyForm">
			
			<h2 class="form-subtitle text-center">Vehicle Details</h2>
			
			<div class="row vehicle-details">
				<div class="four">
					<label for="vehicle">Vehicle Year:</label>
					<select name="vehicleYear" id="vehicle">
						<option disabled selected value="">
							-- Year --
						</option>
						<option value="2018">2018</option>
						<option value="2017">2017</option>
						<option value="2016">2016</option>
						<option value="2015">2015</option>
						<option value="2014">2014</option>
						<option value="2013">2013</option>
						<option value="2012">2012</option>
						<option value="2011">2011</option>
						<option value="2010">2010</option>
						<option value="2009">2009</option>
						<option value="2008">2008</option>
						<option value="2007">2007</option>
						<option value="2006">2006</option>
						<option value="2005">2005</option>
						<option value="2004">2004</option>
						<option value="2003">2003</option>
						<option value="2002">2002</option>
						<option value="2001">2001</option>
						<option value="2000">2000</option>
					</select>
				</div>

				<div class="four">
					<label for="make">Make:</label>
					<select name="make" id="make">
						<option disabled selected value="">
							-- Select Make --
						</option>
					</select>
				</div>

				<div class="four">
					<label for="model">Model:</label>
					<select name="model" id="model">
						<option disabled selected value="">
							-- Select Model --
						</option>
					</select>
				</div>

				<div class="four">
					<label for="vin">VIN:</label>
					<input type="text" name="vin" id="vin" pattern="[a-zA-Z0-9]+">
				</div>

				<div class="four">
					<label for="ownership">Ownership:</label>
					<select name="ownership" id="ownership">
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
					<select name="parking" id="parking">
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
					<select name="primaryUse" id="primaryUse">
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
					<select name="mileage" id="mileage">
						<option disabled selected value="">
							-- Select --
						</option>
						<option value="0-7500">0-7500</option>
						<option value="7500-15000">7500-15000</option>
						<option value="More than 15000">More than 15000</option>
					</select>
				</div>

				<div class="four">
					<label for="zip">ZIP Code:</label>
					<input type="text" name="zip" id="zip" pattern="\d*" maxlength="5" minlength="5">
				</div>

				<div class="four">
					<span class="span-padding">Add another car?</span>

					<div class="radios">
						<label>
							<input type="radio" name="anotherCar" value="Yes">
							Yes
						</label>
						<label>
							<input type="radio" name="anotherCar" value="No">
							No
						</label>
					</div>
				</div>
				
			</div> <!-- Vehicle Details -->
			
			
			<div class="text-center">
				<button type="submit" class="readySubmit" name="continue">Continue</button>
			</div>
		</form>
		
		
	</div>

	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  
	<script>

		$(document).ready(function() {
			
			/* ===== Makes ===== */
			$.ajax({
				url: 'https://cors-anywhere.herokuapp.com/https://www.carqueryapi.com/api/0.3/?cmd=getMakes&sold_in_us=1',
				method: 'GET',
				success: function(data) {

					const makes = data.Makes;
					const makeOptionsArray = makes.map(make => {
						return `<option value="${make.make_display}">${make.make_display}</option>`;
					});
					const makeOptions = makeOptionsArray.join('');

					$("#make").append(makeOptions);
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
					url: `https://cors-anywhere.herokuapp.com/https://www.carqueryapi.com/api/0.3/?cmd=getModels&make=${make}&sold_in_us=1`,
					method: 'GET',
					success: function(data) {
						console.log(data); 
						console.log(data.Models);

						const models = data.Models;
						const modelOptionsArray = models.map(model => {
							return `<option value="${model.model_name}">${model.model_name}</option>`;
						});

						modelOptionsArray.unshift(`<option disabled selected value="">-- Select Model --</option>)`)

						const modelOptions = modelOptionsArray.join('');
	
						$("#model").html(modelOptions);
					},
					error: function(err) {
							console.log(err);
					}
				});
			});
			
		// 	/* ===== Insurance Past 30 ===== */
  //           if ($("input[name=insurancePast30]")[0].checked) {
  //               $(".insuranceItem").show();
  //               $(".insuranceItem input").prop("disabled", false);
  //               $(".insuranceItem select").prop("disabled", false);
  //           } else {
  //               $(".insuranceItem").hide();
  //               $(".insuranceItem input").prop('disabled', true);
  //               $(".insuranceItem select").prop('disabled', true);
  //           }
            
  //           $("input[name=insurancePast30]").change(function() {
  //               if (this.value == 'Yes') {
  //                   $(".insuranceItem").fadeIn();
  //                   $(".insuranceItem input").prop("disabled", false);
  //                   $(".insuranceItem select").prop("disabled", false);
  //               } else {
  //                   $(".insuranceItem").fadeOut('fast');
  //                   $(".insuranceItem input").prop('disabled', true);
  //                   $(".insuranceItem select").prop('disabled', true);
  //               }
  //           });
            
  //           /* ===== Current Insurance ===== */
  //           if ($("input[name=currentInsurance]")[0].checked) {
  //               $(".currentInsuranceItem").show();
  //               $(".currentInsuranceItem").prop("disabled", false);
  //               $(".currentInsuranceItem").prop("disabled", false);
  //           } else {
  //                $(".currentInsuranceItem").hide();
  //                $(".currentInsuranceItem").prop('disabled', true);
  //                $(".currentInsuranceItem").prop('disabled', true);
  //           }
            
  //           $("input[name=currentInsurance]").change(function() {
  //               if (this.value == 'Yes') {
  //                   $(".currentInsuranceItem").fadeIn();
  //                   $(".currentInsuranceItem input").prop("disabled", false);
  //                   $(".currentInsuranceItem select").prop("disabled", false);
  //               } else {
  //                   $(".currentInsuranceItem").fadeOut('fast');
  //                   $(".currentInsuranceItem input").prop('disabled', true);
  //                   $(".currentInsuranceItem select").prop('disabled', true);
  //               }
  //           });


  //           /* ===== Current Insurance ===== */
  //           if ($("input[name=anotherCar]")[0].checked) {
  //               $("#vehicle2").show();
  //               $(".currentInsuranceItem").prop("disabled", false);
  //               $(".currentInsuranceItem").prop("disabled", false);
  //           } else {
  //                $(".currentInsuranceItem").hide();
  //                $(".currentInsuranceItem").prop('disabled', true);
  //                $(".currentInsuranceItem").prop('disabled', true);
  //           }
            
  //           $("input[name=currentInsurance]").change(function() {
  //               if (this.value == 'Yes') {
  //                   $(".currentInsuranceItem").fadeIn();
  //                   $(".currentInsuranceItem input").prop("disabled", false);
  //                   $(".currentInsuranceItem select").prop("disabled", false);
  //               } else {
  //                   $(".currentInsuranceItem").fadeOut('fast');
  //                   $(".currentInsuranceItem input").prop('disabled', true);
  //                   $(".currentInsuranceItem select").prop('disabled', true);
  //               }
  //           });

		});


	</script>
</body>

</html>