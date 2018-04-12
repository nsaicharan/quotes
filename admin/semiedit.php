<?php 

session_start();

if (!$_SESSION['loggedInUser']) {
    header("Location: index.php");

} else {
    include('../conn.php');

    $message = '';

    if (isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        $query = "SELECT * FROM semi_drivers WHERE id = '$id'";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
    }

    if (isset($_POST['update'])) {
        
        // Driver Details
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
        $driverFinancialForm = mysqli_real_escape_string($conn, $_POST['driverFinancialForm']);

        $query = "UPDATE semi_drivers SET 
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
                 driver_financial_form = '$driverFinancialForm' 
                 WHERE id = '$id' ";

        $result = mysqli_query($conn, $query);

        if ($result) {
            $message = '<div class="alert alert-success my-3">Data has been successfully updated. <button class="close" data-dismiss="alert">&times;</button> </div>';

            $query = "SELECT * FROM semi_drivers WHERE id = '$id'";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_array($result);

            $_SESSION['edit'] = $id;
        } else {
            $message = '<div class="alert alert-danger my-3">Something went wrong! <button class="close" data-dismiss="alert">&times;</button> </div>';
        }

        // Vehicle Details
        $vehiclesquery = "SELECT * FROM semi_vehicles WHERE driver LIKE '$id'";
        $vehiclesresult = mysqli_query($conn, $vehiclesquery);

        if ( mysqli_num_rows($vehiclesresult) > 0) {

            $i = 0;
            while ($vehiclesrow = mysqli_fetch_array($vehiclesresult)) {

                $vehicleID = $vehiclesrow['id'];

                $vehicleYear = mysqli_real_escape_string($conn, $_POST['vehicleYear'][$i]);
                $make = mysqli_real_escape_string($conn, $_POST['make'][$i]);
                $model = mysqli_real_escape_string($conn, $_POST['model'][$i]);
                $ownership = mysqli_real_escape_string($conn, $_POST['ownership'][$i]);
                $primaryUse = mysqli_real_escape_string($conn, $_POST['primaryUse'][$i]);
                $coverage = mysqli_real_escape_string($conn, $_POST['coverage'][$i]);
                $insurance = mysqli_real_escape_string($conn, $_POST['insurance'][$i]);

                $query = "UPDATE semi_vehicles SET 

                            vehicle_year = '$vehicleYear',
                            make = '$make',
                            model = '$model',
                            ownership = '$ownership',
                            primary_use = '$primaryUse',
                            coverage = '$coverage', 
                            insurance = '$insurance'

                        WHERE id = '$vehicleID'";

                if (!mysqli_query($conn, $query)) {
                    $message = '<div class="alert alert-danger my-3">Something went wrong while updating vehicle details! <button class="close" data-dismiss="alert">&times;</button> </div>';
                }

                $i++;
            }

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
    <title>Edit | Semi Interested</title>
    
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
    <a href="<?php echo (isset($_GET['all'])) ? 'all.php' : 'semi.php' ?>" class="btn btn-primary m-4"><i class="fa fa-hand-o-left"></i> Back to listing page</a>

    <div class="text-center mb-3">
        <h2>Update Information</h2>
        <p class="text-success">(Driver ID - <?php echo $id; ?>)</p>
    </div>

    <form class="container" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
        <?php echo $message; ?>

        <div>
            
            <div class="text-center">
                <h3>Driver Details</h3>
            </div>

            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input class="form-control" type="text" id="firstName"  name="firstName" value="<?php echo $row['first_name']; ?>">
            </div>

            <div class="form-group">
                <label for="lastName">Last Name:</label>
                <input class="form-control" type="text" id="lastName" name="lastName" value="<?php echo $row['last_name']; ?>">
            </div>

            <div class="form-group">
                <label for="gender">Gender:</label>
                <select class="form-control" name="gender" id="coverage">
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
                <label for="email">Email:</label>
                <input class="form-control" type="email" id="email" name="email" value="<?php echo $row['email']; ?>">
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input class="form-control" type="tel" id="phone" name="phone" value="<?php echo $row['phone']; ?>">
            </div>
            
            <div class="form-group">
                <label for="student">Student?</label>
                <select class="form-control" name="student" id="student">
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
                <label for="maritalStatus">Marital Status:</label>
                <select class="form-control" name="maritalStatus" id="maritalStatus">
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
                <label for="residence">Residence:</label>
                <select class="form-control" name="residence" id="residence">
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
                <label for="zip">Zip Code:</label>
                <input class="form-control" type="text" id="zip" name="zip" pattern="[0-9]{5}" maxlength="5" title="Five-Digit ZIP Code" value="<?php echo $row['zip']; ?>">
            </div>

            <div class="form-group">
                <label for="street">Street Address:</label>
                <input class="form-control" id="street" type="text" name="street" value="<?php echo $row['street']; ?>">
            </div>

            <div class="form-group">
                <label for="cityState">City, State, Country:</label>
                <input class="form-control" type="text" id="cityState" name="cityState" value="<?php echo $row['city_state']; ?>">
            </div>

            <div class="form-group">
                <span class="font-weight-bold">Need SR/22?</span>

                <div>
                    <label class="mr-2 font-weight-normal">
                        <input type="radio" name="driverFinancialForm" value="Yes" <?php echo ($row['driver_financial_form'] == 'Yes') ? 'checked' : ''; ?>>
                        Yes
                    </label>

                    <label class="ml-2 font-weight-normal">
                        <input type="radio" name="driverFinancialForm" value="No" <?php echo ($row['driver_financial_form'] == 'No') ? 'checked' : ''; ?>>
                        No
                    </label>
                </div>
            </div>
            

            <?php 
                $query = "SELECT * FROM semi_vehicles WHERE driver LIKE '$id'";
                $result = mysqli_query($conn, $query);

                $vehicleCount = (mysqli_num_rows($result) > 1) ? 1 : '';

                while ( $row = mysqli_fetch_array($result) ) :
            ?>
            
            <div class="js-container">
                <div class="text-center">
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
                    <label>Desired Coverage:</label>
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

                <div class="form-group">
                    <label>Current Insurance Co. :</label>
                    <input class="form-control" type="text" name="insurance[]" value="<?php echo $row['insurance']; ?>">
                </div>
            </div> <!-- JS Container -->

            <?php $vehicleCount++; endwhile; ?>
        </div>

        <div class="text-center my-4">
            <button type="submit" class="btn btn-primary btn-lg btn-block" name="update">Update</button>
        </div>
    </form> <!-- Form/Container -->
    
    <script src="assets/library.js"></script>
     
    <script>

        $(document).ready(function() {

            /* ===== Vehicle Years ===== */
			let options = '';
			let year = new Date().getFullYear();
			const lastYear = year - 35;

			for (year; year >= lastYear; year--) {
				options += `<option value="${year}">${year}</option>`;
			}
			$(".availVehicleYears").html(options);
            
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