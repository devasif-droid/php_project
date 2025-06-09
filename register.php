
<?php 
$servername="localhost";
$username="root";
$password="";
$dbname="new_form";

$conn= new mysqli($servername,$username,$password,$dbname);
if($conn->connect_error){
    die("Connection failed".$conn->connect_error);
}

if($_SERVER['REQUEST_METHOD']=='POST'){

$name=$_POST['name'];
$email=$_POST['email'];
$password=$_POST['pass1'];
$gender=$_POST['gender'];
$country=$_POST['country'];
$term_accepted=isset($_POST['check']) ? 1 : 0;


$password_hashed=password_hash($password,PASSWORD_DEFAULT);

$sql=$conn->prepare("INSERT INTO students (name,email,password,gender,country,term_accepted)VALUES(?,?,?,?,?,?)");
$sql->bind_param("sssssi",$name,$email,$password_hashed,$gender,$country,$term_accepted);

if($sql->execute()==TRUE){
    echo "New record created succesfully"; 
    header("location: login.html ");
}
else{ 
    echo "Error".$sql->error; 
}
$sql->close();
} 
$conn->close();

?>
