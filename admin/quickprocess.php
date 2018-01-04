<?php 

	if ( isset($_POST['key']) ) {

		session_start();

		include('conn.php');

		$_SESSION['deleted'] = "";

		if ( $_POST['key'] == 'curiousDelete' ) {

			$id = $_POST['id'];

			$query = "DELETE FROM quick WHERE id = '$id'";

			$result = mysqli_query($conn, $query);

			if($result) {
				$_SESSION['deleted'] = "$id";
				echo 'curiousSuccess';
			} else {
				echo 'There was some error';
			}
		}

		if ( $_POST['key'] == 'curiousDeleteAll' ) {

			foreach($_POST['data'] as $data) {
				$id = mysqli_real_escape_string($conn, $data);
				$query = "DELETE FROM quick WHERE id = '$id'";
				$result = mysqli_query($conn, $query);
				
				if ($result) {
					$_SESSION['deleted'] .= "$id ";
					echo "curiousSuccess";
				} else {
					echo mysqli_error($conn);
				}
			}
		}

	}

 ?>
