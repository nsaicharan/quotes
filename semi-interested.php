<?php 
	
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Semi Interested Form</title>

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
		<form action="thankyou/index.php" id="readyForm" method="post">
			
			<h2 class="form-subtitle text-center">Vehicle Details</h2>
			<div class="row vehicle-details">
				<div class="four">
					<label for="vehicleYear">Vehicle Year:</label>
					<select name="vehicleYear" id="vehicleYear" required>
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
					<label for="parking">Night Parking:</label>
					<select name="parking" id="parking" required>
						<option disabled selected value="">
							-- Select --
						</option>
						<option value="Street">Street</option>
						<option value="Garage">Garage</option>
						<option value="Other">Other</option>
					</select>
				</div>

				<div class="four">
					<label for="zip">ZIP Code:</label>
					<input type="text" id="zip" name="zip" pattern="\d*" required>
				</div>

				<div class="four">
					<label for="insurance">Insurance Company (Optional):</label>
					<input type="text" id="insurance" name="insurance">
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

			</div> <!-- Vehicle Details -->
				 
			<h2 class="form-subtitle text-center">Primary Driver Details</h2>
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
					<label for="email">Email:</label>
					<input type="email" id="email" name="email" required>
				</div>

				<div class="four">
					<label for="phone">Phone Number:</label>
					<input type="tel" id="phone" name="phone" required>
				</div>

				<div class="four">
					<label for="gender">Gender:</label>
					<select name="gender" id="coverage" required>
						<option disabled selected value="">
							-- Select --
						</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
						<option value="Transgender">Transgender</option>
					</select>
				</div>
				
				<div class="four">
					<label for="education">Educational Level:</label>
					<select name="education" id="education" required>
						<option disabled selected value="">
							-- Select --
						</option>
						<option value="High School">High School Diploma</option>
						<option value="Bachelor's degree">Bachelor's Degree</option>
						<option value="Master's Degree">Master's Degree</option>
						<option value="PHD">PHD</option>
						<option value="Other">Other</option>
					</select>
				</div>


				<div class="four">
					<label for="occupation">Occupation:</label>
					<select name="occupation" id="occupation" required>
						<option disabled selected value="">
							-- Select --
						</option>
						<option value="Employee">Employee</option>
						<option value="Worker">Worker</option>
						<option value="Manager">Manager</option>
						<option value="Entrepreneur">Entrepreneur</option>
					</select>
				</div>

				<div class="four">
					<label for="maritalStatus">Marital Status:</label>
					<select name="maritalStatus" id="maritalStatus" required>
						<option disabled selected value="">
							-- Select --
						</option>
						<option value="Single">Single</option>
						<option value="Married">Married</option>
						<option value="Manager">Domestic Partner</option>
						<option value="Divorced/Separated">Divorced/Separated</option>
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
						<option value="Rent/Lease">Rent/Lease</option>
						<option value="Other">Other</option>
					</select>
				</div>

				<div class="four">
					<label for="creditEvaluation">Credit Evaluation:</label>
					<select name="creditEvaluation" id="creditEvaluation" required>
						<option disabled selected value="">
							-- Select --
						</option>
						<option value="Good">Good</option>
						<option value="Average">Average</option>
						<option value="Bad">Bad</option>
					</select>
				</div>

				<div class="two">
					<span class="span-padding">Does this driver needs Financial Responsibility Form (SR/22)?</span>

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

				
			</div> <!-- Driver Details -->
			
			<div class="text-center">
				<button type="submit" class="readySubmit" name="semiSubmit">Submit</button>
			</div>
		</form>
		
		
	</div>

	<script type="text/javascript" src="https://www.carqueryapi.com/js/jquery.min.js"></script>
	<script type="text/javascript" src="https://www.carqueryapi.com/js/carquery.0.3.4.js"></script>
  
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
			
		})


	</script>
</body>

</html>