<?php

	include('conn.php');

	$query = "SELECT * FROM bg_logo";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_array($result);

	$tracking_query = "SELECT * FROM tracking_code";
	$tracking_result = mysqli_query($conn, $tracking_query);
	$tracking_row = mysqli_fetch_array($tracking_result);

	$forms_query = "SELECT * FROM form_styles";
	$forms_result = mysqli_query($conn, $forms_query);
	$forms_row = mysqli_fetch_array($forms_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

	<meta name="description" content="<?php echo $row['front_page_text']; ?>">
	<meta name="keywords" content="car insurance, auto insurance, insurance quote, online insurance quote, free insurance quotes, local agents">

	<meta property="og:title" content="<?php echo $row['site_title']; ?>">
	<meta property="og:type" content="website">
	<meta property="og:image" content="<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . '/img/share-preview.jpg'; ?>">
	<meta property="og:image:width" content="1920">
	<meta property="og:image:height" content="1000">
	<meta property="og:url" content="<?php echo (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST']; ?>">
	<meta property="og:description" content="<?php echo $row['front_page_text']; ?>">
	<meta property="og:site_name" content="<?php echo $row['site_title']; ?>">

    <title><?php echo $row['site_title'] ?></title>

	<link rel="shortcut icon" type="image/x-icon" href="img/<?php echo $row['favicon']; ?>">

	<link rel="stylesheet" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Mate+SC" rel="stylesheet">

	<!-- Google Analytics Here -->
	<?php echo $tracking_row['g_analytics']; ?>

	<style>
		main {
			background-image: linear-gradient(rgba(0,0,0,.28), rgba(0,0,0,.28)), url(img/<?php echo $row['bg']; ?>);
			background-position: <?php echo $row['bg_xaxis']; ?> <?php echo $row['bg_yaxis']; ?>;
		}

		@media (max-width: 768px) and (orientation: portrait) {
			main {

				<?php if ( $row['mobile_bg'] != ""): ?>
				background-image: linear-gradient(rgba(0,0,0,.3), rgba(0,0,0,.3)), url(img/<?php echo $row['mobile_bg']; ?>);
				<?php endif; ?>
				background-position: <?php echo $row['mobile_bg_xaxis']; ?> <?php echo $row['mobile_bg_yaxis']; ?>;
			}
		}

		.logo {
			vertical-align: middle;
			height: <?php echo $row['logo_height']; ?>;
		}

		.btn:nth-child(1) {
		  background: #<?php echo $row['btn_one_color']; ?>;
		}

		.btn:nth-child(2) {
		  background: #<?php echo $row['btn_two_color']; ?>;
		}

		.btn:nth-child(3) {
		  background: #<?php echo $row['btn_three_color']; ?>;
		}

		.form {
			background: rgba(0, 0, 0, <?php echo $forms_row['layer_opacity']; ?>);
		}

		.form-title,
		.form-header__title {
			color: #<?php echo $forms_row['primary_color']; ?>;
		}

		.submitBtn {
			background: #<?php echo $forms_row['primary_color']; ?>;
			border: 1px solid #<?php echo $forms_row['primary_color']; ?>;
		}

		footer {
			background: #<?php echo $row['footer_color']; ?>
		}
	</style>
</head>

<body>

	<main>
		<h1 class="sr-only"><?php echo $row['site_title']; ?></h1>

		<div class="logo-container wrapper">
			<a href="index.php">
				<img class="logo" alt="<?php echo $row['logo_alt_text']; ?>" src="img/<?php echo $row['logo']; ?>">
			</a>
		</div>