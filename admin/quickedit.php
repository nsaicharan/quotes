<?php 

session_start();

if (!$_SESSION['loggedInUser']) {
    header("Location: index.php");

} else {
    include('../conn.php');

    $message = '';

    if (isset($_GET['id'])) {
        $id = mysqli_real_escape_string($conn, $_GET['id']);

        $query = "SELECT * FROM quick WHERE id = $id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_array($result);
    }

    if (isset($_POST['update'])) {
        
        foreach ($_POST as $key => $value) {
            $$key = mysqli_real_escape_string($conn, $_POST[$key]);
        }

        $query = "UPDATE quick SET first = '$firstName', last = '$lastName', email = '$email', phone = '$phone', street = '$street', city_state = '$cityState', insurance = '$insurance' WHERE id = $id";

        $result = mysqli_query($conn, $query);

        if ($result) {
            $message = '<div class="alert alert-success mb-4">Data has been successfully updated. <button class="close" data-dismiss="alert">&times;</button> </div>';

            $query = "SELECT * FROM quick WHERE id = $id";
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
    <title>Edit | Just Curious</title>

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
    </style>
</head>
<body>
    <a href="<?php echo (isset($_GET['all'])) ? 'all.php' : 'quick.php' ?>" class="btn btn-primary m-4"><i class="fa fa-hand-o-left"></i> Back to listing page</a>

    <div class="text-center mb-5">
        <h2>Update Information</h2>
        <p class="text-success">( ID - <?php echo $id; ?> )</p>
    </div>

    <form class="container" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
        <?php echo $message; ?>
        <div class="">
            <div class="form-group">
                <label for="firstName">First Name:</label>
                <input class="form-control" type="text" id="firstName"  name="firstName" value="<?php echo $row['first']; ?>" required>
            </div>

            <div class="form-group">
                <label for="lastName">Last Name:</label>
                <input class="form-control" type="text" id="lastName" name="lastName" value="<?php echo $row['last']; ?>" required>
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
                <label for="zip">ZIP Code:</label>
                <input class="form-control" type="text" id="zip" name="zip" maxlength="5" value="<?php echo $row['zip']; ?>" required>
            </div>

             <div class="form-group">
                <label for="street">Street Address:</label>
                <input class="form-control" type="text" id="street" name="street" value="<?php echo $row['street']; ?>" required>
            </div>

             <div class="form-group">
                <label for="cityState">City, State, Country:</label>
                <input class="form-control" type="text" id="cityState" name="cityState" value="<?php echo $row['city_state']; ?>" required>
            </div>

            <div class="form-group">
                <label for="insurance">Current Insurance Company:</label>
                <input class="form-control" type="text" id="insurance" name="insurance" value="<?php echo $row['insurance']; ?>">
            </div>
        </div>

        <div class="text-center my-4">
            <button type="submit" class="btn btn-primary btn-lg btn-block" name="update">Update</button>
        </div>
    </form> <!-- Form/Container -->
    
    <script src="assets/library.js"></script>
    <script>
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
    </script>
</body>
</html>