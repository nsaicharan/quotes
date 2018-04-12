<?php 
	session_start(); 

	if (!$_SESSION['loggedInUser']) {
		header("Location: index.php");

	} else {
		include('../conn.php');

		$message = "";

		if ( isset($_SESSION['userAdded']) ) {
			$message = "<div class='alert alert-warning'>New User Added <button class='close' data-dismiss='alert'>&times;</button></div>";
			unset($_SESSION['userAdded']);
		}

		if ( isset($_SESSION['userEdited']) ) {
			$username = $_SESSION['userEdited'];
			$message = "<div class='alert alert-warning'>User Edited: $username <button class='close' data-dismiss='alert'>&times;</button></div>";
			unset($_SESSION['userEdited']);
		}

		if ( isset($_SESSION['userDeleted']) ) {
			$username = $_SESSION['userDeleted'];
			$message = "<div class='alert alert-warning'>User Deleted: $username <button class='close' data-dismiss='alert'>&times;</button></div>";
			unset($_SESSION['userDeleted']);
		}
	}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Users | Admin Panel</title>
	
	<link rel="stylesheet" href="assets/library.css">
    <link href="https://fonts.googleapis.com/css?family=Mate+SC|Satisfy|Open+Sans:400,700" rel="stylesheet">

	<style type="text/css">

		body {
			background: hsl(48, 100%, 67%);
			font-family: 'Open Sans';
		}
		button {
			cursor: pointer;
		}

		.alert {
			width: 850px;
			max-width: 90vw;
			margin: 10px auto 12px;
		}

		@media (max-width: 480px) {
			.alert {
				width: 95vw;
			}
		}

		h2 {
			font-family: 'Mate SC', satisfy;
			margin: 0 0 20px;
			font-size: 24px;
			background: #011638;
			padding: 12px 0;
			color: white;
			text-align: center;
		}

		.container--users {
			width: 850px;
			max-width: 90vw;
			margin: 0 auto;
			background: white;
			box-shadow: 0 1px 5px rgba(0, 0, 0, .15);
			margin-bottom: 25px;
		}

		@media (max-width: 480px) {
			.container--users {
				max-width: 95vw;
			}
		}

		.wrapper {
			padding: 10px 20px 15px;
		}

		.update-btn {
			padding: 10px 30px;
			border: none;
			display: inline-block;
			font-weight: 500;
			border-radius: 3px;
			margin: 25px 0;
			font-size: 18px;
		}

	</style>
</head>
<body>

	<?php include('navbar.php') ?>

	<?php echo $message; ?>
	
	<div class="container--users">
		<h2>Users</h2>

		<div class="wrapper">
			<button class="btn btn-primary btn-sm mb-2 addBtn" data-target="#addUserModal" data-toggle="modal">
				<i class="fa fa-plus"></i>
				Add User
			</button>

			<table class="table table-bordered table-striped table-responsive"> 
				<thead>
					<tr>
						<th class="text-center">S/N</th>
						<th class="text-center">Username</th>
						<th class="text-center">Email</th>
						<th class="text-center" style="min-width:100px !important">Action</th>
					</tr>
				</thead>

				<tbody class="text-center">
					<?php 
						
						if ( $_SESSION['loggedInUser'] == 'operator' ) {
							$query = "SELECT * FROM users";
						} else {
							$query = "SELECT * FROM users WHERE username != 'operator'";
						}

						$result = mysqli_query($conn, $query);

						$i=1;
						while ($row = mysqli_fetch_array($result)) :
					?>

					<tr>
						<td class="align-middle"><?php echo $i ?></td>
						<td class="align-middle"><?php echo $row['username'] ?></td>
						<td class="align-middle"><?php echo $row['email'] ?></td>
						<td class="align-middle">
							<button title="Edit" class="btn btn-primary btn-sm mr-1 editBtn" data-target="#editUserModal" data-toggle="modal" data-username="<?php echo $row['username'] ?>"><i class="fa fa-pencil"></i></button>
							
							<?php if ( $row['username'] != 'operator' ) : ?>
								<button title="Delete" class="btn btn-danger btn-sm ml-1 deleteBtn" data-username="<?php echo $row['username'] ?>"><i class="fa fa-trash-o"></i></button>
							<?php endif; ?>
						</td>
					</tr>

					<?php $i++; endwhile; ?>
				</tbody>
			</table>

			<!-- Add User Modal -->
			<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="addUserModalLabel">New User</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>

						<div class="modal-body">
							<form id="addUserForm">
								<div class="form-group">
									<label>Username:</label>
									<input type="text" class="form-control" name="username" required>
								</div>

								<div class="form-group">
									<label>Password:</label>
									<input type="password" class="form-control" name="password" required>
								</div>

								<div class="form-group">
									<label>Confirm Password:</label>
									<input type="password" class="form-control" name="cpassword" required>
								</div>

								<div class="form-group">
									<label>Email:</label>
									<input type="email" class="form-control" name="email" required>
								</div>

								<input type="hidden" name="key" value="addUser">

								<button class="btn btn-primary btn-block mb-1" type="submit">ADD USER</button>

								<div class="error"></div>
							</form>
						</div>
					</div>
				</div>
			</div> <!-- End Add User Modal -->

			<!-- Edit User Modal -->
			<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							</button>
						</div>

						<div class="modal-body">
						</div>
					</div>
				</div>
			</div> <!-- End Edit User Modal -->

		</div> <!-- wrapper -->
	</div> <!-- container-user -->
	
	<script src="assets/library.js"></script>

    <script>

		//Modal 
		$('#editUserModal').on('show.bs.modal', function (event) {
			const button = $(event.relatedTarget); // Button that triggered the modal
			const username = button.data('username');
			const modal = $(this);
			
			modal.find('.modal-title').text(`Edit ${username}`);
			modal.find('.modal-body').load(`usersedit.php?username=${username}`);
		});

		//Edit User
		function editUser(form) {
			if ( $(form).find('[name=password]').val() != $(form).find('[name=cpassword]').val() ) {
				$(form).find('.error').html(`<p class="text-danger text-center mt-3 mb-0"><strong>Passwords do not match!</strong></p>`);

			} else {
				$.ajax({
					url: 'process.php',
					method: 'post',
					data: $(form).serialize(),
					success: (response) => {
						if (response == 'userEdited') {
							window.location.href = 'users.php';
						} else {
							console.log(response);
						}
					},
					error: function(err) {
						console.log(err);
					}
				});
			}

			return false;
		}

		//Add User
		$("#addUserForm").submit(function() {

			if ( $(this).find('[name=password]').val() != $(this).find('[name=cpassword]').val() ) {
				$(this).find('.error').html(`<p class="text-danger text-center mt-3 mb-0"><strong>Passwords do not match!</strong></p>`);

			} else {
				$.ajax({
					url: 'process.php',
					method: 'post',
					data: $(this).serialize(),
					success: (response) => {
						if (response == 'userAdded') {
							window.location.href = 'users.php';
						} else if (response == 'userExist') {
							$(this).find('.error').html(`<p class="text-danger text-center mt-3 mb-0"><strong>Username already exists!</strong></p>`);
						} else {
							console.log(response);
						}
					},
					error: function(err) {
						console.log(err);
					}
				});
			}

			return false;
		});

		//Delete User
		$('.deleteBtn').click(function() {
			const username = $(this).data('username');
			const deleteUser = confirm(`Do you want to delete ${username}?`);

			if (deleteUser) {
				$.ajax({
					url: 'process.php',
					method: 'post',
					data: {username: username, key:'deleteUser'},
					success: (response) => {
						if (response == 'userDeleted') {
							window.location.href = 'users.php';
						} else {
							console.log(response);
						}
					},
					error: function(err) {
						console.log(err);
					}
				});
			}
		});
   
    </script>
</body>
</html>