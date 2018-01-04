<?php 

    session_start(); 

	if (!$_SESSION['loggedInUser']) {
		header("Location: index.php");
        exit();
        
    }  else {
        include('conn.php');

        $message = '';
        
        if ( isset($_GET['id']) ) {
            $id = mysqli_real_escape_string($conn, $_GET['id']);

            $query = "SELECT * FROM semi WHERE id = $id";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_array($result);
        }

        if ( isset($_POST['update']) ) {
            $vehicleYear = mysqli_real_escape_string($conn, $_POST['vehicleYear']);
            $make = mysqli_real_escape_string($conn, $_POST['make']);
            $model = mysqli_real_escape_string($conn, $_POST['model']);
            $ownership = mysqli_real_escape_string($conn, $_POST['ownership']);
            $primaryUse = mysqli_real_escape_string($conn, $_POST['primaryUse']);
            $parking = mysqli_real_escape_string($conn, $_POST['parking']);
            $zip = mysqli_real_escape_string($conn, $_POST['zip']);
            $insurance = mysqli_real_escape_string($conn, $_POST['insurance']);
            $coverage = mysqli_real_escape_string($conn, $_POST['coverage']);
            $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
            $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $phone = mysqli_real_escape_string($conn, $_POST['phone']);
            $gender = mysqli_real_escape_string($conn, $_POST['gender']);
            $education = mysqli_real_escape_string($conn, $_POST['education']);
            $occupation = mysqli_real_escape_string($conn, $_POST['occupation']);
            $maritalStatus = mysqli_real_escape_string($conn, $_POST['maritalStatus']);
            $residence = mysqli_real_escape_string($conn, $_POST['residence']);
            $creditEvaluation = mysqli_real_escape_string($conn, $_POST['creditEvaluation']);
            $driverFinancialForm = mysqli_real_escape_string($conn, $_POST['driverFinancialForm']);
    
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
                 gender = '$gender', 
                 education = '$education', 
                 occupation = '$occupation', 
                 marital_status = '$maritalStatus', 
                 residence = '$residence', 
                 credit_evaluation = '$creditEvaluation', 
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
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.css">
    <link href="https://fonts.googleapis.com/css?family=Mate+SC|Satisfy|Open+Sans:400,700,300" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

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
    <a href="semi.php" class="btn btn-primary m-4"><i class="fa fa-hand-o-left"></i> Back to listing page</a>

    <div class="text-center mb-3">
        <h2>Update Information</h2>
        <p class="text-success">( User ID - <?php echo $id; ?> )</p>
    </div>

    <form class="container" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
        <?php echo $message; ?>

        <div class="text-center">
            <h3>Vehicle Details</h3>
        </div>

        <div>
            <div class="form-group">
                <label for="vehicleYear">Vehicle Year:</label>
                <select class="form-control" name="vehicleYear" id="vehicleYear" required>
                    <optgroup label="Current Value:">
                        <option selected value="<?php echo $row['vehicle_year']; ?>">
                           <?php echo $row['vehicle_year']; ?> 
                        </option>
                    </optgroup>

                    <optgroup label="Available Options:">
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
                    </optgroup>
                </select>
            </div>

            <div class="form-group">
                <label for="make">Make:</label>
                <select class="form-control" name="make" id="make" required>
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
                <select class="form-control" class="form-control" name="model" id="model" required>
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
                <select class="form-control" name="ownership" id="ownership" required>
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
                <select class="form-control" name="primaryUse" id="primaryUse" required>
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
                <select class="form-control" name="parking" id="parking" required>
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
                <label for="zip">Zip code:</label>
                <input class="form-control" type="text" id="zip" name="zip" required value="<?php echo $row['zip']; ?>">
            </div>

            <div class="form-group">
                <label for="insurance">Insurance Company (Optional):</label>
                <input class="form-control" type="text" id="insurance" name="insurance" value="<?php echo $row['insurance']; ?>">
            </div>

            <div class="form-group">
                <label for="coverage">Desired Amount of Coverage:</label>
                <select class="form-control" name="coverage" id="coverage" required>
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

            <div class="text-center">
                <h3>Driver Details</h3>
            </div>

            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input class="form-control" type="text" id="firstName"  name="firstName" value="<?php echo $row['first_name']; ?>" required>
            </div>

            <div class="form-group">
                <label for="lastName">Last Name:</label>
                <input class="form-control" type="text" id="lastName" name="lastName" value="<?php echo $row['last_name']; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input class="form-control" type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input class="form-control" type="tel" name="phone" value="<?php echo $row['phone']; ?>" required>
            </div>

            <div class="form-group">
                <label for="gender">Gender:</label>
                <select class="form-control" name="gender" id="coverage" required>
                    <optgroup label="Current Value:">
                        <option selected value="<?php echo $row['gender']; ?>">
                            <?php echo $row['gender']; ?> 
                        </option>
                    </optgroup>

                    <optgroup label="Available Options:">
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Transgender">Transgender</option>
                    </optgroup>
                </select>
            </div>
            
            <div class="form-group">
                <label for="education">Educational Level:</label>
                <select class="form-control" name="education" id="education" required>
                    <optgroup label="Current Value:">
                        <option selected value="<?php echo $row['education']; ?>">
                            <?php echo $row['education']; ?> 
                        </option>
                    </optgroup>

                    <optgroup label="Available Options:">
                        <option value="High School">High School Diploma</option>
                        <option value="Bachelor's degree">Bachelor's degree</option>
                        <option value="Master's Degree">Master's Degree</option>
                        <option value="PHD">PHD</option>
                        <option value="Other">Other</option>
                    </optgroup>
                </select>
            </div>


            <div class="form-group">
                <label for="occupation">Occupation:</label>
                <select class="form-control" name="occupation" id="occupation" required>
                    <optgroup label="Current Value:">
                        <option selected value="<?php echo $row['occupation']; ?>">
                            <?php echo $row['occupation']; ?> 
                        </option>
                    </optgroup>

                    <optgroup label="Available Options:">
                        <option value="Employee">Employee</option>
                        <option value="Worker">Worker</option>
                        <option value="Manager">Manager</option>
                        <option value="Entrepreneur">Entrepreneur</option>
                    </optgroup>
                </select>
            </div>

            <div class="form-group">
                <label for="maritalStatus">Marital Status:</label>
                <select class="form-control" name="maritalStatus" id="maritalStatus" required>
                    <optgroup label="Current Value:">
                        <option selected value="<?php echo $row['marital_status']; ?>">
                            <?php echo $row['marital_status']; ?> 
                        </option>
                    </optgroup>

                    <optgroup label="Available Options:">
                        <option value="Single">Single</option>
                        <option value="Married">Married</option>
                        <option value="Manager">Domestic Partner</option>
                        <option value="Divorced/Separated">Divorced/Separated</option>
                        <option value="Widowed">Widowed</option>
                    </optgroup>
                </select>
            </div>
            
            <div class="form-group">
                <label for="residence">Residence:</label>
                <select class="form-control" name="residence" id="residence" required>
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
                <label for="creditEvaluation">Credit Evaluation:</label>
                <select class="form-control" name="creditEvaluation" id="creditEvaluation" required>
                    <optgroup label="Current Value:">
                        <option selected value="<?php echo $row['credit_evaluation']; ?>">
                            <?php echo $row['credit_evaluation']; ?> 
                        </option>
                    </optgroup>

                    <optgroup label="Available Options:">
                        <option value="Good">Good</option>
                        <option value="Average">Average</option>
                        <option value="Bad">Bad</option>
                    </optgroup>
                </select>
            </div>

            <div class="form-group">
                <span class="font-weight-bold">Does this driver needs Financial Responsibility Form (SR/22)?</span>

                <div>
                    <label class="mr-2 font-weight-normal">
                        <input type="radio" name="driverFinancialForm" value="Yes" required <?php echo ($row['driver_financial_form'] == 'Yes') ? 'checked' : ''; ?>>
                        Yes
                    </label>

                    <label class="ml-2 font-weight-normal">
                        <input type="radio" name="driverFinancialForm" value="No" required <?php echo ($row['driver_financial_form'] == 'No') ? 'checked' : ''; ?>>
                        No
                    </label>
                </div>
            </div>


            
        </div>

        <div class="text-center my-4">
            <button type="submit" class="btn btn-primary btn-lg btn-block" name="update">Update</button>
        </div>
    </form> <!-- Form/Container -->
    
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
     
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

                    $("#makeOptions").html(makeOptions);
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
                url: `https://cors-anywhere.herokuapp.com/https://www.carqueryapi.com/api/0.3/?cmd=getModels&make=${make}&sold_in_us=1`,
                method: 'GET',
                success: function(data) {
                    console.log(data); 
                    console.log(data.Models);

                    const models = data.Models;
                    const modelOptionsArray = models.map(model => {
                        return `<option value="${model.model_name}">${model.model_name}</option>`;
                    });

                    const modelOptions = modelOptionsArray.join('');
            
                    $("#modelOptions").html(modelOptions);
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
                    url: `https://cors-anywhere.herokuapp.com/https://www.carqueryapi.com/api/0.3/?cmd=getModels&make=${make}&sold_in_us=1`,
                    method: 'GET',
                    success: function(data) {
                        console.log(data); 
                        console.log(data.Models);

                        const models = data.Models;
                        const modelOptionsArray = models.map(model => {
                            return `<option value="${model.model_name}">${model.model_name}</option>`;
                        });

                        const modelOptions = modelOptionsArray.join('');
    
                        $("#modelOptions").html(modelOptions);
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