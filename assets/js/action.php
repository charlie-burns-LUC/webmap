 
<?php  
 session_start();  

 
 define ('DB_SERVER', 'localhost:3306');
 define ('DB_USERNAME', 'root');
 define ('DB_PASSWORD', '');
 define ('DB_NAME', 'lucmapsc_data_explorer');
 
 
 $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
 if ($link === false){
     die("ERROR: Could not connect to database".mysqli_connect_error());
     echo 'non';
 }

 else
  {


     if(isset($_POST["username"]))  

     {  
          $query = "  
          SELECT * FROM users 
          WHERE email = '".$_POST["username"]."'  
          AND password = '".$_POST["password"]."'  
          ";  
          $result = mysqli_query($link, $query);  
          if(mysqli_num_rows($result) > 0)  
          
          {  
               $_SESSION['username'] = $_POST['username'];  
               echo 'bien';  
          }  
          else  
          {  
               echo 'non';  
          }  
     }

     if(isset($_POST["action"]))  
     {  
          unset($_SESSION["username"]);  
     }  

 }
 ?>
