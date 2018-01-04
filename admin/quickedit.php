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

            $query = "SELECT * FROM quick WHERE id = $id";
            $result = mysqli_query($conn, $query);
            $row = mysqli_fetch_array($result);
        }

        if ( isset($_POST['update']) ) {
            $first = mysqli_real_escape_string($conn, $_POST['firstName']);
            $last = mysqli_real_escape_string($conn, $_POST['lastName']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $phone = mysqli_real_escape_string($conn, $_POST['phone']);
            $insurance = mysqli_real_escape_string($conn, $_POST['insurance']);
    
            $query = "UPDATE quick SET first = '$first', last = '$last', email = '$email', phone = '$phone', insurance = '$insurance' WHERE id = $id";
    
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
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.css">
    <link href="https://fonts.googleapis.com/css?family=Mate+SC|Montserrat:400,700|Satisfy|Open+Sans:400,700,300" rel="stylesheet">
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
    </style>
</head>
<body>
    <a href="data.php" class="btn btn-primary m-4"><i class="fa fa-hand-o-left"></i> Back to listing page</a>

    <div class="text-center mb-5">
        <h2>Update Information</h2>
        <p class="text-success">( User ID - <?php echo $id; ?> )</p>
    </div>

    <form class="container" action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
        <?php echo $message; ?>
        <div class="">
            <div class="form-group">
                <label for="firstName">First Name</label>
                <input class="form-control" type="text" id="firstName"  name="firstName" value="<?php echo $row['first']; ?>" required>
            </div>

            <div class="form-group">
                <label for="lastName">Last Name</label>
                <input class="form-control" type="text" id="lastName" name="lastName" value="<?php echo $row['last']; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control" type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input class="form-control" type="tel" name="phone" value="<?php echo $row['phone']; ?>" required>
            </div>

            <div class="form-group">
                <label for="insurance">Insurance Company</label>
                <input class="form-control" type="text" id="insurance" name="insurance" value="<?php echo $row['insurance']; ?>">
            </div>
        </div>

        <div class="text-center my-4">
            <button type="submit" class="btn btn-primary btn-lg btn-block" name="update">Update</button>
        </div>
    </form> <!-- Form/Container -->
    
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
</body>
</html>