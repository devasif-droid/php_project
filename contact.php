<?php

$servername="localhost";
$username="root";
$password="";
$dbname="new_form";

$conn=new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error){
    die("Connection failed".$conn->connect_error);
}
if($_SERVER['REQUEST_METHOD']=='POST'){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $address=$_POST['address'];
    $message=$_POST['message'];

    $sql=$conn->prepare("INSERT into feedback (name,email,address,message)VALUES(?,?,?,?)");
    $sql->bind_param("ssss",$name,$email,$address,$message);

    if($sql->execute()==TRUE){
        echo "Your Message Submit Succesfully";
    }
    else{
        echo "Error".$sql->error;
    }
    $sql->close(); 

// 
}
$conn->close();
?>