<?php 

	session_start();
	
	if (!$_SESSION['loggedInUser']) {
		header("Location: index.php");
		exit();

	} else {

		if ( isset($_POST['key']) ) {
			
			$_SESSION['deleted'] = '';

			include('conn.php');

			//Delete Item
			if ( $_POST['key'] == 'delete' ) {

				$id = mysqli_real_escape_string($conn, $_POST['id']);
				$table = mysqli_real_escape_string($conn, $_POST['table']);

				$query = "DELETE FROM $table WHERE id = '$id' LIMIT 1";

				$result = mysqli_query($conn, $query);

				if($result) {
					$_SESSION['delete'] = "$id";
					echo 'deleteSuccess';
				} else {
					echo mysqli_error($conn);
				}
			}

			//Delete Selected Items
			if ( $_POST['key'] == 'deleteSelected' ) {

				foreach($_POST['ids'] as $id) {
					$id = mysqli_real_escape_string($conn, $id);
					$table = mysqli_real_escape_string($conn, $_POST['table']);

					$query = "DELETE FROM $table WHERE id = '$id' LIMIT 1";
					$result = mysqli_query($conn, $query);
					
					if ($result) {
						$_SESSION['deleteSelected'] .= "$id ";
						echo "deleteSuccess";
					} else {
						echo mysqli_error($conn);
					}
				}
			}

			//BACKGROUND
			if ( $_POST['key'] == 'background' ) {
				$bgXAxis = mysqli_real_escape_string($conn, $_POST['bgXAxis']);
				$bgYAxis = mysqli_real_escape_string($conn, $_POST['bgYAxis']);

				$query = "UPDATE bg_logo SET bg_xaxis = '$bgXAxis', bg_yaxis = '$bgYAxis'";
				$result = mysqli_query($conn, $query);

				if ( isset($_FILES['bgImage']) ) {
				   
				    $file = $_FILES['bgImage'];
				    $fileName = $_FILES['bgImage']['name'];
				    $fileTmpName = $_FILES['bgImage']['tmp_name'];
				    $fileSize = $_FILES['bgImage']['size'];
				    $fileError = $_FILES['bgImage']['error'];
				    $fileType = $_FILES['bgImage']['type'];

				    $fileActualExt = explode('.', $fileName);
				    $fileExt = strtolower(end($fileActualExt));

				    if ($fileError === 0) {
				        $fileNameNew = uniqid('').".".$fileExt;
						$fileDest = '../img/'.$fileNameNew;

				        move_uploaded_file($fileTmpName, $fileDest);

				        $query = "UPDATE bg_logo SET background = '$fileNameNew'";
				        $result = mysqli_query($conn, $query);
					} 	
				}
			}

			//LOGO
			if ( $_POST['key'] == 'logo' ) {

				$logoHeight = mysqli_real_escape_string($conn, $_POST['logoHeight']);
				$logoAltText = mysqli_real_escape_string($conn, $_POST['logoAltText']);

				$query = "UPDATE bg_logo SET logo_height = '$logoHeight', logo_alt_text = '$logoAltText'";
				$result = mysqli_query($conn, $query); 

				if (isset ($_FILES['logoImage'])) {
				   
				    $file = $_FILES['logoImage'];
				    $fileName = $_FILES['logoImage']['name'];
				    $fileTmpName = $_FILES['logoImage']['tmp_name'];
				    $fileSize = $_FILES['logoImage']['size'];
				    $fileError = $_FILES['logoImage']['error'];
				    $fileType = $_FILES['logoImage']['type'];

				    $fileActualExt = explode('.', $fileName);
				    $fileExt = strtolower(end($fileActualExt));

				    if ($fileError === 0) {
				        $fileNameNew = uniqid('').".".$fileExt;
				        $fileDest = '../img/'.$fileNameNew;

				        move_uploaded_file($fileTmpName, $fileDest);

				        $query = "UPDATE bg_logo SET logo = '$fileNameNew'";
				        $result = mysqli_query($conn, $query);  
				    }
				}
			}

		}
	}

 ?>
