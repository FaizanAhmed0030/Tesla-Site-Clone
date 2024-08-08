<?php
    session_start();
    $con = mysqli_connect("localhost", "root", "", "Tesla");

    if($con){
        
        // echo("Connected!");
        
        if(isset($_POST['subl'])){
            $l_email = $_POST['email'];
            $l_password = $_POST['pass'];
            
            $InQuery = "SELECT * FROM user WHERE '$l_email'=email AND '$l_password' = password";
            $retrive = mysqli_query($con, $InQuery);
            
            if(mysqli_num_rows($retrive) > 0){
                $record = mysqli_fetch_assoc($retrive);

                $_SESSION['session_name'] = $record['name'];
                $_SESSION['session_email'] = $s_email;
                $_SESSION['session_pass'] = $s_pass;
                $_SESSION['session_country'] = $record['country'];
                header("Location:dashboard.php");
            }
            else
            {
                //Refresh Login page incase of wrong credentails
                
                header("Location:login.html");
                exit();
            }
        }
        else if(isset($_POST['subs'])){

            $s_name = $_POST['name'];
            $s_email = $_POST['email'];
            $s_pass = $_POST['pass'];
            $s_country = $_POST['country'];
            $s_phone = $_POST['phone'];
            $s_owntesla = $_POST['ownTesla'];
            $s_vehicles = $_POST['vehicles'];

            $database_emails = "SELECT email FROM user WHERE email='$s_email'";
            $de = mysqli_query($con, $database_emails);
            
            if(mysqli_num_rows($de) > 0){
                
                header("Location:login.html");
                exit();
            }
            else
            {
                
                $usedVehicles = "";
                foreach($s_vehicles as $v){
                    $usedVehicles = $usedVehicles.$v.",";
                }
    
                $file = $_FILES['file'];
                $file_name = $file['name'];
                $tmp_name = $file['tmp_name'];
    
                $destination = "file/".$file_name;
                move_uploaded_file($tmp_name, $destination);
    
                $UpQuery = "INSERT INTO user(name, email, password, country, phone, have_tesla, vehicles, documents) 
                VALUES('$s_name', '$s_email', '$s_pass', '$s_country', '$s_phone', '$s_owntesla','$usedVehicles','$destination' )";
    
                $q = mysqli_query($con, $UpQuery);
                if($q){

                    $_SESSION['session_name'] = $s_name;
                    $_SESSION['session_email'] = $s_email;
                    $_SESSION['session_pass'] = $s_pass;
                    $_SESSION['session_country'] = $s_country;

                    header("Location:dashboard.php");   
                }
                
            }
            


        }

    }
    else
        echo("Not Connected to Database!");

?>