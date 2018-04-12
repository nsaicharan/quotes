<?php 

	session_start();

	if (!$_SESSION['loggedInUser']) {
		header("Location: index.php");
		exit();

    }  else {
    	include('../conn.php');

		$table = mysqli_real_escape_string($conn, $_GET['table']);
		$id = mysqli_real_escape_string($conn, $_GET['id']);

		$query = "SELECT * FROM $table WHERE id = '$id'";
		$result = mysqli_query($conn, $query);
		
		if ($result) {
			$row = mysqli_fetch_array($result);
		} else {
			echo mysqli_error($conn);
		}
    }

?>

<div class="form-group">
	<label for="status">Customer ID: <?php echo $id; ?></label>
	<select class="form-control" name="status" id="status">
		<optgroup label="Current Value">
			<option value="<?php echo $row['status'] ?>"><?php echo $row['status'] ?></option>
		</optgroup>
		
		<optgroup label="Available Options">
			<option value="Sell Back">Sell Back</option>
			<option value="In Progress">In Progress</option>
			<option value="Sold">Sold</option>
			<option value="Not Sold">Not Sold</option>
		</optgroup>
	</select>
</div>
<button class="btn btn-primary mt-3 mb-1 btn-block" id="statusUpdate" data-table="<?php echo $table ?>" data-id="<?php echo $row['id'] ?>" onclick="statusUpdate(this)">UPDATE</button>

