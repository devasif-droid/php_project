<?php

session_start();
if(!isset($_SESSION['user_id'])){
    header("location: login.html");
    exit();
}

$user_id=$_SESSION['user_id'];
$current_password=$_POST['current_password'];
$new_password=$_POST['new_password'];
$confirm_password=$_POST['confirm_password'];
$success="Password changed succesfully";

$servername="localhost";
$username="root";
$password="";
$dbname= "new_form";

$conn= new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error){
    die("Connection Failed".$conn->connect_error);
}

$sql=$conn->prepare("SELECT password from students WHERE id=?");
$sql->bind_param("i",$user_id);
$sql->execute();
$sql->bind_result($db_password);
$sql->fetch();
$sql->close();

if(password_verify($current_password,$db_password)){ 
    if($new_password==$confirm_password){
        $password_hashed=password_hash($new_password,PASSWORD_DEFAULT);
        $new_pass=$conn->prepare("UPDATE students SET password=? where id=? ");
        $new_pass->bind_param("si",$password_hashed,$user_id); 
        $new_pass->execute(); 
        echo "<script> alert('$success');
        window.location.href='login.html';</script>";  
        
        echo "Password changed succesfully";
        
        $new_pass->close(); 
    } 
   
    else{
        echo "Confirm password must be same as new password"; 
    }     
}
else{ 
    echo "Current Password is incorrect";
}

$conn->close();
?>




