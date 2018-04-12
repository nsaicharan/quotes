<?php 

session_start();

if (!$_SESSION['loggedInUser']) {
    header("Location: index.php");

} else {
    include('../conn.php');

    $message = '';

    if (isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        $query = "SELECT * FROM semi WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
    }

    if (isset($_POST['update'])) {
        foreach ($_POST as $key => $value) {
            $ $key = mysqli_real_escape_string($conn, htmlspecialchars($_POST[$key]));
        }

        $query = "UPDATE semi SET vehicle_year = '$vehicleYear', 
                 make = '$make',
                 model = '$model', 
                 ownership = '$ownership', 
                 primary_use = '$primaryUse', 
                 parking = '$parking', 
                 zip = '$zip', 
                 insurance = '$insurance', 
                 coverage = '$coverage', 
                 first_name = '$firstName', 
                 last_name = '$lastName',
                 email = '$email', 
                 phone = '$phone', 
                 address = '$address', 
                 gender = '$gender', 
                 education = '$education', 
                 marital_status = '$maritalStatus', 
                 residence = '$residence', 
                 driver_financial_form = '$driverFinancialForm' 
                 WHERE id = '$id' ";

        $result = mysqli_query($conn, $query);

        if ($result) {
            $message = '<div class="alert alert-success my-3">Data has been successfully updated. <button class="close" data-dismiss="alert">&times;</button> </div>';

            $query = "SELECT * FROM semi WHERE id = $id";
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
    <title>Edit | Semi Interested</title>
    
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
    <a href="<?php echo (isset($_GET['all'])) ? 'all.php' : 'semi.php' ?>" class="btn btn-primary m-4"><i class="fa fa-hand-o-left"></i> Back to listing page</a>

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
                <label for="vehicleYear">Vehicle Year:</label>
                <select class="form-control" name="vehicleYear" id="vehicleYear">
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
                <label for="make">Make:</label>
                <select class="form-control" name="make" id="make">
                    <optgroup label="Current Value:">
                        <option selected value="<?php echo $row['make']; ?>">
                            <?php echo $row['make']; ?> 
                        </option>
                    </optgroup>

                    <optgroup label="Available Options:" id="makeOptions">
                        
                    </optgroup>
                </select>
            </div>

            <div class="form-group">
                <label for="model">Model:</label>
                <select class="form-control" class="form-control" name="model" id="model">
                    <optgroup label="Current Value:">
                        <option selected value="<?php echo $row['model']; ?>">
                            <?php echo $row['model']; ?> 
                        </option>
                    </optgroup>

                    <optgroup label="Available Options:" id="modelOptions">
                        
                    </optgroup>
                </select>
            </div>

            <div class="form-group">
                <label for="ownership">Ownership:</label>
                <select class="form-control" name="ownership" id="ownership">
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
                <label for="primaryUse">Primary Use:</label>
                <select class="form-control" name="primaryUse" id="primaryUse">
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
                <label for="parking">Night Parking:</label>
                <select class="form-control" name="parking" id="parking">
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
                <label for="coverage">Desired Coverage:</label>
                <select class="form-control" name="coverage" id="coverage">
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
                <label for="insurance">Current Insurance Co. :</label>
                <input class="form-control" type="text" id="insurance" name="insurance" value="<?php echo $row['insurance']; ?>">
            </div>

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
                <label for="education">Educational Level:</label>
                <select class="form-control" name="education" id="education">
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
                <label for="zip">Zip Code:</label>
                <input class="form-control" type="text" id="zip" name="zip" pattern="\d*" minlength="5" maxlength="5" value="<?php echo $row['zip']; ?>">
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
                        <option value="Rent/Lease">Rent/Lease</option>
                        <option value="Other">Other</option>
                    </optgroup>
                </select>
            </div>

            <div class="form-group">
                <label for="address">Address:</label>
                <textarea class="form-control" id="address" type="text" name="address"><?php echo $row['address']; ?></textarea>
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


            
        </div>

        <div class="text-center my-4">
            <button type="submit" class="btn btn-primary btn-lg btn-block" name="update">Update</button>
        </div>
    </form> <!-- Form/Container -->
    
    <script src="assets/master.js"></script>
     
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
                    $("#makeOptions").html(options);
                },
                error: function(err) {
                    console.log(err);
                }
            });
            
            /* ===== Models ===== */
            //Initial Options
            const make = $('#make').val();
            $("#modelOptions").html(`<option selected disabled>Populating Models...</option>`);

            $.ajax({
                url: '../cardata.php',
				method: 'post',
				data: {type: 'models', make: make},
                success: function(options) {
                    $("#modelOptions").html(options);
                },
                error: function(err) {
                    console.log(err);
                }
            });

            //When make changes
            $("#make").change(function() {
                const make = this.value;
                $("#modelOptions").html(`<option selected disabled>Populating Models...</option>`);

                $.ajax({
                    url: '../cardata.php',
                    method: 'post',
                    data: {type: 'models', make: make},
                    success: function(options) {
                        $("#modelOptions").html(options);
                    },
                    error: function(err) {
                        console.log(err);
                    }
                });
            });

            /* ===== Address===== */
            $("#zip").on('change keyup', function() {
                const zip = $(this).val();
                const url = `https://maps.googleapis.com/maps/api/geocode/json?address=${zip}&key=AIzaSyAkV84Xk5gHRpupQUNDMgdEMEXy-6RbGRI`;

                if (zip.length !== 5 || $.isNumeric(zip) === false) {
                    return false;
                } else {
                    $.ajax({
                        url: url,
                        success: function(data) {
                            $('#address').val(data.results[0].formatted_address);
                        }
                    })
                }
            });
            
        })


    </script>
</body>
</html>