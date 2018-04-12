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

$query = "SELECT * FROM tracking_code";
$result = mysqli_query($conn, $query);
$tracking_row = mysqli_fetch_array($result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Main Page | Admin Panel</title>

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

		small {
			display: block;
			max-width: 360px;
			margin: 0 auto 18px;
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

		.tips {
			list-style-type: none;
			font-size: 80%;
			padding-left: 20px;
			max-width: 365px;
			width: 100%;
			margin: 45px auto 25px;
		}

		.tip:before {
			font-family: 'FontAwesome';
			content: '\f0a4';
			margin:0 10px 0 -23px;
			color: #007bff;
		}
 	</style>
</head>
<body >

	<?php include('navbar.php') ?>

	<div class="container form-container row">
		<div class="col-lg-6">
			<form id="bgForm" action="process.php" method="POST" enctype="multipart/form-data">
				<h2 class="text-center">Background Image</h2>

				<ul class="tips text-left">
					<li class="tip text-muted">Use tools like <a href="https://kraken.io/web-interface" target="_blank">Kraken</a> or <a href="https://tinyjpg.com/" target="_blank">TinyJPG</a> to compress your images.</li>
					<li class="tip text-muted">Guide to resize/crop images in  <a href="https://scottiestech.info/2015/04/30/how-to-easily-resize-and-crop-a-single-image-in-windows/" target="_blank">Windows</a> and <a href="https://www.howtogeek.com/201638/use-your-macs-preview-app-to-crop-resize-rotate-and-edit-images/" target="_blank">macOS</a>.</li>
					<li class="tip text-muted">Need an online image editor? Try <a href="https://pixlr.com/editor/" target="_blank">this</a>  or  <a href="https://www.fotor.com/app.html#/editor/basic" target="_blank">this</a>.</li>
				</ul>

				<h3>Large Screens</h3>
				<br>
				<input type="file" class="mb-1" name="bg" id="bg" accept="image/*">
				<br>
				<small class="text-muted">(Average Image Size: 2272 x 1278 pixels)</small>

				<div class="d-flex justify-content-center">
					<div class="form-group mr-1">
						<label class="text-left" for="bgXAxis">X-Axis Position:</label>
						<select class="form-control" name="bgXAxis" id="bgXAxis">
							<option <?php echo ($row['bg_xaxis'] == 'center') ? 'selected' : ''; ?> value="center">Center</option>
							<option <?php echo ($row['bg_xaxis'] == 'left') ? 'selected' : ''; ?> value="left">Start From Left</option>
							<option <?php echo ($row['bg_xaxis'] == 'right') ? 'selected' : ''; ?> value="right">Start From Right</option>
						</select>
					</div>

					<div class="form-group ml-1">
						<label for="bgYAxis">Y-Axis Position:</label>
						<select class="form-control" name="bgYAxis" id="bgYAxis">
							<option <?php echo ($row['bg_yaxis'] == 'center') ? 'selected' : ''; ?> value="center">Center</option>
							<option <?php echo ($row['bg_yaxis'] == 'top') ? 'selected' : ''; ?> value="top">Start From Top</option>
							<option <?php echo ($row['bg_yaxis'] == 'bottom') ? 'selected' : ''; ?> value="bottom">Start From Bottom</option>
						</select>
					</div>
				</div>
				<br>

				<h3>Mobile (Orientation: Portrait)</h3>

				<br>
				<input type="file" class="mb-1" name="mobileBG" id="mobileBG" accept="image/*">
				<br>

				<small class="text-muted">(If you're unsure about the dimensions, we recommend to crop your image somewhere close to 1080px wide and 1920px tall)</small>

				<div class="d-flex justify-content-center">
					<div class="form-group mr-1">
						<label class="text-left" for="mobileXAxis">X-Axis Position:</label>
						<select class="form-control" name="mobileXAxis" id="mobileXAxis">
							<option <?php echo ($row['mobile_bg_xaxis'] == 'center') ? 'selected' : ''; ?> value="center">Center</option>
							<option <?php echo ($row['mobile_bg_xaxis'] == 'left') ? 'selected' : ''; ?> value="left">Start From Left</option>
							<option <?php echo ($row['mobile_bg_xaxis'] == 'right') ? 'selected' : ''; ?> value="right">Start From Right</option>
						</select>
					</div>

					<div class="form-group ml-1">
						<label for="mobileYAxis">Y-Axis Position:</label>
						<select class="form-control" name="mobileYAxis" id="mobileYAxis">
							<option <?php echo ($row['mobile_bg_yaxis'] == 'center') ? 'selected' : ''; ?> value="center">Center</option>
							<option <?php echo ($row['mobile_bg_yaxis'] == 'top') ? 'selected' : ''; ?> value="top">Start From Top</option>
							<option <?php echo ($row['mobile_bg_yaxis'] == 'bottom') ? 'selected' : ''; ?> value="bottom">Start From Bottom</option>
						</select>
					</div>
				</div>

				<button class="btn-primary mt-2" type="submit" name="bgSubmit">UPDATE</button>

				<div class="message text-success mt-3">Background successfully updated!</div>
			</form>

			<hr>

			<form id="logoForm" action="process.php" method="POST" enctype="multipart/form-data">
				<h2 class="text-center">Logo</h2>

				<input type="file" name="logo" id="logo" accept="image/*">

				<div class="d-flex justify-content-center">
					<div class="form-group mr-1">
						<label for="height">Height:</label>
						<select class="form-control" name="height" id="height">
							<option <?php echo ($row['logo_height'] == '30px') ? 'selected' : ''; ?> value="30px">30px</option>
							<option <?php echo ($row['logo_height'] == '35px') ? 'selected' : ''; ?> value="35px">35px</option>
							<option <?php echo ($row['logo_height'] == '40px') ? 'selected' : ''; ?> value="40px">40px</option>
							<option <?php echo ($row['logo_height'] == '45px') ? 'selected' : ''; ?> value="45px">45px</option>
							<option <?php echo ($row['logo_height'] == '50px') ? 'selected' : ''; ?> value="50px">50px</option>
							<option <?php echo ($row['logo_height'] == '55px') ? 'selected' : ''; ?> value="55px">55px</option>
							<option <?php echo ($row['logo_height'] == '60px') ? 'selected' : ''; ?> value="60px">60px</option>
							<option <?php echo ($row['logo_height'] == '65px') ? 'selected' : ''; ?> value="65px">65px</option>
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

				<button class="submit btn-primary mt-2" type="submit" name="logoSubmit">UPDATE</button>

				<div class="message text-success mt-3">Logo successfully updated!</div>
			</form>


			<!-- TRACKING CODE -->
			<hr>

			<form class="mx-width" id="trackingForm" action="process.php" method="POST" enctype="multipart/form-data">
				<h2 class="text-center">Tracking Code</h2>

				<div class="form-group text-left">
					<label for="gAnalytics">Google Analytics:</label>
					<textarea class="form-control" name="gAnalytics" id="gAnalytics" rows="4"><?php echo $tracking_row['g_analytics']; ?></textarea>
				</div>

				<div class="form-group text-left">
					<label for="fbChat">Live Chat:</label>
					<textarea class="form-control" name="fbChat" id="fbChat" rows="5"><?php echo $tracking_row['fb_chat']; ?></textarea>
					<small class="text-muted mt-1 text-left">
						How-To Guides: 
						<a href="https://www.labnol.org/internet/embed-facebook-customer-chat-widget/30663/" target="_blank">Facebook Chat</a> |  
						<a href="https://www.tawk.to/knowledgebase/getting-started/adding-a-widget-to-your-website/" target="_blank">Tawk.to</a> | 
						<a href="https://docs.intercom.com/install-on-your-product-or-site/quick-install/install-intercom-on-your-website-for-logged-out-visitors" target="_blank">Intercom</a> (paid).
					</small>
				</div>

				<div class="form-group text-left">
					<label for="otherScripts">Other Scripts/Code:</label>
					<textarea class="form-control" name="otherScripts" id="otherScripts" rows="5" placeholder="Facebook Pixel, AdRoll Pixel, etc."><?php echo $tracking_row['other_scripts']; ?></textarea>
				</div>

				<button class="submit btn-primary mt-2" type="submit" name="trackingSubmit">UPDATE</button>

				<div class="message text-success mt-3">Code successfully updated!</div>
			</form>
		</div>

		<div class="col-lg-6">
			<form id="btnColorsForm" action="process.php" method="POST" enctype="multipart/form-data">
				<h2 class="text-center">Buttons</h2>

				<ul class="tips text-left">
					<li class="tip text-muted">Need color inspiration? Check <a href="https://flatuicolors.com/" target="_blank">Flat UI</a> or <a href="http://materialui.com/" target="_blank">Material UI</a> colors.</li>
				</ul>

				<!-- BUTTON ONE -->
				<h3>1st Button</h3>

				<div class="form-group mx-width  text-left">
					<label for="btnOneColor">Color:</label>
					<input class="form-control jscolor" id="btnOneColor" name="btnOneColor" value="<?php echo $row['btn_one_color'] ?>">
				</div>

				<div class="form-group mx-width  text-left">
					<label for="btnOneText">Text:</label>
					<input type="text" class="form-control" id="btnOneText" name="btnOneText" value="<?php echo $row['btn_one_text'] ?>">
				</div>

				<div class="form-group mx-width  text-left">
					<label for="btnOneSubtext">Subtext:</label>
					<input type="text" class="form-control" id="btnOneSubtext" name="btnOneSubtext" value="<?php echo $row['btn_one_subtext'] ?>">
				</div>

				<!-- BUTTON TWO -->
				<h3 class="mt-2">2nd Button</h3>

				<div class="form-group mx-width text-left">
					<label for="btnTwoColor">Color:</label>
					<input class="form-control jscolor" id="btnTwoColor" name="btnTwoColor" value="<?php echo $row['btn_two_color'] ?>">
				</div>

				<div class="form-group mx-width  text-left">
					<label for="btnTwoText">Text:</label>
					<input type="text" class="form-control" id="btnTwoText" name="btnTwoText" value="<?php echo $row['btn_two_text'] ?>">
				</div>

				<div class="form-group mx-width  text-left">
					<label for="btnTwoSubtext">Subtext:</label>
					<input type="text" class="form-control" id="btnTwoSubtext" name="btnTwoSubtext" value="<?php echo $row['btn_two_subtext'] ?>">
				</div>

				<!-- BUTTON THREE -->
				<h3 class="mt-2">3rd Button</h3>

				<div class="form-group mx-width text-left">
					<label for="btnThreeColor">Color:</label>
					<input class="form-control jscolor" id="btnThreeColor" name="btnThreeColor" value="<?php echo $row['btn_three_color'] ?>">
				</div>

				<div class="form-group mx-width  text-left">
					<label for="btnThreeText">Text:</label>
					<input type="text" class="form-control" id="btnThreeText" name="btnThreeText" value="<?php echo $row['btn_three_text'] ?>">
				</div>

				<div class="form-group mx-width  text-left">
					<label for="btnThreeSubtext">Subtext:</label>
					<input type="text" class="form-control" id="btnThreeSubtext" name="btnThreeSubtext" value="<?php echo $row['btn_three_subtext'] ?>">
				</div>

				<button class="submit btn-primary mt-2" type="submit" name="btnColorsSubmit">UPDATE</button>

				<div class="message text-success mt-3">Buttons successfully updated!</div>
			</form>

			<hr>
			<!-- SITE INFO -->
			<form id="siteInfoForm" action="process.php" method="POST" enctype="multipart/form-data">
				<h2 class="text-center">Site Info</h2>

				<ul class="tips text-left">
					<li class="tip text-muted">Don't have ".ico" file? Use tools like <a href="http://icoconvert.com/" target="_blank">ICO Convert</a> or <a href="https://redketchup.io/" target="_blank">redketchup</a> to convert your image into ".ico" format.</li>
				</ul>

				<div class="form-group mx-width text-left">
					<label for="favicon">Favicon:</label>
					<input type="file" class="mb-1 mt-1" name="favicon" id="favicon" accept="image/*">
					<small class="text-muted">(Please select ".ico" file)</small>
				</div>

				<div class="form-group mx-width text-left">
					<label for="siteTitle">Site Title:</label>
					<input type="text" class="form-control" id="siteTitle" name="siteTitle" value="<?php echo $row['site_title']; ?>">
				</div>

				<div class="form-group mx-width text-left">
					<label for="frontPageText">Front Page Text:</label>
					<textarea  rows="3" class="form-control" id="frontPageText" name="frontPageText"><?php echo $row['front_page_text']; ?></textarea>
				</div>

				<button class="submit btn-primary mt-1" type="submit" name="siteInfoSubmit">UPDATE</button>

				<div class="message text-success mt-3">Info successfully updated!</div>
			</form>

			<hr>
			<!-- Footer Color -->
			<form id="footerForm" action="process.php" method="POST" enctype="multipart/form-data">
				<h2 class="text-center">Footer</h2>

				<div class="form-group mx-width text-left">
					<label for="footerColor">Color:</label>
					<input type="text" class="form-control jscolor" id="footerColor" name="footerColor" value="<?php echo $row['footer_color']; ?>">
				</div>

				<button class="submit btn-primary mt-1" type="submit" name="footerSubmit">UPDATE</button>

				<div class="message text-success mt-3">Footer successfully updated!</div>
			</form>
		</div>
	</div> <!-- form-container -->


	<script src="assets/library.js"></script>
	<script src="assets/jscolor.js"></script>

	<script>

		//BACKGROUND
		$('#bgForm').submit(function(e) {
			e.preventDefault();

			const message = this.querySelector('.message');

			if (message.classList.contains('message--is-visible')) {
				message.classList.remove('message--is-visible');
			}

			$('button[name=bgSubmit]').addClass('btn--is-processing');
			$('button[name=bgSubmit]').html(`<i class="fa fa-refresh fa-spin fa-fw"></i> Please Wait...`);
			$('button[name=bgSubmit]').blur();

			const bgXAxis = $('#bgXAxis').val();
			const bgYAxis = $('#bgYAxis').val();
			const mobileXAxis = $('#mobileXAxis').val();
			const mobileYAxis = $('#mobileYAxis').val();

			//Images
			const bg = $(this).find('#bg').prop('files')[0];
			const mobileBG = $(this).find('#mobileBG').prop('files')[0];

			const form_data = new FormData();
			form_data.append('bg', bg);
			form_data.append('bgXAxis', bgXAxis);
			form_data.append('bgYAxis', bgYAxis);
			form_data.append('mobileBG', mobileBG);
			form_data.append('mobileXAxis', mobileXAxis);
			form_data.append('mobileYAxis', mobileYAxis);

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
					document.querySelector('#mobileBG').value = '';

					$('button[name=bgSubmit]').removeClass('btn--is-processing');
					$('button[name=bgSubmit]').html('UPDATE');
					$('button[name=bgSubmit]').blur();

					message.classList.add('message--is-visible');
				}
			 });
		});


		// LOGO
		$('#logoForm').submit(function(e) {
			e.preventDefault();

			const message = this.querySelector('.message');

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

					message.classList.add('message--is-visible');
				}
			});
		});

		// BUTTONS
		$("#btnColorsForm").submit(function(e) {
			e.preventDefault();

			const message = this.querySelector('.message');

			if (message.classList.contains('message--is-visible')) {
				message.classList.remove('message--is-visible');
			}

			$('button[name=btnColorsSubmit]').addClass('btn--is-processing');
			$('button[name=btnColorsSubmit]').html(`<i class="fa fa-refresh fa-spin fa-fw"></i> Please Wait...`);
			$('button[name=btnColorsSubmit]').blur();


			$.ajax({
				url: 'process.php',
				data: $(this).serialize()+"&key=btnColors",
				method: 'post',
				success: (data) => {

					$('button[name=btnColorsSubmit]').removeClass('btn--is-processing');
					$('button[name=btnColorsSubmit]').html('UPDATE');
					$('button[name=btnColorsSubmit]').blur();

					message.classList.add('message--is-visible');
				}
			});
		});

		// SITE INFO
		$('#siteInfoForm').submit(function(e) {
			e.preventDefault();

			const message = this.querySelector('.message');

			if (message.classList.contains('message--is-visible')) {
				message.classList.remove('message--is-visible');
			}

			$('button[name=siteInfoSubmit]').addClass('btn--is-processing');
			$('button[name=siteInfoSubmit]').html(`<i class="fa fa-refresh fa-spin fa-fw"></i> Please Wait...`);
			$('button[name=siteInfoSubmit]').blur();

			const siteTitle = $('#siteTitle').val();
			const frontPageText = $('#frontPageText').val();
			const favicon = $(this).find('#favicon').prop('files')[0];

			const form_data = new FormData();
			form_data.append('favicon', favicon);
			form_data.append('siteTitle', siteTitle);
			form_data.append('frontPageText', frontPageText);
			form_data.append('key', 'siteInfo');

			$.ajax({
				url: 'process.php',
				dataType: 'text',
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,
				method: 'post',
				success: (data) => {
					document.querySelector('#favicon').value = '';

					$('button[name=siteInfoSubmit]').removeClass('btn--is-processing');
					$('button[name=siteInfoSubmit]').html('UPDATE');
					$('button[name=siteInfoSubmit]').blur();

					message.classList.add('message--is-visible');
				}
			});
		});

		//TRACKING CODE
		$('#trackingForm').submit(function(e) {
			e.preventDefault();

			const message = this.querySelector('.message');

			if (message.classList.contains('message--is-visible')) {
				message.classList.remove('message--is-visible');
			}

			$('button[name=trackingSubmit]').addClass('btn--is-processing');
			$('button[name=trackingSubmit]').html(`<i class="fa fa-refresh fa-spin fa-fw"></i> Please Wait...`);
			$('button[name=trackingSubmit]').blur();

			$.ajax({
				url: 'process.php',
				data: $(this).serialize()+'&key=tracking',
				method: 'post',
				success: (data) => {

					$('button[name=trackingSubmit]').removeClass('btn--is-processing');
					$('button[name=trackingSubmit]').html('UPDATE');
					$('button[name=trackingSubmit]').blur();

					message.classList.add('message--is-visible');
				}
			});
		});

		//FOOTER
		$('#footerForm').submit(function(e) {
			e.preventDefault();

			const message = this.querySelector('.message');

			if (message.classList.contains('message--is-visible')) {
				message.classList.remove('message--is-visible');
			}

			$('button[name=footerSubmit]').addClass('btn--is-processing');
			$('button[name=footerSubmit]').html(`<i class="fa fa-refresh fa-spin fa-fw"></i> Please Wait...`);
			$('button[name=footerSubmit]').blur();

			$.ajax({
				url: 'process.php',
				data: $(this).serialize()+'&key=footer',
				method: 'post',
				success: (data) => {

					$('button[name=footerSubmit]').removeClass('btn--is-processing');
					$('button[name=footerSubmit]').html('UPDATE');
					$('button[name=footerSubmit]').blur();

					message.classList.add('message--is-visible');
				}
			});
		});

	</script>
</body>
</html>
