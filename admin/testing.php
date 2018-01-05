<?php 
	session_start(); 

	if (!$_SESSION['loggedInUser']) {
		header("Location: index.php");
	}

	include('conn.php');

	$actionMessage = '';

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

	$query = "SELECT * FROM multi_vehicle";
	$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data Collection</title>
   	<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
	<link href="https://fonts.googleapis.com/css?family=Mate+SC|Satisfy|Open+Sans:400,500,700" rel="stylesheet">

	<style>
		body {
			text-rendering: optimizeLegibility;
			 -webkit-font-smoothing: antialiased;
			 -moz-osx-font-smoothing: grayscale;
			 font-family: 'Open Sans', sans-serif;
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
			font-family: 'Mate SC', satisfy;
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

	<nav class="navbar navbar-expand-lg  static-top">
		<div class="container container--nav">
			<a class="navbar-brand" href="data.php">Data Collection</a>
			<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
				Menu
				<i class="fa fa-bars"></i>
			</button>
			<div class="collapse navbar-collapse mt-lg-2" id="navbarResponsive">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" href="#" id="dropdownThemes" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-id-card-o mr-twopx"></i>
							Insurance Listing
						</a>
						<div class="dropdown-menu" aria-labelledby="dropdownThemes">
							<a class="dropdown-item" href="data.php">
								<i class="fa fa-binoculars fa-fw mr-1"></i>
								Just Curious
							</a>
							<a class="dropdown-item" href="semi.php">
								<i class="fa fa-balance-scale fa-fw mr-1"></i>
								Semi Interested
							</a>
							<a class="dropdown-item" href="ready.php">
								<i class="fa fa-handshake-o fa-fw mr-1"></i>
								Ready To Buy
							</a>
						</div>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="thankyou.php" title="Edit thank you page">
							<i class="fa fa-heart-o mr-onepx"></i>
							Thank You
						</a>
					</li>

					<li class="nav-item">
						<a class="nav-link" href="bg-logo.php" title="Change background or logo">
							<i class="fa fa-file-image-o mr-twopx"></i>
							Background &amp; Logo
						</a>
					</li>
				</ul>
				<ul class="navbar-nav">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle text-capitalize" href="#" id="dropdownPremium" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="fa fa-user-circle-o fa-lg fa-fw"></i>
							<?php echo $_SESSION['loggedInUser']; ?>
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

	<div class="actionMessage">
		<?php echo (!empty($actionMessage)) ? $actionMessage : ''; ?>
	</div>

	<div class="container--table">

		<h2 class="text-center">WIP</h2>
		
		<div class="text-center text-md-right mb-3 mr-md-3">
			<button class="btn btn-danger btn-sm" id="deleteSelected"><i class="fa fa-check-square-o"></i> Delete Selected Items</button>
		</div>
		
	   	<table id="myTable" class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">

			<thead>
				<tr class="">
					<th class="text-center">
						<input type="checkbox" id="checkAll">
					</th>
					<th>ID</th>
					<th>Year</th>
					<th>Make</th>
					<th>Model</th>
					<th>Ownership</th>
					<th>Primary Use</th>
					<th>ZIP</th>
					<th>Full Details</th>
					<th>Action</th>
				</tr>
			</thead>

			<tbody class="text-center">
	   			<?php while($row = mysqli_fetch_array($result)): ?>

	   			<tr>
					<td class="text-center align-middle">
						<input type="checkbox" class="rowCheck" data-id="<?php echo $row['id']; ?>">
					</td>
	   				<td class="align-middle"><?php echo $row['id']; ?></td>
	   				<td class="align-middle"><?php echo $row['vehicle_year']; ?></td>
	   				<td class="align-middle"><?php echo $row['make']; ?></td>
	   				<td class="align-middle"><?php echo $row['model']; ?></td>
	   				<td class="align-middle"><?php echo $row['ownership']; ?></td>
	   				<td class="align-middle"><?php echo $row['primary_use']; ?></td>
	   				<td class="align-middle"><?php echo $row['zip']; ?></td>
	   				<td class="align-middle"><a href="#" class="btn btn-link" data-id="<?php echo $row['id']; ?>" data-toggle="modal" data-target="#exampleModal">View</a></td>
	   				<td class="text-center align-middle">
						<a title="Edit" class="btn btn-primary btn-sm mr-1" href="testingedit.php?id=<?php echo $row['id']; ?>"><i class="fa  fa-pencil"></i></a><button title="Delete" class="deleteBtn btn btn-danger btn-sm ml-1" data-id="<?php echo $row['id']; ?>"><i class="fa fa-trash-o"></i></button>
					</td>
	   			</tr>

			  	<?php endwhile; ?>
	   		</tbody>
		 </table>
   	</div>
	   	
	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Full Details</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">
				
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

  <script>
	$(document).ready(function(){
		$('#myTable').DataTable({
			'columnDefs': [{ 'orderable': false, 'targets': 0 }], // hide sort icon on header of first column
    		'aaSorting': [[1, 'asc']] // start to sort data in second column
		});

	});

	$('#exampleModal').on('show.bs.modal', function (event) {
		const button = $(event.relatedTarget) // Button that triggered the modal
		const id = button.data('id') // Extract info from data-* attributes
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		var modal = $(this)
		modal.find('.modal-body').load(`view/testingview.php?id=${id}`);

	});

	// Delete Item
	$('.deleteBtn').click(function(e) {
		e.preventDefault();

		const id = this.dataset.id;
		const deleteItem = confirm(`Do you want to delete the record with the id of "${id}"?`);

		if (deleteItem) {
			$.ajax({
				url: 'process.php',
				method: 'POST',
				data: {key: 'delete', id: id, table: 'multi_vehicle'},
				success: function(response) {
					if (response.includes('deleteSuccess')) {
						window.location.href = `testing.php`;
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
					data: {key: 'deleteSelected', ids: checkedItems, table: 'multi_vehicle'},
					success: function(response) {
						if (response.includes('deleteSuccess')) {
							window.location.href = `testing.php`;
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
  </script>
</body>
</html>