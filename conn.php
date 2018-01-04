<?php 
    $conn = mysqli_connect('localhost', 'root', '', 'quotes');

    if (!$conn) {
        echo mysqli_connect_error($conn);
    }
?>