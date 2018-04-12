<?php  

session_start(); 

if (!$_SESSION['loggedInUser']) {
    header("Location: index.php");

} else {

    include('../conn.php');

    if ( isset($_POST["export"]) ) {  

        $table = mysqli_real_escape_string($conn, $_POST['table']);
        
        if ($table == 'quick') {

            header("Content-Type: text/csv; charset=utf-8");  
            header("Content-Disposition: attachment; filename=just-curious.csv");  
            $output = fopen("php://output", "w");  

            fputcsv($output, array('ID', 'First Name', 'Last Name', 'Email', 'Phone', 'Insurance', 'Address', 'Status'));  

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

        } else if ($table == 'semi') {

            header("Content-Type: text/csv; charset=utf-8");  
            header("Content-Disposition: attachment; filename=semi-interested.csv");  
            $output = fopen("php://output", "w");  

            fputcsv($output, array('ID', 'Year', 'Make', 'Model', 'Ownership', 'Primary Use', 'Parking', 'Desired Coverage', 'Current Insurance Co.', 'First Name', 'Last Name', 'Gender', 'Email', 'Phone', 'Educational Level', 'Marital Status', 'ZIP', 'Residence', 'Address', 'SR/22', 'Status'));  

            if ( isset($_POST['id']) ) {
                $id = mysqli_real_escape_string($conn, $_POST['id']);
                $query = "SELECT * from semi WHERE id = '$id'";  
            } else {
                $query = "SELECT * from semi ORDER BY id DESC";  
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

            fputcsv( $output, array('Assoc Driver ID', 'Vehicle Year', 'Make', 'Model', 'VIN', 'Ownership', 'Parking', 'Primary Use', 'Mileage', 'Desired Coverage', 'Insurance Past 30', 'Insurance Co.', 'Insurance Exp. Month', 'Insurance Exp. Yr', 'Years Insured', 'Bodily Injury Limit', 'Status', 'Vehicle ID', 'First Name', 'Last Name', 'Gender', 'Email', 'Phone', 'Educational Level', 'Marital Status', 'ZIP', 'Residence', 'Address', 'Licence Number', 'Age First Licensed', 'DOB Month', 'DOB Date', 'DOB Yr', 'Licence Suspended?', 'FR Form', 'Tickets/Accidents', 'DUI or DWI', 'Currently Have Insurance?', 'Current Co.', 'Paying Amt', 'Exp. Month', 'Exp. Yr', 'Years Insured', 'Deductible') );


            if ( isset($_POST['id']) ) {
                $id = mysqli_real_escape_string($conn, $_POST['id']);

                
                $query = "SELECT * FROM ready_vehicles 
                      LEFT JOIN ready_drivers
                      ON ready_vehicles.id = ready_drivers.vehicle WHERE ready_vehicles.id = '$id'
                    ";    

            } else {
                $query = "SELECT * FROM ready_vehicles 
                      LEFT JOIN ready_drivers
                      ON ready_vehicles.id = ready_drivers.vehicle ORDER BY ready_vehicles.id DESC
                    ";  
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