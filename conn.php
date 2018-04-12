<?php 
    $conn = mysqli_connect('localhost', 'root', '', 'quotesdb');

    if (!$conn) {
        echo mysqli_connect_error($conn);
    }

?>