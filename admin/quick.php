<?php 
    include('conn.php');

    if (isset($_POST['curiousSubmit'])) {

        $first = mysqli_real_escape_string($conn, $_POST['firstName']);
        $last = mysqli_real_escape_string($conn, $_POST['lastName']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $insurance = mysqli_real_escape_string($conn, $_POST['insurance']);

        $query = "INSERT INTO quick VALUES (NULL, '$first', '$last', '$email', '$phone', '$insurance')";

        $result = mysqli_query($conn, $query);

        if ($result) {
            echo 'Data has been successfully collected. <br><br> Visit <a href="index.php">this</a> page to view data.';
        } else {
            echo mysqli_error($conn);
        }

    } else {
        header("Location: index.html");
    }

?>