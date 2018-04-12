<?php 

session_start();

if ( isset($_SESSION['loggedInUser']) ) {
    header("Location: all.php");  
} else {

    //Set session variable and redirect user if cookie is available
    if ( isset($_COOKIE['loggedInUser']) ) {
        $_SESSION['loggedInUser'] = $_COOKIE['loggedInUser'];
        header('Location: all.php');
    }

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

                        //Set session variable
                        $_SESSION['loggedInUser'] = $username;

                        //Set cookie
                        if ( isset($_POST['remember']) ) {
                            setcookie('loggedInUser', true, time() + (86400 * 21), "/");
                        } 

                        //Redirect
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
            width: 500px;
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

        svg {
            height: 20px;
            fill: currentColor;
            vertical-align: bottom;
        }

        .label-container {
            display: flex;
            justify-content: space-between;
        }

        .eye-container {
            text-decoration: none;
            font-size: 90%;
            color: hsl(217, 71%, 53%);
            transition: .2s;
            font-weight: 500;
        }

        .eye-container:hover {
            filter: brightness(115%);
        }

        .eye-text {
            margin-left: 5px;
            margin-right: 2px;
        }

        .is-inactive {
            display: none;
        }

        label {
            font-weight: 500;
            color: #2c3e50;
        }

        input:not([type=checkbox]) {
            width: 100%;
            border: none;
            padding: 12px 20px;
            margin: 5px 0 18px;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 3px;
            font-size: 18px;
            font-family:  -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        .g-recaptcha {
            padding: 3px 0 18px;
        }

        button {
            display: block;
            width: 100%;
            border: none;;
            background: hsl(217, 71%, 53%);
            color: white;
            padding: 10px;
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

        <div class="label-container">
            <label for="pass">Password:</label>

            <a href="#" class="eye-container js-show is-active">
                <svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M555 1335l78-141q-87-63-136-159t-49-203q0-121 61-225-229 117-381 353 167 258 427 375zm389-759q0-20-14-34t-34-14q-125 0-214.5 89.5t-89.5 214.5q0 20 14 34t34 14 34-14 14-34q0-86 61-147t147-61q20 0 34-14t14-34zm363-191q0 7-1 9-106 189-316 567t-315 566l-49 89q-10 16-28 16-12 0-134-70-16-10-16-28 0-12 44-87-143-65-263.5-173t-208.5-245q-20-31-20-69t20-69q153-235 380-371t496-136q89 0 180 17l54-97q10-16 28-16 5 0 18 6t31 15.5 33 18.5 31.5 18.5 19.5 11.5q16 10 16 27zm37 447q0 139-79 253.5t-209 164.5l280-502q8 45 8 84zm448 128q0 35-20 69-39 64-109 145-150 172-347.5 267t-419.5 95l74-132q212-18 392.5-137t301.5-307q-115-179-282-294l63-112q95 64 182.5 153t144.5 184q20 34 20 69z"/></svg>
                <span class="eye-text">Show</span>
            </a>

            <a href="#" class="eye-container js-hide is-inactive">
                <svg viewBox="0 0 1792 1792" xmlns="http://www.w3.org/2000/svg"><path d="M1664 960q-152-236-381-353 61 104 61 225 0 185-131.5 316.5t-316.5 131.5-316.5-131.5-131.5-316.5q0-121 61-225-229 117-381 353 133 205 333.5 326.5t434.5 121.5 434.5-121.5 333.5-326.5zm-720-384q0-20-14-34t-34-14q-125 0-214.5 89.5t-89.5 214.5q0 20 14 34t34 14 34-14 14-34q0-86 61-147t147-61q20 0 34-14t14-34zm848 384q0 34-20 69-140 230-376.5 368.5t-499.5 138.5-499.5-139-376.5-368q-20-35-20-69t20-69q140-229 376.5-368t499.5-139 499.5 139 376.5 368q20 35 20 69z"/>
                </svg>
                <span class="eye-text">Hide</span>
            </a>
        </div>
        <input type="password" name="pass" id="pass" required>
        
        <div class="g-recaptcha" data-sitekey="6Lc_OkoUAAAAAD8hbOqzogjHWZIRzFq2_u9KAnV2"></div>

        <p>
            <input type="checkbox" id="remember" name="remember">
            <label for="remember">Keep me logged in</label>
        </p>

        <button type="submit" name="submit">Login</button>

        
        <!--  <a href="forgotpass.php" class="forgot">Forgot Password?</a> -->

    </form>

    <script src='https://www.google.com/recaptcha/api.js'></script>
    <script>
        const eyeContainers = Array.from(document.querySelectorAll('.eye-container'));
        const passInput = document.querySelector('#pass');

        function handleClick(e) {
            e.preventDefault();

            eyeContainers.forEach(eyeContainer => eyeContainer.classList.remove('is-inactive'));
            this.classList.add('is-inactive');

            const currentType = passInput.getAttribute('type');

            if (currentType === 'password') {
                passInput.setAttribute('type', 'text');
            } else {
                passInput.setAttribute('type', 'password');
            }
        }

        eyeContainers.forEach(eyeContainer => eyeContainer.addEventListener('click', handleClick));
    </script>
</body>
</html>