
<?php include('header.php'); ?>

		<div class="main-container">

			<h2 class="headline"><?php echo $row['front_page_text']; ?></h2>

			<div class="btns">
				<a href="just-curious.php" class="btn"><?php echo $row['btn_one_text']; ?> <span class="btn-subtext"><?php echo $row['btn_one_subtext']; ?></span></a>

				<a href="semi-drivers.php" class="btn"><?php echo $row['btn_two_text'] ?> <span class="btn-subtext"><?php echo $row['btn_two_subtext']; ?></span></a>

				<a href="ready-drivers.php" class="btn"><?php echo $row['btn_three_text']; ?> <span class="btn-subtext"><?php echo $row['btn_three_subtext'] ?></span></a>
			</div> <!-- btns -->

		</div>

	</main>

	<?php include('footer.php'); ?>

	<!-- Live Chat Here -->
	<?php echo $tracking_row['fb_chat']; ?>

	<!-- Other Scripts Here -->
	<?php echo $tracking_row['other_scripts']; ?>

</body>
</html>
