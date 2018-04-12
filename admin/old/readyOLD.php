<?php
	session_start();

	if (!$_SESSION['loggedInUser']) {
		header("Location: index.php");
	}

	include('../conn.php');

	$actionMessage = '';

	if ( isset($_SESSION['status']) ) {
		$id = $_SESSION['status'];
		$actionMessage = "<div class='alert alert-warning'><strong>Recent Action:</strong> Changed the status of $id. <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
		unset($_SESSION['status']);
	}

	if ( isset($_SESSION['delete']) ) {
		$id = $_SESSION['delete'];
		$actionMessage = "<div class='alert alert-warning'><strong>Recent Action:</strong> Deleted the record of $id. <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
		unset($_SESSION['delete']);
	}

	if ( isset($_SESSION['deleteSelected']) ) {
		$ids = str_replace(' ', ', ', trim($_SESSION['deleteSelected']));
		$actionMessage = "<div class='alert alert-warning'><strong>Recent Action:</strong> Deleted the records of $ids. <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
		unset($_SESSION['deleteSelected']);
	}

	if ( isset($_SESSION['edit']) ) {
		$id = $_SESSION['edit'];
		$actionMessage = "<div class='alert alert-warning'><strong>Recent Action:</strong> Edited the record of $id. <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
		unset($_SESSION['edit']);
	}

	$query = "SELECT * FROM ready_vehicles ORDER BY id DESC";
	$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ready To Buy | Admin Panel</title>

   	<link rel="stylesheet" type="text/css" href="assets/master.css">
	<link href="https://fonts.googleapis.com/css?family=Mate+SC|Open+Sans:400,700" rel="stylesheet">

	<style>
		body {
			text-rendering: optimizeLegibility;
			 -webkit-font-smoothing: antialiased;
			 -moz-osx-font-smoothing: grayscale;
			 font-family: 'Open Sans';
			 background: hsl(48, 100%, 67%);
		}

		a:hover {
			text-decoration: none;
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
			box-shadow: 0 1px 5px rgba(0, 0, 0, 0.15);
		    background-color: #fff;
		    margin-bottom: 30px;
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

		.alert {
			width: 95vw;
			max-width: 1170px;
			margin: 10px auto 12px;
		}

		h2 {
			font-family: 'Mate SC';
			margin: 0 0 20px;
			font-size: 24px;
			background: #011638;
			padding: 12px 0;
			color: white;
		}

		.container--table {
			background: white;
			padding: 0 0 30px;
			margin:0 auto 25px;
			box-shadow: 0 1px 5px rgba(0,0,0,.15);
			width: 1170px;
			max-width: 95vw;
		}

		button {
			cursor: pointer;
		}

	</style>
</head>
<body>

	<?php include('navbar.php'); ?>

	<div class="actionMessage">
		<?php echo (!empty($actionMessage)) ? $actionMessage : ''; ?>
	</div>

	<div class="container--table">

		<h2 class="text-center"><?php echo $btnrow['btn_three_text']; ?> Listing</h2>

		<div class="d-md-flex justify-content-between">
			<div class="text-center mb-3 ml-md-3">
				<form action="export.php" method="post">
					<input type="hidden" name="table" value="ready">
					<button class="btn btn-primary btn-sm" type="submit" name="export"><i class="fa fa-file-text-o"></i> Export as CSV</button>
				</form>
			</div>

			<div class="text-center mb-3 mr-md-3">
				<button class="btn btn-danger btn-sm" id="deleteSelected"><i class="fa fa-check-square-o"></i> Delete Selected Items</button>
			</div>
		</div>

	   	<table id="myTable" class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">

			<thead>
				<tr>
					<th class="text-center px-2">
						<input type="checkbox" id="checkAll">
					</th>
					<th>ID</th>
					<th>Year</th>
					<th>Make</th>
					<th>Model</th>
					<th>VIN</th>
					<th>Status</th>
					<th>Details</th>
					<th style="min-width:100px !important">Action</th>
				</tr>
			</thead>

			<tbody class="text-center">

	   			<?php while($row = mysqli_fetch_array($result)) : ?>

	   			<tr>
					<td class="text-center align-middle">
						<input type="checkbox" class="rowCheck" data-id="<?php echo $row['id']; ?>">
					</td>
					<td class="align-middle"><?php echo $row['id']; ?></td>
	   				<td class="align-middle"><?php echo $row['vehicle_year']; ?></td>
	   				<td class="align-middle"><?php echo $row['make']; ?></td>
	   				<td class="align-middle"><?php echo $row['model']; ?></td>
	   				<td class="align-middle"><?php echo $row['vin']; ?></td>
	   				<td class="align-middle"><?php echo $row['status']; ?></td>
	   				<td class="align-middle"><a href="#" class="btn btn-link" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#detailsModal">View</a></td>
	   				<td class="text-center align-middle">
	   					<button title="Change Status" class="btn btn-success btn-sm" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#statusModal"><i class="fa fa-clock-o"></i></button>

	   					<a title="Edit Info" class="btn btn-primary btn-sm mx-1" href="readyedit.php?id=<?php echo $row['id']; ?>"><i class="fa  fa-pencil"></i></a>

	   					<button title="Delete" class="deleteBtn btn btn-danger btn-sm" data-id="<?php echo $row['id']; ?>"><i class="fa fa-trash-o"></i></button>
					</td>
	   			</tr>

			<?php endwhile; ?>
	   		</tbody>
		 </table>
   	</div>

	<!-- Details Modal -->
	<div class="modal fade" id="detailsModal" tabindex="-1" role="dialog" aria-labelledby="detailsModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="detailsModalLabel">Full Details</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
				</div>

				<div class="modal-footer">
					<form class="form-inline" action="export.php" method="post">
						<input type="hidden" name="table" value="ready">
						<input type="hidden" name="id" value="">
						<button class="btn btn-primary mr-1" type="submit" name="export"><i class="fa fa-file-text-o"></i> Export</button>
					</form>

					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Status Modal -->
	<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="statusModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="statusModalLabel">Current Status</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
				</div>
			</div>
		</div>
	</div>


  <script src="assets/master.js"></script>

  <script>

	$(window).on('load resize', function() {
		if ( $(this).width() < 768 ) {
			$('table').addClass('table-sm');
		} else {
			$('table').removeClass('table-sm');
		}
	});

	// Modals
	$('#detailsModal').on('show.bs.modal', function (event) {
		const button = $(event.relatedTarget); // Button that triggered the modal
		const id = button.data('id');
		const modal = $(this);

		modal.find('.modal-body').load(`view/readyview.php?id=${id}`);
		modal.find('[name=id]').val(id);
	});

	$('#statusModal').on('show.bs.modal', function (event) {
		const button = $(event.relatedTarget); // Button that triggered the modal
		const id = button.data('id');
		const modal = $(this);

		modal.find('.modal-body').load(`status.php?table=ready_drivers&id=${id}`);

	});

	//Status
	function statusUpdate (updateButton) {
		const id = updateButton.dataset.id;
		const status = $('select[name=status]').val();

		$.ajax({
			url: 'process.php',
			method: 'post',
			data: {key: 'statusUpdate', id: id, status: status, table: 'ready_drivers'},
			success: function(response) {
				if (response.includes('statusSuccess')) {
					window.location.href = 'ready.php';
				} else {
					console.log(response);
				}
			},
			error: function(err) {
				console.log(err);
			}
		});
	};

	// Delete Item
	$('.deleteBtn').click(function(e) {
		e.preventDefault();

		const id = this.dataset.id;
		const deleteItem = confirm(`Do you want to delete the record with the id of "${id}"?`);

		if (deleteItem) {
			$.ajax({
				url: 'process.php',
				method: 'POST',
				data: {key: 'delete', id: id, table: 'ready_vehicles'},
				success: function(response) {
					if (response.includes('deleteSuccess')) {
						window.location.href = `ready.php`;
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

	$("#checkAll").change(function() {
		if (this.checked) {
			$('.rowCheck').prop('checked', true);
		} else {
			$('.rowCheck').prop('checked', false);
		}
	});

	// Delete Selected Items
	$("#deleteSelected").click(function() {
		const checkedItems = Array.from($('.rowCheck')).filter(box => box.checked).map(item => item.dataset.id);

		if (checkedItems.length > 0) {
			const deleteSelectedItems = confirm(`Do you want to delete the records of ${checkedItems.join(', ')}?`);

			if (deleteSelectedItems) {
				$.ajax({
					url: 'process.php',
					method: 'POST',
					data: {key: 'deleteSelected', ids: checkedItems, table: 'ready_vehicles'},
					success: function(response) {
						if (response.includes('deleteSuccess')) {
							window.location.href = `ready.php`;
						} else {
							console.log(response);
						}
					},
					error: function(err) {
						console.log(err);
					}
				});
			}
		} else {
			alert("No item selected!");
		}
	});

	// Table
	$('#myTable').DataTable({
		'columnDefs': [{ 'orderable': false, 'targets': 0 }], // hide sort icon on header of first column
		'aaSorting': [1] // start to sort data in second column
	});
  </script>
</body>
</html>
