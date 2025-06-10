<?php    //after submission we locate the file
echo "Thank You for Registration";

session_start(); 

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");  
    exit();
}

$user_id = $_SESSION['user_id'];
$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password']; 


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "new_form";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
        
}


$sql = $conn->prepare("SELECT password FROM students WHERE id = ?");
$sql->bind_param("i", $user_id);
$sql->execute();
$sql->bind_result($db_password);
$sql->fetch();
$sql->close();


if (password_verify($current_password, $db_password)) {
    if ($new_password == $confirm_password) {
        
        $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_sql = $conn->prepare("UPDATE students SET password = ? WHERE id = ?");
        $update_sql->bind_param("si", $hashed_new_password, $user_id);
        if ($update_sql->execute()) {
            echo "Password changed successfully!";
            
        } else {
            
        }

        $update_sql->close();
    } else {
        echo "New passwords do not match!";

    }
} else {
    echo "Incorrect current password!";
}

$conn->close();
?>
if (isset($_POST['current_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password'])) {


    body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fc;
        }

        h1 {
            background-color: skyblue;
            color: white;
            padding: 20px;
            text-align: center;
        }

        /* Container for user details */
        .user-detail {
            background-color: white;
            margin: 20px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 60%;
            text-align: center;
        }

        .user-detail p {
            font-size: 18px;
            margin: 10px 0;
        }

        /* Change password section */
        h4 {
            text-align: center;
            color: #333;
            margin-top: 40px;
        }

        form {
            max-width: 400px;
            margin: 30px auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .chng_pass {
            margin-bottom: 20px;
        }

        .chng_pass label {
            display: block;
            font-size: 16px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .chng_pass input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            box-sizing: border-box;
        }

        .chng_pass input:focus {
            outline: none;
            border-color: skyblue;
        }

        .chng_pass input[type="submit"] {
            background-color: skyblue;
            color: white;
            border: none;
            cursor: pointer;
            font-size: 18px;
        }

        .chng_pass input[type="submit"]:hover {
            background-color: cyan;
        }

        /* Responsive styling */
        @media (max-width: 768px) {
            .user-detail {
                width: 80%;
            }

            form {
                width: 90%;
            }
        }



        new 
        body {
            background-color: #f0f4f7;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* Form Container */
        form {
            background-color: white;
            padding: 40px 50px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        /* Logo */
        .image {
            margin-bottom: 20px;
        }

        h2 {
            font-size: 24px;
            margin-bottom: 30px;
            color: #333;
        }

        /* Input Styles */
        .login-page {
            margin-bottom: 20px;
            text-align: left;
        }

        label {
            display: block;
            font-size: 14px;
            color: #333;
            margin-bottom: 8px;
        }

        input[type=text], input[type=password] {
            width: 100%;
            padding: 12px 16px;
            margin-top: 6px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            background-color: #f9f9f9;
            transition: border-color 0.3s ease;
        }

        input[type=text]:focus, input[type=password]:focus {
            border-color: #007BFF;
            outline: none;
        }

        /* Submit Button */
        input[type=submit] {
            padding: 12px 50px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type=submit]:hover {
            background-color: #0056b3;
        }

        /* Error Message Styles */
        .error {
            color: red;
            font-size: 12px;
            margin-top: 6px;
            display: block;
        }

        /* Forgot Password Link */
        .forgot-password {
            font-size: 14px;
            color: red;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        /* Sign Up Link */
        .signup {
            font-size: 14px;
            color: #333;
        }

        .signup a {
            color: #007BFF;
            text-decoration: none;
        }

        .signup a:hover {
            text-decoration: underline;
        }
    




        //// leftside
        body{
            background:radial-gradient(circle, rgb(68, 73, 78) 30%, rgba(6, 54, 25, 0.8) 100%);
            margin: 0;
            
        }
        .leftsidebar{
            display: flexbox;
            flex-direction: column;
            background: radial-gradient(circle, rgb(68, 73, 78) 30%, rgba(6, 54, 25, 0.8) 100%);
            height: 100vh;
            padding-top: 20px;
            margin-right: 90%;
            color: white;   

        }
       
        h3:hover,li a:hover{
            background: radial-gradient(circle, rgb(126, 142, 158) 30%, rgba(74, 173, 114, 0.8) 100%);
            height: 500px;
            height: max-content;
            padding-right: 90px;
            color: rgb( 0, 255, 190);
            cursor: pointer;   
            
        }
        li a{
            color: white;
            text-decoration: none;
        }






























