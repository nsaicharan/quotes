<?php
	session_start();

	if (!$_SESSION['loggedInUser']) {
		header("Location: index.php");
		exit();
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

	$query = "SELECT * FROM quick ORDER BY id DESC";
	$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Just Curious | Admin Panel</title>

	<link rel="stylesheet" type="text/css" href="assets/library.css">
	<link href="https://fonts.googleapis.com/css?family=Mate+SC|Open+Sans:400,700" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="assets/listing.css">
</head>
<body>

	<?php include('navbar.php') ?>

	<?php echo $actionMessage; ?>

	<div class="container--table">

		<h2 class="text-center"><?php echo $btnrow['btn_one_text']; ?> Listing</h2>

		<div class="d-md-flex justify-content-between">
			<div class="text-center mb-3 ml-md-3">
			<form action="export.php" method="post">
				<input type="hidden" name="table" value="quick">
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
					<th>First Name</th>
					<th>Last Name</th>
					<th>Email</th>
					<th style="min-width:105px !important">Phone</th>
					<th style="min-width:85px !important">Status</th>
					<th>Details</th>
					<th style="min-width:100px !important">Action</th>
				</tr>
			</thead>

			<tbody class="text-center">
	   			<?php while($row = mysqli_fetch_array($result)): ?>

	   			<tr>
					<td class="align-middle">
						<input type="checkbox" class="rowCheck" data-id="<?php echo $row['id']; ?>">
					</td>
	   				<td class="align-middle"><?php echo $row['id']; ?></td>
	   				<td class="align-middle"><?php echo $row['first']; ?></td>
	   				<td class="align-middle"><?php echo $row['last']; ?></td>
	   				<td class="align-middle"><?php echo $row['email']; ?></td>
	   				<td class="align-middle"><?php echo $row['phone']; ?></td>
	   				<td class="align-middle"><?php echo $row['status']; ?></td>
	   				<td class="align-middle">
	   					<a href="#" class="btn btn-link" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#detailsModal">View</a>
	   				</td>
	   				<td class="align-middle">
	   					<button title="Change Status" class="btn btn-success btn-sm" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#statusModal"><i class="fa fa-clock-o"></i></button>

	   					<a title="Edit Info" class="btn btn-primary btn-sm mx-1" href="quickedit.php?id=<?php echo $row['id']; ?>"><i class="fa  fa-pencil"></i></a>

	   					<button title="Delete" class="btn btn-danger btn-sm deleteBtn" data-id="<?php echo $row['id']; ?>"><i class="fa fa-trash-o"></i></button>
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
						<input type="hidden" name="table" value="quick">
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
					<p>ID: <?php echo $id; ?></p>

					<select class="form-control" name="status">
						<option value="In Progress">In Progress</option>
						<option value="Sold Out">Sold Out</option>
						<option value="Not Sold">Not Sold</option>
					</select>

					<button class="btn btn-primary mt-3 mb-1" id="statusUpdate" data-id="<?php echo $row['id'] ?>">UPDATE</button>
				</div>
			</div>
		</div>
	</div>

  	<script src="assets/library.js"></script>

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

			modal.find('.modal-body').load(`view/quickview.php?id=${id}`);
			modal.find('[name=id]').val(id);
		});

		$('#statusModal').on('show.bs.modal', function (event) {
			const button = $(event.relatedTarget) // Button that triggered the modal
			const id = button.data('id')
			const modal = $(this)

			modal.find('.modal-body').load(`status.php?table=quick&id=${id}`);

		});

		// Status
		function statusUpdate (updateButton) {
			const id = updateButton.dataset.id;
			const status = $('select[name=status]').val();

			$.ajax({
				url: 'process.php',
				method: 'post',
				data: {key: 'statusUpdate', id: id, status: status, table: 'quick'},
				success: function(response) {
					if (response.includes('statusSuccess')) {
						window.location.href = 'quick.php';
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
					method: 'post',
					data: {key: 'delete', id: id, table: 'quick'},
					success: function(response) {
						if (response.includes('deleteSuccess')) {
							window.location.href = 'quick.php';
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
						method: 'post',
						data: {key: 'deleteSelected', ids: checkedItems, table: 'quick'},
						success: function(response) {
							if (response.includes('deleteSuccess')) {
								window.location.href = 'quick.php';
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

		// Tables
		$('#myTable').DataTable({
			'columnDefs': [{ 'orderable': false, 'targets': 0 }], // hide sort icon on header of first column
    		'aaSorting': [1] // start to sort data in second column
		});

 	</script>
</body>
</html>
