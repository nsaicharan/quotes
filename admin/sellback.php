<?php 
session_start();

if ($_SESSION['loggedInUser'] != 'operator') {
	header("Location: index.php");
	exit();
}

include('../conn.php');

$actionMessage = "";

if (isset($_SESSION['delete'])) {
	$id = $_SESSION['delete'];
	$actionMessage = "<div class='alert alert-warning'>Successfully deleted the record. <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
	unset($_SESSION['delete']);
}

if (isset($_SESSION['deleteSelected'])) {
	$ids = str_replace(' ', ', ', trim($_SESSION['deleteSelected']));
	$actionMessage = "<div class='alert alert-warning'>Successfully deleted the records. <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
	unset($_SESSION['deleteSelected']);
}

if (isset($_SESSION['response'])) {
	$id = $_SESSION['response'];
	$actionMessage = "<div class='alert alert-warning'>Your response has been successfully submitted. <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
	unset($_SESSION['response']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Sell Back | Admin Panel</title>
	
	<link rel="stylesheet" type="text/css" href="assets/library.css">
    <link href="https://fonts.googleapis.com/css?family=Mate+SC|Open+Sans:400,700" rel="stylesheet">

	<style type="text/css">

		body {
			background: hsl(48, 100%, 67%);
			font-family: 'Open Sans';
		}
		button {
			cursor: pointer;
		}

		.alert {
			width: 1170px;
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
			width: 1170px;
			max-width: 90vw;
			margin: 0 auto;
			background: white;
			box-shadow: 0 1px 5px rgba(0, 0, 0, .15);
			margin-bottom: 25px;
			padding-bottom: 25px;
		}

		@media (max-width: 480px) {
			.container--users {
				max-width: 95vw;
			}
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

	<?php echo $actionMessage; ?>
	
	<div class="container--users">
		<h2>Sell Back Offers</h2>

		<div class="text-center text-lg-right mb-3 mr-md-3">
			<button class="btn btn-danger btn-sm" id="deleteSelected"><i class="fa fa-check-square-o"></i> Delete Selected Items</button>
		</div>

		<table id="sellbackTable" class="table table-bordered table-striped table-responsive" cellspacing="0" width="100%"> 
			<thead>
				<tr>
					<th class="text-center">
						<input type="checkbox" id="checkAll">
					</th>
					<th class="text-center">S/N</th>
					<th class="text-center">Lead Info</th>
					<th class="text-center">Offeror</th>
					<th class="text-center">Your Response</th>
					<th class="text-center">Action</th>
				</tr>
			</thead>

			<tbody class="text-center">
				<?php 

			$query = "SELECT * FROM sellback ORDER BY id DESC";
			$result = mysqli_query($conn, $query);

			$i = 1;
			while ($row = mysqli_fetch_array($result)) :
			?>

				<tr>
					<td class="align-middle">
						<input type="checkbox" class="rowCheck" data-id="<?php echo $row['id']; ?>">
					</td>
					<td class="align-middle"><?php echo $i ?></td>
					<td class="align-middle" style="min-width: 240px;"><?php echo $row['info'] ?></td>
					<td class="align-middle text-capitalize"><?php echo $row['offeror'] ?></td>
					<td class="align-middle text-capitalize"><?php echo $row['response'] ?></td>
					<td class="align-middle" style="min-width: 85px;">
						<button title="Respond" class="btn btn-primary btn-sm mr-1" data-id="<?php echo $row['id'] ?>" data-info="<?php echo $row['info'] ?>" data-offeror="<?php echo $row['offeror'] ?>" data-target="#responseModal" data-toggle="modal">
							<i class="fa fa-mail-reply"></i>
						</button>

						<button title="Delete" class="btn btn-danger btn-sm ml-1 deleteBtn" data-id="<?php echo $row['id']; ?>"><i class="fa fa-trash-o"></i></button>
					</td>
				</tr>

				<?php $i++;
			endwhile; ?>
			</tbody>
		</table>

		<!-- Response Modal -->
		<div class="modal fade" id="responseModal" tabindex="-1" role="dialog" aria-labelledby="responseModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="responseModalLabel">Your Response</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>

					<div class="modal-body">
						<form id="responseForm">
							<div class="form-group">
								<label for="response">Do you want to accept the offer?</label>
								<select name="response" id="response" class="form-control" required>
									<option value="accepted">Yes</option>
									<option value="declined">No</option>
								</select>
							</div>

							<label for="message">Message (Optional):</label>
							<textarea name="message" id="message" rows="4" class="form-control" style="white-space: pre-line;"></textarea>
							
							<input type="hidden" name="sellbackID" value="">
							<input type="hidden" name="leadInfo" value="">
							<input type="hidden" name="offeror" value="">
							<input type="hidden" name="key" value="sellbackResponse">
					
							<button class="btn btn-primary btn-block mt-3 mb-1" type="submit">SUBMIT</button>

							<div class="error"></div>
						</form>
					</div>
				</div>
			</div>
		</div> <!-- End Add User Modal -->

	</div> <!-- container-user -->
	
	<script src="assets/library.js"></script>

    <script>

    	$('#sellbackTable').DataTable({
			'columnDefs': [{ 'orderable': false, 'targets': 0 }], // hide sort icon on header of first column
    		'aaSorting': [[1, 'asc']] // start to sort data in second column
		});

		//Response Modal 
		$('#responseModal').on('show.bs.modal', function (event) {
			const button = $(event.relatedTarget); // Button that triggered the modal
			const sellbackID = button.data('id');
			const leadInfo = button.data('info');
			const offeror = button.data('offeror');
			const modal = $(this);
			
			modal.find('input[name=response]').prev().text(`Do you want to accept ${offeror}'s offer?`);
			modal.find('input[name=sellbackID]').val(sellbackID);
			modal.find('input[name=leadInfo]').val(leadInfo);
			modal.find('input[name=offeror]').val(offeror);
		});
		
		//Handle Response Submission
		$("#responseForm").submit(function() {
			console.log($(this).serialize());

			$.ajax({
				url: 'process.php',
				method: 'post',
				data: $(this).serialize(),
				success: (response) => {
					if (response == 'responseSuccess') {
						window.location.href = 'sellback.php';
					} else {
						console.log(response);
					}
				},
				error: function(err) {
					console.log(err);
				}
			});
			
			return false;
		});

	// Delete Item
	$('.deleteBtn').click(function(e) {
		e.preventDefault();

		const id = this.dataset.id;
		const deleteItem = confirm(`Do you want to delete the record?`);

		if (deleteItem) {
			$.ajax({
				url: 'process.php',
				method: 'post',
				data: {key: 'delete', id: id, table: 'sellback'},
				success: function(response) {
					if (response.includes('deleteSuccess')) {
						window.location.href = 'sellback.php';
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
			const deleteSelectedItems = confirm(`Do you want to delete selected records?`);

			if (deleteSelectedItems) {
				$.ajax({
					url: 'process.php',
					method: 'post',
					data: {key: 'deleteSelected', ids: checkedItems, table: 'sellback'},
					success: function(response) {
						if (response.includes('deleteSuccess')) {
							window.location.href = 'sellback.php';
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