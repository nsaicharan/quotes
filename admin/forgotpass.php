<?php 
$success = "";
$error = "";

include('../conn.php');

if (isset($_POST['submit'])) {

    $secretKey = '6Lc_OkoUAAAAAJM1LMpNV5Qj_OdiajmKJXWT2c8Z';
    $response = $_POST['g-recaptcha-response'];
    $remoteip = $_SERVER['REMOTE_ADDR'];
    $url = 'https://www.google.com/recaptcha/api/siteverify';

    $response = json_decode(file_get_contents("$url?secret=$secretKey&response=$response&remoteip=$remoteip"));

    if ($response->success) {

        $formUser = $_POST['user'];

        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = mysqli_stmt_init($conn);

        mysqli_stmt_prepare($stmt, $query);
        mysqli_stmt_bind_param($stmt, 's', $formUser);
        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);

        if (mysqli_num_rows($result) > 0) {

            //Create token
            function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
            {
                $str = '';
                $max = mb_strlen($keyspace, '8bit') - 1;
                for ($i = 0; $i < $length; ++$i) {
                    $str .= $keyspace[random_int(0, $max)];
                }
                return $str;
            }
            $token = random_str(32);

            //Set token and expire
            $query = "UPDATE users SET token = '$token', expire = DATE_ADD(NOW(), INTERVAL 30 MINUTE) WHERE username = ?";
            $stmt = mysqli_stmt_init($conn);

            mysqli_stmt_prepare($stmt, $query);
            mysqli_stmt_bind_param($stmt, 's', $formUser);
            
            $execute = mysqli_stmt_execute($stmt);

            if ($execute) {
                    
                //Set url
                $url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $escaped_url = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
                $reset_url = str_replace('forgotpass.php', 'resetpass.php', $escaped_url) . "?username=$formUser&token=$token";

                //Send mail
                $to = $row['email'];
                $subject = "Your Password Reset Link";
                $message = "<p>Hey there, here's your password reset link: <a href='$reset_url'>$reset_url</a> </p>";
                $message .= "<p>If you haven't requested for password reset, you can safely ignore this email and your password will remain the same.</p>";
                $message .= "<p>Reset requested from this IP - $remoteip</p>";
                $headers = "From: Sai <hi@saicharan.me>\r\n";
                $headers .= "Reply-To: noreply@saicharan.me\r\n";
                $headers .= "Content-type: text/html\r\n";

                if (mail($to, $subject, $message, $headers)) {
                    $success = '<p class="success">Your request has been submitted. If there is an account associated with your username, you will receive an email.</p>';
                }
            } else {echo("result fail");}

        } else {
            $success = '<p class="success">Your request has been submitted. If there is an account associated with your username, you will receive an email.</p>';
        }
    } else {
        $error = '<p class="error">Verification Failed!</p>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Password Recovery</title>
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
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <h1>Password Recovery</h1>

        <?php echo $success . $error ?>

        <label for="user">Enter Your Username:</label>
        <input type="text" name="user" id="user" required>

        <div class="g-recaptcha" data-sitekey="6Lc_OkoUAAAAAD8hbOqzogjHWZIRzFq2_u9KAnV2"></div>

        <button type="submit" name="submit">Submit</button>
    </form>

    <script src='https://www.google.com/recaptcha/api.js'></script>
</body>
</html>