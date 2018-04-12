<?php

	include('../conn.php');

	$query = "SELECT * FROM bg_logo";
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_array($result);

	$tracking_query = "SELECT * FROM tracking_code";
	$tracking_result = mysqli_query($conn, $tracking_query);
	if ($tracking_result) {
		$tracking_row = mysqli_fetch_array($tracking_result);
	}

	$thankyou_query = "SELECT * FROM thankyou";
	$thankyou_result = mysqli_query($conn, $thankyou_query);
	if ($thankyou_result) {
		$thankyou_row = mysqli_fetch_array($thankyou_result);
	}

	$icons_query = "SELECT * FROM social_icons WHERE display = 'yes'";
	$icons_result = mysqli_query($conn, $icons_query);
	if ($icons_result) {
		$icons_row = mysqli_fetch_all($icons_result);
	}

	//Sharing button's encoded content
	$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
	$url_encoded = rawurlencode($url);
	$title = $row['site_title'];
	$title_encoded = rawurlencode($row['site_title']);
	$description = rawurlencode($row['front_page_text']);

	$tweet_source = "source=" . $url_encoded;
	$tweet_text = "&text=" . rawurlencode($row['site_title']) . ':%20' . $url_encoded;
	$tweet_via = (!empty($icons_row[1][3])) ? "&via=" . explode('.com/', $icons_row[1][3])[1] : '';
	$tweet = $tweet_source . $tweet_text . $tweet_via;

	$email_mailto = "mailto:?";
	$email_subject = "subject=I think you might like this website";
	$email_body = "&body=Hey there, I recently discovered a website where you can get car insurance quotes from your local agents, check out this - $url_encoded";
	$email = $email_mailto . $email_subject . $email_body;

	//Used to change footer links
	$thankyou = true;
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="description" content="<?php echo $row['front_page_text']; ?>">

    <title>Thank You | <?php echo $row['site_title'] ?></title>

	<link rel="shortcut icon" type="image/x-icon" href="../img/<?php echo $row['favicon']; ?>">

	<link href="https://fonts.googleapis.com/css?family=Mate+SC" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

	<link rel="stylesheet" href="thankstyles.css">

	<style>
		.logo {
			vertical-align: middle;
			height: <?php echo $row['logo_height']; ?>;
		}

		.hero {
			background-image: linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,.3)), url('img/<?php echo $thankyou_row['image']; ?>');
			background-position: <?php echo $thankyou_row['image_xaxis']; ?> <?php echo $thankyou_row['image_yaxis']; ?>;
		}
	</style>

</head>
<body>

	<div class="hero">

		<div class="logo-container wrapper">
			<a href="../index.php">
				<img class="logo" alt="<?php echo $row['logo_alt_text']; ?>" src="../img/<?php echo $row['logo']; ?>">
			</a>
		</div>

		<div class="hero-text">
			<h1><?php echo $thankyou_row['title']; ?></h1>
			<p class="lead"><?php echo $thankyou_row['message']; ?></p>
		</div>
	</div>

	<div class="social text-center">
		<h2>Have friends who would like our service? <br> Tell them about it.</h2>

		<div class="share-container">
			<div>
				<a href="https://twitter.com/intent/tweet?<?php echo $tweet; ?>" target="_blank" class="share-twitter"><i class="fa fa-twitter"></i>  Share on Twitter</a>
			</div>

			<div>
				<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url_encoded; ?>" target="_blank" class="share-fb"><i class="fa fa-facebook"></i>  Share on Facebook</a>
			</div>

			<div>
				<a class="share-email" href="<?php echo $email; ?>"><i class="fa fa-envelope-o"></i>  Send a quick email</a>
			</div>
		</div>

		<p class="or">- OR -</p>

		<div class="icons-container">


			<h2>Connect with us on social networks</h2>

			<div class="icons">
				<?php for ($i=0; $i < mysqli_num_rows($icons_result); $i++): ?>

					<a href="<?php echo $icons_row[$i][3]; ?>" target="_blank"><i class="<?php echo $icons_row[$i][2]; ?>"></i></a>

				<?php endfor; ?>
			</div>
		</div>

	</div> <!-- Social -->

	<?php include('../footer.php') ?>
</body>
</html>
