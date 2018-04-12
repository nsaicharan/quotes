<?php 

session_start();

if (!$_SESSION['loggedInUser']) {
    header("Location: index.php");

} else {
    include('../conn.php');

    $message = '';

    if (isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        $query = "SELECT * FROM ready_vehicles WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
    }

    if (isset($_POST['update'])) {
        $vehicleYear = $make = $model = $vin = $ownership = $parking = $primaryUse = $mileage = $zip = $coverage = $insurancePast30 = $insuranceCompany = $expireMonth = $expireYear = $yearsInsured = $injuryLiabilityLimit = $firstName = $lastName = $gender = $email = $phone = $address = $maritalStatus = $education = $residence = $licence = $licenceAge = $dobMonth = $dobDate = $dobYear = $licenceSuspended = $driverFinancialForm = $speedingTickets = $duiDWI = $currentInsurance = $currentCompany = $currentAmount = $currentExpireMonth = $currentExpireYear = $currentYearsInsured = $deductible = "";

        $vehicleYear = mysqli_real_escape_string($conn, $_POST['vehicleYear']);
        $make = mysqli_real_escape_string($conn, $_POST['make']);
        $model = mysqli_real_escape_string($conn, $_POST['model']);
        $vin = mysqli_real_escape_string($conn, $_POST['vin']);
        $ownership = mysqli_real_escape_string($conn, $_POST['ownership']);
        $parking = mysqli_real_escape_string($conn, $_POST['parking']);
        $primaryUse = mysqli_real_escape_string($conn, $_POST['primaryUse']);
        $mileage = mysqli_real_escape_string($conn, $_POST['mileage']);
        $coverage = mysqli_real_escape_string($conn, $_POST['coverage']);
        $insurancePast30 = mysqli_real_escape_string($conn, $_POST['insurancePast30']);
        $insuranceCompany = mysqli_real_escape_string($conn, $_POST['insuranceCompany']);
        $expireMonth = mysqli_real_escape_string($conn, $_POST['expireMonth']);
        $expireYear = mysqli_real_escape_string($conn, $_POST['expireYear']);
        $yearsInsured = mysqli_real_escape_string($conn, $_POST['yearsInsured']);
        $injuryLiabilityLimit = mysqli_real_escape_string($conn, $_POST['injuryLiabilityLimit']);

        $query = "UPDATE ready_vehicles SET 
                                                                                                                                                                                            
                        vehicle_year = '$vehicleYear',
                        make = '$make',
                        model = '$model',
                        vin = '$vin',
                        ownership = '$ownership',
                        parking = '$parking',
                        primary_use = '$primaryUse',
                        mileage = '$mileage',
                        coverage = '$coverage', 
                        insurance_past_30 = '$insurancePast30', 
                        insurance_company = '$insuranceCompany', 
                        expire_month = '$expireMonth', 
                        expire_year = '$expireYear', 
                        years_insured = '$yearsInsured', 
                        injury_liability_limit = '$injuryLiabilityLimit'

                        WHERE id = '$id' ";

        $result = mysqli_query($conn, $query);

        $driversquery = "SELECT * FROM ready_drivers WHERE vehicle LIKE '$id'";
        $driversresult = mysqli_query($conn, $driversquery);

        $i = 0;
        while ($driversrow = mysqli_fetch_array($driversresult)) {

            $driverID = $driversrow['id'];

            $firstName = mysqli_real_escape_string($conn, $_POST['firstName'][$i]);
            $lastName = mysqli_real_escape_string($conn, $_POST['lastName'][$i]);
            $gender = mysqli_real_escape_string($conn, $_POST['gender'][$i]);
            $email = mysqli_real_escape_string($conn, $_POST['email'][$i]);
            $phone = mysqli_real_escape_string($conn, $_POST['phone'][$i]);
            $address = mysqli_real_escape_string($conn, $_POST['address'][$i]);
            $maritalStatus = mysqli_real_escape_string($conn, $_POST['maritalStatus'][$i]);
            $zip = mysqli_real_escape_string($conn, $_POST['zip'][$i]);
            $education = mysqli_real_escape_string($conn, $_POST['education'][$i]);
            $residence = mysqli_real_escape_string($conn, $_POST['residence'][$i]);
            $licence = mysqli_real_escape_string($conn, $_POST['licence'][$i]);
            $licenceAge = mysqli_real_escape_string($conn, $_POST['licenceAge'][$i]);
            $dobMonth = mysqli_real_escape_string($conn, $_POST['dobMonth'][$i]);
            $dobDate = mysqli_real_escape_string($conn, $_POST['dobDate'][$i]);
            $dobYear = mysqli_real_escape_string($conn, $_POST['dobYear'][$i]);
            $licenceSuspended = mysqli_real_escape_string($conn, $_POST['licenceSuspended'][$i]);
            $driverFinancialForm = mysqli_real_escape_string($conn, $_POST['driverFinancialForm'][$i]);
            $speedingTickets = mysqli_real_escape_string($conn, $_POST['speedingTickets'][$i]);
            $duiDWI = mysqli_real_escape_string($conn, $_POST['duiDWI'][$i]);
            $currentInsurance = mysqli_real_escape_string($conn, $_POST['currentInsurance'][$i]);
            $currentCompany = mysqli_real_escape_string($conn, $_POST['currentCompany'][$i]);
            $currentAmount = mysqli_real_escape_string($conn, $_POST['currentAmount'][$i]);
            $currentExpireMonth = mysqli_real_escape_string($conn, $_POST['currentExpireMonth'][$i]);
            $currentExpireYear = mysqli_real_escape_string($conn, $_POST['currentExpireYear'][$i]);
            $currentYearsInsured = mysqli_real_escape_string($conn, $_POST['currentYearsInsured'][$i]);
            $deductible = mysqli_real_escape_string($conn, $_POST['deductible'][$i]);

            $query = "UPDATE ready_drivers SET 

                        first_name = '$firstName', 
                        last_name = '$lastName', 
                        gender = '$gender', 
                        email = '$email', 
                        phone = '$phone', 
                        address = '$address', 
                        marital_status = '$maritalStatus', 
                        education = '$education', 
                        zip = '$zip',
                        residence = '$residence', 
                        licence = '$licence', 
                        licence_age = '$licenceAge', 
                        dob_month = '$dobMonth', 
                        dob_date = '$dobDate', 
                        dob_year = '$dobYear', 
                        licence_suspended = '$licenceSuspended', 
                        driver_financial_form = '$driverFinancialForm', 
                        speeding_tickets = '$speedingTickets', 
                        dui_dwi = '$duiDWI', 
                        current_insurance = '$currentInsurance', 
                        current_company = '$currentCompany', 
                        current_amount = '$currentAmount', 
                        current_expire_month = '$currentExpireMonth', 
                        current_expire_year = '$currentExpireYear', 
                        current_years_insured = '$currentYearsInsured', 
                        deductible = '$deductible'

                    WHERE id = '$driverID'";

            $result = mysqli_query($conn, $query);

            $i++;
        }


        if ($result) {
            $message = '<div class="alert alert-success my-3">Data has been successfully updated. <button class="close" data-dismiss="alert">&times;</button> </div>';

            $query = "SELECT * FROM ready_vehicles WHERE id = $id";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_array($result);

            $_SESSION['edit'] = $id;
        } else {
            echo mysqli_error($conn);
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit | Ready To Buy</title>
    
    <link rel="stylesheet" href="assets/master.css">
    <link href="https://fonts.googleapis.com/css?family=Mate+SC|Open+Sans:400,700" rel="stylesheet">

    <style>
        body {
            background: #f3f3f3;
        }

        .container {
            max-width: 500px;
        }

        label {
            font-weight: bold;
            margin-top: 4px;
        }

        a,
        button {
            text-transform: uppercase;
            cursor: pointer;
        }

        h3 {
            font-size: 20px;
            margin-top: 35px;
            border-bottom: 2px solid;
            display: inline-block;
            text-transform: uppercase;
        }
    </style>
</head>
<body>
    <a href="<?php echo (isset($_GET['all'])) ? 'all.php' : 'ready.php' ?>" class="btn btn-primary m-4"><i class="fa fa-hand-o-left"></i> Back to listing page</a>

    <div class="text-center mb-3">
        <h2>Update Information</h2>
        <p class="text-success">( ID - <?php echo $id; ?> )</p>
    </div>

    <form class="container" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
        <?php echo $message; ?>

        <div class="text-center">
            <h3>Vehicle Details</h3>
        </div>

        <div>
            <div class="form-group">
                <label>Vehicle Year:</label>
                <select class="form-control" name="vehicleYear">
                    <optgroup label="Current Value:">
                        <option selected value="<?php echo $row['vehicle_year']; ?>">
                           <?php echo $row['vehicle_year']; ?> 
                        </option>
                    </optgroup>

                    <optgroup label="Available Options:" class="availVehicleYears">
                    </optgroup>
                </select>
            </div>

            <div class="form-group">
                <label>Make:</label>
                <select class="form-control" name="make">
                    <optgroup label="Current Value:">
                        <option selected value="<?php echo $row['make']; ?>">
                            <?php echo $row['make']; ?> 
                        </option>
                    </optgroup>

                    <optgroup label="Available Options:" class="makeOptions">
                        
                    </optgroup>
                </select>
            </div>

            <div class="form-group">
                <label>Model:</label>
                <select class="form-control" class="form-control" name="model">
                    <optgroup label="Current Value:">
                        <option selected value="<?php echo $row['model']; ?>">
                            <?php echo $row['model']; ?> 
                        </option>
                    </optgroup>

                    <optgroup label="Available Options:" class="modelOptions">
                        
                    </optgroup>
                </select>
            </div>

            <div class="form-group">
                <label>VIN:</label>
                <input class="form-control" type="text" name="vin" value="<?php echo $row['vin']; ?>">
            </div>

            <div class="form-group">
                <label>Ownership:</label>
                <select class="form-control" name="ownership">
                    <optgroup label="Current Value:">
                        <option selected value="<?php echo $row['ownership']; ?>">
                            <?php echo $row['ownership']; ?> 
                        </option>
                    </optgroup>

                    <optgroup label="Available Options:">
                        <option value="Financed">Financed</option>
                        <option value="Lease">Lease</option>
                        <option value="Paid Off">Paid Off</option>
                    </optgroup>
                </select>
            </div>

            <div class="form-group">
                <label>Night Parking:</label>
                <select class="form-control" name="parking">
                    <optgroup label="Current Value:">
                        <option selected value="<?php echo $row['parking']; ?>">
                            <?php echo $row['parking']; ?> 
                        </option>
                    </optgroup>

                    <optgroup label="Available Options:">
                        <option value="Street">Street</option>
                        <option value="Garage">Garage</option>
                        <option value="Other">Other</option>
                    </optgroup>
                </select>
            </div>

            <div class="form-group">
                <label>Primary Use:</label>
                <select class="form-control" name="primaryUse">
                    <optgroup label="Current Value:">
                        <option selected value="<?php echo $row['primary_use']; ?>">
                            <?php echo $row['primary_use']; ?> 
                        </option>
                    </optgroup>

                    <optgroup label="Available Options:">
                        <option value="Commuting to/from work/school">Commuting to/from work/school</option>
                        <option value="Pleasure/Personal use">Pleasure/Personal use</option>
                        <option value="Business/Commercial">Business/Commercial</option>
                        
                    </optgroup>
                </select>
            </div>

            <div class="form-group">
                <label>Annual Mileage:</label>
                <select class="form-control" name="mileage">
                    <optgroup label="Current Value:">
                        <option selected value="<?php echo $row['mileage']; ?>">
                            <?php echo $row['mileage']; ?> 
                        </option>
                    </optgroup>

                    <optgroup label="Available Options">
                        <option value="0-7500">0-7500</option>
                        <option value="7500-15000">7500-15000</option>
                        <option value="More than 15000">More than 15000</option>
                    </optgroup>
                </select>
            </div>

            <div class="form-group">
                <label>Desired Amount of Coverage:</label>
                <select class="form-control" name="coverage">
                   <optgroup label="Current Value:">
                        <option selected value="<?php echo $row['coverage']; ?>">
                            <?php echo $row['coverage']; ?> 
                        </option>
                    </optgroup>

                    <optgroup label="Available Options:">
                        <option value="25/65/15">25/65/15 </option>
                        <option value="50/100/50">50/100/50</option>
                        <option value="100/300/100">100/300/100</option>
                        <option value="250/500/250">250/500/250</option>
                        <option value="500/500/500">500/500/500</option>
                    </optgroup>
                </select>
            </div>

            <div class="insurancePast30-container">
                <div class="form-group">
                    <label>Have you had insurance past 30 days?</label>
                    <select class="form-control insurancePast30" name="insurancePast30">
                       <option value="Yes" <?php echo ($row['insurance_past_30'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                       <option value="No" <?php echo ($row['insurance_past_30'] == 'No') ? 'selected' : ''; ?>>No</option>
                    </select>
                </div>
                
                <div class="form-group insuranceItem">
                    <label>Insurance Company:</label>
                    <input type="text" class="form-control" name="insuranceCompany" value="<?php echo $row['insurance_company']; ?>">
                </div>
                
                <div class="form-group insuranceItem">
                    <label>Insurance Expiration Date:</label>
                    
                    <div class="row ">
                        <div class="col pr-1">
                            <select class="form-control" name="expireMonth">
                                <optgroup label="Current Value:">
                                     <option selected value="<?php echo $row['expire_month']; ?>">
                                        <?php echo $row['expire_month']; ?> 
                                    </option>
                                </optgroup>
                                
                                <optgroup label="Available Options:">
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
                                </optgroup>
                            </select>
                        </div>

                        <div class="col pl-1">
                            <select class="form-control" name="expireYear">
                                <optgroup label="Current Value:">
                                    <option selected value="<?php echo $row['expire_year']; ?>">
                                        <?php echo $row['expire_year']; ?> 
                                    </option>
                                </optgroup>

                                <optgroup label="Available Options:">
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
                                </optgroup>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="form-group insuranceItem">
                    <label>Years Insured:</label>
                    <select class="form-control" name="yearsInsured">
                        <optgroup label="Current Value:">
                            <option selected value="<?php echo $row['years_insured']; ?>">
                                <?php echo $row['years_insured']; ?> 
                            </option>
                        </optgroup>

                        <optgroup label="Available Options:">
                            <option value="1 Year">1 Year</option>
                            <option value="2 Years">2 Years</option>
                            <option value="3 Years">3 Years</option>
                            <option value="4 Years">4 Years</option>
                            <option value="5 Years">5 Years</option>
                            <option value="6 Years">6 Years</option>
                            <option value="7 Years">7 Years</option>
                            <option value="8+ Years">8+ Years</option>
                        </optgroup>
                    </select>
                </div>
                
                <div class="form-group insuranceItem">
                    <label>Current bodily injury liability limit:</label>
                    <select class="form-control" name="injuryLiabilityLimit">
                        <optgroup label="Current Value:">
                            <option selected value="<?php echo $row['injury_liability_limit']; ?>">
                                <?php echo $row['injury_liability_limit']; ?> 
                            </option>
                        </optgroup>

                        <optgroup label="Available Options:">
                            <option value="25/65/15">25/65/15 </option>
                            <option value="50/100/50">50/100/50</option>
                            <option value="100/300/100">100/300/100</option>
                            <option value="250/500/250">250/500/250</option>
                            <option value="500/500/500">500/500/500</option>
                        </optgroup>
                    </select>
                </div>
            </div> <!-- insurancePast30-container -->
            
            <?php 
            $id = $row['id'];

            $query = "SELECT * FROM ready_drivers WHERE vehicle LIKE '$id'";
            $result = mysqli_query($conn, $query);

            while ($row = mysqli_fetch_array($result)) :
            ?>

                <div class="text-center mb-3">
                    <h3>Driver Details</h3>
                </div>

                <div class="form-group">
                    <label>First Name:</label>
                    <input class="form-control" type="text"  name="firstName[]" value="<?php echo $row['first_name']; ?>">
                </div>

                <div class="form-group">
                    <label>Last Name:</label>
                    <input class="form-control" type="text" name="lastName[]" value="<?php echo $row['last_name']; ?>">
                </div>

                <div class="form-group">
                    <label>Gender:</label>
                    <select class="form-control" name="gender[]">
                        <optgroup label="Current Value:">
                            <option selected value="<?php echo $row['gender']; ?>">
                                <?php echo $row['gender']; ?> 
                            </option>
                        </optgroup>

                        <optgroup label="Available Options:">
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </optgroup>
                    </select>
                </div>

                <div class="form-group">
                    <label>Email:</label>
                    <input class="form-control"  name="email[]" value="<?php echo $row['email']; ?>">
                </div>

                <div class="form-group">
                    <label>Phone Number:</label>
                    <input class="form-control" type="tel" name="phone[]" value="<?php echo $row['phone']; ?>">
                </div>
                
                <div class="form-group">
                    <label>Educational Level:</label>
                    <select class="form-control" name="education[]">
                        <optgroup label="Current Value:">
                            <option selected value="<?php echo $row['education']; ?>">
                                <?php echo $row['education']; ?> 
                            </option>
                        </optgroup>

                        <optgroup label="Available Options:">
                            <option value="Current student with 3.0 or better">Current student with 3.0 or better</option>
                            <option value="Recent graduate with 3.0 or better">Recent graduate with 3.0 or better</option>
                            <option value="Not a current student">Not a current student</option>
                        </optgroup>
                    </select>
                </div>

                <div class="form-group">
                    <label>Marital Status:</label>
                    <select class="form-control" name="maritalStatus[]">
                        <optgroup label="Current Value:">
                            <option selected value="<?php echo $row['marital_status']; ?>">
                                <?php echo $row['marital_status']; ?> 
                            </option>
                        </optgroup>

                        <optgroup label="Available Options:">
                            <option value="Married">Married</option>
                            <option value="Single">Single</option>
                            <option value="Single">Single with child</option>
                            <option value="Divorced/Separated">Divorced</option>
                            <option value="Widowed">Widowed</option>
                        </optgroup>
                    </select>
                </div>

                <div class="js-container">
                    <div class="form-group">
                        <label>ZIP Code:</label>
                        <input class="form-control zip" type="text" name="zip[]" pattern="\d*" minlength="5" maxlength="5" value="<?php echo $row['zip']; ?>">
                    </div>

                    <div class="form-group">
                        <label>Residence:</label>
                        <select class="form-control" name="residence[]">
                            <optgroup label="Current Value:">
                                <option selected value="<?php echo $row['residence']; ?>">
                                    <?php echo $row['residence']; ?> 
                                </option>
                            </optgroup>

                            <optgroup label="Available Options:">
                                <option value="Own">Own</option>
                                <option value="Rent/Lease">Rent/Lease</option>
                                <option value="Other">Other</option>
                            </optgroup>
                        </select>
                    </div>
                        
                    <div class="form-group">
                        <label>Address:</label>
                        <textarea class="form-control address" type="text" name="address[]"><?php echo $row['address']; ?></textarea>
                    </div>
                </div> <!-- js-container -->

                <div class="form-group">
                    <label>Driver Licence Number:</label>
                    <input type="text" class="form-control" name="licence[]" value="<?php echo $row['licence']; ?>">
                </div>
                
                <div class="form-group">
                    <label>Age First Licensed:</label>
                    <input type="number" class="form-control" name="licenceAge[]" value="<?php echo $row['licence_age']; ?>">
                </div>

                <div class="form-group">
                    <label>What's this driver's date of birth?</label>
                    
                    <div class="row">
                        <div class="col pr-1">
                            <select class="form-control" name="dobMonth[]">
                                <optgroup label="Current Value:">
                                    <option selected value="<?php echo $row['dob_month']; ?>">
                                        <?php echo $row['dob_month']; ?> 
                                    </option>
                                </optgroup>

                                <optgroup label="Available Options:">
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
                                </optgroup>
                            </select>
                        </div>

                        <div class="col pl-0 pr-1">
                            <select  class="form-control" name="dobDate[]">
                                <optgroup label="Current Value:">
                                    <option selected value="<?php echo $row['dob_date']; ?>">
                                        <?php echo $row['dob_date']; ?> 
                                    </option>
                                </optgroup>

                                <optgroup label="Available Options:">
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
                                </optgroup>
                            </select>
                        </div>

                        <div class="col pl-0">
                            <select class="form-control" name="dobYear[]">
                                <optgroup label="Current Value:">
                                    <option selected value="<?php echo $row['dob_year']; ?>">
                                        <?php echo $row['dob_year']; ?> 
                                    </option>
                                </optgroup>
                                
                                <optgroup label="Available Options:" class="availableDOBYears">
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
                                </optgroup>
                            </select>
                        </div>
                    </div> <!-- row -->
                </div>
                
                <div class="form-group">
                    <label>Has driver license been suspended/revoked in the last 5 years?</label>
                    <select class="form-control" name="licenceSuspended[]">
                       <option value="Yes" <?php echo ($row['licence_suspended'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                       <option value="No" <?php echo ($row['licence_suspended'] == 'No') ? 'selected' : ''; ?>>No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Need SR/22?</label>
                    <select class="form-control" name="driverFinancialForm[]">
                       <option value="Yes" <?php echo ($row['driver_financial_form'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                       <option value="No" <?php echo ($row['driver_financial_form'] == 'No') ? 'selected' : ''; ?>>No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Any tickets/accidents within the last 3 years?</label>
                    <select class="form-control" name="speedingTickets[]">
                       <option value="Yes" <?php echo ($row['speeding_tickets'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                       <option value="No" <?php echo ($row['speeding_tickets'] == 'No') ? 'selected' : ''; ?>>No</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Any DUI/DWI in the past 5 years?</label>
                    <select class="form-control" name="duiDWI[]">
                       <option value="Yes" <?php echo ($row['dui_dwi'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                       <option value="No" <?php echo ($row['dui_dwi'] == 'No') ? 'selected' : ''; ?>>No</option>
                    </select>
                </div>
                
                <div class="currentInsuranceContainer">
                    <div class="form-group">
                        <label>Do you currently have insurance?</label>
                        <select class="form-control currentInsurance" name="currentInsurance[]">
                           <option value="Yes" <?php echo ($row['current_insurance'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                           <option value="No" <?php echo ($row['current_insurance'] == 'No') ? 'selected' : ''; ?>>No</option>
                        </select>
                    </div>
                    
                    <div class="form-group currentInsuranceItem">
                        <label>Current Company?</label>
                        <input type="text" class="form-control" name="currentCompany[]" value="<?php echo $row['current_company'] ?>">
                    </div>
                    
                    <div class="form-group currentInsuranceItem">
                        <label>How much do you pay per month OR every 6 months?</label>
                        <input class="form-control" name="currentAmount[]" value="<?php echo $row['current_amount'] ?>">
                    </div>
                    
                    <div class="form-group currentInsuranceItem">
                        <label>Expiration Date?</label>
                        
                        <div class="row">
                            <div class="col pr-1">
                                <select class="form-control" name="currentExpireMonth[]">
                                    <optgroup label="Current Value:">
                                        <option selected value="<?php echo $row['current_expire_month']; ?>">
                                            <?php echo $row['current_expire_month']; ?> 
                                        </option>
                                    </optgroup>

                                    <optgroup label="Available Options:">
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
                                    </optgroup>
                                </select>
                            </div>

                            <div class="col pl-1">
                                <select class="form-control" name="currentExpireYear[]">
                                    <optgroup label="Current Value:">
                                        <option selected value="<?php echo $row['current_expire_year']; ?>">
                                            <?php echo $row['current_expire_year']; ?> 
                                        </option>
                                    </optgroup>

                                    <optgroup label="Available Options:">
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
                                    </optgroup>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group currentInsuranceItem">
                        <label>Years Insured?</label>
                        <select class="form-control" name="currentYearsInsured[]">
                            <optgroup label="Current Value:">
                                <option selected value="<?php echo $row['current_years_insured']; ?>">
                                    <?php echo $row['current_years_insured']; ?> 
                                </option>
                            </optgroup>

                            <optgroup label="Available Options:">
                                <option value="1 Year">1 Year</option>
                                <option value="2 Years">2 Years</option>
                                <option value="3 Years">3 Years</option>
                                <option value="4 Years">4 Years</option>
                                <option value="5 Years">5 Years</option>
                                <option value="6 Years">6 Years</option>
                                <option value="7 Years">7 Years</option>
                                <option value="8+ Years">8+ Years</option>
                            </optgroup>
                        </select>
                    </div>
                    
                    <div class="form-group currentInsuranceItem">
                        <label>Deductible:</label>
                        <input type="text" class="form-control" name="deductible[]" value="<?php echo $row['deductible'] ?>">
                    </div>
                </div> <!-- currentInsuranceContainer -->
            
            <?php endwhile; ?>
           
        </div>

        <div class="text-center my-4">
            <button type="submit" class="btn btn-primary btn-lg btn-block" name="update">Update</button>
        </div>
    </form> <!-- Form/Container -->
    
    <script src="assets/master.js"></script>
     
    <script>

        $(document).ready(function() {

            /* ===== Vehicle Years ===== */
			{
				let options = '';
				let year = new Date().getFullYear();
				const lastYear = year - 35;

				for (year; year >= lastYear; year--) {
					options += `<option value="${year}">${year}</option>`;
				}
				$(".availVehicleYears").html(options);
			}
            
            /* ===== Makes ===== */
            $.ajax({
                url: '../cardata.php',
				method: 'post',
				data: {type: 'makes'},
                success: function(options) {
                    $(".makeOptions").html(options);
                },
                error: function(err) {
                    console.log(err);
                }
            });
            
            /* ===== Models ===== */
            //Initial Options
            const make = $('select[name=make]').val();
            $(".modelOptions").html(`<option selected disabled>Populating Models...</option>`);

            $.ajax({
                url: '../cardata.php',
				method: 'post',
				data: {type: 'models', make: make},
                success: function(options) {
                    $(".modelOptions").html(options);
                },
                error: function(err) {
                    console.log(err);
                }
            });

            //When make changes
            $("select[name=make]").change(function() {
                const make = this.value;
                $(".modelOptions").html(`<option selected disabled>Populating Models...</option>`);

                $.ajax({
                    url: '../cardata.php',
                    method: 'post',
                    data: {type: 'models', make: make},
                    success: function(options) {
                        $(".modelOptions").html(options);
                    },
                    error: function(err) {
                            console.log(err);
                    }
                });
            });

            /* ===== Driver Years ===== */
            {
                let options = '';
                let year = new Date().getFullYear() - 16;
                const lastYear = year - 100;

                for (year; year >= lastYear; year--) {
                    options += `<option value="${year}">${year}</option>`;
                }
                $(".availableDOBYears").html(options);
            }
            
            /* ===== Address ===== */
            $(".zip").on('change keyup', function() {

                $(this).each(function() {
                    const zip = $(this).val();
                    const url = `https://maps.googleapis.com/maps/api/geocode/json?address=${zip}&key=AIzaSyAkV84Xk5gHRpupQUNDMgdEMEXy-6RbGRI`;

                    if (zip.length !== 5 || $.isNumeric(zip) === false) {
                        return false;
                    } else {
                        $.ajax({
                            url: url,
                            success: (data) => {
                                $(this).closest('.js-container').find('.address').val(data.results[0].formatted_address);
                            }
                        })
                    }
                });
            });

            /* ===== Insurance Past 30 ===== */
            if ($(".insurancePast30").val() == 'Yes') {
                $('.insuranceItem').show();
                // $(".insuranceItem input").prop("disabled", false);
                // $(".insuranceItem select").prop("disabled", false);
            } else {
                 $('.insuranceItem').hide();
                // $(".insuranceItem input").prop('disabled', true);
                // $(".insuranceItem select").prop('disabled', true);
            }
            
            $(".insurancePast30").change(function() {
                if (this.value == 'Yes') {
                    $('.insuranceItem').slideDown();
                    // $(".insuranceItem input").prop("disabled", false);
                    // $(".insuranceItem select").prop("disabled", false);
                } else {
                    $('.insuranceItem').slideUp();
                    // $(".insuranceItem input").prop('disabled', true);
                    // $(".insuranceItem select").prop('disabled', true);
                }
            });



            /* ===== Current Insurance ===== */
            $(".currentInsurance").each(function() {
                if ($(this).val() == 'Yes') {
                    $(this).closest('.currentInsuranceContainer').find('.currentInsuranceItem').show();
                    // $(".currentInsuranceItem").prop("disabled", false);
                    // $(".currentInsuranceItem").prop("disabled", false);
                } else {
                    $(this).closest('.currentInsuranceContainer').find('.currentInsuranceItem').hide();
                    // $(".currentInsuranceItem").prop('disabled', true);
                    // $(".currentInsuranceItem").prop('disabled', true);
                }
            });

            
            $(".currentInsurance").change(function() {
                if ($(this).val() == 'Yes') {
                    $(this).closest('.currentInsuranceContainer').find('.currentInsuranceItem').slideDown();
                    // $(".currentInsuranceItem input").prop("disabled", false);
                    // $(".currentInsuranceItem select").prop("disabled", false);
                } else {
                    $(this).closest('.currentInsuranceContainer').find('.currentInsuranceItem').slideUp();
                    // $(".currentInsuranceItem input").prop('disabled', true);
                    // $(".currentInsuranceItem select").prop('disabled', true);
                }
            });

        });


    </script>
</body>
</html>