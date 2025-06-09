<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "new_form";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

//if (isset($_GET['email']) && !empty($_GET['email'])) {
    $email = $_GET['email'];
    
    
    $email_check_query = $conn->prepare("SELECT COUNT(*) FROM students WHERE email = ?");
    $email_check_query->bind_param("s", $email);
    $email_check_query->execute();
    $email_check_query->bind_result($email_count);
    $email_check_query->fetch();

    if ($email_count > 0) {
        echo "1";  
    } else {
        echo "0";
    }

    $email_check_query->close();
//}

$conn->close();
?>
















