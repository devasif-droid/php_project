<?php
session_start();

$message="Login Successfully";
$passerror="Please fill the correct password";
$nameerror="Please enter correct username";

$servername="localhost";
$username = "root";
$password = "";
$dbname = "new_form";

$conn = new mysqli ($servername,$username,$password,$dbname);
if($conn->connect_error){
    die("Connection Failed".$conn->connect_error);
}

if($_SERVER ['REQUEST_METHOD']=="POST"){
    $email= $_POST['email']; 
    $input_password=$_POST['password'];


$sql=$conn->prepare("SELECT id, email,password from students WHERE email=?");
$sql->bind_param("s",$email);
$sql->execute();
$sql->store_result();
$sql->bind_result($id,$db_email,$db_password); 
if($sql->num_rows>0){
    $sql->fetch();

    if(password_verify($input_password,$db_password)){  
        $_SESSION['user_id']=$id;
        $_SESSION['email']=$db_email;
        //header("location: profile.php"); 

        echo "<script> alert('$message'); 
        window.location.href = 'leftside.html'; </script>";   
    }
    else{
        echo "<script>alert('$passerror');</script>";
        echo "Incorrect Password";
    }
}
else{
    echo "<script> alert('$nameerror'); </script>"; // 
    echo "No username found"; 
}
$sql->close();
}
$conn->close();

?>
