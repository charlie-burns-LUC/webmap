<?php 



// Define variables and initialize with empty values
$username = $password = "";
$username_login_err = $password_login_err = "";
 
// checks that form has been submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
   if (isset($_POST["usernameLogin"])) {
  $username = $_POST["usernameLogin"];
} else {
  $username_login_err = "Please enter username.";
}
    
   if (isset($_POST["passwordLogin"])) {
  $password = $_POST["passwordLogin"];
} else {
  $password_login_err = "Please enter a password.";
}
   
    
    // Validate credentials
    if(empty($username_login_err) && empty($password_login_err)){
        // Prepare a select statement
        $sql = "SELECT ID, email, first_name, password FROM users WHERE email = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $name, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        echo $password;
                        echo $hashed_password;
                        if(($password == $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;  
                            $_SESSION["name"] = $name;  
							
                            header("Location:./index.php?user=$username&name=$name");
                            exit();
                        } else{
                            // Display an error message if password is not valid
                            $password_login_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_login_err = "No account found with that username.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
	

}
?>

