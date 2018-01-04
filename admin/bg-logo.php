<?php 

session_start(); 

// if (!$_SESSION['loggedInUser']) {
// 	header("Location: index.php");
// }

include('../conn.php');

$query = "SELECT * FROM bg_logo";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Background - Logo</title>
	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,500,700|Satisfy|Mate+SC" rel="stylesheet">
	<style>

		body {
			background: #f3f3f3;
			background: hsl(48, 100%, 67%);
			min-height: 100vh;
			display: flex;
			flex-direction: column;
			padding-bottom: 25px; /* form-container won't touch bottom */
		}

		/* === Start Navbar === */
		.container--nav {
			padding: 0;
		}

		.mr-onepx {
			margin-right: 1px;
		}

		.mr-twopx {
			margin-right: 2px;
		}

		.navbar {
			padding: 0 1rem .16rem;
			box-shadow: 0 1px 6px rgba(0, 0, 0, 0.1);
		    background-color: #fff;
		    margin-bottom: 30px;
		    font-family: 'Open Sans', sans-serif;
		}

		 .nav-link {
			color: rgba(0, 0, 0, .7);
		}

		.nav-link:hover,
		.nav-link:focus {
			color: rgba(0, 0, 0, 1);
		}

		.navbar-brand {
			font-size: 2rem;
			color: #007bff !important;
			font-family: 'Mate SC', serif;
		}

		@media (max-width: 767px) {
			.navbar {
				padding: 0 1rem;
			}

			.navbar-brand {
				font-size: 1.8rem;
			}

			.navbar-toggler {
				font-size: 1.1rem;
			}
		}
		/* === End Navbar === */

		.form-container {
			margin: auto;
			padding: 30px 0;
			background: white;
			box-shadow: 0 1px 5px rgba(0, 0, 0, .15);
			text-align: center;
		}
	
		form {
			padding: 50px 0;
		}	

		.col-lg-6:first-child {
			border-right: 1px solid #ddd;
		}

		@media (max-width: 991px) {

			.form-container {
				padding: 0 15px;
			}

			form {
				padding-bottom: 15px;
			}

			.col-lg-6:first-child {
				border-right: none;
				border-bottom: 1px solid #ddd;
			}

			button:focus {
				outline: none;
			}
		}

		@media (max-width: 480px) {
			.form-container {
				max-width: 95vw;
			}
		}

		h2 {
			margin-bottom: 30px;
			font-family: 'Satisfy', sans-serif;
			font-size: 35px;
			font-weight: normal;
		}

		h3 {
			font-size: 18px;
			display: inline-block;
			border-bottom: 1px solid;
			font-weight: 500;
		}

		input[type=file] {
			width: 100%;
			max-width: 360px;
			margin: 20px auto;
			padding: 25px;
			border: 1px dashed hsl(48, 100%, 67%);
			outline: none;
			cursor: pointer;
			background: #fbfbfb;
		}

		button {
			cursor: pointer;
		}

		.form-container button {
			width: 100%;
			max-width: 360px;
			display: inline-block;
			cursor: pointer;
			padding: 10px 20px;
			border: none;
			border-radius: 3px;
			color: white;
			font-weight: 500;
		}

		.btn--is-processing {
			cursor: not-allowed;
		}

		.message {
			font-weight: 500;
			font-size: 17px;
			opacity: 0;
			visibility: hidden;
			display: inline-block;
			width: 100%;
			transform: scale(.2);
		}

		.message--is-visible {
			opacity: 1;
			visibility: visible;
			transform: scale(1);
			transition-delay: .2s;
			transition: .5s;
		}
 	</style>
</head>
<body >

	<nav class="navbar navbar-expand-lg  static-top">
		<div class="container container--nav">
			<a class="navbar-brand" href="data.php">Data Collection</a>
			<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				Menu
				<i class="fa fa-bars"></i>
			</button>
			<div class="collapse navbar-collapse mt-lg-2" id="navbarResponsive">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="dropdownThemes" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-id-card-o mr-twopx"></i>
							Insurance Listing
						</a>
						<div class="dropdown-menu" aria-labelledby="dropdownThemes">
							<a class="dropdown-item" href="data.php">
								<i class="fa fa-binoculars fa-fw mr-1"></i>
								Just Curious
							</a>
							<a class="dropdown-item" href="semi.php">
								<i class="fa fa-balance-scale fa-fw mr-1"></i>
								Semi Interested
							</a>
							<a class="dropdown-item" href="ready.php">
								<i class="fa fa-handshake-o fa-fw mr-1"></i>
								Ready To Buy
							</a>
						</div>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="thankyou.php" title="Edit thank you page">
							<i class="fa fa-heart-o mr-onepx"></i>
							Thank You
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="bg-logo.php" title="Change background or logo">
							<i class="fa fa-file-image-o mr-twopx"></i>
							Background &amp; Logo
						</a>
					</li>
				</ul>
				<ul class="navbar-nav">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-capitalize" href="#" id="dropdownPremium" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-user-circle-o fa-lg fa-fw"></i>
							Max
						</a>
						<div class="dropdown-menu dropdown-menu-right mb-1" aria-labelledby="dropdownPremium">
							<a class="dropdown-item" href="logout.php">
								<i class="fa fa-sign-out"></i>
								Logout</a>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container form-container row">
		<div class="col-lg-6">
			<form id="bgForm" action="bg-logo.php" method="POST" enctype="multipart/form-data">
				<h2 class="text-center">Background Image</h2>

				<input type="file" name="bg" id="bg" accept="image/*">
				<br>
				<h3>Position</h3>

				<div class="d-flex justify-content-center">		
					<div class="form-group mr-1">
						<label class="text-left" for="xAxis">X-Axis:</label>
						<select class="form-control" name="xAxis" id="xAxis">
							<option <?php echo ($row['bg_xaxis'] == 'center') ? 'selected' : ''; ?> value="center">Center</option>
							<option <?php echo ($row['bg_xaxis'] == 'left') ? 'selected' : ''; ?> value="left">Start From Left</option>
							<option <?php echo ($row['bg_xaxis'] == 'right') ? 'selected' : ''; ?> value="right">Start From Right</option>
						</select>
					</div>
			
					<div class="form-group ml-1">
						<label for="yAxis">Y-Axis:</label>
						<select class="form-control" name="yAxis" id="yAxis">
							<option <?php echo ($row['bg_yaxis'] == 'center') ? 'selected' : ''; ?> value="center">Center</option>
							<option <?php echo ($row['bg_yaxis'] == 'top') ? 'selected' : ''; ?> value="top">Start From Top</option>
							<option <?php echo ($row['bg_yaxis'] == 'bottom') ? 'selected' : ''; ?> value="bottom">Start From Bottom</option>
						</select>
					</div>
				</div>

				<button class="btn-primary mt-1" type="submit" name="bgSubmit">UPDATE</button>	
			
				<div class="message text-success mt-3">Background successfully updated!</div>
			</form>
		</div>

		<div class="col-lg-6">
			<form id="logoForm" action="bg-logo.php" method="POST" enctype="multipart/form-data">
				<h2 class="text-center">Logo</h2>

				<input type="file" class="mb-1" name="logo" id="logo" accept="image/*">

				<p>
					<small class="text-muted">(Note: It's recommended to use ".svg" image)</small>
				</p>

				<div class="d-flex justify-content-center">
					<div class="form-group mr-1">
						<label for="height">Height:</label>
						<select class="form-control" name="height" id="height">
							<option <?php echo ($row['logo_height'] == '30px') ? 'selected' : ''; ?> value="30px">30px</option>
							<option <?php echo ($row['logo_height'] == '40px') ? 'selected' : ''; ?> value="40px">40px</option>
							<option <?php echo ($row['logo_height'] == '50px') ? 'selected' : ''; ?> value="50px">50px</option>
							<option <?php echo ($row['logo_height'] == '60px') ? 'selected' : ''; ?> value="60px">60px</option>
							<option <?php echo ($row['logo_height'] == '70px') ? 'selected' : ''; ?> value="70px">70px</option>
							<option <?php echo ($row['logo_height'] == '80px') ? 'selected' : ''; ?> value="80px">80px </option>
							<option <?php echo ($row['logo_height'] == '90px') ? 'selected' : ''; ?> value="90px">90px</option>
							<option <?php echo ($row['logo_height'] == '100px') ? 'selected' : ''; ?> value="100px">100px</option>
						</select>
					</div>

					<div class="form-group ml-1">
						<label for="altText">Alt Text (Optional):</label>
						<input type="text" class="form-control" id="altText" name="altText" placeholder="Your Company Name" value="<?php echo $row['logo_alt_text']; ?>">
					</div>
				</div>
				
				<button class="submit btn-primary mt-1" type="submit" name="logoSubmit">UPDATE</button>	 
			
				<div class="message text-success mt-3">Logo successfully updated!</div>
			</form>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>

	<script>

		//BACKGROUND
		$('#bgForm').submit(function(e) {
			e.preventDefault();

			let message = this.querySelector('.message');
			
			if (message.classList.contains('message--is-visible')) {
				message.classList.remove('message--is-visible');
			}

			$('button[name=bgSubmit]').addClass('btn--is-processing');
			$('button[name=bgSubmit]').html(`<i class="fa fa-refresh fa-spin fa-fw"></i> Please Wait...`);
			$('button[name=bgSubmit]').blur();

			const bgXAxis = $('#xAxis').val();
			const bgYAxis = $('#yAxis').val();

			//Image
			const file_data = $(this[0]).prop('files')[0];   

			const form_data = new FormData();                  
			form_data.append('bgImage', file_data);
			form_data.append('bgXAxis', bgXAxis);
			form_data.append('bgYAxis', bgYAxis);
			form_data.append('key', 'background');
			                            
			$.ajax({
				url: 'process.php', 
				dataType: 'text',  
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,                         
				method: 'post',
				success: (data) => {

					document.querySelector('#bg').value = '';

					$('button[name=bgSubmit]').removeClass('btn--is-processing');
					$('button[name=bgSubmit]').html('UPDATE');
					$('button[name=bgSubmit]').blur();
					
					let message = this.querySelector('.message');
					message.classList.add('message--is-visible');
				}
			 });
		})


		//LOGO
		$('#logoForm').submit(function(e) {
			e.preventDefault();

			let message = this.querySelector('.message');

			if (message.classList.contains('message--is-visible')) {
				message.classList.remove('message--is-visible');
			}

			$('button[name=logoSubmit]').addClass('btn--is-processing');
			$('button[name=logoSubmit]').html(`<i class="fa fa-refresh fa-spin fa-fw"></i> Please Wait...`);
			$('button[name=logoSubmit]').blur();

			const logoHeight = $('#height').val();
			const logoAltText = $('#altText').val();

			//Image
			const file_data = $(this[0]).prop('files')[0]; 

			const form_data = new FormData();                  
			form_data.append('logoImage', file_data);
			form_data.append('logoHeight', logoHeight);
			form_data.append('logoAltText', logoAltText);
			form_data.append('key', 'logo');

			$.ajax({
				url: 'process.php', 
				dataType: 'text',  
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,                         
				method: 'post',
				success: (data) => {
					document.querySelector('#logo').value = '';

					$('button[name=logoSubmit]').removeClass('btn--is-processing');
					$('button[name=logoSubmit]').html('UPDATE');
					$('button[name=logoSubmit]').blur();
					
					let message = this.querySelector('.message');
					message.classList.add('message--is-visible');
				}
			});
		})
	</script>
</body>
</html>

