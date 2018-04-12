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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>View All | Admin Panel</title>

   	<link rel="stylesheet" href="assets/library.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Mate+SC|Open+Sans:400,700" >
	<link rel="stylesheet" type="text/css" href="assets/listing.css">
</head>
<body>

	<?php include('navbar.php'); ?>

	<div class="actionMessage">
		<?php echo (!empty($actionMessage)) ? $actionMessage : ''; ?>
	</div>

	<!-- Just Curious -->
	<div class="container--table js-listing">

		<h2 class="text-center"><?php echo $btnrow['btn_one_text']; ?> Listing</h2>

		<div class="d-md-flex justify-content-between">
			<div class="text-center mb-3 ml-md-3">
			<form action="export.php" method="post">
				<input type="hidden" name="table" value="quick">
				<button class="btn btn-primary btn-sm" type="submit" name="export"><i class="fa fa-file-text-o"></i> Export as CSV</button>
			</form>
			</div>

			<div class="text-center mb-3 mr-md-3">
				<button class="btn btn-danger btn-sm deleteSelected" data-table="quick"><i class="fa fa-check-square-o"></i> Delete Selected Items</button>
			</div>
		</div>

	   	<table id="curiousTable" class="table table-striped table-bordered table-sm table-responsive" cellspacing="0" width="100%">

			<thead>
				<tr>
					<th class="text-center px-2">
						<input type="checkbox" class="checkAll">
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
	   			<?php
	   				$query = "SELECT * FROM quick ORDER BY id DESC";
	   				$result = mysqli_query($conn, $query);
	   				while($row = mysqli_fetch_array($result)):
	   			?>

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
	   					<a href="#" class="btn btn-link" data-id="<?php echo $row['id']; ?>" data-table="quick" data-toggle="modal" data-target="#detailsModal">View</a>
	   				</td>
	   				<td class="align-middle">
	   					<button title="Change Status" class="btn btn-success btn-sm" data-table="quick" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#statusModal"><i class="fa fa-clock-o"></i></button>

	   					<a title="Edit Info" class="btn btn-primary btn-sm mx-1" href="quickedit.php?all=true&id=<?php echo $row['id']; ?>"><i class="fa  fa-pencil"></i></a>

	   					<button title="Delete" class="deleteBtn btn btn-danger btn-sm" data-table="quick" data-id="<?php echo $row['id']; ?>"><i class="fa fa-trash-o"></i></button>
					</td>
	   			</tr>

			  	<?php endwhile; ?>
	   		</tbody>
		 </table>
   	</div> <!-- Container -->
	<!-- End Just Curious -->


	<!-- Semi Interested -->
	<div class="container--table js-listing">

		<h2 class="text-center"><?php echo $btnrow['btn_two_text']; ?> Listing</h2>

		<div class="d-md-flex justify-content-between">
			<div class="text-center mb-3 ml-md-3">
			<form action="export.php" method="post">
				<input type="hidden" name="table" value="semi">
				<button class="btn btn-primary btn-sm" type="submit" name="export"><i class="fa fa-file-text-o"></i> Export as CSV</button>
			</form>
			</div>

			<div class="text-center mb-3 mr-md-3">
				<button class="btn btn-danger btn-sm deleteSelected" data-table="semi_drivers"><i class="fa fa-check-square-o"></i> Delete Selected Items</button>
			</div>
		</div>

	   	<table id="semiTable" class="table table-striped table-bordered table-sm table-responsive" cellspacing="0" width="100%">

			<thead>
				<tr>
					<th class="text-center px-2">
						<input type="checkbox" class="checkAll">
					</th>
					<th>ID</th>
					<th>Group ID</th>
					<th>First Name</th>
					<th>Last Name</th>
					<!-- <th>Email</th> -->
					<th style="min-width:105px !important">Phone</th>
					<th style="min-width:85px !important">Status</th>
					<th>Details</th>
					<th style="min-width:100px !important">Action</th>
				</tr>
			</thead>

			<tbody class="text-center">
	   			<?php
	   				$query = "SELECT * FROM semi_drivers ORDER BY group_id DESC";
	   				$result = mysqli_query($conn, $query);
	   				while($row = mysqli_fetch_array($result)):
	   			?>

	   			<tr>
					<td class="text-center align-middle">
						<input type="checkbox" class="rowCheck" data-id="<?php echo $row['id']; ?>">
					</td>
	   				<td class="align-middle"><?php echo $row['id']; ?></td>
	   				<td class="align-middle"><?php echo $row['group_id']; ?></td>
	   				<td class="align-middle"><?php echo $row['first_name']; ?></td>
	   				<td class="align-middle"><?php echo $row['last_name']; ?></td>
	   				<!-- <td class="align-middle"><?php echo $row['email']; ?></td> -->
	   				<td class="align-middle"><?php echo $row['phone']; ?></td>
	   				<td class="align-middle"><?php echo $row['status']; ?></td>
	   				<td class="align-middle"><a href="#" class="btn btn-link" data-table="semi" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#detailsModal">View</a></td>
	   				<td class="text-center align-middle">
						<button title="Change Status" class="btn btn-success btn-sm" data-table="semi_drivers" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#statusModal"><i class="fa fa-clock-o"></i></button>

	   					<a title="Edit Info" class="btn btn-primary btn-sm mx-1" href="semiedit.php?all=true&id=<?php echo $row['id']; ?>"><i class="fa  fa-pencil"></i></a>

	   					<button title="Delete" class="deleteBtn btn btn-danger btn-sm" data-table="semi_drivers" data-id="<?php echo $row['id']; ?>"><i class="fa fa-trash-o"></i></button>
					</td>
	   			</tr>

			  	<?php endwhile; ?>
	   		</tbody>
		 </table>
   	</div> <!-- Container -->
   	<!-- End Semi Interested -->


	<!-- Ready To Buy -->
	<div class="container--table js-listing">

		<h2 class="text-center"><?php echo $btnrow['btn_three_text']; ?> Listing</h2>

		<div class="d-md-flex justify-content-between">
			<div class="text-center mb-3 ml-md-3">
				<form action="export.php" method="post">
					<input type="hidden" name="table" value="ready_drivers">
					<button class="btn btn-primary btn-sm" type="submit" name="export"><i class="fa fa-file-text-o"></i> Export as CSV</button>
				</form>
			</div>

			<div class="text-center mb-3 mr-md-3">
				<button class="btn btn-danger btn-sm deleteSelected" data-table="ready_drivers"><i class="fa fa-check-square-o"></i> Delete Selected Items</button>
			</div>
		</div>

	   	<table id="readyTable" class="table table-striped table-bordered table-sm table-responsive" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th class="text-center px-2">
						<input type="checkbox"  class="checkAll">
					</th>
					<th>ID</th>
					<th>Group ID</th>
					<th>First Name</th>
					<th>Last Name</th>
					<!-- <th>Email</th> -->
					<th style="min-width:105px !important">Phone</th>
					<th style="min-width:85px !important">Status</th>
					<th>Details</th>
					<th style="min-width:100px !important">Action</th>
				</tr>
			</thead>

			<tbody class="text-center">
	   			<?php
	   				$query = "SELECT * FROM ready_drivers ORDER BY group_id DESC";
	   				$result = mysqli_query($conn, $query);
	   				while($row = mysqli_fetch_array($result)):
	   			 ?>

	   			<tr>
					<td class="text-center align-middle">
						<input type="checkbox" class="rowCheck" data-id="<?php echo $row['id']; ?>">
					</td>
	   				<td class="align-middle"><?php echo $row['id']; ?></td>
	   				<td class="align-middle"><?php echo $row['group_id']; ?></td>
	   				<td class="align-middle"><?php echo $row['first_name']; ?></td>
	   				<td class="align-middle"><?php echo $row['last_name']; ?></td>
	   				<!-- <td class="align-middle"><?php echo $row['email']; ?></td> -->
	   				<td class="align-middle"><?php echo $row['phone']; ?></td>
	   				<td class="align-middle"><?php echo $row['status']; ?></td>
	   				<td class="align-middle"><a href="#" class="btn btn-link" data-table="ready" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#detailsModal">View</a></td>
	   				<td class="text-center align-middle">
	   					<button title="Change Status" class="btn btn-success btn-sm" data-table="ready_drivers" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#statusModal"><i class="fa fa-clock-o"></i></button>

	   					<a title="Edit Info" class="btn btn-primary btn-sm mx-1" href="readyedit.php?all=true&id=<?php echo $row['id']; ?>"><i class="fa  fa-pencil"></i></a>

	   					<button title="Delete" class="deleteBtn btn btn-danger btn-sm" data-table="ready_drivers" data-id="<?php echo $row['id']; ?>"><i class="fa fa-trash-o"></i></button>
					</td>
	   			</tr>

			  	<?php endwhile; ?>
	   		</tbody>
		</table>
   	</div> <!-- Container -->
	<!-- End Ready To Buy -->


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
						<input type="hidden" name="table" value="">
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


  <script src="assets/library.js"></script>

  <script>

	// Modals
	$('#detailsModal').on('show.bs.modal', function (event) {
		const button = $(event.relatedTarget); // Button that triggered the modal
		const table = button.data('table');
		const id = button.data('id');
		const modal = $(this);
		modal.find('.modal-body').load(`view/${table}view.php?id=${id}`);
		modal.find('[name=table]').val(table);
		modal.find('[name=id]').val(id);
	});

	$('#statusModal').on('show.bs.modal', function (event) {
		const button = $(event.relatedTarget); // Button that triggered the modal
		const id = button.data('id');
		const table = button.data('table');
		const modal = $(this);

		modal.find('.modal-body').load(`status.php?table=${table}&id=${id}`);
	});

	//Status
	function statusUpdate (updateButton) {
		const table = updateButton.dataset.table;
		const id = updateButton.dataset.id;
		const status = $('select[name=status]').val();

		$.ajax({
			url: 'process.php',
			method: 'post',
			data: {key: 'statusUpdate', id: id, status: status, table: table},
			success: function(response) {
				if (response.includes('statusSuccess')) {
					window.location.href = 'all.php';
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
		const table = this.dataset.table;
		const deleteItem = confirm(`Do you want to delete the record with the id of "${id}"?`);

		if (deleteItem) {
			$.ajax({
				url: 'process.php',
				method: 'POST',
				data: {key: 'delete', id: id, table: table},
				success: function(response) {
					if (response.includes('deleteSuccess')) {
						window.location.href = `all.php`;
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

	$(".checkAll").change(function() {
		if (this.checked) {
			$('.checkAll').prop('checked', false);
			$('.rowCheck').prop('checked', false);

			$(this).prop('checked', true);
			$(this).closest('table').find('.rowCheck').prop('checked', true);
		} else {
			$('.rowCheck').prop('checked', false);
		}
	});

	// Delete Selected Items
	$(".deleteSelected").click(function() {
		const table = this.dataset.table;
		const checkedItems = Array.from( $(this).closest('.js-listing').find('.rowCheck') ).filter(box => box.checked).map(item => item.dataset.id);

		if (checkedItems.length > 0) {
			const deleteSelectedItems = confirm(`Are you sure? This will permanently delete the records of ${checkedItems.join(', ')}!`);

			if (deleteSelectedItems) {
				$.ajax({
					url: 'process.php',
					method: 'POST',
					data: {key: 'deleteSelected', ids: checkedItems, table: table},
					success: function(response) {
						if (response.includes('deleteSuccess')) {
							window.location.href = `all.php`;
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
	$('#curiousTable').DataTable({
		'iDisplayLength': 5,
		'aLengthMenu': [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
		'columnDefs': [{ 'orderable': false, 'targets': 0 }], // hide sort icon on header of first column
		'aaSorting': [[1, 'dsc']] // start to sort data in second column
	});

	$('#semiTable').DataTable({
		'iDisplayLength': 5,
		'aLengthMenu': [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
		'columnDefs': [{ 'orderable': false, 'targets': 0 }], // hide sort icon on header of first column
		'aaSorting': [[1, 'dsc']] // start to sort data in second column
	});


	$('#readyTable').DataTable({
		'iDisplayLength': 5,
		'aLengthMenu': [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, 'All']],
		'columnDefs': [{ 'orderable': false, 'targets': 0 }], // hide sort icon on header of first column
		'aaSorting': [[1, 'dsc']] // start to sort data in second column
	});
  </script>
</body>
</html>
