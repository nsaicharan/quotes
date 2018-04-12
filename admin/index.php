<?php 

session_start();

if (isset($_SESSION['loggedInUser'])) {

    header("Location: all.php");

} else {

    include('../conn.php');

    $message = '';

    if (isset($_POST['submit'])) {

        $secretKey = '6Lc_OkoUAAAAAJM1LMpNV5Qj_OdiajmKJXWT2c8Z';
        $response = $_POST['g-recaptcha-response'];
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $url = 'https://www.google.com/recaptcha/api/siteverify';

        $response = json_decode(file_get_contents("$url?secret=$secretKey&response=$response&remoteip=$remoteip"));

        if ($response->success) {
            $formUser = trim($_POST['user']);
            $formPass = mysqli_real_escape_string($conn, $_POST['pass']);

            $query = "SELECT * FROM users WHERE username = ?";
            $stmt = mysqli_stmt_init($conn);
            
            mysqli_stmt_prepare($stmt, $query);
            mysqli_stmt_bind_param($stmt, 's', $formUser);
            mysqli_stmt_execute($stmt);

            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {

                while ($row = mysqli_fetch_array($result)) {
                    $username = $row['username'];
                    $password = $row['password'];

                    if (password_verify($formPass, $password)) {

                        $_SESSION['loggedInUser'] = $username;
                        
                        header('Location: all.php');

                    } else {
                        $message = '<p>Wrong username or password.</p>';
                    }
                }

            } else {
                $message = '<p>Wrong username or password.</p>';
            }
        } else {
            $message = '<p>Verification Failed!</p>';
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
    <title>Login</title>
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
            width: 530px;
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
            color: red;
            font-weight: 500;
            transition: .3s;
        }

        .forgot {
            display: block;
            position: relative;
            margin: -8px 2px 10px 0;
            text-align: right;
            text-decoration: none;
            font-size: 80%;
            color: hsl(217, 71%, 53%);
            transition: .2s;
        }

        .forgot:hover {
           text-decoration: underline;

        }
    </style>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <h1>Account Login</h1>

        <?php echo $message; ?>

        <label for="user">Username:</label>
        <input type="text" name="user" id="user" value="<?php echo (isset($formUser)) ? $formUser : '';  ?>" required>

        <label for="pass">Password:</label>
        <input type="password" name="pass" id="pass" required>
        <a href="forgotpass.php" class="forgot">Forgot Password?</a>
        
        <div class="g-recaptcha" data-sitekey="6Lc_OkoUAAAAAD8hbOqzogjHWZIRzFq2_u9KAnV2"></div>

        <button type="submit" name="submit">Login</button>
    </form>

    <script src='https://www.google.com/recaptcha/api.js'></script>
</body>
</html>