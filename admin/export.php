<?php  

session_start(); 

if (!$_SESSION['loggedInUser']) {
    header("Location: index.php");
    exit();

} else {

    include('../conn.php');

    if ( isset($_POST["export"]) ) {  

        $table = mysqli_real_escape_string($conn, $_POST['table']);
        
        if ($table == 'quick') {

            header("Content-Type: text/csv; charset=utf-8");  
            header("Content-Disposition: attachment; filename=just-curious.csv");  
            $output = fopen("php://output", "w");  

            fputcsv($output, array('ID', 'First Name', 'Last Name', 'Email', 'Phone', 'ZIP', 'Street Address', 'City, State, Country', 'Cur. Insurance Co.', 'Status'));  

            if ( isset($_POST['id']) ) {
                $id = mysqli_real_escape_string($conn, $_POST['id']);
                $query = "SELECT * from quick WHERE id = '$id'";  
            } else {
                $query = "SELECT * from quick ORDER BY id DESC";  
            }

            $result = mysqli_query($conn, $query);  
            while($row = mysqli_fetch_assoc($result)) {  
                fputcsv($output, $row);  
            }  

            fclose($output); 

        } else if ($table == 'semi' || $table == 'semi_drivers') {

            header("Content-Type: text/csv; charset=utf-8");  
            header("Content-Disposition: attachment; filename=semi-interested.csv");  
            $output = fopen("php://output", "w");  

            fputcsv($output, array('Assoc Vehicle ID', 'Group #', 'First Name', 'Last Name', 'Gender', 'Email', 'Phone', 'Student?', 'Marital Status', 'Residence', 'ZIP', 'Street Address', 'City, State, Country', 'SR/22?', 'Status', 'Driver ID', 'Year', 'Make', 'Model', 'Ownership', 'Primary Use', 'Desired Coverage', 'Current Insurance Co.'));  

            if ( isset($_POST['id']) ) {
                $id = mysqli_real_escape_string($conn, $_POST['id']);
                $query = "SELECT * from semi_drivers
                          LEFT JOIN semi_vehicles
                          ON semi_drivers.id = semi_vehicles.driver WHERE semi_drivers.id = $id";  
            } else {
                
                $query = "SELECT * from semi_drivers
                          LEFT JOIN semi_vehicles
                          ON semi_drivers.id = semi_vehicles.driver ORDER BY semi_drivers.group_id DESC";           
            }

            $result = mysqli_query($conn, $query);  
            while($row = mysqli_fetch_assoc($result)) {  
                fputcsv($output, $row);  
            }  

            fclose($output);
        } else { 

            //Ready To Buy 
            
            header("Content-Type: text/csv; charset=utf-8");  
            header("Content-Disposition: attachment; filename=ready-to-buy.csv");  
            $output = fopen("php://output", "w");  

            fputcsv( $output, array('Assoc Vehicle ID', 'Group #', 'First Name', 'Last Name', 'Gender', 'Email', 'Phone', 'Student?', 'Marital Status', 'Residence', 'ZIP', 'Street Address', 'City, State, Country', 'Licence Number', 'Licence State', 'Age First Licensed', 'DOB Month', 'DOB Date', 'DOB Yr', 'Tickets/Accidents?', 'DUI or DWI?', 'Licence Suspended?', 'SR 22?', 'Status', 'Driver ID', 'Vehicle Year', 'Make', 'Model', 'VIN', 'Ownership', 'Primary Use', 'Mileage', 'Desired Coverage', 'Insurance Past 30', 'Insurance Co.', 'Insurance Exp. Month', 'Insurance Exp. Yr', 'Years Insured', 'Bodily Injury Limit') );


            if ( isset($_POST['id']) ) {
                $id = mysqli_real_escape_string($conn, $_POST['id']);
                $query = "SELECT * from ready_drivers
                          LEFT JOIN ready_vehicles
                          ON ready_drivers.id = ready_vehicles.driver WHERE ready_drivers.id = $id";  
            } else {
                
                $query = "SELECT * from ready_drivers
                          LEFT JOIN ready_vehicles
                          ON ready_drivers.id = ready_vehicles.driver ORDER BY ready_drivers.group_id DESC";           
            }

            $result = mysqli_query($conn, $query);  
            while($row = mysqli_fetch_assoc($result)) {  
                fputcsv($output, $row);  
            }  

            fclose($output);
        }
    }
}

 ?>  