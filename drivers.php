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

	$ids = explode(',', $_GET['id']);
	print_r($ids);
	echo "<br>";

	$options = "";

	foreach ($ids as $key => $value) {
		$query = "SELECT id, make FROM multi_vehicle WHERE id = $value";
		$result = mysqli_query($conn, $query);

		$vehicle_row = mysqli_fetch_array($result);

		$options .= "<option value='". $vehicle_row['id'] . "'>" . $vehicle_row['make'] . "</option>";
	}

	if ( isset($_POST['continue']) )  {

		print_r($_POST);

		$vehicle = $coverage = $insurancePast30 = $insuranceCompany = $expireMonth = $expireYear = $yearsInsured = $injuryLiabilityLimit = $firstName = $lastName = $gender = $email = $phone = $maritalStatus = $occupation = $education = $residence = $licence = $licenceAge = $creditEvaluation = $dobMonth = $dobDate = $dobYear = $licenceSuspended = $driverFinancialForm = $speedingTickets = $duiDWI = $currentInsurance = $currentCompany = $currentAmount = $currentExpireMonth = $currentExpireYear = $currentYearsInsured = $currentLimits = $yourList = $deductible = "";


		foreach ($_POST as $key => $value) {
			$$key = mysqli_real_escape_string($conn, strip_tags($_POST[$key]));
		}
		 
		$query = "INSERT INTO multi_drivers VALUES (NULL, '$coverage', '$insurancePast30', '$insuranceCompany', '$expireMonth', '$expireYear', '$yearsInsured', '$injuryLiabilityLimit', '$vehicle', '$firstName', '$lastName', '$gender', '$email', '$phone', '$maritalStatus', '$occupation', '$education', '$residence', '$licence', '$licenceAge', '$creditEvaluation', '$dobMonth', '$dobDate', '$dobYear', '$licenceSuspended', '$driverFinancialForm', '$speedingTickets', '$duiDWI', '$currentInsurance', '$currentCompany', '$currentAmount', '$currentExpireMonth', '$currentExpireYear', '$currentYearsInsured', '$currentLimits', '$yourList', '$deductible')";

		$result = mysqli_query($conn, $query);

		if ( isset($_POST['anotherDriver']) && $_POST['anotherDriver'] == 'Yes') {
			echo "ADD Another Drive <br>";
			$location = $_SERVER['PHP_SELF'];
			echo "Location: $location";
		} else {
			header("Location: thankyou/index.php");
		}

	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ready To Buy Form</title>

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
		<form method="post" name="readyForm" id="readyForm">
			
			<h2 class="form-subtitle text-center">Auto Coverage</h2>
			
			<div class="row vehicle-details">

				<div class="four">
					<label for="coverage">Desired Amount of Coverage:</label>
					<select name="coverage" id="coverage">
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

				<div class="two">
					<span class="span-padding">Have you had insurance past 30 days?</span>

					<div class="radios">
						<label>
							<input type="radio" name="insurancePast30" value="Yes">
							Yes
						</label>
						<label>
							<input type="radio" name="insurancePast30" value="No">
							No
						</label>
					</div>
				</div>
				
				<div class="four insuranceItem">
					<label for="insuranceCompany">Insurance Company:</label>
					<input type="text" name="insuranceCompany" id="insuranceCompany">
				</div>
				
				<div class="four insuranceItem">
					<label for="expireMonth">Insurance Expiration Date:</label>
					
					<div>
						<select name="expireMonth" id="expireMonth" class="half">
							<option value="" selected disabled>Month</option>
							<option value="January">January</option>
							<option value="February">February</option>
							<option value="March">March</option>
							<option value="April">April</option>
							<option value="May">May </option> 
							<option value="June">June</option> 
							<option value="July">July</option>
							<option value="August">August</option> 
							<option value="September">September</option> 
							<option value="October">October</option> 
							<option value="November">November</option> 
							<option value="December">December</option> 
						</select>

						<select name="expireYear" id="expireYear" class="half">
							<option value="" selected disabled>Year</option> 
							<option value="2014">2014</option> 
							<option value="2015">2015</option> 
							<option value="2016">2016</option> 
							<option value="2017">2017</option> 
							<option value="2018">2018</option> 
							<option value="2019">2019</option> 
							<option value="2020">2020</option> 
						</select>
					</div>
				</div>
				
				<div class="four insuranceItem">
					<label for="yearsInsured">Years Insured:</label>
					<select name="yearsInsured" id="yearsInsured">
						<option disabled selected value="">
							-- Insured Years --
						</option>
                        <option value="1-2 Years">1-2 Years</option>
                        <option value="2-3 Years">2-3 Years</option>
                        <option value="3-4 Years">3-4 Years</option>
                        <option value="4-5 Years">4-5 Years</option>
					</select>
				</div>
				
				<div class="four insuranceItem">
					<label for="injuryLiabilityLimit">Current bodily injury liability limit:</label>
					<select name="injuryLiabilityLimit" id="injuryLiabilityLimit">
						<option disabled selected value="">
							-- Select --
						</option>
                        <option value="$100,000-$300,000">$100,000 - $300,000</option>
						<option value="$300,000-$500,000">$300,000 - $500,000</option>
						<option value="$500,000-$700,000">$500,000 - $700,000</option>
					</select>
				</div>
				
			</div> <!-- Vehicle Details -->
				
				 
			<h2 class="form-subtitle text-center">Primary Driver Details</h2>
			<div class="row driver-details">
				<div class="four">
					<label for="vehicle">Vehicle:</label>
					<select name="vehicle" id="vehicle">
						<?php echo $options; ?>
					</select>
				</div>

				<div class="four">
					<label for="firstName">First Name:</label>
					<input type="text" name="firstName" id="firstName">
				</div>

				<div class="four">
					<label for="lastName">Last Name:</label>
					<input type="text" name="lastName" id="lastName">
				</div>
				
				<div class="four">
					<label for="gender">Gender:</label>
					<select name="gender" id="coverage">
						<option disabled selected value="">
							-- Select --
						</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
						<option value="Transgender">Transgender</option>
					</select>
				</div>

				<div class="four">
					<label for="email">Email:</label>
					<input type="email" name="email" id="email">
				</div>

				<div class="four">
					<label for="phone">Phone Number:</label>
					<input type="tel" name="phone" id="phone">
				</div>
				
				<div class="four">
					<label for="maritalStatus">Marital Status:</label>
					<select name="maritalStatus" id="maritalStatus">
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
					<label for="occupation">Occupation:</label>
					<select name="occupation" id="occupation">
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
					<label for="education">Educational Level:</label>
					<select name="education" id="education">
						<option disabled selected value="">
							-- Select --
						</option>
						<option value="High School">High School Diploma</option>
						<option value="Bachelor's degree">Bachelor's degree</option>
						<option value="Master's Degree">Master's Degree</option>
						<option value="PHD">PHD</option>
						<option value="Other">Other</option>
					</select>
				</div>
				
				<div class="four">
					<label for="residence">Residence:</label>
					<select name="residence" id="residence">
						<option disabled selected value="">
							-- Select --
						</option>
						<option value="Own">Own</option>
						<option value="Rent/Lease">Rent/Lease</option>
						<option value="Other">Other</option>
					</select>
				</div>
				
				<div class="four">
					<label for="licence">Driver Licence Number:</label>
					<input type="text" name="licence" id="licence">
				</div>
				
				<div class="four">
					<label for="licenceAge">Age First Licensed:</label>
					<input type="number" name="licenceAge" id="licenceAge" min="16" max="100">
				</div>
				
				<div class="four">
					<label for="creditEvaluation">Credit Evaluation:</label>
					<select name="creditEvaluation" id="creditEvaluation">
						<option disabled selected value="">
							-- Select --
						</option>
						<option value="Good">Good</option>
						<option value="Average">Average</option>
						<option value="Bad">Bad</option>
					</select>
				</div>
				
				<div class="three">
					<label for="dobMonth">What's this driver's date of birth?</label>
					
					<div class="driver-dob">
						<select name="dobMonth" id="dobMonth" class="dob">
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

						<select name="dobDate" id="dobDate" class="dob">
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

						<select name="dobYear" id="dobYear" class="dob">
							<option value="" selected disabled>Year</option>
							<option value="1960">1960</option> 
							<option value="1961">1961</option> 
							<option value="1962">1962</option> 
							<option value="1963">1963</option> 
							<option value="1964">1964</option> 
							<option value="1965">1965</option> 
							<option value="1966">1966</option> 
							<option value="1967">1967</option> 
							<option value="1968">1968</option> 
							<option value="1969">1969</option> 
							<option value="1970">1970</option> 
							<option value="1971">1971</option> 
							<option value="1972">1972</option> 
							<option value="1973">1973</option> 
							<option value="1974">1974</option> 
							<option value="1975">1975</option> 
							<option value="1976">1976</option> 
							<option value="1977">1977</option> 
							<option value="1978">1978</option> 
							<option value="1979">1979</option> 
							<option value="1980">1980</option> 
							<option value="1981">1981</option> 
							<option value="1982">1982</option> 
							<option value="1983">1983</option> 
							<option value="1984">1984</option> 
							<option value="1985">1985</option> 
							<option value="1986">1986</option> 
							<option value="1987">1987</option> 
							<option value="1988">1988</option> 
							<option value="1989">1989</option> 
							<option value="1990">1990</option> 
							<option value="1991">1991</option> 
							<option value="1992">1992</option> 
							<option value="1993">1993</option> 
							<option value="1994">1994</option> 
							<option value="1995">1995</option> 
							<option value="1996">1996</option> 
							<option value="1997">1997</option> 
							<option value="1998">1998</option> 
							<option value="1999">1999</option> 
							<option value="2000">2000</option> 
							<option value="2001">2001</option> 
							<option value="2002">2002</option> 
							<option value="2003">2003</option> 
							<option value="2004">2004</option> 
							<option value="2005">2005</option> 
							<option value="2006">2006</option> 
							<option value="2007">2007</option> 
							<option value="2008">2008</option> 
							<option value="2009">2009</option> 
							<option value="2010">2010</option> 
						</select>
					</div> <!-- driver-dob -->
				</div>
				
				<div class="two">
					<span class="span-padding">Has driver license been suspended/revoked in the last 3 years?</span>

					<div class="radios">
						<label>
							<input type="radio" name="licenceSuspended" value="Yes"> 
							Yes
						</label>
						<label>
							<input type="radio" name="licenceSuspended" value="No">
							No
						</label>
					</div>
				</div>
				
				<div class="two">
					<span class="span-padding">Does this driver needs Financial Responsibility Form (SR/22)?</span>

					<div class="radios">
						<label>
							<input type="radio" name="driverFinancialForm" value="Yes">
							Yes
						</label>
						<label>
							<input type="radio" name="driverFinancialForm" value="No">
							No
						</label>
					</div>
				</div>
				
			</div> <!-- Driver Details -->
			
			<h2 class="form-subtitle text-center">Other Details</h2>
			<div class="other-details row">
				<div class="three">
					<span class="span-padding">Any speeding tickets within 3 years?</span>

					<div class="radios">
						<label>
							<input type="radio" name="speedingTickets" value="Yes">
							Yes
						</label>
						<label>
							<input type="radio" name="speedingTickets" value="No">
							No
						</label>
					</div>
				</div>
				
				<div class="three">
					<span class="span-padding">Any DUI/DWI in the past 3 years?
					</span>

					<div class="radios">
						<label>
							<input type="radio" name="duiDWI" value="Yes">
							Yes
						</label>
						<label>
							<input type="radio" name="duiDWI" value="No">
							No
						</label>
					</div>
				</div>
				
				<div class="three">
					<span class="span-padding">Do you currently have insurance?
					</span>

					<div class="radios">
						<label>
							<input type="radio" name="currentInsurance" value="Yes">
							Yes
						</label>
						<label>
							<input type="radio" name="currentInsurance" value="No">
							No
						</label>
					</div>
				</div>
				
				<div class="three currentInsuranceItem">
					<label for="currentCompany">Current Company?</label>
					<input type="text" name="currentCompany" id="currentCompany">
				</div>
				
				<div class="three currentInsuranceItem">
					<label for="currentAmount">How much are you paying?</label>
					<input type="number" name="currentAmount" id="currentAmount">
				</div>
				
				<div class="three currentInsuranceItem">
					<label for="currentExpireMonth">Expiration Date?</label>
					
					<div>
						<select name="currentExpireMonth" id="currentExpireMonth" class="half">
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

						<select name="currentExpireYear" id="currentExpireYear" class="half">
							<option value="" selected disabled>-- Year --</option> 
							<option value="2014">2014</option> 
							<option value="2015">2015</option> 
							<option value="2015">2016</option> 
							<option value="2015">2017</option> 
							<option value="2015">2018</option> 
							<option value="2015">2019</option> 
						</select>
					</div>
				</div>
				
				<div class="three currentInsuranceItem">
					<label for="currentYearsInsured">Years Insured?</label>
					<select name="currentYearsInsured" id="currentYearsInsured">
						<option value="" disabled selected value="">-- Insured Years --</option>
                        <option value="1-2 Years">1-2 Years</option>
                        <option value="2-3 Years">2-3 Years</option>
                        <option value="3-4 Years">3-4 Years</option>
                        <option value="4-5 Years">4-5 Years</option>
					</select>
				</div>
				
				<div class="three currentInsuranceItem">
					<label for="currentLimits">Current Limits:</label>
					<input type="text" name="currentLimits" id="currentLimits">
				</div>
				
				<div class="three currentInsuranceItem">
					<label for="yourList">Your Lists:</label>
					<input type="text" name="yourList" id="yourList">
				</div>
				
				<div class="three currentInsuranceItem">
					<label for="deductible">Deductible:</label>
					<input type="text" name="deductible" id="deductible">
				</div>

				<div class="three">
					<span class="span-padding">Add another driver?</span>

					<div class="radios">
						<label>
							<input type="radio" name="anotherDriver" value="Yes"> 
							Yes
						</label>
						<label>
							<input type="radio" name="anotherDriver" value="No">
							No
						</label>
					</div>
				</div>

			</div> <!-- Other Details -->
			
			<div class="text-center">
				<button type="submit" class="readySubmit" name="continue">Continue</button>
			</div>
		</form>
		
		
	</div>

	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  
	<script>

		$(document).ready(function() {
			
			/* ===== Insurance Past 30 ===== */
            if ($("input[name=insurancePast30]")[0].checked) {
                $(".insuranceItem").show();
                $(".insuranceItem input").prop("disabled", false);
                $(".insuranceItem select").prop("disabled", false);
            } else {
                $(".insuranceItem").hide();
                $(".insuranceItem input").prop('disabled', true);
                $(".insuranceItem select").prop('disabled', true);
            }
            
            $("input[name=insurancePast30]").change(function() {
                if (this.value == 'Yes') {
                    $(".insuranceItem").fadeIn();
                    $(".insuranceItem input").prop("disabled", false);
                    $(".insuranceItem select").prop("disabled", false);
                } else {
                    $(".insuranceItem").fadeOut('fast');
                    $(".insuranceItem input").prop('disabled', true);
                    $(".insuranceItem select").prop('disabled', true);
                }
            });
            
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

		});


	</script>
</body>

</html>