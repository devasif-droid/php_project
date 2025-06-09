<?php 
session_start();

if(!isset($_SESSION["user_id"])){
    echo "<script> 
        alert(' Please Login first'); 
        window.location.href='login.html'; 
      </script>";
    exit();
}
/*unset($_SESSION["user_id"]); 
unset($_SESSION["email"]);*/
session_unset(); 
session_destroy();

echo 
  "<script> 
    alert('Logout Successfully');
    window.location.href='login.html'; 
  </script>";
?>