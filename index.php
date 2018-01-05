<?php 
	
	include('conn.php');

	$tracking_query = "SELECT * FROM tracking_code";
	$tracking_result = mysqli_query($conn, $tracking_query);
	if ($tracking_result) {
		$tracking_row = mysqli_fetch_array($tracking_result);
	}

	$query = "SELECT * FROM bg_logo";
	$result = mysqli_query($conn, $query);

	if ($result) {
		$row = mysqli_fetch_array($result);
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Home</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<link href="https://fonts.googleapis.com/css?family=Mate+SC|Satisfy" rel="stylesheet">
	<link rel="stylesheet" href="style1a.css">

	<?php echo $tracking_row['fb_pixel']; ?>
	<?php echo $tracking_row['g_analytics']; ?>

	<style>
		body {
			background-image: linear-gradient(rgba(0,0,0,.5), rgba(0,0,0,.5)), url(img/<?php echo $row['background']; ?>);
			background-position: <?php echo $row['bg_xaxis']; ?> <?php echo $row['bg_yaxis']; ?>;
		}

		.logo img {
			height: <?php echo $row['logo_height']; ?>;
		}
	</style>
</head>
<body>
	
	<header>
		<div class="wrapper wrapper--nav">
			<div class="logo">
				<a href="index.php"><img alt="<?php echo $row['logo_alt_text']; ?>" src="img/<?php echo $row['logo']; ?>"></a>
			</div>
			<nav>
				<a href="index.php">Home</a>
				<a href="#">About Us</a>
				<a href="#">FAQ</a>
				<a href="#">Contact</a>
			</nav>
		</div>
	</header>
	
	<div class="btns">
		<div class="btns-container">
			<a href="#" class="btn">I'm just curious</a>
			<a href="semi-interested.php" class="btn">I'm semi interested</a>
			<a href="ready-to-buy.php" class="btn">I'm ready to buy</a>
		</div>
	</div>
	
	<div class="wrapper">
		<form action="thankyou/index.php" method="POST" id="curiousForm" class="zoomIn">
		
		<div class="form-header">
			<h2>Quick Contact</h2>
			<p>Contact us today and get reply within 24 hours!</p>
		</div>
		
		<div class="form-content">
		
			<div class="two">
				<label for="firstName">First Name:</label>
				<input type="text" id="firstName"  name="firstName" required>
			</div>

			<div class="two">
				<label for="lastName">Last Name:</label>
				<input type="text" id="lastName" name="lastName" required>
			</div>

			<div class="two">
				<label for="email">Email:</label>
				<input type="email" id="email" name="email" required>
			</div>

			<div class="two">
				<label for="phone">Phone Number:</label>
				<input type="tel" name="phone" required>
			</div>

			<div class="two">
				<label for="insurance">Current Insurance Co. (Optional):</label>
				<input type="text" id="insurance" name="insurance">
			</div>
		
		</div>
		
		<div class="text-center">
			<button type="submit" class="curiousSubmit" name="curiousSubmit">Submit</button>
		</div>
	</form>
	</div>
	
	
	<script>
		const buttons = document.querySelectorAll('.btn');
		const buttonsContainer = document.querySelector('.btns-container');
		window.onload = () => {
			setTimeout(function() {
				buttons.forEach(button => button.classList.add('fadeInDown'));
			}, 1000);
			
		}
		
		const curiousBtn = document.querySelector('.btn');
		const curiousForm = document.querySelector('#curiousForm');
		
		curiousBtn.addEventListener('click', function() {
			buttonsContainer.style.display = 'none';
			
			curiousForm.style.display = "block";
			
			setTimeout(function() {
				curiousForm.style.opacity = 1;
			}, 1000);
			
		})
	</script>
</body>
</html>
