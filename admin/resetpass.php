<?php 

$success = "";
$error = "";

if (isset($_GET['username']) && isset($_GET['token'])) {

    include('../conn.php');

    $formUser = $_GET['username'];
    $formToken = $_GET['token'];

    if (isset($_POST['submit'])) {

        $secretKey = '6Lc_OkoUAAAAAJM1LMpNV5Qj_OdiajmKJXWT2c8Z';
        $response = $_POST['g-recaptcha-response'];
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $url = 'https://www.google.com/recaptcha/api/siteverify';

        $response = json_decode(file_get_contents("$url?secret=$secretKey&response=$response&remoteip=$remoteip"));

        if ($response->success) {
            $formPass = mysqli_real_escape_string($conn, $_POST['password']);
            $formCPass = mysqli_real_escape_string($conn, $_POST['cpassword']);

            if ($formPass != $formCPass) {
                
                $error = "<p class='error'>Passwords didn't match, please try again.</p>";

            } else {
                $query = "SELECT * FROM users WHERE username = ? AND token = ? AND token <> '' AND expire > NOW()";
                $stmt = mysqli_stmt_init($conn);

                mysqli_stmt_prepare($stmt, $query);
                mysqli_stmt_bind_param($stmt, 'ss', $formUser, $formToken);
                mysqli_stmt_execute($stmt);

                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_array($result);

                if (mysqli_num_rows($result) > 0) {
                    //Insert into new hashed password into db
                    $hashedPass = password_hash($formPass, PASSWORD_DEFAULT);

                    $query = "UPDATE users SET token = '', password = ? WHERE username = ?";
                    $stmt = mysqli_stmt_init($conn);

                    mysqli_stmt_prepare($stmt, $query);
                    mysqli_stmt_bind_param($stmt, 'ss', $hashedPass, $formUser);
                    mysqli_stmt_execute($stmt);

                    $success = '<p class="success">Your password has been reset.</p> <p class="success">You can now <a href="index.php">login</a> using your new password.</p>';
                } else {
                    $error = '<p class="error">Password reset link is invalid or has expired.</p>';
                }
            }
        } else {
            $error = '<p class="error">Verification Failed!</p>';
        }
    }
} else {
    header("Location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
    <link href="https://fonts.googleapis.com/css?family=Mate+SC" rel="stylesheet">
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
			background: linear-gradient( 135deg, #3C8CE7 10%, #00EAFF 100%) fixed;
            font-family:  -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            display: flex;
            align-items: center;
        }

        * {
            box-sizing: border-box;
        }

        form {
            width: 550px;
            max-width: 95vw;
            margin: 20px auto;
            background: white;
            padding: 50px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }

        @media (max-width: 480px) {
            form {
                padding: 30px 20px;
            }
        }

        h1 {
            color: hsl(217, 71%, 53%)	;
            font-family: 'Mate SC';
            margin: 0 0 30px;
            font-size: 35px;
            font-weight: normal;
        }

        label {
            font-weight: 500;
            color: #2c3e50;
        }

        input {
            width: 100%;
            border: none;
            padding: 12px 20px;
            margin: 5px 0 12px;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 3px;
            font-size: 18px;
            font-family:  -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        button {
            display: block;
            width: 100%;
            border: none;;
            background: hsl(217, 71%, 53%);
            color: white;
            padding: 10px;
            margin-top: 15px;
            font-size: 25px;
            font-family: 'Mate SC', sans-serif;
            border-radius: 3px;
            letter-spacing: 1px;
            cursor: pointer;
        }

        p {
            font-weight: 500;
            transition: .3s;
        }

        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
    <form action="" method="post">
        <h1>Reset Password</h1>

        <?php echo $success . $error ?>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>

        <label for="cpassword">Confirm Password:</label>
        <input type="password" name="cpassword" id="cpassword" required>

        <div class="g-recaptcha" data-sitekey="6Lc_OkoUAAAAAD8hbOqzogjHWZIRzFq2_u9KAnV2"></div>

        <button type="submit" name="submit">Submit</button>
    </form>

    <script src='https://www.google.com/recaptcha/api.js'></script>
</body>
</html>