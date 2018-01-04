<?php 

	include('conn.php');

	$actionMessage = '';

	if ( isset($_GET['deleted']) ) {

		$id = mysqli_real_escape_string($conn, $_GET['deleted']);
		
		$actionMessage = "<div class='alert alert-warning'><strong><u>Recent Action</u>:</strong> A record with the ID of '$id' has been deleted. <a href='#' class='close' data-dismiss='alert'>&times;</a></div>";
		
	}

	$query = "SELECT * FROM quick";

	$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
   <link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css">
	<link href="https://fonts.googleapis.com/css?family=Mate+SC|Montserrat:400,700|Satisfy|Open+Sans:400,700,300" rel="stylesheet">

	<style type="text/css">
		body {
			text-rendering: optimizeLegibility;
			 -webkit-font-smoothing: antialiased;
			 -moz-osx-font-smoothing: grayscale;
			 font-family: 'Open Sans';
			 background: #f6f9fc;
			 /*background: #f8f8f9;*/
			 background: hsl(48, 100%, 67%);
			/* background-image: linear-gradient(rgba(0,0,0,.7), rgba(0,0,0,.7)), url('https://projects.saicharan.com/max/car1.jpeg');
			 background-size: cover;
			 background-position: center;
			 height: 100vh;
			 background-attachment: fixed;*/
		}

		nav {
			/*background: hsl(48, 100%, 67%);
			background: #3ecf8e;
			background: #6772e5;*/
			color: #6772e5;
			background: white;
			box-shadow: 0px 2px 5px rgba(0,0,0,0.1);
			margin-bottom: 40px;
			width: 100vw;
		}

		/*.text-primary {
			color: #fff !important;
		}
*/
		.title {
			color: #6772e5;
			font-size: 30px;
			font-weight: 300;
			font-family: 'Mate SC'
		}

		.actionMessage {
			width: 620px;
			max-width: 94%;
			margin: 0 auto;
		}

		h3 {
			font-family: 'Mate SC', satisfy;
			margin: 0 0 25px;
			font-size: 24px;
			background:  #2c3e50;
			/*background:hsl(48, 100%, 67%);*/
			padding: 12px 0;
			color: white;
		}

		.logout {
			background: #6b7c93;
			color: white;
			padding: 10px 20px;
		}

		.container--table {
			background: white;
			padding: 0 0 30px;
			box-shadow: 0 1px 5px rgba(0,0,0,.15);
		}

		.info {
			display: flex;
		}

		aside {
			width: 100px;
			background: #2c3e50;
			padding: 10px;
			display: flex;
			flex-direction: column;
			justify-content: center;
			
		}

		main  {
			flex: 1;
		}
	</style>
</head>
<body>
    
    <nav class="navbar">
    	<div class="container text-center">
    		<a class="title text-primary" href="#">Data Collection</a>

    		<div class="text-capitalize">
    			Hello Max!
    		</div>
    	</div>	
    </nav>

	<div class="info">
		<!-- <aside>
			<div>
				<a href="#">Insurance</a>
				<a href="#">Data</a>
				<a href="#">Employee</a>
				<a href="#">Collection</a>
			</div>
		</aside> -->

	   	<main>
			
			<div class="actionMessage text-center">
   				<?php echo $actionMessage; ?>
   			</div>

	   		<div class="container container--table">

		    	<h3 class="text-center">Insurance Listing</h3>
			   	<table id="myTable" class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">

					<thead>
						<tr class="">
							<th>ID</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Insurance</th>
							<th>Actions</th>
						</tr>
					</thead>

					<tbody>
			   		<?php while($row = mysqli_fetch_array($result)): ?>

			   			<tr>
			   				<td><?php echo $row['id']; ?></td>
			   				<td><?php echo $row['first']; ?></td>
			   				<td><?php echo $row['last']; ?></td>
			   				<td><?php echo $row['email']; ?></td>
			   				<td><?php echo $row['phone']; ?></td>
			   				<td><?php echo $row['insurance']; ?></td>
			   				<td><a href="#" class="deleteBtn btn btn-sm btn-danger" data-id="<?php echo $row['id']; ?>">Delete</a></td>
			   			</tr>

			   		<?php endwhile; ?>
			   		</tbody>
			   	</table>
		   	</div>
	   	</main>
	</div>

  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>

  <script>
  	$(document).ready(function(){
  	    $('#myTable').DataTable();

  	});

  	$('.deleteBtn').click(function(e) {
  		e.preventDefault();

  		const id = this.dataset.id;
  		console.log(id);

  		const deleteRecord = confirm(`Do you want to delete "${id}" record?`);

  		if (deleteRecord == true) {
	  		$.ajax({
	  			url: 'quickprocess.php',
	  			method: 'POST',
	  			data: {
	  				key: 'delete',
	  				id: id
	  			},
	  			success: function(response) {
	  				console.log(response);
	  				window.location.href = `data.php?deleted=${id}`;
	  			}
	  		});
  		}

  	})
  </script>
</body>
</html>