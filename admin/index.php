<?php 

    session_start();

    if (isset($_SESSION['loggedInUser'])) {
       
		header("Location: data.php");
		
    } else {
		
		include('conn.php');

		$message = '';

		if (  isset($_POST['submit'])  ) {
			$formUser = mysqli_real_escape_string($conn, $_POST['user']);
			$formPass = mysqli_real_escape_string($conn, $_POST['pass']);

			$query = "SELECT * FROM users WHERE username = '$formUser'";

			$result = mysqli_query($conn, $query);

			if (mysqli_num_rows($result) > 0) {

				while($row = mysqli_fetch_array($result)) {
					$name = $row['username'];
					$pass = $row['password'];

					if ($pass == $formPass) {

						session_start();

						$_SESSION['loggedInUser'] = $name;

						header('Location: data.php');

					} else {
						$message = '<p>Username and passwords do not match!</p>';
					}
				}

			} else {
				$message = '<p>No such user!</p>';
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
    <link href="https://fonts.googleapis.com/css?family=Mate+SC|Roboto:400,700|Satisfy|Open+Sans:400,700,300" rel="stylesheet">
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
            margin: 5px 0 20px;
            background: rgba(0, 0, 0, 0.1);
            border-radius: 3px;
            font-size: 18px;
            font-family:  -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        button {
            display: block;
            width: 100%;
            border: none;;
            background: hsl(217, 71%, 53%)	;
            color: white;
            padding: 10px;
			margin-top: 3px;
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

    </style>
    <link rel="stylesheet" href="pat.css">
</head>
<body>
    <form action="" method="post">
        <h1>Account Login</h1>

        <?php echo $message; ?>

        <label for="user">User Name:</label>
        <input type="text" name="user" id="user">

        <label for="pass">Password:</label>
        <input type="password" name="pass" id="pass">

        <button type="submit" name="submit">Login</button>
    </form>
</body>
</html>