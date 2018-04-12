<?php 

session_start();

if (!$_SESSION['loggedInUser']) {
    header("Location: index.php");

} else {
    include('../conn.php');

    $message = '';

    if (isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        $query = "SELECT * FROM ready_drivers WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
    }

    if (isset($_POST['update'])) {
        $vehicleYear = $make = $model = $vin = $ownership = $parking = $primaryUse = $mileage = $zip = $street = $cityState = $coverage = $insurancePast30 = $insuranceCompany = $expireMonth = $expireYear = $yearsInsured = $injuryLiabilityLimit = $firstName = $lastName = $gender = $email = $phone = $address = $maritalStatus = $education = $residence = $licence = $licenceAge = $dobMonth = $dobDate = $dobYear = $licenceSuspended = $driverFinancialForm = $speedingTickets = $duiDWI = "";

        $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
        $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
        $gender = mysqli_real_escape_string($conn, $_POST['gender']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $student = mysqli_real_escape_string($conn, $_POST['student']);
        $maritalStatus = mysqli_real_escape_string($conn, $_POST['maritalStatus']);
        $residence = mysqli_real_escape_string($conn, $_POST['residence']);
        $zip = mysqli_real_escape_string($conn, $_POST['zip']);
        $street = mysqli_real_escape_string($conn, $_POST['street']);
        $cityState = mysqli_real_escape_string($conn, $_POST['cityState']);
        $licence = mysqli_real_escape_string($conn, $_POST['licence']);
        $licenceState = mysqli_real_escape_string($conn, $_POST['licenceState']);
        $licenceAge = mysqli_real_escape_string($conn, $_POST['licenceAge']);
        $dobMonth = mysqli_real_escape_string($conn, $_POST['dobMonth']);
        $dobDate = mysqli_real_escape_string($conn, $_POST['dobDate']);
        $dobYear = mysqli_real_escape_string($conn, $_POST['dobYear']);
        $speedingTickets = mysqli_real_escape_string($conn, $_POST['speedingTickets']);
        $duiDWI = mysqli_real_escape_string($conn, $_POST['duiDWI']);
        $licenceSuspended = mysqli_real_escape_string($conn, $_POST['licenceSuspended']);
        $driverFinancialForm = mysqli_real_escape_string($conn, $_POST['driverFinancialForm']);

        $query = "UPDATE ready_drivers SET 

                        first_name = '$firstName', 
                        last_name = '$lastName', 
                        gender = '$gender', 
                        email = '$email', 
                        phone = '$phone', 
                        student = '$student', 
                        marital_status = '$maritalStatus', 
                        residence = '$residence', 
                        zip = '$zip',
                        street = '$street', 
                        city_state = '$cityState', 
                        licence = '$licence', 
                        licence_state = '$licenceState', 
                        licence_age = '$licenceAge', 
                        dob_month = '$dobMonth', 
                        dob_date = '$dobDate', 
                        dob_year = '$dobYear', 
                        licence_suspended = '$licenceSuspended', 
                        driver_financial_form = '$driverFinancialForm', 
                        speeding_tickets = '$speedingTickets', 
                        dui_dwi = '$duiDWI'

                        WHERE id = '$id' ";

        $result = mysqli_query($conn, $query);

        $vehiclesquery = "SELECT * FROM ready_vehicles WHERE driver LIKE '$id'";
        $vehiclesresult = mysqli_query($conn, $vehiclesquery);

        $i = 0;
        while ($vehiclesrow = mysqli_fetch_array($vehiclesresult)) {

            $vehicleID = $vehiclesrow['id'];

            $vehicleYear = mysqli_real_escape_string($conn, $_POST['vehicleYear'][$i]);
            $make = mysqli_real_escape_string($conn, $_POST['make'][$i]);
            $model = mysqli_real_escape_string($conn, $_POST['model'][$i]);
            $vin = mysqli_real_escape_string($conn, $_POST['vin'][$i]);
            $ownership = mysqli_real_escape_string($conn, $_POST['ownership'][$i]);
            $primaryUse = mysqli_real_escape_string($conn, $_POST['primaryUse'][$i]);
            $mileage = mysqli_real_escape_string($conn, $_POST['mileage'][$i]);
            $coverage = mysqli_real_escape_string($conn, $_POST['coverage'][$i]);
            $insurancePast30 = mysqli_real_escape_string($conn, $_POST['insurancePast30'][$i]);
            $insuranceCompany = mysqli_real_escape_string($conn, $_POST['insuranceCompany'][$i]);
            $expireMonth = mysqli_real_escape_string($conn, $_POST['expireMonth'][$i]);
            $expireYear = mysqli_real_escape_string($conn, $_POST['expireYear'][$i]);
            $yearsInsured = mysqli_real_escape_string($conn, $_POST['yearsInsured'][$i]);
            $injuryLiabilityLimit = mysqli_real_escape_string($conn, $_POST['injuryLiabilityLimit'][$i]);
           
            $query = "UPDATE ready_vehicles SET 

                        vehicle_year = '$vehicleYear',
                        make = '$make',
                        model = '$model',
                        vin = '$vin',
                        ownership = '$ownership',
                        primary_use = '$primaryUse',
                        mileage = '$mileage',
                        coverage = '$coverage', 
                        insurance_past_30 = '$insurancePast30', 
                        insurance_company = '$insuranceCompany', 
                        expire_month = '$expireMonth', 
                        expire_year = '$expireYear', 
                        years_insured = '$yearsInsured', 
                        injury_liability_limit = '$injuryLiabilityLimit'        
                        
                        WHERE id = '$vehicleID'";

            $result = mysqli_query($conn, $query);

            $i++;
        }


        if ($result) {
            $message = '<div class="alert alert-success mt-4 mb-2">Data has been successfully updated. <button class="close" data-dismiss="alert">&times;</button> </div>';

            $query = "SELECT * FROM ready_drivers WHERE id = $id";
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
    
    <link rel="stylesheet" href="assets/library.css">
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
        <p class="text-success">(Driver ID - <?php echo $id; ?>)</p>
    </div>

    <form class="container" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
        <?php echo $message; ?>

        <div class="text-center">
            <h3 class="mb-3">Driver Details</h3>
        </div>

        <div class="form-group">
            <label>First Name:</label>
            <input class="form-control" type="text"  name="firstName" value="<?php echo $row['first_name']; ?>">
        </div>

        <div class="form-group">
            <label>Last Name:</label>
            <input class="form-control" type="text" name="lastName" value="<?php echo $row['last_name']; ?>">
        </div>

        <div class="form-group">
            <label>Gender:</label>
            <select class="form-control" name="gender">
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
            <input class="form-control"  name="email" value="<?php echo $row['email']; ?>">
        </div>

        <div class="form-group">
            <label>Phone Number:</label>
            <input class="form-control" type="tel" name="phone" value="<?php echo $row['phone']; ?>">
        </div>
        
        <div class="form-group">
            <label>Student?</label>
            <select class="form-control" name="student">
                <optgroup label="Current Value:">
                    <option selected value="<?php echo $row['student']; ?>">
                        <?php echo $row['student']; ?> 
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
            <select class="form-control" name="maritalStatus">
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

        <div class="form-group">
            <label>Residence:</label>
            <select class="form-control" name="residence">
                <optgroup label="Current Value:">
                    <option selected value="<?php echo $row['residence']; ?>">
                        <?php echo $row['residence']; ?> 
                    </option>
                </optgroup>

                <optgroup label="Available Options:">
                    <option value="Own">Own</option>
                    <option value="Rent">Rent</option>
                    <option value="Other">Other</option>
                </optgroup>
            </select>
        </div>
       
        <div class="form-group">
            <label>ZIP Code:</label>
            <input class="form-control zip" type="text" name="zip" pattern="[0-9]{5}" maxlength="5" title="Five-Digit ZIP Code" value="<?php echo $row['zip']; ?>">
        </div>

            
        <div class="form-group">
            <label>Street Address:</label>
            <input class="form-control street" type="text" name="street" value="<?php echo $row['street']; ?>">
        </div>
       
         <div class="form-group">
            <label>City, State, Country:</label>
            <input class="form-control cityState" type="text" name="cityState" value="<?php echo $row['city_state']; ?>">
        </div>

        <div class="form-group">
            <label>Driver Licence Number:</label>
            <input type="text" class="form-control" name="licence" value="<?php echo $row['licence']; ?>">
        </div>

        <div class="form-group">
            <label>Driver's License State:</label>
            <select class="form-control" name="licenceState">
                <optgroup label="Current Value:">
                    <option selected value="<?php echo $row['licence_state']; ?>">
                        <?php echo $row['licence_state']; ?> 
                    </option>
                </optgroup>

                <optgroup label="Available Options:">
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
                </optgroup>
            </select>
        </div>

        <div class="form-group">
            <label>Age First Licensed:</label>
            <input type="number" class="form-control" name="licenceAge" value="<?php echo $row['licence_age']; ?>">
        </div>

        <div class="form-group">
            <label>What's this driver's date of birth?</label>
            
            <div class="row">
                <div class="col pr-1">
                    <select class="form-control" name="dobMonth">
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
                    <select  class="form-control" name="dobDate">
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
                    <select class="form-control" name="dobYear">
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
            <label>Any tickets/accidents within the last 3 years?</label>
            <select class="form-control" name="speedingTickets">
               <option value="Yes" <?php echo ($row['speeding_tickets'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
               <option value="No" <?php echo ($row['speeding_tickets'] == 'No') ? 'selected' : ''; ?>>No</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Any DUI/DWI in the past 5 years?</label>
            <select class="form-control" name="duiDWI">
               <option value="Yes" <?php echo ($row['dui_dwi'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
               <option value="No" <?php echo ($row['dui_dwi'] == 'No') ? 'selected' : ''; ?>>No</option>
            </select>
        </div>

        <div class="form-group">
            <label>Has driver license been suspended/revoked in the last 5 years?</label>
            <select class="form-control" name="licenceSuspended">
               <option value="Yes" <?php echo ($row['licence_suspended'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
               <option value="No" <?php echo ($row['licence_suspended'] == 'No') ? 'selected' : ''; ?>>No</option>
            </select>
        </div>

        <div class="form-group">
            <label>Need SR/22?</label>
            <select class="form-control" name="driverFinancialForm">
               <option value="Yes" <?php echo ($row['driver_financial_form'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
               <option value="No" <?php echo ($row['driver_financial_form'] == 'No') ? 'selected' : ''; ?>>No</option>
            </select>
        </div>


        <?php 
            $id = $row['id'];

            $query = "SELECT * FROM ready_vehicles WHERE driver LIKE '$id'";
            $result = mysqli_query($conn, $query);

            $vehicleCount = (mysqli_num_rows($result) > 1) ? 1 : '';

            while ($row = mysqli_fetch_array($result)) :
        ?>

        <div class="js-container">

            <div class="text-center mb-3">
                <h3>Vehicle <?php echo $vehicleCount; ?> Details</h3>
            </div>

            <div class="form-group">
                <label>Vehicle Year:</label>
                <select class="form-control" name="vehicleYear[]">
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
                <select class="form-control make" name="make[]">
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
                <select class="form-control" class="form-control" name="model[]">
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
                <input class="form-control" type="text" name="vin[]" value="<?php echo $row['vin']; ?>">
            </div>

            <div class="form-group">
                <label>Ownership:</label>
                <select class="form-control" name="ownership[]">
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
                <label>Primary Use:</label>
                <select class="form-control" name="primaryUse[]">
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
                <select class="form-control" name="mileage[]">
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
                <select class="form-control" name="coverage[]">
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
                    <select class="form-control insurancePast30" name="insurancePast30[]">
                       <option value="Yes" <?php echo ($row['insurance_past_30'] == 'Yes') ? 'selected' : ''; ?>>Yes</option>
                       <option value="No" <?php echo ($row['insurance_past_30'] == 'No') ? 'selected' : ''; ?>>No</option>
                    </select>
                </div>
                
                <div class="form-group insuranceItem">
                    <label>Insurance Company:</label>
                    <input type="text" class="form-control" name="insuranceCompany[]" value="<?php echo $row['insurance_company']; ?>">
                </div>
                
                <div class="form-group insuranceItem">
                    <label>Insurance Expiration Date:</label>
                    
                    <div class="row ">
                        <div class="col pr-1">
                            <select class="form-control" name="expireMonth[]">
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
                            <select class="form-control" name="expireYear[]">
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
                    <select class="form-control" name="yearsInsured[]">
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
                    <select class="form-control" name="injuryLiabilityLimit[]">
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
           
        </div> <!-- JS Container -->
        <?php $vehicleCount++; endwhile; ?>

        <div class="text-center my-4">
            <button type="submit" class="btn btn-primary btn-lg btn-block" name="update">Update</button>
        </div>
    </form> <!-- Form/Container -->
    
    <script src="assets/library.js"></script>
     
    <script>

        $(document).ready(function() {

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
            $('.make').each(function() {
                const make = $(this).val();

                $(this).closest('.js-container').find('.modelOptions').html(`<option selected disabled>Populating Models...</option>`);

                $.ajax({
                    url: '../cardata.php',
                    method: 'post',
                    data: {type: 'models', make: make},
                    success: (options) => {
                        $(this).closest('.js-container').find('.modelOptions').html(options);
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });

            //When make changes
            $(".make").change(function() {
                const make = this.value;
                $(this).closest('.js-container').find(".modelOptions").html(`<option selected disabled>Populating Models...</option>`);

                $.ajax({
                    url: '../cardata.php',
                    method: 'post',
                    data: {type: 'models', make: make},
                    success: (options) => {
                       $(this).closest('.js-container').find(".modelOptions").html(options);
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });
            
            /* ===== City, State ===== */
            $(".zip").on('change keyup', function() {
                const zip = $(this).val();
                const url = `https://maps.googleapis.com/maps/api/geocode/json?address=${zip}&key=AIzaSyAkV84Xk5gHRpupQUNDMgdEMEXy-6RbGRI`;

                if (zip.length !== 5 || $.isNumeric(zip) === false) {
                    return false;
                } else {
                    $.ajax({
                        url: url,
                        success: function(response) {
                            const data = response.results[0].formatted_address.replace(` ${zip}`, '');
                            $('.cityState').val(data);
                        }
                    })
                }
            });

            /* ===== Current Insurance ===== */
            $(".currentInsurance").each(function() {
                if ($(this).val() == 'Yes') {
                    $(this).closest('.currentInsuranceContainer').find('.currentInsuranceItem').show();
                } else {
                    $(this).closest('.currentInsuranceContainer').find('.currentInsuranceItem').hide();
                }
            });
            
            $(".currentInsurance").change(function() {
                if ($(this).val() == 'Yes') {
                    $(this).closest('.currentInsuranceContainer').find('.currentInsuranceItem').slideDown();
                } else {
                    $(this).closest('.currentInsuranceContainer').find('.currentInsuranceItem').slideUp();
                }
            });

            /* ===== Insurance Past 30 ===== */
            $(".insurancePast30").each(function() {
                if ($(this).val() == 'Yes') {
                    $(this).closest('.js-container').find('.insuranceItem').show();
                } else {
                    $(this).closest('.js-container').find('.insuranceItem').hide();
                }
            });
           
            $(".insurancePast30").change(function() {
                if (this.value == 'Yes') {
                    $(this).closest('.js-container').find('.insuranceItem').slideDown();
                } else {
                    $(this).closest('.js-container').find('.insuranceItem').slideUp();
                }
            });

        });


    </script>
</body>
</html>