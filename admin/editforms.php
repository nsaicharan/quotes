<?php

session_start();

if (!$_SESSION['loggedInUser']) {
	header("Location: index.php");
	exit();
}

include('../conn.php');

$query = "SELECT * FROM bg_logo";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_array($result);

$query = "SELECT * FROM form_styles";
$result = mysqli_query($conn, $query);
$forms_row = mysqli_fetch_array($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Edit Forms | Admin Panel</title>

	<link rel="stylesheet" type="text/css" href="assets/library.css">
	<link href="https://fonts.googleapis.com/css?family=Mate+SC|Open+Sans:400,700|Satisfy" rel="stylesheet">

	<style>

		body {
			background: hsl(48, 100%, 67%);
			min-height: 100vh;
			display: flex;
			flex-direction: column;
			padding-bottom: 25px; /* form-container won't touch bottom */
		}

		.form-container {
			margin: auto;
			padding: 30px 0;
			background: white;
			box-shadow: 0 1px 5px rgba(0, 0, 0, .15);
			text-align: center;
		}

		form {
			padding: 40px 0 15px;
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

		.mx-width{
			width: 100%;
			max-width: 360px;
			margin-left: auto;
			margin-right: auto;
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
			transition-delay: .3s;
			transition: .5s;
		}
 	</style>
</head>
<body >

	<?php include('navbar.php') ?>

	<div class="container form-container row">
		<div class="col-lg-6">
			<form class="formText" data-form="formOne" action="process.php" method="POST" enctype="multipart/form-data">
				<h2 class="text-center"><?php echo $row['btn_one_text']; ?></h2>

				<div class="form-group mx-width  text-left">
					<label for="formOneTitle">Title:</label>
					<input type="text" class="form-control" id="formOneTitle" name="formOneTitle" value="<?php echo $forms_row['form_one_title']; ?>">
				</div>

				<div class="form-group mx-width  text-left">
					<label for="formOneSubtitle">Subtitle:</label>
					<input type="text" class="form-control" id="formOneSubtitle" name="formOneSubtitle" value="<?php echo $forms_row['form_one_subtitle']; ?>">
				</div>

				<button class="submit btn-primary mt-2" type="submit" name="formOne">UPDATE</button>

				<div class="message text-success mt-3">Info successfully updated!</div>
			</form>

			<hr>

			<form class="formText" data-form="formTwo" action="process.php" method="POST" enctype="multipart/form-data">
				<h2 class="text-center"><?php echo $row['btn_two_text']; ?></h2>

				<div class="form-group mx-width  text-left">
					<label for="formTwoDriver">Driver Section Title:</label>
					<input type="text" class="form-control" id="formTwoDriver" name="formTwoDriver" value="<?php echo $forms_row['form_two_driver']; ?>">
				</div>

				<div class="form-group mx-width  text-left">
					<label for="formTwoVehicle">Vehicle Section Title:</label>
					<input type="text" class="form-control" id="formTwoVehicle" name="formTwoVehicle" value="<?php echo $forms_row['form_two_vehicle']; ?>">
				</div>

				<button class="submit btn-primary mt-2" type="submit" name="formTwo">UPDATE</button>

				<div class="message text-success mt-3">Info successfully updated!</div>
			</form>

		</div>

		<div class="col-lg-6">
			<form class="formText" data-form="formThree" method="POST" enctype="multipart/form-data">
				<h2 class="text-center"><?php echo $row['btn_three_text']; ?></h2>

				<div class="form-group mx-width  text-left">
					<label for="formThreeDriver">Driver Section Title:</label>
					<input type="text" class="form-control" id="formThreeDriver" name="formThreeDriver" value="<?php echo $forms_row['form_three_driver']; ?>">
				</div>

				<div class="form-group mx-width  text-left">
					<label for="formThreeVehicle">Vehicle Section Title:</label>
					<input type="text" class="form-control" id="formThreeVehicle" name="formThreeVehicle" value="<?php echo $forms_row['form_three_vehicle']; ?>">
				</div>

				<button class="submit btn-primary mt-2" type="submit" name="formThree">UPDATE</button>

				<div class="message text-success mt-3">Info successfully updated!</div>
			</form>
			
			<hr>

			<form id="generalForm" action="process.php" method="POST" enctype="multipart/form-data">
				<h2 class="text-center">General Styles</h2>
				
				<div class="form-group mx-width text-left">
					<label for="primaryColor">Title/Button Color:</label>
					<input type="text" class="form-control jscolor" id="primaryColor" name="primaryColor" value="<?php echo $forms_row['primary_color']; ?>">
				</div>

				<div class="form-group mx-width text-left">
					<label for="layerOpacity">Layer Opacity:</label>
					<select class="form-control" id="layerOpacity" name="layerOpacity">
						<optgroup label="Current Value">
							<option value="<?php echo $forms_row['layer_opacity']; ?>"><?php echo $forms_row['layer_opacity']; ?></option>
						</optgroup>

						<optgroup label="Available Options">
							<option value="0">0</option>
							<option value="0.05">0.05</option>
							<option value="0.1">0.1</option>
							<option value="0.15">0.15</option>
							<option value="0.175">0.175</option>
							<option value="0.2">0.2</option>
							<option value="0.225">0.225</option>
							<option value="0.25">0.25</option>
							<option value="0.275">0.275</option>
							<option value="0.3">0.3</option>
						</optgroup>
					</select>
				</div>

				<button class="btn-primary mt-2" type="submit" name="generalSubmit">UPDATE</button>

				<div class="message text-success mt-3">Styles successfully updated!</div>
			</form>

		</div>

	</div> <!-- form-container -->


	<script src="assets/library.js"></script>
	<script src="assets/jscolor.js"></script>

	<script>

		//General Styles
		$('#generalForm').submit(function(e) {
			e.preventDefault();

			const message = this.querySelector('.message');

			if (message.classList.contains('message--is-visible')) {
				message.classList.remove('message--is-visible');
			}

			$(this).find('button[type=submit]').addClass('btn--is-processing');
			$(this).find('button[type=submit]').html(`<i class="fa fa-refresh fa-spin fa-fw"></i> Please Wait...`);
			$(this).find('button[type=submit]').blur();

			$.ajax({
				url: 'process.php',
				method: 'post',
				data: $(this).serialize()+'&key=generalStyles',
				success: (response) => {

					$(this).find('button[type=submit]').removeClass('btn--is-processing');
					$(this).find('button[type=submit]').html('UPDATE');
					$(this).find('button[type=submit]').blur();

					if (response == 'generalSuccess') {
						message.classList.add('message--is-visible');
					} else {
						console.log(response);
					}
				},
				error: (err) => console.log(err)
			 });
		});

		//Other Forms
		$('.formText').submit(function(e) {
			e.preventDefault();

			const message = this.querySelector('.message');

			if (message.classList.contains('message--is-visible')) {
				message.classList.remove('message--is-visible');
			}

			$(this).find('button[type=submit]').addClass('btn--is-processing');
			$(this).find('button[type=submit]').html(`<i class="fa fa-refresh fa-spin fa-fw"></i> Please Wait...`);
			$(this).find('button[type=submit]').blur();

			$.ajax({
				url: 'process.php',
				method: 'post',
				data: $(this).serialize()+`&key=formText&${this.dataset.form}`,
				success: (response) => {

					$(this).find('button[type=submit]').removeClass('btn--is-processing');
					$(this).find('button[type=submit]').html('UPDATE');
					$(this).find('button[type=submit]').blur();

					if (response == 'formTextSuccess') {
						message.classList.add('message--is-visible');
					} else {
						console.log(response);
					}
				},
				error: (err) => console.log(err)
			 });
		});
		
	</script>
</body>
</html>
