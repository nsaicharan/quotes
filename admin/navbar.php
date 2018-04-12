<?php
	$btnquery = "SELECT btn_one_text, btn_two_text, btn_three_text FROM bg_logo";
	$btnresult = mysqli_query($conn, $btnquery);
	$btnrow = mysqli_fetch_array($btnresult);
?>

<style type="text/css">
	/* === Start Navbar === */
	.container--nav {
		padding: 0;
		max-width: 1190px;
	}

	.mr-onepx {
		margin-right: 1px;
	}

	.mr-twopx {
		margin-right: 2px;
	}

	.navbar {
		padding: 0 1rem .16rem;
		box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
	    background-color: #fff;
	    margin-bottom: 30px;
	    font-family: 'Open Sans';
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
</style>

<nav class="navbar navbar-expand-lg  static-top">
	<div class="container container--nav">
		<a class="navbar-brand" href="all.php">Admin Panel</a>
		<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
			Menu
			<i class="fa fa-bars"></i>
		</button>
		<div class="collapse navbar-collapse mt-lg-2" id="navbarResponsive">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" id="dropdownThemes" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-id-card-o mr-twopx"></i>
						Forms
					</a>
					<div class="dropdown-menu" aria-labelledby="dropdownThemes">
						<a class="dropdown-item" href="quick.php">
							<i class="fa fa-binoculars fa-fw mr-1"></i>
							<?php echo $btnrow['btn_one_text']; ?>
						</a>
						<a class="dropdown-item" href="semi.php">
							<i class="fa fa-balance-scale fa-fw mr-1"></i>
							<?php echo $btnrow['btn_two_text']; ?>
						</a>
						<a class="dropdown-item" href="ready.php">
							<i class="fa fa-handshake-o fa-fw mr-1"></i>
							<?php echo $btnrow['btn_three_text']; ?>
						</a>
						<a class="dropdown-item" href="all.php">
							<i class="fa fa-map-o fa-fw mr-1"></i>
							View All
						</a>
						
						<div class="dropdown-divider"></div>

						<a class="dropdown-item" href="editforms.php">
							<i class="fa fa-edit fa-fw mr-1"></i>
							Edit
						</a>
					</div>
				</li>

				<li class="nav-item">
					<a class="nav-link" href="bg-logo.php" title="Background, Logo, Buttons, Tracking Code, Site Info, Footer">
						<i class="fa fa-file-image-o mr-twopx"></i>
						Main Page
					</a>
				</li>

				<li class="nav-item">
					<a class="nav-link" href="thankyou.php" title="Edit Thank You Page">
						<i class="fa fa-heart-o mr-onepx"></i>
						Thank You
					</a>
				</li>

				<?php if ($_SESSION['loggedInUser'] == 'operator') : ?>
					<li class="nav-item">
						<a class="nav-link" href="sellback.php" title="Sell Back Offers">
							<i class="fa fa-star-o mr-onepx"></i>
							Sell Back
						</a>
					</li>
				<?php endif; ?>

				<li class="nav-item">
					<a class="nav-link" href="users.php" title="Edit users">
						<i class="fa fa-users mr-twopx"></i>
						Users
					</a>
				</li>
			</ul>
			<ul class="navbar-nav">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle text-capitalize" href="#" id="dropdownPremium" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="fa fa-user-circle-o fa-lg fa-fw"></i>
						<?php echo $_SESSION['loggedInUser'] ?>
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
